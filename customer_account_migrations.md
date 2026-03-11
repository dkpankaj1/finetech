# 🏦 CustomerAccount Module — Migration Reference

> **Module:** CustomerAccount (Phase 3 & 4)
> **Date:** 2026-03-11
> **Depends on:** `users`, `branches`, `currencies` tables (already exist)

---

## Migration Order

| # | Migration File | Table | Depends On |
|---|---------------|-------|------------|
| 1 | `2026_03_11_000001_create_customers_table.php` | `customers` | `branches`, `users` |
| 2 | `2026_03_11_000002_create_kyc_documents_table.php` | `kyc_documents` | `customers`, `users` |
| 3 | `2026_03_11_000003_create_account_types_table.php` | `account_types` | — |
| 4 | `2026_03_11_000004_create_accounts_table.php` | `accounts` | `customers`, `account_types`, `branches`, `currencies`, `users` |
| 5 | `2026_03_11_000005_create_transactions_table.php` | `transactions` | `accounts`, `users` |
| 6 | `2026_03_11_000006_create_transaction_approvals_table.php` | `transaction_approvals` | `transactions`, `users` |

---

## 1. `customers` Table

```php
Schema::create('customers', function (Blueprint $table) {
    $table->id();
    $table->string('customer_number')->unique()->comment('Auto-generated: CUS-2026-00001');

    // Personal Info
    $table->string('first_name');
    $table->string('last_name');
    $table->string('email')->unique();
    $table->string('phone', 20);
    $table->date('date_of_birth')->nullable();
    $table->enum('gender', ['male', 'female', 'other'])->nullable();
    $table->string('photo')->nullable()->comment('Profile photo path');

    // Address
    $table->string('address');
    $table->string('city');
    $table->string('state');
    $table->string('postal_code', 20);
    $table->string('country')->default('India');

    // Relations
    $table->foreignId('branch_id')->constrained('branches');
    $table->foreignId('created_by')->constrained('users');

    // Status
    $table->enum('status', ['active', 'inactive', 'suspended', 'blacklisted'])->default('active');
    $table->enum('kyc_status', ['pending', 'verified', 'rejected', 'expired'])->default('pending');
    $table->text('status_reason')->nullable()->comment('Reason for suspend/blacklist');

    $table->timestamps();
    $table->softDeletes();

    // Indexes
    $table->index('status');
    $table->index('kyc_status');
    $table->index(['first_name', 'last_name']);
});
```

---

## 2. `kyc_documents` Table

```php
Schema::create('kyc_documents', function (Blueprint $table) {
    $table->id();
    $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();

    // Document Details
    $table->enum('document_type', [
        'national_id',
        'passport',
        'driving_license',
        'voter_id',
        'aadhaar',
        'pan_card'
    ]);
    $table->string('document_number');
    $table->string('front_image')->comment('File path');
    $table->string('back_image')->nullable()->comment('File path');
    $table->date('expiry_date')->nullable();

    // Review
    $table->enum('status', ['pending', 'verified', 'rejected'])->default('pending');
    $table->foreignId('reviewed_by')->nullable()->constrained('users');
    $table->timestamp('reviewed_at')->nullable();
    $table->text('rejection_reason')->nullable();

    $table->timestamps();

    // Indexes
    $table->index(['customer_id', 'status']);
});
```

---

## 3. `account_types` Table

```php
Schema::create('account_types', function (Blueprint $table) {
    $table->id();
    $table->string('name')->comment('e.g. Savings Account');
    $table->string('code')->unique()->comment('e.g. SAV, CUR, FD');

    // Rates & Limits
    $table->decimal('interest_rate', 5, 2)->default(0.00)->comment('Annual interest rate %');
    $table->decimal('minimum_balance', 15, 2)->default(0.00);
    $table->decimal('maximum_balance', 15, 2)->nullable();
    $table->decimal('daily_deposit_limit', 15, 2)->nullable();
    $table->decimal('daily_withdrawal_limit', 15, 2)->nullable();
    $table->unsignedInteger('monthly_free_transactions')->default(0);

    // Flags
    $table->boolean('requires_kyc')->default(true);
    $table->boolean('is_active')->default(true);

    $table->timestamps();
});
```

---

## 4. `accounts` Table

```php
Schema::create('accounts', function (Blueprint $table) {
    $table->id();
    $table->string('account_number', 20)->unique()->comment('Auto-generated 10-digit: 1001000001');

    // Relations
    $table->foreignId('customer_id')->constrained('customers');
    $table->foreignId('account_type_id')->constrained('account_types');
    $table->foreignId('branch_id')->constrained('branches');
    $table->foreignId('currency_id')->constrained('currencies');

    // Balance
    $table->decimal('opening_balance', 15, 2)->default(0.00);
    $table->decimal('current_balance', 15, 2)->default(0.00);

    // Status
    $table->enum('status', ['active', 'frozen', 'dormant', 'closed'])->default('active');
    $table->text('status_reason')->nullable()->comment('Freeze/close reason');

    // Dates
    $table->timestamp('last_transaction_at')->nullable();
    $table->date('opened_at');
    $table->date('closed_at')->nullable();

    // Staff
    $table->foreignId('opened_by')->constrained('users');

    $table->timestamps();
    $table->softDeletes();

    // Indexes
    $table->index('status');
    $table->index('customer_id');
    $table->index(['branch_id', 'status']);
});
```

---

## 5. `transactions` Table

> ⚠️ **Immutable ledger** — rows are never updated or deleted, only reversed.

```php
Schema::create('transactions', function (Blueprint $table) {
    $table->id();
    $table->string('reference_number')->unique()->comment('TXN-20260311-000001');

    // Type
    $table->enum('transaction_type', [
        'cash_deposit',
        'cash_withdrawal',
        'internal_transfer_debit',
        'internal_transfer_credit',
        'external_transfer'
    ]);

    // Accounts
    $table->foreignId('account_id')->constrained('accounts');
    $table->foreignId('related_account_id')->nullable()->constrained('accounts')
          ->comment('Linked account for internal transfers');

    // Amounts
    $table->decimal('amount', 15, 2);
    $table->decimal('fee', 15, 2)->default(0.00);
    $table->decimal('net_amount', 15, 2)->comment('amount - fee');
    $table->decimal('balance_before', 15, 2);
    $table->decimal('balance_after', 15, 2);

    // Details
    $table->string('narration');
    $table->date('value_date');
    $table->enum('status', ['pending', 'completed', 'failed', 'reversed'])->default('pending');

    // External Transfer Fields (nullable — only for external_transfer type)
    $table->string('beneficiary_name')->nullable();
    $table->string('beneficiary_bank')->nullable();
    $table->string('beneficiary_account')->nullable();
    $table->string('beneficiary_ifsc')->nullable();
    $table->enum('transfer_mode', ['neft', 'rtgs', 'imps'])->nullable();

    // Staff
    $table->foreignId('processed_by')->constrained('users');
    $table->foreignId('approved_by')->nullable()->constrained('users');
    $table->foreignId('reversed_by')->nullable()->constrained('users');
    $table->string('reversed_reference')->nullable()->comment('Reference of reversal transaction');

    $table->timestamps();

    // Indexes
    $table->index('transaction_type');
    $table->index('status');
    $table->index(['account_id', 'created_at']);
    $table->index('value_date');
});
```

---

## 6. `transaction_approvals` Table

```php
Schema::create('transaction_approvals', function (Blueprint $table) {
    $table->id();
    $table->foreignId('transaction_id')->constrained('transactions');

    // Workflow
    $table->foreignId('requested_by')->constrained('users')->comment('Teller who initiated');
    $table->foreignId('approved_by')->nullable()->constrained('users')->comment('Manager who decided');
    $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
    $table->text('remarks')->nullable();
    $table->timestamp('decided_at')->nullable();

    $table->timestamps();

    // Indexes
    $table->index('status');
});
```

---

## Entity Relationship Diagram

```
┌──────────┐       ┌────────────┐       ┌──────────────┐
│ branches │──1:M──│ customers  │──1:M──│ kyc_documents│
└──────────┘       └─────┬──────┘       └──────────────┘
                         │ 1:M
                         ▼
┌──────────────┐   ┌──────────┐   ┌────────────┐
│ account_types│─M:1─│ accounts │──1:M──│transactions│
└──────────────┘   └─────┬────┘   └──────┬─────┘
                         │                │ 1:0..1
┌──────────┐             │          ┌─────▼──────────────────┐
│currencies│─────────M:1─┘          │transaction_approvals   │
└──────────┘                        └────────────────────────┘
```

---

## Artisan Commands (Run in Order)

```bash
php artisan make:migration create_customers_table
php artisan make:migration create_kyc_documents_table
php artisan make:migration create_account_types_table
php artisan make:migration create_accounts_table
php artisan make:migration create_transactions_table
php artisan make:migration create_transaction_approvals_table
```

---

## Key Business Rules (enforced at service layer, not DB)

- **Customer** must have `kyc_status = verified` before opening an account
- **Account number** is auto-generated using branch code + sequence
- **Customer number** is auto-generated: `CUS-{YEAR}-{SEQUENCE}`
- **Transactions** are **immutable** — never UPDATE or DELETE
- **Reversals** create a new opposite transaction linked via `reversed_reference`
- **Approval** is required for transactions exceeding the configured threshold
- **Dormant** status is triggered after configurable days of inactivity
