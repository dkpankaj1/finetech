<x-app-layout>

    {{-- Page Header --}}
    <div class="py-3 py-lg-4">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h4 class="page-title mb-0">
                    <i class="fas fa-layer-group me-2 text-primary"></i>Account Types
                </h4>
            </div>
            <div class="col-lg-6">
                <div class="d-none d-lg-block">
                    <ol class="breadcrumb m-0 float-end">
                        <li class="breadcrumb-item"><a href="{{ route('finetech.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Account Types</li>
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
                Total <strong>{{ $accountTypes->count() }}</strong> account type(s) registered in the system.
            </span>
            <x-button icon="add" variant="primary" text="Add New Account Type" href="{{ route('finetech.account-types.create') }}" />
        </div>
    </div>

    {{-- Table Card --}}
    <div class="card border-0">
        <div class="card-header bg-primary bg-opacity-10 border-0 py-3">
            <h6 class="mb-0 card-title">
                <i class="fas fa-list me-2"></i>Manage Account Types
            </h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">#</th>
                            <th>Name</th>
                            <th>Code</th>
                            <th>Interest Rate</th>
                            <th>Min Balance</th>
                            <th>KYC</th>
                            <th>Status</th>
                            <th class="text-end pe-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($accountTypes as $key => $accountType)
                            <tr>
                                <td class="ps-3 text-muted small">{{ ++$key }}</td>
                                <td>
                                    <div class="fw-semibold small">{{ $accountType->name }}</div>
                                </td>
                                <td>
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle">
                                        {{ $accountType->code }}
                                    </span>
                                </td>
                                <td class="small">
                                    {{ number_format($accountType->interest_rate, 2) }}%
                                </td>
                                <td class="small">
                                    {{ number_format($accountType->minimum_balance, 2) }}
                                </td>
                                <td>
                                    @if ($accountType->requires_kyc)
                                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle">Required</span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">Not Required</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($accountType->is_active)
                                        <span class="badge bg-success-subtle text-success border border-success-subtle">Active</span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle">Inactive</span>
                                    @endif
                                </td>
                                <td class="text-end pe-3">
                                    <div class="d-flex justify-content-end gap-1">
                                        <x-button size="sm" icon="show" variant="outline-primary"
                                            href="{{ route('finetech.account-types.show', $accountType) }}" text="View" />
                                        <x-button size="sm" icon="edit" variant="outline-info" text="Edit"
                                            href="{{ route('finetech.account-types.edit', $accountType) }}" />
                                        <button type="button" class="btn btn-sm btn-outline-danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#confirmDeleteModal"
                                            data-delete-url="{{ route('finetech.account-types.destroy', $accountType) }}"
                                            data-item-name="{{ $accountType->name }}">
                                            <i class="fas fa-trash me-1"></i>Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="fas fa-layer-group fa-2x mb-2 d-block opacity-25"></i>
                                    No account types found. <a href="{{ route('finetech.account-types.create') }}">Create one now</a>.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Confirm Delete Modal --}}
    <x-confirm-delete-model modal-id="confirmDeleteModal" title="Delete Account Type"
        message="Are you sure you want to delete this account type? This action cannot be undone." />

</x-app-layout>
