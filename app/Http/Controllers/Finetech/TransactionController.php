<?php

namespace App\Http\Controllers\Finetech;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Deposit;
use App\Models\Withdrawal;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $accounts = Account::with(['customer'])->orderBy('account_number')->get();

        $type = $request->get('type');
        $accountId = $request->get('account_id');
        $fromDate = $request->get('from_date');
        $toDate = $request->get('to_date');

        $depositsQuery = Deposit::with(['account.customer', 'currency', 'depositor']);
        $withdrawalsQuery = Withdrawal::with(['account.customer', 'currency', 'withdrawer']);

        if ($accountId) {
            $depositsQuery->where('account_id', $accountId);
            $withdrawalsQuery->where('account_id', $accountId);
        }

        if ($fromDate) {
            $depositsQuery->whereDate('deposited_at', '>=', $fromDate);
            $withdrawalsQuery->whereDate('withdrawn_at', '>=', $fromDate);
        }

        if ($toDate) {
            $depositsQuery->whereDate('deposited_at', '<=', $toDate);
            $withdrawalsQuery->whereDate('withdrawn_at', '<=', $toDate);
        }

        $deposits = collect();
        $withdrawals = collect();

        if ($type !== 'withdrawal') {
            $deposits = $depositsQuery->latest('deposited_at')
                ->latest()
                ->take(500)
                ->get()
                ->map(function (Deposit $deposit) {
                    return [
                        'transaction_type' => 'deposit',
                        'reference_no' => $deposit->reference_no,
                        'account_no' => $deposit->account?->account_number,
                        'customer_name' => trim(($deposit->account?->customer?->first_name ?? '') . ' ' . ($deposit->account?->customer?->last_name ?? '')),
                        'source' => $deposit->source,
                        'amount' => (float) $deposit->amount,
                        'currency_symbol' => $deposit->currency?->symbol ?? '',
                        'currency_code' => $deposit->currency?->code ?? '',
                        'created_by' => $deposit->depositor?->name ?? 'System',
                        'transacted_at' => $deposit->deposited_at,
                        'show_url' => route('finetech.deposits.show', $deposit),
                    ];
                });
        }

        if ($type !== 'deposit') {
            $withdrawals = $withdrawalsQuery->latest('withdrawn_at')
                ->latest()
                ->take(500)
                ->get()
                ->map(function (Withdrawal $withdrawal) {
                    return [
                        'transaction_type' => 'withdrawal',
                        'reference_no' => $withdrawal->reference_no,
                        'account_no' => $withdrawal->account?->account_number,
                        'customer_name' => trim(($withdrawal->account?->customer?->first_name ?? '') . ' ' . ($withdrawal->account?->customer?->last_name ?? '')),
                        'source' => $withdrawal->source,
                        'amount' => (float) $withdrawal->amount,
                        'currency_symbol' => $withdrawal->currency?->symbol ?? '',
                        'currency_code' => $withdrawal->currency?->code ?? '',
                        'created_by' => $withdrawal->withdrawer?->name ?? 'System',
                        'transacted_at' => $withdrawal->withdrawn_at,
                        'show_url' => route('finetech.withdrawals.show', $withdrawal),
                    ];
                });
        }

        $transactions = $deposits
            ->merge($withdrawals)
            ->sortByDesc('transacted_at')
            ->values();

        return view('finetech.transactions.index', [
            'transactions' => $transactions,
            'accounts' => $accounts,
            'filters' => [
                'type' => $type,
                'account_id' => $accountId,
                'from_date' => $fromDate,
                'to_date' => $toDate,
            ],
        ]);
    }
}
