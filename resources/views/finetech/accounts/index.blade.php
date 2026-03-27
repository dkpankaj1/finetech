<x-app-layout>

    @php
        $list = collect($accounts);
        $totalAccounts = method_exists($accounts, 'total') ? $accounts->total() : $accounts->count();
        $activeAccounts = $list->where('status', 'active')->count();
        $frozenAccounts = $list->where('status', 'frozen')->count();
        $visibleBalance = $list->sum('current_balance');
    @endphp

    {{-- Page Header --}}
    <div class="py-3 py-lg-4">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h4 class="page-title mb-0">
                    <i class="fas fa-university me-2 text-primary"></i>Accounts
                </h4>
                <p class="text-muted mb-0 small mt-1">Search, monitor, and manage customer accounts from a single view.</p>
            </div>
            <div class="col-lg-6">
                <div class="d-none d-lg-block">
                    <ol class="breadcrumb m-0 float-end">
                        <li class="breadcrumb-item"><a href="{{ route('finetech.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Accounts</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    {{-- Snapshot Cards --}}
    <div class="row g-3 mb-3">
        <div class="col-12 col-md-6 col-xl-3">
            <div class="card border-0 h-100 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted text-uppercase small mb-1">Total Accounts</p>
                            <h4 class="mb-0">{{ number_format($totalAccounts) }}</h4>
                        </div>
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle">
                            <i class="fas fa-layer-group me-1"></i>All
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-xl-3">
            <div class="card border-0 h-100 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted text-uppercase small mb-1">Active Accounts</p>
                            <h4 class="mb-0">{{ number_format($activeAccounts) }}</h4>
                        </div>
                        <span class="badge bg-success-subtle text-success border border-success-subtle">
                            <i class="fas fa-check-circle me-1"></i>Active
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-xl-3">
            <div class="card border-0 h-100 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted text-uppercase small mb-1">Frozen Accounts</p>
                            <h4 class="mb-0">{{ number_format($frozenAccounts) }}</h4>
                        </div>
                        <span class="badge bg-info-subtle text-info border border-info-subtle">
                            <i class="fas fa-snowflake me-1"></i>Frozen
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-xl-3">
            <div class="card border-0 h-100 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted text-uppercase small mb-1">Visible Balance</p>
                            <h4 class="mb-0">{{ number_format($visibleBalance, 2) }}</h4>
                        </div>
                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle">
                            <i class="fas fa-wallet me-1"></i>Total
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter Panel --}}
    <div class="card border-0 mb-3 shadow-sm">
        <div class="card-body">
            <div class="row g-3 align-items-end">
                <div class="col-12 col-xl-8">
                    <label for="accountSearch" class="form-label mb-1 small text-muted">Find Account</label>
                    <form action="{{ route('finetech.accounts.search') }}" method="GET" class="d-flex flex-column flex-md-row gap-2">
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span>
                            <input id="accountSearch" type="text" name="q" value="{{ $searchQuery ?? '' }}" class="form-control"
                                placeholder="Search by customer name, account number, mobile, email or customer ID">
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search me-1"></i>Search
                            </button>
                            @if(!empty($searchQuery))
                                <a href="{{ route('finetech.accounts.index') }}" class="btn btn-outline-secondary">Clear</a>
                            @endif
                        </div>
                    </form>
                </div>
                <div class="col-12 col-xl-4 d-flex justify-content-xl-end">
                    <x-button icon="add" variant="primary" text="Open New Account" href="{{ route('finetech.accounts.create') }}" />
                </div>
            </div>
            @if(!empty($searchQuery))
                <div class="alert alert-light border mt-3 mb-0 py-2 px-3 small">
                    Showing results for <strong>{{ $searchQuery }}</strong>.
                </div>
            @endif
        </div>
    </div>

    {{-- Table Card --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
            <h6 class="mb-0 card-title"><i class="fas fa-list me-2"></i>Account Directory</h6>
            <span class="badge bg-light text-dark border">{{ $list->count() }} visible row(s)</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">#</th>
                            <th>Account No.</th>
                            <th>Customer</th>
                            <th>Type</th>
                            <th>Branch</th>
                            <th>Currency</th>
                            <th class="text-end">Balance</th>
                            <th>Status</th>
                            <th class="text-end pe-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($accounts as $key => $account)
                            <tr>
                                <td class="ps-3 text-muted small">{{ ++$key }}</td>
                                <td>
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle">
                                        {{ $account->account_number }}
                                    </span>
                                </td>
                                <td>
                                    <div class="fw-semibold small">{{ $account->customer->first_name }} {{ $account->customer->last_name }}</div>
                                    <div class="text-muted" style="font-size:11px;">{{ $account->customer->customer_number }} | {{ $account->customer->phone }}</div>
                                </td>
                                <td class="small">{{ $account->accountType->name }}</td>
                                <td class="small text-muted">{{ $account->branch->name ?? '—' }}</td>
                                <td class="small">{{ $account->currency->code }}</td>
                                <td class="text-end fw-semibold small">
                                    {{ $account->currency->symbol }}{{ number_format($account->current_balance, 2) }}
                                </td>
                                <td>
                                    @switch($account->status)
                                        @case('active')
                                            <span class="badge bg-success-subtle text-success border border-success-subtle">Active</span>
                                            @break
                                        @case('frozen')
                                            <span class="badge bg-info-subtle text-info border border-info-subtle">Frozen</span>
                                            @break
                                        @case('dormant')
                                            <span class="badge bg-warning-subtle text-warning border border-warning-subtle">Dormant</span>
                                            @break
                                        @case('closed')
                                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle">Closed</span>
                                            @break
                                    @endswitch
                                </td>
                                <td class="text-end pe-3">
                                    <div class="d-flex justify-content-end gap-1">
                                        <x-button size="sm" icon="show" variant="outline-primary"
                                            href="{{ route('finetech.accounts.show', $account) }}" text="View" />
                                        <x-button size="sm" icon="edit" variant="outline-info" text="Edit"
                                            href="{{ route('finetech.accounts.edit', $account) }}" />
                                        <button type="button" class="btn btn-sm btn-outline-danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#confirmDeleteModal"
                                            data-delete-url="{{ route('finetech.accounts.destroy', $account) }}"
                                            data-item-name="{{ $account->account_number }}">
                                            <i class="fas fa-trash me-1"></i>Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-5 text-muted">
                                    <i class="fas fa-university fa-2x mb-2 d-block opacity-25"></i>
                                    No accounts found for this view. <a href="{{ route('finetech.accounts.create') }}">Open one now</a>.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Confirm Delete Modal --}}
    <x-confirm-delete-model modal-id="confirmDeleteModal" title="Delete Account"
        message="Are you sure you want to delete this account? This action cannot be undone." />

</x-app-layout>
