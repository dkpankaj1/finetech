<?php

namespace App\Http\Controllers\Finetech;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Deposit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DepositController extends Controller
{
    private array $rules = [
        'account_id'   => 'required|exists:accounts,id',
        'amount'       => 'required|numeric|gt:0',
        'source'       => 'required|in:cash,bank_transfer,cheque,online,other',
        'deposited_at' => 'required|date',
        'remarks'      => 'nullable|string|max:500',
    ];

    public function index()
    {
        return view('finetech.deposits.index', [
            'deposits' => Deposit::with(['account.customer', 'branch', 'currency', 'depositor'])
                ->latest('deposited_at')
                ->latest()
                ->get(),
        ]);
    }

    public function create()
    {
        return view('finetech.deposits.create', [
            'accounts' => Account::with(['customer', 'branch', 'currency'])
                ->where('status', 'active')
                ->orderBy('account_number')
                ->get(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate($this->rules);

        try {
            $deposit = DB::transaction(function () use ($request) {
                $account = Account::with(['customer', 'branch', 'currency'])
                    ->lockForUpdate()
                    ->findOrFail($request->account_id);

                if ($account->status !== 'active') {
                    throw new \RuntimeException('Only active accounts can receive deposits.');
                }

                $deposit = Deposit::create([
                    'account_id'    => $account->id,
                    'customer_id'   => $account->customer_id,
                    'branch_id'     => $account->branch_id,
                    'currency_id'   => $account->currency_id,
                    'reference_no'  => $this->generateReferenceNo(),
                    'amount'        => $request->amount,
                    'source'        => $request->source,
                    'remarks'       => $request->remarks,
                    'deposited_at'  => $request->deposited_at,
                    'deposited_by'  => Auth::id(),
                ]);

                $account->increment('current_balance', (float) $request->amount);
                $account->update(['last_transaction_at' => $request->deposited_at]);

                return $deposit;
            });

            toastr()->success('Deposit recorded successfully.');
            return redirect()->route('finetech.deposits.show', $deposit);
        } catch (\Throwable $e) {
            toastr()->error($e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function show(Deposit $deposit)
    {
        $deposit->load(['account.customer', 'branch', 'currency', 'depositor']);

        return view('finetech.deposits.show', [
            'deposit' => $deposit,
        ]);
    }

    private function generateReferenceNo(): string
    {
        $year = date('Y');
        $last = Deposit::where('reference_no', 'like', "DEP-{$year}-%")
            ->orderByDesc('id')
            ->value('reference_no');

        $nextNumber = 1;
        if ($last) {
            $parts = explode('-', $last);
            $nextNumber = (int) end($parts) + 1;
        }

        return sprintf('DEP-%s-%06d', $year, $nextNumber);
    }
}
