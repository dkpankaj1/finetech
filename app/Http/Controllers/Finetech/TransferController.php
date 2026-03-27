<?php

namespace App\Http\Controllers\Finetech;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Transaction;
use App\Models\Transfer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransferController extends Controller
{
    private array $rules = [
        'source_account_id' => 'required|exists:accounts,id',
        'transfer_type' => 'required|in:internal,external',
        'destination_account_id' => 'nullable|exists:accounts,id|different:source_account_id',
        'destination_bank_name' => 'nullable|string|max:255',
        'destination_account_number' => 'nullable|string|max:50',
        'destination_ifsc' => 'nullable|string|max:20',
        'beneficiary_name' => 'nullable|string|max:255',
        'amount' => 'required|numeric|gt:0',
        'transferred_at' => 'required|date',
        'remarks' => 'nullable|string|max:500',
    ];

    public function index()
    {
        return view('finetech.transfers.index', [
            'transfers' => Transfer::with(['sourceAccount.customer', 'destinationAccount.customer', 'currency', 'transferBy'])
                ->latest('transferred_at')
                ->latest()
                ->get(),
        ]);
    }

    public function create()
    {
        return view('finetech.transfers.create', [
            'accounts' => Account::with(['customer', 'currency'])
                ->where('status', 'active')
                ->orderBy('account_number')
                ->get(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate($this->rules);

        if ($request->transfer_type === 'internal' && !$request->destination_account_id) {
            return redirect()->back()->withInput()->withErrors([
                'destination_account_id' => 'Destination account is required for internal transfer.',
            ]);
        }

        if ($request->transfer_type === 'external' && (!$request->destination_bank_name || !$request->destination_account_number || !$request->beneficiary_name)) {
            return redirect()->back()->withInput()->withErrors([
                'destination_bank_name' => 'Bank name, beneficiary name and destination account are required for external transfer.',
            ]);
        }

        try {
            $transfer = DB::transaction(function () use ($request) {
                $source = Account::with(['customer', 'branch', 'currency'])
                    ->lockForUpdate()
                    ->findOrFail($request->source_account_id);

                if ($source->status !== 'active') {
                    throw new \RuntimeException('Only active source accounts can transfer balance.');
                }

                $amount = (float) $request->amount;
                if ((float) $source->current_balance < $amount) {
                    throw new \RuntimeException('Insufficient balance in source account.');
                }

                $destination = null;
                if ($request->transfer_type === 'internal') {
                    $destination = Account::with(['customer', 'branch', 'currency'])
                        ->lockForUpdate()
                        ->findOrFail($request->destination_account_id);

                    if ($destination->status !== 'active') {
                        throw new \RuntimeException('Destination account must be active for internal transfer.');
                    }

                    if ($destination->currency_id !== $source->currency_id) {
                        throw new \RuntimeException('Internal transfer requires same currency accounts.');
                    }
                }

                $transfer = Transfer::create([
                    'reference_no' => $this->generateReferenceNo(),
                    'source_account_id' => $source->id,
                    'source_customer_id' => $source->customer_id,
                    'source_branch_id' => $source->branch_id,
                    'currency_id' => $source->currency_id,
                    'transfer_type' => $request->transfer_type,
                    'destination_account_id' => $destination?->id,
                    'destination_bank_name' => $request->destination_bank_name,
                    'destination_account_number' => $request->destination_account_number,
                    'destination_ifsc' => $request->destination_ifsc,
                    'beneficiary_name' => $request->beneficiary_name,
                    'amount' => $amount,
                    'remarks' => $request->remarks,
                    'transferred_at' => $request->transferred_at,
                    'transferred_by' => Auth::id(),
                ]);

                $sourceTxRef = $transfer->reference_no . '-OUT';
                $destinationTxRef = $transfer->reference_no . '-IN';

                $sourceOpening = (float) $source->current_balance;
                $sourceClosing = $sourceOpening - $amount;

                $sourceTransaction = Transaction::create([
                    'reference_no' => $sourceTxRef,
                    'account_id' => $source->id,
                    'customer_id' => $source->customer_id,
                    'branch_id' => $source->branch_id,
                    'currency_id' => $source->currency_id,
                    'transaction_type' => 'transfer_out',
                    'source' => $request->transfer_type === 'internal' ? 'internal_transfer' : 'external_transfer',
                    'amount' => $amount,
                    'opening_balance' => $sourceOpening,
                    'closing_balance' => $sourceClosing,
                    'remarks' => $request->remarks,
                    'transacted_at' => $request->transferred_at,
                    'created_by' => Auth::id(),
                    'transactionable_type' => Transfer::class,
                    'transactionable_id' => $transfer->id,
                    'counterparty_account_id' => $destination?->id,
                    'counterparty_bank_name' => $request->destination_bank_name,
                    'counterparty_account_number' => $request->destination_account_number,
                    'counterparty_ifsc' => $request->destination_ifsc,
                ]);

                $source->update([
                    'current_balance' => $sourceClosing,
                    'last_transaction_at' => $request->transferred_at,
                ]);

                $destinationTransactionId = null;
                if ($destination) {
                    $destinationOpening = (float) $destination->current_balance;
                    $destinationClosing = $destinationOpening + $amount;

                    $destinationTransaction = Transaction::create([
                        'reference_no' => $destinationTxRef,
                        'account_id' => $destination->id,
                        'customer_id' => $destination->customer_id,
                        'branch_id' => $destination->branch_id,
                        'currency_id' => $destination->currency_id,
                        'transaction_type' => 'transfer_in',
                        'source' => 'internal_transfer',
                        'amount' => $amount,
                        'opening_balance' => $destinationOpening,
                        'closing_balance' => $destinationClosing,
                        'remarks' => $request->remarks,
                        'transacted_at' => $request->transferred_at,
                        'created_by' => Auth::id(),
                        'transactionable_type' => Transfer::class,
                        'transactionable_id' => $transfer->id,
                        'counterparty_account_id' => $source->id,
                    ]);

                    $destination->update([
                        'current_balance' => $destinationClosing,
                        'last_transaction_at' => $request->transferred_at,
                    ]);

                    $destinationTransactionId = $destinationTransaction->id;
                }

                $transfer->update([
                    'source_transaction_id' => $sourceTransaction->id,
                    'destination_transaction_id' => $destinationTransactionId,
                ]);

                return $transfer;
            });

            toastr()->success('Transfer completed successfully.');
            return redirect()->route('finetech.transfers.show', $transfer);
        } catch (\Throwable $e) {
            toastr()->error($e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function show(Transfer $transfer)
    {
        $transfer->load([
            'sourceAccount.customer',
            'destinationAccount.customer',
            'sourceBranch',
            'currency',
            'transferBy',
            'sourceTransaction',
            'destinationTransaction',
        ]);

        return view('finetech.transfers.show', [
            'transfer' => $transfer,
        ]);
    }

    private function generateReferenceNo(): string
    {
        $year = date('Y');
        $last = Transfer::where('reference_no', 'like', "TRF-{$year}-%")
            ->orderByDesc('id')
            ->value('reference_no');

        $nextNumber = 1;
        if ($last) {
            $parts = explode('-', $last);
            $nextNumber = (int) end($parts) + 1;
        }

        return sprintf('TRF-%s-%06d', $year, $nextNumber);
    }
}
