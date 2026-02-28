<x-app-layout>

    {{-- Page Header --}}
    <div class="py-3 py-lg-4">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h4 class="page-title mb-0">
                    <i class="fas fa-user-shield me-2 text-primary"></i>Role & Permission
                </h4>
            </div>
            <div class="col-lg-6">
                <div class="d-none d-lg-block">
                    <ol class="breadcrumb m-0 float-end">
                        <li class="breadcrumb-item"><a href="{{ route('finetech.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Role & Permission</li>
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
                Total <strong>{{ $roles->count() }}</strong> role(s) configured.
            </span>
            <x-button icon="add" variant="primary" text="Add New Role" href="{{ route('finetech.authorization.create') }}" />
        </div>
    </div>

    {{-- Table Card --}}
    <div class="card border-0">
        <div class="card-header bg-primary bg-opacity-10 border-0 py-3">
            <h6 class="mb-0 card-title">
                <i class="fas fa-list me-2"></i>Manage Roles
            </h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">#</th>
                            <th>Role</th>
                            <th>Last Update</th>
                            <th class="text-end pe-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($roles as $key => $role)
                            <tr>
                                <td class="ps-3 text-muted small">{{ ++$key }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle">Role</span>
                                        <span class="fw-semibold small">{{ $role->name }}</span>
                                    </div>
                                </td>
                                <td class="small text-muted">{{ $role->created_at->diffForHumans() }}</td>
                                <td class="text-end pe-3">
                                    <div class="d-flex justify-content-end gap-1">
                                        <x-button size="sm" icon="edit" variant="outline-info" text="Edit"
                                            href="{{ route('finetech.authorization.edit', $role) }}" />
                                        <button type="button" class="btn btn-sm btn-outline-danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#confirmDeleteModal"
                                            data-delete-url="{{ route('finetech.authorization.destroy', $role) }}"
                                            data-item-name="{{ $role->name }}">
                                            <i class="fas fa-trash me-1"></i>Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">
                                    <i class="fas fa-user-shield fa-2x mb-2 d-block opacity-25"></i>
                                    No roles found. <a href="{{ route('finetech.authorization.create') }}">Create one now</a>.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- confirm delete modal --}}
    <x-confirm-delete-model
        modal-id="confirmDeleteModal"
        title="Delete Role"
        message="Are you sure you want to delete this role? This action cannot be undone."
    />

</x-app-layout>