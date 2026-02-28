<x-app-layout>

    {{-- Page Header --}}
    <div class="py-3 py-lg-4">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h4 class="page-title mb-0">
                    <i class="fas fa-code-branch me-2 text-primary"></i>Branches
                </h4>
            </div>
            <div class="col-lg-6">
                <div class="d-none d-lg-block">
                    <ol class="breadcrumb m-0 float-end">
                        <li class="breadcrumb-item"><a href="{{ route('finetech.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Branches</li>
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
                Total <strong>{{ $branches->count() }}</strong> branch(es) registered in the system.
            </span>
            <x-button icon="add" variant="primary" text="Add New Branch" href="{{ route('finetech.branches.create') }}" />
        </div>
    </div>

    {{-- Table Card --}}
    <div class="card border-0">
        <div class="card-header bg-primary bg-opacity-10 border-0 py-3">
            <h6 class="mb-0 card-title">
                <i class="fas fa-list me-2"></i>Manage Branches
            </h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">#</th>
                            <th>Branch</th>
                            <th>Code</th>
                            <th>Contact</th>
                            <th>Location</th>
                            <th>Status</th>
                            <th>Last Updated</th>
                            <th class="text-end pe-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($branches as $key => $branch)
                            <tr>
                                <td class="ps-3 text-muted small">{{ ++$key }}</td>
                                <td>
                                    <div class="fw-semibold small">{{ $branch->name }}</div>
                                    @if ($branch->is_main_branch)
                                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle" style="font-size:10px;">
                                            <i class="fas fa-star me-1"></i>Main Branch
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle">
                                        {{ $branch->code }}
                                    </span>
                                </td>
                                <td class="small">
                                    <div><i class="fas fa-phone fa-fw text-muted me-1"></i>{{ $branch->phone_number }}</div>
                                    @if ($branch->email)
                                        <div class="text-muted" style="font-size:11px;"><i class="fas fa-envelope fa-fw me-1"></i>{{ $branch->email }}</div>
                                    @endif
                                </td>
                                <td class="small text-muted">
                                    {{ $branch->city }}, {{ $branch->state }}
                                </td>
                                <td>
                                    @if ($branch->is_active)
                                        <span class="badge bg-success-subtle text-success border border-success-subtle">
                                            <i class="fas fa-circle me-1" style="font-size:7px;vertical-align:middle;"></i>Active
                                        </span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle">
                                            <i class="fas fa-circle me-1" style="font-size:7px;vertical-align:middle;"></i>Inactive
                                        </span>
                                    @endif
                                </td>
                                <td class="small text-muted">{{ $branch->updated_at->diffForHumans() }}</td>
                                <td class="text-end pe-3">
                                    <div class="d-flex justify-content-end gap-1">
                                        <x-button size="sm" icon="show" variant="outline-primary"
                                            href="{{ route('finetech.branches.show', $branch) }}" text="View" />
                                        <x-button size="sm" icon="edit" variant="outline-info" text="Edit"
                                            href="{{ route('finetech.branches.edit', $branch) }}" />
                                        <button type="button" class="btn btn-sm btn-outline-danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#confirmDeleteModal"
                                            data-delete-url="{{ route('finetech.branches.destroy', $branch) }}"
                                            data-item-name="{{ $branch->name }}">
                                            <i class="fas fa-trash me-1"></i>Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="fas fa-code-branch fa-2x mb-2 d-block opacity-25"></i>
                                    No branches found. <a href="{{ route('finetech.branches.create') }}">Create one now</a>.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Confirm Delete Modal --}}
    <x-confirm-delete-model modal-id="confirmDeleteModal" title="Delete Branch"
        message="Are you sure you want to delete this branch? This action cannot be undone." />

</x-app-layout>
