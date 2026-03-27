<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\AccountType;
use App\Models\Branch;
use App\Models\Currency;
use App\Models\Customer;
use App\Models\Deposit;
use App\Models\FixedDeposit;
use App\Models\Transaction;
use App\Models\Transfer;
use App\Models\User;
use App\Models\Withdrawal;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function () {
            $admin = User::firstOrCreate(
                ['email' => 'seed.admin@finetech.test'],
                [
                    'name' => 'Seed Admin',
                    'password' => Hash::make('password'),
                    'phone_number' => '9000000000',
                    'is_active' => 1,
                ]
            );

            $inr = Currency::firstOrCreate(
                ['code' => 'INR'],
                [
                    'name' => 'Indian Rupee',
                    'symbol' => 'Rs',
                    'exchange_rate' => 1.000000,
                ]
            );

            $branchMain = Branch::firstOrCreate(
                ['code' => 'TST-BR-001'],
                [
                    'name' => 'Test Main Branch',
                    'ifsc_code' => 'TSTB0000001',
                    'address' => '101 Test Street',
                    'city' => 'Ahmedabad',
                    'state' => 'Gujarat',
                    'postal_code' => '380001',
                    'country' => 'India',
                    'phone_number' => '07940000001',
                    'is_active' => true,
                    'is_main_branch' => true,
                ]
            );

            $branchCity = Branch::firstOrCreate(
                ['code' => 'TST-BR-002'],
                [
                    'name' => 'Test City Branch',
                    'ifsc_code' => 'TSTB0000002',
                    'address' => '22 Demo Avenue',
                    'city' => 'Surat',
                    'state' => 'Gujarat',
                    'postal_code' => '395003',
                    'country' => 'India',
                    'phone_number' => '02610000002',
                    'is_active' => true,
                    'is_main_branch' => false,
                ]
            );

            $savingsType = AccountType::firstOrCreate(
                ['code' => 'TST-SAV'],
                [
                    'name' => 'Test Savings',
                    'interest_rate' => 3.50,
                    'minimum_balance' => 1000,
                    'maximum_balance' => 1000000,
                    'daily_deposit_limit' => 200000,
                    'daily_withdrawal_limit' => 100000,
                    'monthly_free_transactions' => 8,
                    'requires_kyc' => true,
                    'is_active' => true,
                ]
            );

            $currentType = AccountType::firstOrCreate(
                ['code' => 'TST-CUR'],
                [
                    'name' => 'Test Current',
                    'interest_rate' => 0.00,
                    'minimum_balance' => 5000,
                    'maximum_balance' => null,
                    'daily_deposit_limit' => 500000,
                    'daily_withdrawal_limit' => 250000,
                    'monthly_free_transactions' => 20,
                    'requires_kyc' => true,
                    'is_active' => true,
                ]
            );

            $customer1 = Customer::firstOrCreate(
                ['customer_number' => 'TST-CUS-0001'],
                [
                    'first_name' => 'Ravi',
                    'last_name' => 'Shah',
                    'email' => 'ravi.shah.test@finetech.local',
                    'phone' => '9001100001',
                    'date_of_birth' => '1992-04-10',
                    'gender' => 'male',
                    'address' => 'A/12 Green Park',
                    'city' => 'Ahmedabad',
                    'state' => 'Gujarat',
                    'postal_code' => '380015',
                    'country' => 'India',
                    'branch_id' => $branchMain->id,
                    'created_by' => $admin->id,
                    'status' => 'active',
                    'kyc_status' => 'verified',
                ]
            );

            $customer2 = Customer::firstOrCreate(
                ['customer_number' => 'TST-CUS-0002'],
                [
                    'first_name' => 'Neha',
                    'last_name' => 'Patel',
                    'email' => 'neha.patel.test@finetech.local',
                    'phone' => '9001100002',
                    'date_of_birth' => '1995-09-21',
                    'gender' => 'female',
                    'address' => 'B/9 Silver Residency',
                    'city' => 'Surat',
                    'state' => 'Gujarat',
                    'postal_code' => '395002',
                    'country' => 'India',
                    'branch_id' => $branchCity->id,
                    'created_by' => $admin->id,
                    'status' => 'active',
                    'kyc_status' => 'verified',
                ]
            );

            $customer3 = Customer::firstOrCreate(
                ['customer_number' => 'TST-CUS-0003'],
                [
                    'first_name' => 'Amit',
                    'last_name' => 'Joshi',
                    'email' => 'amit.joshi.test@finetech.local',
                    'phone' => '9001100003',
                    'date_of_birth' => '1989-01-05',
                    'gender' => 'male',
                    'address' => 'C/21 River View',
                    'city' => 'Ahmedabad',
                    'state' => 'Gujarat',
                    'postal_code' => '380009',
                    'country' => 'India',
                    'branch_id' => $branchMain->id,
                    'created_by' => $admin->id,
                    'status' => 'active',
                    'kyc_status' => 'verified',
                ]
            );

            $account1 = Account::firstOrCreate(
                ['account_number' => 'TST-ACC-0001'],
                [
                    'customer_id' => $customer1->id,
                    'account_type_id' => $savingsType->id,
                    'branch_id' => $branchMain->id,
                    'currency_id' => $inr->id,
                    'opening_balance' => 120000,
                    'current_balance' => 120000,
                    'status' => 'active',
                    'opened_at' => Carbon::now()->subMonths(4)->toDateString(),
                    'opened_by' => $admin->id,
                ]
            );

            $account2 = Account::firstOrCreate(
                ['account_number' => 'TST-ACC-0002'],
                [
                    'customer_id' => $customer2->id,
                    'account_type_id' => $savingsType->id,
                    'branch_id' => $branchCity->id,
                    'currency_id' => $inr->id,
                    'opening_balance' => 90000,
                    'current_balance' => 90000,
                    'status' => 'active',
                    'opened_at' => Carbon::now()->subMonths(3)->toDateString(),
                    'opened_by' => $admin->id,
                ]
            );

            $account3 = Account::firstOrCreate(
                ['account_number' => 'TST-ACC-0003'],
                [
                    'customer_id' => $customer3->id,
                    'account_type_id' => $currentType->id,
                    'branch_id' => $branchMain->id,
                    'currency_id' => $inr->id,
                    'opening_balance' => 300000,
                    'current_balance' => 300000,
                    'status' => 'active',
                    'opened_at' => Carbon::now()->subMonths(6)->toDateString(),
                    'opened_by' => $admin->id,
                ]
            );

            $this->seedDepositWithTransaction(
                account: $account1,
                referenceNo: 'TST-DEP-0001',
                amount: 15000,
                source: 'cash',
                when: Carbon::now()->subDays(12),
                byUserId: $admin->id
            );

            $this->seedWithdrawalWithTransaction(
                account: $account1,
                referenceNo: 'TST-WDL-0001',
                amount: 7000,
                source: 'online',
                when: Carbon::now()->subDays(9),
                byUserId: $admin->id
            );

            $this->seedDepositWithTransaction(
                account: $account2,
                referenceNo: 'TST-DEP-0002',
                amount: 12000,
                source: 'bank_transfer',
                when: Carbon::now()->subDays(8),
                byUserId: $admin->id
            );

            $this->seedWithdrawalWithTransaction(
                account: $account3,
                referenceNo: 'TST-WDL-0002',
                amount: 25000,
                source: 'cheque',
                when: Carbon::now()->subDays(7),
                byUserId: $admin->id
            );

            $this->seedInternalTransfer(
                sourceAccount: $account1->fresh(),
                destinationAccount: $account2->fresh(),
                referenceNo: 'TST-TRF-0001',
                amount: 5000,
                when: Carbon::now()->subDays(5),
                byUserId: $admin->id
            );

            $this->seedExternalTransfer(
                sourceAccount: $account3->fresh(),
                referenceNo: 'TST-TRF-0002',
                amount: 11000,
                when: Carbon::now()->subDays(3),
                byUserId: $admin->id
            );

            FixedDeposit::firstOrCreate(
                ['fd_number' => 'TST-FDS-0001'],
                [
                    'account_id' => $account2->id,
                    'customer_id' => $account2->customer_id,
                    'branch_id' => $account2->branch_id,
                    'currency_id' => $account2->currency_id,
                    'principal_amount' => 20000,
                    'interest_rate' => 7.25,
                    'tenure_months' => 12,
                    'maturity_amount' => 21450,
                    'status' => 'active',
                    'opened_at' => Carbon::now()->subDays(30)->toDateString(),
                    'maturity_date' => Carbon::now()->addMonths(11)->toDateString(),
                    'remarks' => 'Seeded FDS sample',
                    'created_by' => $admin->id,
                ]
            );
        });
    }

    private function seedDepositWithTransaction(Account $account, string $referenceNo, float $amount, string $source, Carbon $when, int $byUserId): void
    {
        $existing = Deposit::where('reference_no', $referenceNo)->first();
        if ($existing) {
            return;
        }

        $account->refresh();
        $opening = (float) $account->current_balance;
        $closing = $opening + $amount;

        $deposit = Deposit::create([
            'account_id' => $account->id,
            'customer_id' => $account->customer_id,
            'branch_id' => $account->branch_id,
            'currency_id' => $account->currency_id,
            'reference_no' => $referenceNo,
            'amount' => $amount,
            'source' => $source,
            'remarks' => 'Seeded deposit',
            'deposited_at' => $when,
            'deposited_by' => $byUserId,
        ]);

        $tx = Transaction::create([
            'reference_no' => $referenceNo,
            'account_id' => $account->id,
            'customer_id' => $account->customer_id,
            'branch_id' => $account->branch_id,
            'currency_id' => $account->currency_id,
            'transaction_type' => 'deposit',
            'source' => $source,
            'amount' => $amount,
            'opening_balance' => $opening,
            'closing_balance' => $closing,
            'remarks' => 'Seeded deposit transaction',
            'transacted_at' => $when,
            'created_by' => $byUserId,
            'transactionable_type' => Deposit::class,
            'transactionable_id' => $deposit->id,
        ]);

        $deposit->update(['transaction_id' => $tx->id]);
        $account->update([
            'current_balance' => $closing,
            'last_transaction_at' => $when,
        ]);
    }

    private function seedWithdrawalWithTransaction(Account $account, string $referenceNo, float $amount, string $source, Carbon $when, int $byUserId): void
    {
        $existing = Withdrawal::where('reference_no', $referenceNo)->first();
        if ($existing) {
            return;
        }

        $account->refresh();
        if ((float) $account->current_balance < $amount) {
            return;
        }

        $opening = (float) $account->current_balance;
        $closing = $opening - $amount;

        $withdrawal = Withdrawal::create([
            'account_id' => $account->id,
            'customer_id' => $account->customer_id,
            'branch_id' => $account->branch_id,
            'currency_id' => $account->currency_id,
            'reference_no' => $referenceNo,
            'amount' => $amount,
            'source' => $source,
            'remarks' => 'Seeded withdrawal',
            'withdrawn_at' => $when,
            'withdrawn_by' => $byUserId,
        ]);

        $tx = Transaction::create([
            'reference_no' => $referenceNo,
            'account_id' => $account->id,
            'customer_id' => $account->customer_id,
            'branch_id' => $account->branch_id,
            'currency_id' => $account->currency_id,
            'transaction_type' => 'withdrawal',
            'source' => $source,
            'amount' => $amount,
            'opening_balance' => $opening,
            'closing_balance' => $closing,
            'remarks' => 'Seeded withdrawal transaction',
            'transacted_at' => $when,
            'created_by' => $byUserId,
            'transactionable_type' => Withdrawal::class,
            'transactionable_id' => $withdrawal->id,
        ]);

        $withdrawal->update(['transaction_id' => $tx->id]);
        $account->update([
            'current_balance' => $closing,
            'last_transaction_at' => $when,
        ]);
    }

    private function seedInternalTransfer(Account $sourceAccount, Account $destinationAccount, string $referenceNo, float $amount, Carbon $when, int $byUserId): void
    {
        $existing = Transfer::where('reference_no', $referenceNo)->first();
        if ($existing) {
            return;
        }

        $sourceAccount->refresh();
        $destinationAccount->refresh();

        if ((float) $sourceAccount->current_balance < $amount) {
            return;
        }

        $transfer = Transfer::create([
            'reference_no' => $referenceNo,
            'source_account_id' => $sourceAccount->id,
            'source_customer_id' => $sourceAccount->customer_id,
            'source_branch_id' => $sourceAccount->branch_id,
            'currency_id' => $sourceAccount->currency_id,
            'transfer_type' => 'internal',
            'destination_account_id' => $destinationAccount->id,
            'amount' => $amount,
            'remarks' => 'Seeded internal transfer',
            'transferred_at' => $when,
            'transferred_by' => $byUserId,
        ]);

        $sourceOpening = (float) $sourceAccount->current_balance;
        $sourceClosing = $sourceOpening - $amount;
        $destinationOpening = (float) $destinationAccount->current_balance;
        $destinationClosing = $destinationOpening + $amount;

        $sourceTx = Transaction::create([
            'reference_no' => $referenceNo . '-OUT',
            'account_id' => $sourceAccount->id,
            'customer_id' => $sourceAccount->customer_id,
            'branch_id' => $sourceAccount->branch_id,
            'currency_id' => $sourceAccount->currency_id,
            'transaction_type' => 'transfer_out',
            'source' => 'internal_transfer',
            'amount' => $amount,
            'opening_balance' => $sourceOpening,
            'closing_balance' => $sourceClosing,
            'remarks' => 'Seeded internal transfer out',
            'transacted_at' => $when,
            'created_by' => $byUserId,
            'transactionable_type' => Transfer::class,
            'transactionable_id' => $transfer->id,
            'counterparty_account_id' => $destinationAccount->id,
        ]);

        $destinationTx = Transaction::create([
            'reference_no' => $referenceNo . '-IN',
            'account_id' => $destinationAccount->id,
            'customer_id' => $destinationAccount->customer_id,
            'branch_id' => $destinationAccount->branch_id,
            'currency_id' => $destinationAccount->currency_id,
            'transaction_type' => 'transfer_in',
            'source' => 'internal_transfer',
            'amount' => $amount,
            'opening_balance' => $destinationOpening,
            'closing_balance' => $destinationClosing,
            'remarks' => 'Seeded internal transfer in',
            'transacted_at' => $when,
            'created_by' => $byUserId,
            'transactionable_type' => Transfer::class,
            'transactionable_id' => $transfer->id,
            'counterparty_account_id' => $sourceAccount->id,
        ]);

        $transfer->update([
            'source_transaction_id' => $sourceTx->id,
            'destination_transaction_id' => $destinationTx->id,
        ]);

        $sourceAccount->update([
            'current_balance' => $sourceClosing,
            'last_transaction_at' => $when,
        ]);

        $destinationAccount->update([
            'current_balance' => $destinationClosing,
            'last_transaction_at' => $when,
        ]);
    }

    private function seedExternalTransfer(Account $sourceAccount, string $referenceNo, float $amount, Carbon $when, int $byUserId): void
    {
        $existing = Transfer::where('reference_no', $referenceNo)->first();
        if ($existing) {
            return;
        }

        $sourceAccount->refresh();
        if ((float) $sourceAccount->current_balance < $amount) {
            return;
        }

        $transfer = Transfer::create([
            'reference_no' => $referenceNo,
            'source_account_id' => $sourceAccount->id,
            'source_customer_id' => $sourceAccount->customer_id,
            'source_branch_id' => $sourceAccount->branch_id,
            'currency_id' => $sourceAccount->currency_id,
            'transfer_type' => 'external',
            'destination_bank_name' => 'Demo National Bank',
            'destination_account_number' => '987654321001',
            'destination_ifsc' => 'DNBK0000123',
            'beneficiary_name' => 'External Beneficiary',
            'amount' => $amount,
            'remarks' => 'Seeded external transfer',
            'transferred_at' => $when,
            'transferred_by' => $byUserId,
        ]);

        $opening = (float) $sourceAccount->current_balance;
        $closing = $opening - $amount;

        $sourceTx = Transaction::create([
            'reference_no' => $referenceNo . '-OUT',
            'account_id' => $sourceAccount->id,
            'customer_id' => $sourceAccount->customer_id,
            'branch_id' => $sourceAccount->branch_id,
            'currency_id' => $sourceAccount->currency_id,
            'transaction_type' => 'transfer_out',
            'source' => 'external_transfer',
            'amount' => $amount,
            'opening_balance' => $opening,
            'closing_balance' => $closing,
            'remarks' => 'Seeded external transfer out',
            'transacted_at' => $when,
            'created_by' => $byUserId,
            'transactionable_type' => Transfer::class,
            'transactionable_id' => $transfer->id,
            'counterparty_bank_name' => 'Demo National Bank',
            'counterparty_account_number' => '987654321001',
            'counterparty_ifsc' => 'DNBK0000123',
        ]);

        $transfer->update(['source_transaction_id' => $sourceTx->id]);

        $sourceAccount->update([
            'current_balance' => $closing,
            'last_transaction_at' => $when,
        ]);
    }
}
