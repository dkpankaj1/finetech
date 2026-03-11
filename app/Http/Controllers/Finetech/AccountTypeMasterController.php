<?php

namespace App\Http\Controllers\Finetech;

use App\Http\Controllers\Controller;
use App\Models\AccountType;
use Illuminate\Http\Request;

class AccountTypeMasterController extends Controller
{
    private array $rules = [
        'name'                      => 'required|string|max:255',
        'code'                      => 'required|string|max:50',
        'interest_rate'             => 'required|numeric|min:0|max:100',
        'minimum_balance'           => 'required|numeric|min:0',
        'maximum_balance'           => 'nullable|numeric|min:0',
        'daily_deposit_limit'       => 'nullable|numeric|min:0',
        'daily_withdrawal_limit'    => 'nullable|numeric|min:0',
        'monthly_free_transactions' => 'required|integer|min:0',
        'requires_kyc'              => 'required|boolean',
        'is_active'                 => 'required|boolean',
    ];

    public function index()
    {
        return view('finetech.account-types.index', [
            'accountTypes' => AccountType::latest()->get(),
        ]);
    }

    public function create()
    {
        return view('finetech.account-types.create');
    }

    public function store(Request $request)
    {
        $request->validate(array_merge($this->rules, [
            'code' => 'required|string|max:50|unique:account_types,code',
        ]));

        try {
            AccountType::create([
                'name'                      => $request->name,
                'code'                      => strtoupper($request->code),
                'interest_rate'             => $request->interest_rate,
                'minimum_balance'           => $request->minimum_balance,
                'maximum_balance'           => $request->maximum_balance,
                'daily_deposit_limit'       => $request->daily_deposit_limit,
                'daily_withdrawal_limit'    => $request->daily_withdrawal_limit,
                'monthly_free_transactions' => $request->monthly_free_transactions,
                'requires_kyc'              => $request->boolean('requires_kyc'),
                'is_active'                 => $request->boolean('is_active'),
            ]);

            toastr()->success('Account type created successfully.');
            return redirect()->route('finetech.account-types.index');
        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function show(AccountType $accountType)
    {
        return view('finetech.account-types.show', ['accountType' => $accountType]);
    }

    public function edit(AccountType $accountType)
    {
        return view('finetech.account-types.edit', ['accountType' => $accountType]);
    }

    public function update(Request $request, AccountType $accountType)
    {
        $request->validate(array_merge($this->rules, [
            'code' => 'required|string|max:50|unique:account_types,code,' . $accountType->id,
        ]));

        try {
            $accountType->update([
                'name'                      => $request->name,
                'code'                      => strtoupper($request->code),
                'interest_rate'             => $request->interest_rate,
                'minimum_balance'           => $request->minimum_balance,
                'maximum_balance'           => $request->maximum_balance,
                'daily_deposit_limit'       => $request->daily_deposit_limit,
                'daily_withdrawal_limit'    => $request->daily_withdrawal_limit,
                'monthly_free_transactions' => $request->monthly_free_transactions,
                'requires_kyc'              => $request->boolean('requires_kyc'),
                'is_active'                 => $request->boolean('is_active'),
            ]);

            toastr()->success('Account type updated successfully.');
            return redirect()->route('finetech.account-types.index');
        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function destroy(AccountType $accountType)
    {
        try {
            $accountType->delete();
            toastr()->success('Account type deleted successfully.');
            return redirect()->route('finetech.account-types.index');
        } catch (\Exception $e) {
            toastr()->error('Failed to delete account type. Please try again.');
            return redirect()->back();
        }
    }
}
