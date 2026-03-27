<?php

namespace App\Http\Controllers\Finetech;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\AccountType;
use App\Models\Branch;
use App\Models\Currency;
use App\Models\Customer;
use App\Services\AccountNumberGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    private array $rules = [
        'customer_id'     => 'required|exists:customers,id',
        'account_type_id' => 'required|exists:account_types,id',
        'branch_id'       => 'required|exists:branches,id',
        'currency_id'     => 'required|exists:currencies,id',
        'opening_balance' => 'required|numeric|min:0',
        'status'          => 'required|in:active,frozen,dormant,closed',
        'status_reason'   => 'nullable|string|max:500',
        'opened_at'       => 'required|date',
        'closed_at'       => 'nullable|date|after_or_equal:opened_at',
    ];

    public function index()
    {
        return view('finetech.accounts.index', [
            'accounts' => Account::with('customer', 'accountType', 'branch', 'currency')->latest()->get(),
            'searchQuery' => null,
        ]);
    }

    public function search(Request $request)
    {
        $searchQuery = trim((string) $request->get('q', ''));

        $accountsQuery = Account::with('customer', 'accountType', 'branch', 'currency')->latest();

        if ($searchQuery !== '') {
            $accountsQuery->where(function ($query) use ($searchQuery) {
                $query->where('account_number', 'like', "%{$searchQuery}%")
                    ->orWhereHas('customer', function ($customerQuery) use ($searchQuery) {
                        $customerQuery
                            ->where('customer_number', 'like', "%{$searchQuery}%")
                            ->orWhere('phone', 'like', "%{$searchQuery}%")
                            ->orWhere('email', 'like', "%{$searchQuery}%")
                            ->orWhere('first_name', 'like', "%{$searchQuery}%")
                            ->orWhere('last_name', 'like', "%{$searchQuery}%")
                            ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$searchQuery}%"]);
                    });
            });
        }

        return view('finetech.accounts.index', [
            'accounts' => $accountsQuery->get(),
            'searchQuery' => $searchQuery,
        ]);
    }

    public function create()
    {
        return view('finetech.accounts.create', [
            'customers'    => Customer::where('status', 'active')->get(),
            'accountTypes' => AccountType::where('is_active', true)->get(),
            'branches'     => Branch::where('is_active', true)->get(),
            'currencies'   => Currency::all(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate($this->rules);

        try {
            $generator = new AccountNumberGenerator(
                prefix: 'ACC',
                length: 14,
                separator: '-',
                includeYear: true,
            );

            Account::create([
                'account_number'  => $generator->generate(),
                'customer_id'     => $request->customer_id,
                'account_type_id' => $request->account_type_id,
                'branch_id'       => $request->branch_id,
                'currency_id'     => $request->currency_id,
                'opening_balance' => $request->opening_balance,
                'current_balance' => $request->opening_balance,
                'status'          => $request->status,
                'status_reason'   => $request->status_reason,
                'opened_at'       => $request->opened_at,
                'closed_at'       => $request->closed_at,
                'opened_by'       => Auth::id(),
            ]);

            toastr()->success('Account created successfully.');
            return redirect()->route('finetech.accounts.index');
        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function show(Account $account)
    {
        $account->load('customer', 'accountType', 'branch', 'currency', 'openedBy');

        $recentDeposits = $account->deposits()
            ->latest('deposited_at')
            ->latest()
            ->take(5)
            ->get();

        $recentWithdrawals = $account->withdrawals()
            ->latest('withdrawn_at')
            ->latest()
            ->take(5)
            ->get();

        $fixedDeposits = $account->fixedDeposits()
            ->latest()
            ->take(5)
            ->get();

        return view('finetech.accounts.show', [
            'account'           => $account,
            'recentDeposits'    => $recentDeposits,
            'recentWithdrawals' => $recentWithdrawals,
            'fixedDeposits'     => $fixedDeposits,
            'totalDeposited'    => $account->deposits()->sum('amount'),
            'totalWithdrawn'    => $account->withdrawals()->sum('amount'),
        ]);
    }

    public function edit(Account $account)
    {
        return view('finetech.accounts.edit', [
            'account'      => $account,
            'customers'    => Customer::where('status', 'active')->get(),
            'accountTypes' => AccountType::where('is_active', true)->get(),
            'branches'     => Branch::where('is_active', true)->get(),
            'currencies'   => Currency::all(),
        ]);
    }

    public function update(Request $request, Account $account)
    {
        $request->validate($this->rules);

        try {
            $account->update([
                'customer_id'     => $request->customer_id,
                'account_type_id' => $request->account_type_id,
                'branch_id'       => $request->branch_id,
                'currency_id'     => $request->currency_id,
                'opening_balance' => $request->opening_balance,
                'status'          => $request->status,
                'status_reason'   => $request->status_reason,
                'opened_at'       => $request->opened_at,
                'closed_at'       => $request->closed_at,
            ]);

            toastr()->success('Account updated successfully.');
            return redirect()->route('finetech.accounts.index');
        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function destroy(Account $account)
    {
        try {
            $account->delete();
            toastr()->success('Account deleted successfully.');
            return redirect()->route('finetech.accounts.index');
        } catch (\Exception $e) {
            toastr()->error('Failed to delete account. Please try again.');
            return redirect()->back();
        }
    }
}
