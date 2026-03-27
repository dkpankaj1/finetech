<?php

namespace App\Http\Controllers\Finetech;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Transaction;
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

        $transactionsQuery = Transaction::with(['account.customer', 'currency', 'creator']);

        if ($accountId) {
            $transactionsQuery->where('account_id', $accountId);
        }

        if ($fromDate) {
            $transactionsQuery->whereDate('transacted_at', '>=', $fromDate);
        }

        if ($toDate) {
            $transactionsQuery->whereDate('transacted_at', '<=', $toDate);
        }

        if ($type) {
            $transactionsQuery->where('transaction_type', $type);
        }

        $transactions = $transactionsQuery
            ->latest('transacted_at')
            ->latest()
            ->take(500)
            ->get();

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
