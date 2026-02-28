<x-app-layout>

    {{-- Page Header --}}
    <div class="py-3 py-lg-4">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h4 class="page-title mb-0">
                    <i class="fas fa-user-shield me-2 text-primary"></i>Role Details
                </h4>
            </div>
            <div class="col-lg-6">
                <div class="d-none d-lg-block">
                    <ol class="breadcrumb m-0 float-end">
                        <li class="breadcrumb-item"><a href="{{ route('finetech.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('finetech.authorization.index') }}">Role & Permission</a></li>
                        <li class="breadcrumb-item active">View</li>
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
                Viewing role and assigned permissions.
            </span>
            <div>
                <x-button text="Back" icon="back" variant="outline-secondary" href="{{ route('finetech.authorization.index') }}" />
                @isset($role)
                    <x-button text="Edit Role" icon="edit" variant="info" href="{{ route('finetech.authorization.edit', $role) }}" />
                @endisset
            </div>
        </div>
    </div>

    @isset($role)
        <div class="row g-3">
            <div class="col-lg-4">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle">Role</span>
                            <span class="fw-semibold">{{ $role->name }}</span>
                        </div>
                        <div class="small text-muted">Created {{ $role->created_at->diffForHumans() }}</div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card border-0">
                    <div class="card-header bg-warning bg-opacity-10 border-0 py-3">
                        <h6 class="mb-0 fw-semibold text-warning">
                            <i class="fas fa-shield-alt me-2"></i>Assigned Permissions
                        </h6>
                    </div>
                    <div class="card-body">
                        @if (method_exists($role, 'permissions') && $role->permissions->count())
                            <div class="d-flex flex-wrap gap-2">
                                @foreach ($role->permissions as $permission)
                                    <span class="badge bg-info-subtle text-info border border-info-subtle">
                                        {{ $permission->name }}
                                    </span>
                                @endforeach
                            </div>
                        @else
                            <div class="text-muted small">No permissions assigned.</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="card border-0">
            <div class="card-body text-center text-muted">
                Role details are not available.
            </div>
        </div>
    @endisset

</x-app-layout>