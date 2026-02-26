# 🏦 Banking Application — Complete Project Plan
> **Project Type:** Office-Use Internal Banking System
> **Author:** @dkpankaj1i
> **Date:** 2026-02-25
> **Version:** 1.0.0

---

## 📋 Table of Contents

1. [Project Overview](#1-project-overview)
2. [System Architecture](#2-system-architecture)
3. [Tech Stack](#3-tech-stack)
4. [Module Overview](#4-module-overview)
5. [Database Schema Design](#5-database-schema-design)
6. [Phase-wise Development Plan](#6-phase-wise-development-plan)
   - [Phase 1 — Foundation & Authentication](#phase-1--foundation--authentication-week-12)
   - [Phase 2 — User & Settings Management](#phase-2--user--settings-management-week-3)
   - [Phase 3 — Customer & KYC Management](#phase-3--customer--kyc-management-week-45)
   - [Phase 4 — Account Management](#phase-4--account-management-week-6)
   - [Phase 5 — Transaction Engine](#phase-5--transaction-engine-week-79)
   - [Phase 6 — Reports & Statements](#phase-6--reports--statements-week-10)
   - [Phase 7 — Testing](#phase-7--testing-week-11)
   - [Phase 8 — Deployment & Documentation](#phase-8--deployment--documentation-week-12)
7. [Role & Permission Matrix](#7-role--permission-matrix)
8. [API Endpoint Plan](#8-api-endpoint-plan)
9. [Security Checklist](#9-security-checklist)
10. [Folder Structure](#10-folder-structure)
11. [Environment Configuration](#11-environment-configuration)
12. [Key Business Rules](#12-key-business-rules)
13. [Full Timeline](#13-full-timeline)
14. [Getting Started — First Steps](#14-getting-started--first-steps)

---

## 1. Project Overview

### Purpose
An internal **office-use banking management system** to manage customers, bank accounts, transactions (deposits, withdrawals, fund transfers), KYC documents, and system users — all with proper role-based access control.

### Scope
| In Scope | Out of Scope |
|----------|-------------|
| User/Role/Permission management | Mobile App |
| System Settings management | Internet Banking for customers |
| Customer management | Third-party open banking APIs |
| Account & Account type management | Loan management |
| KYC document management | Investment / Fixed Deposit interest auto-calc |
| Cash Deposit management | Crypto transactions |
| Cash Withdrawal management | |
| Internal Fund Transfer | |
| External Fund Transfer (Other Bank) | |
| Reports & Statements | |

### Target Users (Staff Roles)
| Role | Responsibility |
|------|---------------|
| Super Admin | Full system access, configuration |
| Admin | Manage users, settings, all operations |
| Manager | Approve large transactions, manage customers |
| Teller | Daily deposit/withdrawal/transfer operations |
| Viewer | Read-only access to reports |

---

## 2. System Architecture

```
┌────────────────────────────────────────────────────────────────┐
│                     PRESENTATION LAYER                         │
│                Web App (Admin Panel / Teller UI)               │
│               React.js + Inertia.js + Tailwind CSS             │
└────────────────────────┬───────────────────────────────────────┘
                         │  HTTP/HTTPS
┌────────────────────────▼───────────────────────────────────────┐
│                       API GATEWAY / ROUTER                     │
│        (Authentication Middleware, CSRF, Rate Limiting)        │
└──┬──────────┬───────────┬───────────┬──────────────────────────┘
   │          │           │           │
┌──▼──┐  ┌───▼──┐  ┌─────▼──┐  ┌────▼─────────┐  ┌────────────┐
│ USR │  │ KYC  │  │  ACCT  │  │  TRANSACTION │  │  SETTINGS  │
│ MGT │  │ MGT  │  │  MGT   │  │   ENGINE     │  │  MODULE    │
└──┬──┘  └───┬──┘  └─────┬──┘  └────┬─────────┘  └─────┬──────┘
   │          │           │           │                   │
┌──▼──────────▼───────────▼───────────▼───────────────────▼─────┐
│                      SERVICE LAYER                             │
│     UserService | KYCService | AccountService |               │
│     TransactionService | NotificationService                  │
└──────────────────────────┬─────────────────────────────────────┘
                           │
┌──────────────────────────▼─────────────────────────────────────┐
│                      DATA LAYER                                │
│     PostgreSQL (Primary DB)   |   Redis (Cache + Sessions)    │
│     File Storage (KYC Docs)   |   Queue (Jobs/Notifications)  │
└────────────────────────────────────────────────────────────────┘
                           │
┌──────────────────────────▼─────────────────────────────────────┐
│                   EXTERNAL INTEGRATIONS                        │
│      Payment Gateway (NEFT/RTGS/IMPS)  |  SMS Gateway         │
│      Email SMTP                        |  PDF Generator        │
└────────────────────────────────────────────────────────────────┘
```

### Architecture Principles
- **Layered Architecture**: Controller → Service → Repository → Model
- **ACID Transactions**: All financial operations use database transactions
- **Immutable Ledger**: Transactions are never updated or deleted, only reversed
- **Audit Everything**: Every state change is logged with actor, timestamp, before/after values
- **Fail Safe**: Failed transactions are logged and never partially applied

---

## 3. Tech Stack

### Core Stack

| Layer | Technology | Purpose |
|-------|-----------|---------|
| **Backend Framework** | Laravel 11 (PHP 8.3) | Core application logic |
| **Frontend** | React.js + Inertia.js | SPA-like UI without separate API |
| **CSS Framework** | Tailwind CSS | Styling |
| **Database** | PostgreSQL 16 | Primary relational database |
| **Cache / Sessions** | Redis 7 | Session storage, caching |
| **Queue Driver** | Laravel Queues (Redis) | Async jobs (notifications, reports) |
| **File Storage** | Local (storage/) or AWS S3 | KYC document storage |
| **PDF Generation** | barryvdh/laravel-dompdf | Receipts, statements |
| **Authentication** | Laravel Breeze + Sanctum | Auth scaffolding |
| **Permissions** | spatie/laravel-permission | RBAC |
| **Audit Logs** | spatie/laravel-activitylog | Activity tracking |

### Key Composer Packages

```bash
# Core
composer require inertiajs/inertia-laravel
composer require tightenco/ziggy                  # Route sharing with JS

# Auth & Permissions
composer require spatie/laravel-permission

# Audit & Logging
composer require spatie/laravel-activitylog

# PDF
composer require barryvdh/laravel-dompdf

# Media/File Uploads
composer require spatie/laravel-medialibrary

# Settings
composer require spatie/laravel-settings           # OR use custom settings table

# Development Tools
composer require --dev laravel/telescope           # Debug dashboard
composer require --dev barryvdh/laravel-debugbar
```

### Key NPM Packages

```bash
npm install @inertiajs/react react react-dom
npm install -D tailwindcss postcss autoprefixer
npm install @headlessui/react @heroicons/react
npm install react-hook-form axios
npm install recharts                              # Charts for dashboard
npm install date-fns                              # Date utilities
```

---

## Module Overview

```
┌─────────────────────────────────────────────────────────────┐
│                     10 CORE MODULES                         │
├──────────────────────┬──────────────────────────────────────┤
│ 01. Authentication   │ Login, Logout, Password Reset, 2FA   │
│ 02. User Management  │ Staff Users CRUD, Role Assignment    │
│ 03. Role & Permission│ Roles CRUD, Permission Assignment    │
│ 04. Settings         │ General, Transaction, Security, SMS  │
│ 05. Customer Mgmt    │ Customer CRUD, Profile, Status Mgmt  │
│ 06. KYC Management   │ Doc Upload, Review, Approve/Reject   │
│ 07. Account Types    │ Savings/Current types configuration  │
│ 08. Account Mgmt     │ Account CRUD, Balance, Statement     │
│ 09. Transactions     │ Deposit, Withdrawal, Internal Xfer   │
│ 10. External Transfer│ NEFT/RTGS/IMPS to other banks        │
└──────────────────────┴──────────────────────────────────────┘
```


### Phase 1 — Foundation & Authentication *(Week 1–2)*

#### 🎯 Goal
Bootstrap the project with a working auth system, role-based access control, and a dashboard skeleton.

#### 📦 Deliverables
- [] Laravel 11 project initialized
- [] PostgreSQL database connected
- [ ] Redis configured for cache/sessions
- [] Laravel Breeze (Inertia + React) installed
- [] Login / Logout / Password Reset working
- [ ] Email verification (optional for internal system)
- [ ] Two-Factor Authentication (2FA) for Admin/Manager
- [] Spatie Permission package installed & configured
- [] Default roles seeded: `super_admin`, `admin`, `manager`, `teller`, `viewer`
- [] Default permissions seeded for all modules
- [ ] Route middleware for permission checks
- [] Admin dashboard skeleton (sidebar, topbar, layout)
- [] Responsive layout (desktop-first for office use)
- [ ] Activity log middleware setup

#### 🔑 Default Roles to Seed

```php
// database/seeders/RoleSeeder.php
$roles = [
    'super_admin',
    'admin',
    'manager',
    'teller',
    'viewer',
];

// Permissions per module
$permissions = [
    // User Management
    'view_users', 'create_users', 'edit_users', 'delete_users', 'activate_users',

    // Role & Permission
    'view_roles', 'create_roles', 'edit_roles', 'delete_roles', 'assign_permissions',

    // Settings
    'view_settings', 'edit_settings',

    // Customer
    'view_customers', 'create_customers', 'edit_customers', 'delete_customers',
    'suspend_customers', 'blacklist_customers',

    // KYC
    'view_kyc', 'upload_kyc', 'approve_kyc', 'reject_kyc',

    // Account Types
    'view_account_types', 'create_account_types', 'edit_account_types',

    // Accounts
    'view_accounts', 'create_accounts', 'edit_accounts', 'freeze_accounts', 'close_accounts',

    // Transactions
    'create_deposit', 'create_withdrawal', 'create_internal_transfer',
    'create_external_transfer', 'view_transactions', 'reverse_transactions',
    'approve_transactions',

    // Reports
    'view_reports', 'export_reports',
];
```

#### 📁 Key Files Created
```
app/Http/Middleware/CheckPermission.php
database/seeders/RolePermissionSeeder.php
database/seeders/SuperAdminSeeder.php
resources/js/Layouts/AuthenticatedLayout.jsx
resources/js/Layouts/AppLayout.jsx
resources/js/Components/Sidebar.jsx
resources/js/Components/Topbar.jsx
resources/js/Pages/Dashboard.jsx
```

---

### Phase 2 — User & Settings Management *(Week 3)*

#### 🎯 Goal
Allow admins to manage system users and configure bank settings.

#### 📦 Deliverables — User Management
- [ ] List all users with filter (role, status, branch)
- [ ] Create new user (name, email, phone, role, branch)
- [ ] Edit user profile and role
- [ ] Activate / Deactivate user
- [ ] Reset user password (admin)
- [ ] View user activity log
- [ ] View user login history

#### 📦 Deliverables — Settings Management

##### General Settings
- [ ] Bank name, logo, tagline
- [ ] Address, city, state, country, postal code
- [ ] Contact phone and email
- [ ] Default currency (symbol, code, decimal places)
- [ ] Timezone and date format

##### Transaction Settings
- [ ] Max cash deposit limit per transaction
- [ ] Max cash deposit limit per day (per account)
- [ ] Max cash withdrawal limit per transaction
- [ ] Max cash withdrawal limit per day (per account)
- [ ] Max fund transfer limit per transaction
- [ ] Approval threshold (transactions above this need manager approval)
- [ ] Dormant account period (days of inactivity)

##### Security Settings
- [ ] Session timeout (minutes)
- [ ] Max failed login attempts before lockout
- [ ] Account lockout duration (minutes)
- [ ] Password expiry (days)
- [ ] Two-factor authentication enforcement by role

##### Notification Settings
- [ ] SMTP host, port, username, password, encryption
- [ ] From email, from name
- [ ] SMS gateway (Twilio / custom)
- [ ] SMS API key and sender ID
- [ ] Toggle notifications: deposit, withdrawal, transfer, login, KYC status

##### Branch Management
- [ ] Create / edit / deactivate branches
- [ ] Assign branch manager

#### 📁 Key Files Created
```
app/Http/Controllers/UserManagement/UserController.php
app/Http/Controllers/Settings/SettingController.php
app/Http/Controllers/Settings/BranchController.php
app/Services/UserService.php
app/Services/SettingService.php
resources/js/Pages/UserManagement/Index.jsx
resources/js/Pages/UserManagement/Create.jsx
resources/js/Pages/UserManagement/Edit.jsx
resources/js/Pages/Settings/General.jsx
resources/js/Pages/Settings/Transaction.jsx
resources/js/Pages/Settings/Security.jsx
resources/js/Pages/Settings/Notification.jsx
resources/js/Pages/Settings/Branch.jsx
```

---

### Phase 3 — Customer & KYC Management *(Week 4–5)*

#### 🎯 Goal
Build customer onboarding and KYC document verification workflows.

#### 📦 Deliverables — Customer Management
- [ ] Customer list with search, filter (status, branch, KYC status)
- [ ] Create customer (full profile form)
- [ ] Auto-generate customer number: `CUS-2026-00001`
- [ ] Edit customer profile
- [ ] View customer details (profile + accounts + KYC + transactions)
- [ ] Activate / Deactivate customer
- [ ] Suspend customer (with reason)
- [ ] Blacklist customer (with reason)
- [ ] Customer photo upload
- [ ] Customer profile print / PDF

#### 📦 Deliverables — KYC Management
- [ ] Upload KYC document (document type, number, front/back image)
- [ ] KYC status badge: `Pending | Verified | Rejected | Expired`
- [ ] KYC review dashboard (pending KYC queue for managers)
- [ ] Approve KYC with reviewer notes
- [ ] Reject KYC with rejection reason
- [ ] Notify customer (email/SMS) on KYC approval/rejection
- [ ] KYC expiry date tracking
- [ ] Re-KYC alerts (configurable interval, e.g., every 2 years)
- [ ] Bulk KYC status export

#### KYC Workflow Diagram

```
Customer Registered (status: active, kyc_status: pending)
          │
          ▼
Teller uploads KYC documents
          │
          ▼
KYC Queue (pending) ──────────────────────────────────┐
          │                                            │
          ▼                                            │
Manager reviews documents                              │
          │                                            │
    ┌─────┴──────┐                                    │
    │            │                                    │
  Approve      Reject ─→ Rejection reason saved        │
    │            │       Notification sent to teller   │
    │            └─────→ Teller re-uploads ────────────┘
    │
    ▼
KYC Verified (kyc_status: verified)
    │
    ▼
Account creation now allowed
```

#### 📁 Key Files Created
```
app/Http/Controllers/Customer/CustomerController.php
app/Http/Controllers/KYC/KYCController.php
app/Services/CustomerService.php
app/Services/KYCService.php
app/Jobs/SendKYCNotificationJob.php
resources/js/Pages/Customer/Index.jsx
resources/js/Pages/Customer/Create.jsx
resources/js/Pages/Customer/Show.jsx
resources/js/Pages/KYC/Review.jsx
resources/js/Pages/KYC/Upload.jsx
```

---

### Phase 4 — Account Management *(Week 6)*

#### 🎯 Goal
Create and manage account types and individual customer accounts.

#### 📦 Deliverables — Account Type Management
- [ ] List all account types
- [ ] Create account type (name, code, rates, limits)
- [ ] Edit account type
- [ ] Activate / Deactivate account type
- [ ] View accounts count per type

#### Account Type Fields
| Field | Type | Example |
|-------|------|---------|
| Name | string | Savings Account |
| Code | string | SAV |
| Interest Rate | decimal | 3.50% |
| Minimum Balance | decimal | ₹500.00 |
| Maximum Balance | decimal | ₹10,00,000.00 |
| Daily Deposit Limit | decimal | ₹1,00,000.00 |
| Daily Withdrawal Limit | decimal | ₹50,000.00 |
| Monthly Free Transactions | integer | 5 |
| Requires KYC | boolean | Yes |
| Status | enum | Active |

#### 📦 Deliverables — Account Management
- [ ] List accounts with search & filter (type, status, branch, customer)
- [ ] Open new account (customer must have verified KYC)
- [ ] Auto-generate account number (10-digit: `1001000001`)
- [ ] Set opening balance
- [ ] Edit account details
- [ ] View account details (balance, transactions, status)
- [ ] Freeze account (with reason)
- [ ] Unfreeze account
- [ ] Mark account as dormant (auto-trigger or manual)
- [ ] Reactivate dormant account
- [ ] Close account (with closure reason)
- [ ] Account statement (date range → PDF/CSV)
- [ ] Mini statement (last 10 transactions)
- [ ] Account balance inquiry

#### Account Number Generation Logic
```php
// app/Services/AccountService.php
public function generateAccountNumber(int $branchId): string
{
    $branchCode = str_pad($branchId, 3, '0', STR_PAD_LEFT);
    $lastAccount = Account::where('account_number', 'LIKE', "1{$branchCode}%")
                          ->orderBy('id', 'desc')
                          ->first();
    $sequence = $lastAccount
        ? (int)substr($lastAccount->account_number, 4) + 1
        : 1;

    return "1{$branchCode}" . str_pad($sequence, 6, '0', STR_PAD_LEFT);
    // Result: 1001000001, 1001000002 ...
}
```

#### 📁 Key Files Created
```
app/Http/Controllers/Account/AccountTypeController.php
app/Http/Controllers/Account/AccountController.php
app/Services/AccountService.php
resources/js/Pages/AccountType/Index.jsx
resources/js/Pages/AccountType/Create.jsx
resources/js/Pages/Account/Index.jsx
resources/js/Pages/Account/Create.jsx
resources/js/Pages/Account/Show.jsx
resources/js/Pages/Account/Statement.jsx
```

---

### Phase 5 — Transaction Engine *(Week 7–9)*

> ⚠️ **This is the most critical phase.** All transaction operations must be ACID-compliant, immutable, and auditable.

#### 🎯 Goal
Build the core financial transaction engine: deposits, withdrawals, and fund transfers.

---

#### Feature 7 — Cash Deposit

##### Flow
```
Teller selects Customer → Selects Account → Enters Amount + Narration
       ↓
Validation:
  - Account status = active
  - Amount > 0
  - Amount ≤ daily deposit limit (settings)
  - Amount ≤ account type max deposit limit
       ↓
DB::transaction() {
  - Create transaction record (status: completed)
  - Update account current_balance += amount
  - Update account last_transaction_at
}
       ↓
Generate Deposit Receipt (PDF)
       ↓
Send notification (SMS/Email) to customer
```

##### Deliverables
- [ ] Cash deposit form (customer search, account select, amount, narration)
- [ ] Real-time balance display before/after
- [ ] Daily limit validation
- [ ] Deposit receipt PDF generation
- [ ] SMS/email notification on successful deposit
- [ ] Deposit transaction history

---

#### Feature 8 — Cash Withdrawal

##### Flow
```
Teller selects Customer → Verifies identity → Selects Account → Enters Amount
       ↓
Validation:
  - Account status = active
  - Available balance ≥ amount
  - Amount > 0
  - Amount ≤ daily withdrawal limit
  - Amount ≤ account type min balance check
  - KYC status = verified
       ↓
Approval Check:
  - If amount > approval_threshold → Route to manager for approval
       ↓
DB::transaction() {
  - Create transaction record
  - Update account current_balance -= amount
  - Update account last_transaction_at
}
       ↓
Generate Withdrawal Receipt (PDF)
       ↓
Send notification (SMS/Email)
```

##### Deliverables
- [ ] Cash withdrawal form with validations
- [ ] Balance sufficiency check (real-time)
- [ ] Manager approval workflow (if above threshold)
- [ ] Withdrawal receipt PDF
- [ ] Pending approval dashboard for managers
- [ ] Approve / Reject transaction with remarks

---

#### Feature 9 — Internal Fund Transfer

##### Flow
```
Teller/Customer selects:
  - Source Account (from)
  - Destination Account (to — within same bank)
  - Amount + Narration
       ↓
Validation:
  - Both accounts are active
  - Source account has sufficient balance
  - Source ≠ Destination
  - Amount ≤ transfer limits
       ↓
DB::transaction() {
  - Debit source account (transaction_type: internal_transfer_debit)
  - Credit destination account (transaction_type: internal_transfer_credit)
  - Both transactions share same reference_number
  - Both use related_account_id to link each other
}
       ↓
Generate Transfer Confirmation (PDF)
       ↓
Notify both account holders
```

##### Deliverables
- [ ] Internal transfer form
- [ ] Destination account lookup (by account number)
- [ ] Atomic debit + credit (single DB transaction)
- [ ] Transfer confirmation slip PDF
- [ ] Linked transaction view (debit ↔ credit)

---

#### Feature 10 — External Fund Transfer (Other Bank)

##### Flow
```
Teller enters:
  - Source Account
  - Beneficiary Name, Bank, Account Number, IFSC Code
  - Amount, Narration
  - Transfer Mode (NEFT / RTGS / IMPS)
       ↓
Validation:
  - Source account active and has balance
  - IFSC code format validation
  - Amount limits per transfer mode
       ↓
Approval Workflow:
  - NEFT/RTGS above threshold → Manager approval required
       ↓
DB::transaction() {
  - Create transaction (status: pending)
  - Hold amount from account (deducted from available_balance)
  - Queue job to call payment gateway API
}
       ↓
Payment Gateway Response:
  - Success → Update status: completed, release hold, deduct balance
  - Failure  → Update status: failed, release hold, notify teller
       ↓
Generate Transfer Receipt
Send notification to customer
```

##### Deliverables
- [ ] External transfer form with IFSC lookup
- [ ] Beneficiary management (save frequent beneficiaries)
- [ ] Transfer mode selection (NEFT/RTGS/IMPS) with limits
- [ ] Async processing via Queue (Job)
- [ ] Transfer status tracking (pending → processing → completed/failed)
- [ ] Auto-reversal on failure
- [ ] Transfer receipt PDF

#### Transaction Reference Number Generation
```php
// app/Services/TransactionService.php
public function generateReference(): string
{
    $date = now()->format('Ymd');
    $count = Transaction::whereDate('created_at', today())->count() + 1;
    return 'TXN-' . $date . '-' . str_pad($count, 6, '0', STR_PAD_LEFT);
    // Result: TXN-20260225-000001
}
```

#### Core Transaction Service (Pseudo-code)
```php
// app/Services/TransactionService.php
public function processDeposit(array $data): Transaction
{
    return DB::transaction(function () use ($data) {

        $account = Account::lockForUpdate()->findOrFail($data['account_id']);

        // Validate
        throw_if($account->status !== 'active', new AccountNotActiveException());
        throw_if($data['amount'] <= 0, new InvalidAmountException());
        $this->validateDailyLimit($account, $data['amount'], 'deposit');

        // Record transaction
        $transaction = Transaction::create([
            'reference_number'  => $this->generateReference(),
            'transaction_type'  => 'cash_deposit',
            'account_id'        => $account->id,
            'amount'            => $data['amount'],
            'net_amount'        => $data['amount'],
            'balance_before'    => $account->current_balance,
            'balance_after'     => $account->current_balance + $data['amount'],
            'narration'         => $data['narration'],
            'value_date'        => today(),
            'status'            => 'completed',
            'processed_by'      => auth()->id(),
        ]);

        // Update balance
        $account->increment('current_balance', $data['amount']);
        $account->update(['last_transaction_at' => now()]);

        // Dispatch notification
        SendTransactionNotificationJob::dispatch($transaction);

        return $transaction;
    });
}
```

#### 📁 Key Files Created
```
app/Http/Controllers/Transaction/DepositController.php
app/Http/Controllers/Transaction/WithdrawalController.php
app/Http/Controllers/Transaction/InternalTransferController.php
app/Http/Controllers/Transaction/ExternalTransferController.php
app/Http/Controllers/Transaction/ApprovalController.php
app/Services/TransactionService.php
app/Services/ExternalTransferService.php
app/Jobs/ProcessExternalTransferJob.php
app/Jobs/SendTransactionNotificationJob.php
app/Exceptions/AccountNotActiveException.php
app/Exceptions/InsufficientBalanceException.php
app/Exceptions/DailyLimitExceededException.php
resources/js/Pages/Transaction/Deposit.jsx
resources/js/Pages/Transaction/Withdrawal.jsx
resources/js/Pages/Transaction/InternalTransfer.jsx
resources/js/Pages/Transaction/ExternalTransfer.jsx
resources/js/Pages/Transaction/Approvals.jsx
resources/js/Pages/Transaction/History.jsx
```

---

### Phase 6 — Reports & Statements *(Week 10)*

#### 📦 Deliverables

| Report | Filters | Export |
|--------|---------|--------|
| Account Statement | Account, Date Range | PDF, CSV |
| Daily Transaction Report | Branch, Date, Type | PDF, CSV |
| Cash Flow Report | Branch, Date Range | PDF, Chart |
| Pending KYC Report | Branch, Document Type | PDF, CSV |
| Dormant Accounts Report | Branch, Account Type | PDF, CSV |
| User Activity Report | User, Date Range | PDF, CSV |
| External Transfer Status | Date Range, Status | PDF, CSV |
| Pending Approval Report | Type, Amount Range | PDF |
| Branch Summary Report | Branch, Date | PDF |
| Customer Account Summary | Customer | PDF |

---

### Phase 7 — Testing *(Week 11)*

#### Unit Tests
- [ ] TransactionService (deposit, withdrawal, transfer)
- [ ] AccountService (account number generation, balance update)
- [ ] CustomerService (customer number generation)
- [ ] KYCService (status transitions)
- [ ] SettingService (setting get/set)

#### Feature Tests
- [ ] Authentication (login, logout, lockout)
- [ ] Permission enforcement (each role access test)
- [ ] Deposit flow (valid, invalid amount, daily limit exceeded)
- [ ] Withdrawal flow (insufficient balance, approval threshold)
- [ ] Internal transfer (same account error, inactive account)
- [ ] External transfer (IFSC validation, failure handling)
- [ ] KYC workflow (upload → approve → reject → re-upload)
- [ ] Account lifecycle (open → dormant → reactivate → close)

#### Critical Concurrency Tests
- [ ] Simultaneous withdrawal from same account
- [ ] Simultaneous transfer from same account
- [ ] Overdraft prevention under concurrent requests

```php
// Example: tests/Feature/Transaction/DepositTest.php
public function test_deposit_increases_account_balance(): void
{
    $account = Account::factory()->create(['current_balance' => 1000.00, 'status' => 'active']);

    $response = $this->actingAs($this->teller)
                     ->post('/transactions/deposit', [
                         'account_id' => $account->id,
                         'amount'     => 500.00,
                         'narration'  => 'Cash deposit test',
                     ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('accounts', [
        'id'              => $account->id,
        'current_balance' => 1500.00,
    ]);
    $this->assertDatabaseHas('transactions', [
        'account_id'       => $account->id,
        'amount'           => 500.00,
        'transaction_type' => 'cash_deposit',
        'status'           => 'completed',
    ]);
}
```

---

### Phase 8 — Deployment & Documentation *(Week 12)*

#### 📦 Deliverables
- [ ] Production server setup (Ubuntu 22.04 LTS)
- [ ] Nginx + PHP-FPM configuration
- [ ] PostgreSQL production configuration
- [ ] Redis production configuration
- [ ] SSL certificate (Let's Encrypt)
- [ ] `.env` production configuration
- [ ] Laravel queue worker setup (Supervisor)
- [ ] Laravel scheduler setup (cron)
- [ ] Backup strategy (daily DB + file backup)
- [ ] User manual (PDF for staff training)
- [ ] Admin/Teller training sessions
- [ ] Post-deployment smoke testing

#### Scheduled Tasks (cron)
```php
// app/Console/Kernel.php
$schedule->command('accounts:check-dormant')->dailyAt('00:01');
$schedule->command('kyc:check-expiry')->weeklyOn(1, '08:00');
$schedule->command('reports:daily-summary')->dailyAt('23:55');
$schedule->command('transactions:process-pending')->everyFiveMinutes();
```

---

## 7. Role & Permission Matrix

| Permission | Super Admin | Admin | Manager | Teller | Viewer |
|-----------|:-----------:|:-----:|:-------:|:------:|:------:|
| **User Management** |||||
| View Users | ✅ | ✅ | 👁️ | ❌ | ❌ |
| Create Users | ✅ | ✅ | ❌ | ❌ | ❌ |
| Edit Users | ✅ | ✅ | ❌ | ❌ | ❌ |
| Delete Users | ✅ | ❌ | ❌ | ❌ | ❌ |
| Activate/Deactivate | ✅ | ✅ | ❌ | ❌ | ❌ |
| **Roles & Permissions** |||||
| View Roles | ✅ | ✅ | ❌ | ❌ | ❌ |
| Create/Edit Roles | ✅ | ✅ | ❌ | ❌ | ❌ |
| Assign Permissions | ✅ | ❌ | ❌ | ❌ | ❌ |
| **Settings** |||||
| View Settings | ✅ | ✅ | 👁️ | ❌ | ❌ |
| Edit Settings | ✅ | ✅ | ❌ | ❌ | ❌ |
| **Customer Management** |||||
| View Customers | ✅ | ✅ | ✅ | 👁️ | 👁️ |
| Create Customers | ✅ | ✅ | ✅ | ✅ | ❌ |
| Edit Customers | ✅ | ✅ | ✅ | ❌ | ❌ |
| Suspend/Blacklist | ✅ | ✅ | ✅ | ❌ | ❌ |
| **KYC** |||||
| View KYC | ✅ | ✅ | ✅ | ✅ | 👁️ |
| Upload KYC | ✅ | ✅ | ✅ | ✅ | ❌ |
| Approve KYC | ✅ | ✅ | ✅ | ❌ | ❌ |
| Reject KYC | ✅ | ✅ | ✅ | ❌ | ❌ |
| **Account Types** |||||
| View Account Types | ✅ | ✅ | ✅ | 👁️ | 👁️ |
| Create/Edit Types | ✅ | ✅ | ❌ | ❌ | ❌ |
| **Accounts** |||||
| View Accounts | ✅ | ✅ | ✅ | ✅ | 👁️ |
| Open Account | ✅ | ✅ | ✅ | ❌ | ❌ |
| Freeze/Unfreeze | ✅ | ✅ | ✅ | ❌ | ❌ |
| Close Account | ✅ | ✅ | ❌ | ❌ | ❌ |
| **Transactions** |||||
| View Transactions | ✅ | ✅ | ✅ | ✅ | 👁️ |
| Cash Deposit | ✅ | ✅ | ✅ | ✅ | ❌ |
| Cash Withdrawal | ✅ | ✅ | ✅ | ✅ | ❌ |
| Internal Transfer | ✅ | ✅ | ✅ | ✅ | ❌ |
| External Transfer | ✅ | ✅ | ✅ | ✅ | ❌ |
| Approve Transactions | ✅ | ✅ | ✅ | ❌ | ❌ |
| Reverse Transactions | ✅ | ✅ | ❌ | ❌ | ❌ |
| **Reports** |||||
| View Reports | ✅ | ✅ | ✅ | 👁️ | 👁️ |
| Export Reports | ✅ | ✅ | ✅ | ❌ | ❌ |

> Legend: ✅ Full Access &nbsp; 👁️ View Only &nbsp; ❌ No Access

---

## 8. API Endpoint Plan

### Authentication
```
POST   /login                           → Authenticate user
POST   /logout                          → Logout user
POST   /forgot-password                 → Send reset link
POST   /reset-password                  → Reset password
GET    /two-factor                      → Show 2FA form
POST   /two-factor                      → Verify 2FA code
```

### User Management
```
GET    /users                           → List users
POST   /users                           → Create user
GET    /users/{id}                      → View user
PUT    /users/{id}                      → Update user
PATCH  /users/{id}/activate             → Activate user
PATCH  /users/{id}/deactivate           → Deactivate user
GET    /users/{id}/activity             → User activity log
```

### Roles & Permissions
```
GET    /roles                           → List roles
POST   /roles                           → Create role
GET    /roles/{id}                      → View role
PUT    /roles/{id}                      → Update role
POST   /roles/{id}/permissions          → Sync permissions
GET    /permissions                     → List all permissions
```

### Settings
```
GET    /settings                        → Get all settings
GET    /settings/{group}               → Get settings by group
PUT    /settings                        → Update settings (bulk)
GET    /branches                        → List branches
POST   /branches                        → Create branch
PUT    /branches/{id}                   → Update branch
```

### Customer
```
GET    /customers                       → List customers
POST   /customers                       → Create customer
GET    /customers/{id}                  → View customer
PUT    /customers/{id}                  → Update customer
PATCH  /customers/{id}/status           → Change status
GET    /customers/{id}/accounts         → Customer accounts
GET    /customers/{id}/kyc              → Customer KYC docs
```

### KYC
```
GET    /kyc                             → KYC queue (pending)
POST   /kyc                             → Upload KYC documents
GET    /kyc/{id}                        → View KYC document
PATCH  /kyc/{id}/approve                → Approve KYC
PATCH  /kyc/{id}/reject                 → Reject KYC
```

### Account Types
```
GET    /account-types                   → List account types
POST   /account-types                   → Create account type
GET    /account-types/{id}              → View account type
PUT    /account-types/{id}              → Update account type
```

### Accounts
```
GET    /accounts                        → List accounts
POST   /accounts                        → Open account
GET    /accounts/{id}                   → View account
PUT    /accounts/{id}                   → Update account
PATCH  /accounts/{id}/freeze            → Freeze account
PATCH  /accounts/{id}/unfreeze          → Unfreeze account
PATCH  /accounts/{id}/close             → Close account
GET    /accounts/{id}/statement         → Account statement
GET    /accounts/{id}/mini-statement    → Mini statement (last 10)
GET    /accounts/search?q={number}      → Search by account number
```

### Transactions
```
POST   /transactions/deposit            → Cash deposit
POST   /transactions/withdrawal         → Cash withdrawal
POST   /transactions/transfer/internal  → Internal fund transfer
POST   /transactions/transfer/external  → External fund transfer
GET    /transactions                    → Transaction history
GET    /transactions/{id}               → View transaction
GET    /transactions/{id}/receipt       → Download receipt (PDF)
POST   /transactions/{id}/reverse       → Reverse transaction
```

### Approvals
```
GET    /approvals                       → Pending approvals list
PATCH  /approvals/{id}/approve          → Approve transaction
PATCH  /approvals/{id}/reject           → Reject transaction
```

### Reports
```
GET    /reports/account-statement       → Account statement report
GET    /reports/daily-transactions      → Daily transaction report
GET    /reports/cash-flow               → Cash flow report
GET    /reports/kyc-status              → KYC status report
GET    /reports/dormant-accounts        → Dormant accounts report
GET    /reports/user-activity           → User activity report
GET    /reports/external-transfers      → External transfer report
```

---

## 9. Security Checklist

### Authentication Security
- [ ] Passwords hashed with `bcrypt` (cost factor ≥ 12) or `Argon2id`
- [ ] Two-Factor Authentication (TOTP) for Admin and Manager roles
- [ ] Account lockout after N failed login attempts (configurable)
- [ ] Session invalidated on logout
- [ ] Session timeout after inactivity (configurable)
- [ ] Secure session cookies (HttpOnly, Secure, SameSite=Strict)
- [ ] Password complexity enforcement
- [ ] Password expiry policy (e.g., every 90 days)

### Application Security
- [ ] HTTPS enforced (HTTP → HTTPS redirect)
- [ ] SSL/TLS certificate (minimum TLS 1.2, prefer 1.3)
- [ ] CSRF protection on all state-changing requests
- [ ] All inputs validated and sanitized server-side
- [ ] Parameterized queries (Eloquent ORM — no raw SQL concatenation)
- [ ] File uploads validated (type, size, MIME type)
- [ ] KYC files stored outside `public/` directory
- [ ] Signed URLs for file downloads
- [ ] Rate limiting on login, transaction, and API endpoints

### Transaction Security
- [ ] All transactions in `DB::transaction()` blocks
- [ ] Row-level locking (`lockForUpdate()`) on balance updates
- [ ] Unique reference numbers for all transactions
- [ ] Transactions are IMMUTABLE (no update/delete — reversal only)
- [ ] Atomic debit + credit for internal transfers
- [ ] Daily limit validation before processing
- [ ] Balance check before withdrawal/transfer
- [ ] Approval workflow for large transactions
- [ ] Complete audit trail for every transaction

### Infrastructure Security
- [ ] Database not exposed to public internet
- [ ] Redis protected with password
- [ ] `.env` file never committed to git
- [ ] Sensitive keys in environment variables (not in code)
- [ ] Regular automated backups (database + files)
- [ ] Backup encryption
- [ ] Server firewall (UFW) — only allow ports 80, 443, 22
- [ ] SSH key-based authentication (no password login)
- [ ] Regular security updates (OS + dependencies)

### Compliance
- [ ] Complete audit log for every action (who, what, when, before, after)
- [ ] IP address logged for all transactions
- [ ] User agent logged for all sessions
- [ ] Data retention policy documented
- [ ] KYC document access controlled by role

---

## 10. Folder Structure

```
banking-app/
├── app/
│   ├── Console/
│   │   └── Commands/
│   │       ├── CheckDormantAccounts.php
│   │       ├── CheckKYCExpiry.php
│   │       └── ProcessPendingTransfers.php
│   ├── Exceptions/
│   │   ├── AccountNotActiveException.php
│   │   ├── InsufficientBalanceException.php
│   │   ├── DailyLimitExceededException.php
│   │   ├── KYCNotVerifiedException.php
│   │   └── AccountFrozenException.php
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/
│   │   │   │   ├── LoginController.php
│   │   │   │   └── TwoFactorController.php
│   │   │   ├── UserManagement/
│   │   │   │   └── UserController.php
│   │   │   ├── Role/
│   │   │   │   ├── RoleController.php
│   │   │   │   └── PermissionController.php
│   │   │   ├── Settings/
│   │   │   │   ├── SettingController.php
│   │   │   │   └── BranchController.php
│   │   │   ├── Customer/
│   │   │   │   └── CustomerController.php
│   │   │   ├── KYC/
│   │   │   │   └── KYCController.php
│   │   │   ├── Account/
│   │   │   │   ├── AccountTypeController.php
│   │   │   │   └── AccountController.php
│   │   │   ├── Transaction/
│   │   │   │   ├── DepositController.php
│   │   │   │   ├── WithdrawalController.php
│   │   │   │   ├── InternalTransferController.php
│   │   │   │   ├── ExternalTransferController.php
│   │   │   │   └── ApprovalController.php
│   │   │   └── Report/
│   │   │       └── ReportController.php
│   │   ├── Middleware/
│   │   │   ├── CheckPermission.php
│   │   │   ├── LogActivity.php
│   │   │   └── EnforcePasswordExpiry.php
│   │   └── Requests/
│   │       ├── Customer/
│   │       │   └── CreateCustomerRequest.php
│   │       └── Transaction/
│   │           ├── DepositRequest.php
│   │           ├── WithdrawalRequest.php
│   │           ├── InternalTransferRequest.php
│   │           └── ExternalTransferRequest.php
│   ├── Jobs/
│   │   ├── ProcessExternalTransferJob.php
│   │   ├── SendTransactionNotificationJob.php
│   │   └── SendKYCNotificationJob.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Branch.php
│   │   ├── Setting.php
│   │   ├── Customer.php
│   │   ├── KYCDocument.php
│   │   ├── AccountType.php
│   │   ├── Account.php
│   │   ├── Transaction.php
│   │   └── TransactionApproval.php
│   ├── Repositories/
│   │   ├── AccountRepository.php
│   │   ├── CustomerRepository.php
│   │   └── TransactionRepository.php
│   └── Services/
│       ├── UserService.php
│       ├── SettingService.php
│       ├── CustomerService.php
│       ├── KYCService.php
│       ├── AccountService.php
│       ├── TransactionService.php
│       ├── ExternalTransferService.php
│       └── NotificationService.php
├── database/
│   ├── migrations/
│   │   ├── 2026_01_01_create_branches_table.php
│   │   ├── 2026_01_02_create_users_table.php
│   │   ├── 2026_01_03_create_settings_table.php
│   │   ├── 2026_01_04_create_customers_table.php
│   │   ├── 2026_01_05_create_kyc_documents_table.php
│   │   ├── 2026_01_06_create_account_types_table.php
│   │   ├── 2026_01_07_create_accounts_table.php
│   │   ├── 2026_01_08_create_transactions_table.php
│   │   └── 2026_01_09_create_transaction_approvals_table.php
│   └── seeders/
│       ├── DatabaseSeeder.php
│       ├── RolePermissionSeeder.php
│       ├── SuperAdminSeeder.php
│       ├── SettingSeeder.php
│       ├── BranchSeeder.php
│       └── AccountTypeSeeder.php
├── resources/
│   ├── js/
│   │   ├── Components/
│   │   │   ├── Layout/
│   │   │   │   ├── AppLayout.jsx
│   │   │   │   ├── Sidebar.jsx
│   │   │   │   └── Topbar.jsx
│   │   │   ├── UI/
│   │   │   │   ├── Button.jsx
│   │   │   │   ├── Input.jsx
│   │   │   │   ├── Modal.jsx
│   │   │   │   ├── Table.jsx
│   │   │   │   ├── Badge.jsx
│   │   │   │   └── Pagination.jsx
│   │   │   └── Transaction/
│   │   │       ├── ReceiptModal.jsx
│   │   │       └── ApprovalBadge.jsx
│   │   └── Pages/
│   │       ├── Auth/
│   │       │   ├── Login.jsx
│   │       │   └── TwoFactor.jsx
│   │       ├── Dashboard.jsx
│   │       ├── UserManagement/
│   │       │   ├── Index.jsx
│   │       │   ├── Create.jsx
│   │       │   └── Edit.jsx
│   │       ├── Role/
│   │       │   ├── Index.jsx
│   │       │   └── Edit.jsx
│   │       ├── Settings/
│   │       │   ├── General.jsx
│   │       │   ├── Transaction.jsx
│   │       │   ├── Security.jsx
│   │       │   ├── Notification.jsx
│   │       │   └── Branch.jsx
│   │       ├── Customer/
│   │       │   ├── Index.jsx
│   │       │   ├── Create.jsx
│   │       │   ├── Edit.jsx
│   │       │   └── Show.jsx
│   │       ├── KYC/
│   │       │   ├── Queue.jsx
│   │       │   ├── Upload.jsx
│   │       │   └── Review.jsx
│   │       ├── AccountType/
│   │       │   ├── Index.jsx
│   │       │   └── Form.jsx
│   │       ├── Account/
│   │       │   ├── Index.jsx
│   │       │   ├── Create.jsx
│   │       │   ├── Show.jsx
│   │       │   └── Statement.jsx
│   │       ├── Transaction/
│   │       │   ├── Deposit.jsx
│   │       │   ├── Withdrawal.jsx
│   │       │   ├── InternalTransfer.jsx
│   │       │   ├── ExternalTransfer.jsx
│   │       │   ├── History.jsx
│   │       │   └── Approvals.jsx
│   │       └── Report/
│   │           └── Index.jsx
│   └── views/
│       └── pdf/
│           ├── deposit-receipt.blade.php
│           ├── withdrawal-receipt.blade.php
│           ├── transfer-receipt.blade.php
│           └── account-statement.blade.php
├── routes/
│   ├── web.php
│   └── api.php
└── tests/
    ├── Unit/
    │   ├── Services/
    │   │   ├── TransactionServiceTest.php
    │   │   └── AccountServiceTest.php
    └── Feature/
        ├── Auth/
        │   └── LoginTest.php
        ├── Transaction/
        │   ├── DepositTest.php
        │   ├── WithdrawalTest.php
        │   ├── InternalTransferTest.php
        │   └── ExternalTransferTest.php
        └── KYC/
            └── KYCWorkflowTest.php
```

---


## 12. Key Business Rules

### Transactions
1. **Transactions are IMMUTABLE** — Never UPDATE or DELETE. Use reversal entries only.
2. **ACID compliance** — Every balance update must be inside `DB::transaction()`
3. **Row-level locking** — Use `lockForUpdate()` when reading balance before updating
4. **Unique reference numbers** — Every transaction gets a unique, traceable reference
5. **Balance trail** — Always store `balance_before` and `balance_after`
6. **Approval workflow** — Any transaction above the configured threshold requires manager approval
7. **Notifications** — Customer must be notified (SMS/email) for every completed transaction

### Accounts
1. **KYC required** — A customer must have verified KYC before opening an account
2. **Minimum balance** — Withdrawal must not bring balance below account type minimum
3. **Dormancy** — Account marked dormant after N days of inactivity (configurable)
4. **Frozen accounts** — No transactions allowed on frozen accounts
5. **Closed accounts** — No transactions allowed; balance must be zero before closing

### KYC
1. **Expiry tracking** — KYC must be renewed before expiry date
2. **Re-KYC** — System must alert manager N days before KYC expiry
3. **File security** — KYC documents stored in `storage/` (not `public/`)
4. **Single primary** — Each customer should have exactly one primary KYC document marked

### Users
1. **Password expiry** — Users must change password after configured days
2. **Account lockout** — Account locked after N failed attempts (auto-unlock after M minutes)
3. **Session management** — Session invalidated after timeout or manual logout
4. **Audit trail** — Every action by every user is logged

---

## 13. Full Timeline

| Phase | Week | Module | Deliverable |
|-------|------|--------|-------------|
| **Phase 1** | Week 1 | Foundation | Project setup, DB, Redis, Auth |
| **Phase 1** | Week 2 | Roles & Permissions | RBAC, permissions seeder, dashboard |
| **Phase 2** | Week 3 | User + Settings | User CRUD, all settings groups, branches |
| **Phase 3** | Week 4 | Customer Management | Customer CRUD, profile, status management |
| **Phase 3** | Week 5 | KYC Management | KYC upload, review workflow, notifications |
| **Phase 4** | Week 6 | Account Management | Account types, account CRUD, statement |
| **Phase 5** | Week 7 | Deposits + Withdrawals | Cash deposit, withdrawal, approval flow |
| **Phase 5** | Week 8 | Internal Transfers | Internal fund transfer, atomic transactions |
| **Phase 5** | Week 9 | External Transfers | NEFT/RTGS/IMPS, async processing, status |
| **Phase 6** | Week 10 | Reports | All reports, PDF/CSV export |
| **Phase 7** | Week 11 | Testing | Unit, feature, concurrency tests |
| **Phase 8** | Week 12 | Deployment | Production server, SSL, training, docs |

**Total: 12 Weeks / ~3 Months**

---

## 14. Getting Started — First Steps

### Step 1: Install Laravel

```bash
composer create-project laravel/laravel banking-app
cd banking-app
```

### Step 2: Install Core Packages

```bash
# Inertia + React
composer require inertiajs/inertia-laravel
php artisan inertia:middleware

# Auth Scaffold (Breeze with React + Inertia)
composer require laravel/breeze --dev
php artisan breeze:install react --typescript

# Permissions
composer require spatie/laravel-permission
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"

# Activity Log
composer require spatie/laravel-activitylog
php artisan vendor:publish --provider="Spatie\Activitylog\ActivitylogServiceProvider" --tag="activitylog-migrations"

# PDF
composer require barryvdh/laravel-dompdf

# Telescope (Dev)
composer require laravel/telescope --dev
php artisan telescope:install
```

### Step 3: Configure .env

```bash
cp .env.example .env
php artisan key:generate
# Edit .env: set DB_*, REDIS_*, MAIL_* values
```

### Step 4: Run Migrations & Seeders

```bash
php artisan migrate
php artisan db:seed --class=RolePermissionSeeder
php artisan db:seed --class=SuperAdminSeeder
php artisan db:seed --class=SettingSeeder
php artisan db:seed --class=BranchSeeder
php artisan db:seed --class=AccountTypeSeeder
```

### Step 5: Build Frontend

```bash
npm install
npm run dev
```

### Step 6: Start Development Server

```bash
php artisan serve
# Open: http://localhost:8000
# Login: admin@bank.com / password
```

### Step 7: Start Queue Worker

```bash
php artisan queue:work redis --queue=notifications,transfers,default
```

---

## ⚠️ Critical Reminders

> 🔴 **NEVER** update or delete transaction records. Use reversal transactions only.

> 🔴 **ALWAYS** wrap balance updates in `DB::transaction()` with `lockForUpdate()`.

> 🔴 **ALWAYS** check account status, KYC status, and balance BEFORE processing any transaction.

> 🔴 **NEVER** store KYC documents in the `public/` folder.

> 🟡 Build and test each phase completely before moving to the next.

> 🟡 Test concurrent transaction scenarios to prevent race conditions.

> 🟢 Start simple — build the core flow first, then add notifications, PDFs, and reports.

---

*Document Version: 1.0.0 | Last Updated: 2026-02-25 | Author: @dkpankaj1i*