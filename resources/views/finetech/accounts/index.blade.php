<x-app-layout>

    {{-- Page Header --}}
    <div class="py-3 py-lg-4">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h4 class="page-title mb-0">
                    <i class="fas fa-university me-2 text-primary"></i>Accounts
                </h4>
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

    {{-- Action Bar --}}
    <div class="card border-0 mb-3">
        <div class="card-body py-2 d-flex justify-content-between align-items-center">
            <span class="text-muted small">
                <i class="fas fa-info-circle me-1"></i>
                Total <strong>{{ $accounts->count() }}</strong> account(s) in the system.
            </span>
            <x-button icon="add" variant="primary" text="Open New Account" href="{{ route('finetech.accounts.create') }}" />
        </div>
    </div>

    {{-- Table Card --}}
    <div class="card border-0">
        <div class="card-header bg-primary bg-opacity-10 border-0 py-3">
            <h6 class="mb-0 card-title">
                <i class="fas fa-list me-2"></i>Manage Accounts
            </h6>
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
                                    <div class="text-muted" style="font-size:11px;">{{ $account->customer->customer_number }}</div>
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
                                    No accounts found. <a href="{{ route('finetech.accounts.create') }}">Open one now</a>.
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
