<x-app-layout>

    {{-- Page Header --}}
    <div class="py-3 py-lg-4">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h4 class="page-title mb-0">
                    <i class="fas fa-id-card me-2 text-primary"></i>KYC Documents
                </h4>
            </div>
            <div class="col-lg-6">
                <div class="d-none d-lg-block">
                    <ol class="breadcrumb m-0 float-end">
                        <li class="breadcrumb-item"><a href="{{ route('finetech.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">KYC Documents</li>
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
                Total <strong>{{ $kycDocuments->count() }}</strong> KYC document(s) in the system.
            </span>
            <x-button icon="add" variant="primary" text="Add New KYC Document" href="{{ route('finetech.kyc-documents.create') }}" />
        </div>
    </div>

    {{-- Table Card --}}
    <div class="card border-0">
        <div class="card-header bg-primary bg-opacity-10 border-0 py-3">
            <h6 class="mb-0 card-title">
                <i class="fas fa-list me-2"></i>Manage KYC Documents
            </h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">#</th>
                            <th>Customer</th>
                            <th>Document Type</th>
                            <th>Document No.</th>
                            <th>Expiry</th>
                            <th>Status</th>
                            <th>Reviewed By</th>
                            <th class="text-end pe-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($kycDocuments as $key => $kyc)
                            <tr>
                                <td class="ps-3 text-muted small">{{ ++$key }}</td>
                                <td>
                                    <div class="fw-semibold small">{{ $kyc->customer->first_name ?? '' }} {{ $kyc->customer->last_name ?? '' }}</div>
                                    <div class="text-muted" style="font-size:11px;">{{ $kyc->customer->customer_number ?? '' }}</div>
                                </td>
                                <td>
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle">
                                        {{ str_replace('_', ' ', ucfirst($kyc->document_type)) }}
                                    </span>
                                </td>
                                <td class="small fw-semibold">{{ $kyc->document_number }}</td>
                                <td class="small text-muted">
                                    {{ $kyc->expiry_date ? \Carbon\Carbon::parse($kyc->expiry_date)->format('d M Y') : '—' }}
                                </td>
                                <td>
                                    @switch($kyc->status)
                                        @case('verified')
                                            <span class="badge bg-success-subtle text-success border border-success-subtle">Verified</span>
                                            @break
                                        @case('pending')
                                            <span class="badge bg-warning-subtle text-warning border border-warning-subtle">Pending</span>
                                            @break
                                        @case('rejected')
                                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle">Rejected</span>
                                            @break
                                    @endswitch
                                </td>
                                <td class="small text-muted">
                                    {{ $kyc->reviewer->name ?? '—' }}
                                </td>
                                <td class="text-end pe-3">
                                    <div class="d-flex justify-content-end gap-1">
                                        <x-button size="sm" icon="show" variant="outline-primary"
                                            href="{{ route('finetech.kyc-documents.show', $kyc) }}" text="View" />
                                        <x-button size="sm" icon="edit" variant="outline-info" text="Edit"
                                            href="{{ route('finetech.kyc-documents.edit', $kyc) }}" />
                                        <button type="button" class="btn btn-sm btn-outline-danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#confirmDeleteModal"
                                            data-delete-url="{{ route('finetech.kyc-documents.destroy', $kyc) }}"
                                            data-item-name="{{ str_replace('_', ' ', ucfirst($kyc->document_type)) }} - {{ $kyc->document_number }}">
                                            <i class="fas fa-trash me-1"></i>Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="fas fa-id-card fa-2x mb-2 d-block opacity-25"></i>
                                    No KYC documents found. <a href="{{ route('finetech.kyc-documents.create') }}">Create one now</a>.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Confirm Delete Modal --}}
    <x-confirm-delete-model modal-id="confirmDeleteModal" title="Delete KYC Document"
        message="Are you sure you want to delete this KYC document? This action cannot be undone." />

</x-app-layout>
