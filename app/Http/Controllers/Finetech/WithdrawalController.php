<?php

namespace App\Http\Controllers\Finetech;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WithdrawalController extends Controller
{
    private array $rules = [
        'account_id'    => 'required|exists:accounts,id',
        'amount'        => 'required|numeric|gt:0',
        'source'        => 'required|in:cash,bank_transfer,cheque,online,other',
        'withdrawn_at'  => 'required|date',
        'remarks'       => 'nullable|string|max:500',
    ];

    public function index()
    {
        return view('finetech.withdrawals.index', [
            'withdrawals' => Withdrawal::with(['account.customer', 'branch', 'currency', 'withdrawer'])
                ->latest('withdrawn_at')
                ->latest()
                ->get(),
        ]);
    }

    public function create()
    {
        return view('finetech.withdrawals.create', [
            'accounts' => Account::with(['customer', 'branch', 'currency', 'accountType'])
                ->where('status', 'active')
                ->orderBy('account_number')
                ->get(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate($this->rules);

        try {
            $withdrawal = DB::transaction(function () use ($request) {
                $account = Account::with(['customer', 'branch', 'currency', 'accountType'])
                    ->lockForUpdate()
                    ->findOrFail($request->account_id);

                if ($account->status !== 'active') {
                    throw new \RuntimeException('Only active accounts can process withdrawals.');
                }

                $amount = (float) $request->amount;

                if ((float) $account->current_balance < $amount) {
                    throw new \RuntimeException('Insufficient balance for this withdrawal.');
                }

                $limit = $account->accountType?->daily_withdrawal_limit;
                if (!is_null($limit)) {
                    $todayWithdrawn = Withdrawal::where('account_id', $account->id)
                        ->whereDate('withdrawn_at', now()->toDateString())
                        ->sum('amount');

                    if (($todayWithdrawn + $amount) > (float) $limit) {
                        throw new \RuntimeException('Daily withdrawal limit exceeded for this account type.');
                    }
                }

                $withdrawal = Withdrawal::create([
                    'account_id'    => $account->id,
                    'customer_id'   => $account->customer_id,
                    'branch_id'     => $account->branch_id,
                    'currency_id'   => $account->currency_id,
                    'reference_no'  => $this->generateReferenceNo(),
                    'amount'        => $amount,
                    'source'        => $request->source,
                    'remarks'       => $request->remarks,
                    'withdrawn_at'  => $request->withdrawn_at,
                    'withdrawn_by'  => Auth::id(),
                ]);

                $account->decrement('current_balance', $amount);
                $account->update(['last_transaction_at' => $request->withdrawn_at]);

                return $withdrawal;
            });

            toastr()->success('Withdrawal recorded successfully.');
            return redirect()->route('finetech.withdrawals.show', $withdrawal);
        } catch (\Throwable $e) {
            toastr()->error($e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function show(Withdrawal $withdrawal)
    {
        $withdrawal->load(['account.customer', 'branch', 'currency', 'withdrawer']);

        return view('finetech.withdrawals.show', [
            'withdrawal' => $withdrawal,
        ]);
    }

    private function generateReferenceNo(): string
    {
        $year = date('Y');
        $last = Withdrawal::where('reference_no', 'like', "WDL-{$year}-%")
            ->orderByDesc('id')
            ->value('reference_no');

        $nextNumber = 1;
        if ($last) {
            $parts = explode('-', $last);
            $nextNumber = (int) end($parts) + 1;
        }

        return sprintf('WDL-%s-%06d', $year, $nextNumber);
    }
}
