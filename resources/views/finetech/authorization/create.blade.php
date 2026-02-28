<x-app-layout>

    {{-- Page Header --}}
    <div class="py-3 py-lg-4">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h4 class="page-title mb-0">
                    <i class="fas fa-user-shield me-2 text-primary"></i>Create Role
                </h4>
            </div>
            <div class="col-lg-6">
                <div class="d-none d-lg-block">
                    <ol class="breadcrumb m-0 float-end">
                        <li class="breadcrumb-item"><a href="{{ route('finetech.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('finetech.authorization.index') }}">Role & Permission</a></li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('finetech.authorization.store') }}" method="POST">
        @csrf

        {{-- Action Bar --}}
        <div class="card border-0 mb-3">
            <div class="card-body py-2 d-flex justify-content-between align-items-center">
                <span class="text-muted small">
                    <i class="fas fa-info-circle me-1"></i>
                    Create a role and assign the permissions that apply.
                </span>
                <div>
                    <x-button text="Back" icon="back" variant="outline-secondary" href="{{ route('finetech.authorization.index') }}" />
                    <x-button text="Create Role" icon="add" variant="primary" />
                </div>
            </div>
        </div>

        <div class="row g-3">
            {{-- Role Details --}}
            <div class="col-lg-4">
                <div class="card border-0">
                    <div class="card-header bg-primary bg-opacity-10 border-0 py-3">
                        <h6 class="mb-0 fw-semibold text-primary">
                            <i class="fas fa-id-badge me-2"></i>Role Details
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <x-input-label name="name" text="Role Name" />
                            <x-input-field name="name" placeholder="Enter role name" />
                        </div>
                        @error('permissions')
                            <div class="invalid-feedback d-block my-1 text-danger">✖ {{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Permissions --}}
            <div class="col-lg-8">
                <div class="card border-0">
                    <div class="card-header bg-warning bg-opacity-10 border-0 py-3">
                        <h6 class="mb-0 fw-semibold text-warning">
                            <i class="fas fa-shield-alt me-2"></i>Permissions
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            @foreach ($permissionGroups as $permissionGroup)
                                <div class="col-md-6 col-xl-4">
                                    <div class="border rounded-3 h-100 p-3">
                                        <div class="fw-semibold small text-uppercase text-muted mb-2">
                                            {{ $permissionGroup->name }}
                                        </div>
                                        @foreach ($permissionGroup->permissions as $permission)
                                            <div class="form-check mb-1">
                                                <input class="form-check-input" type="checkbox" value="{{ $permission->name }}"
                                                    name="permissions[]" @if (in_array($permission->name, old('permissions') ?? [])) checked @endif>
                                                <label class="form-check-label">{{ $permission->name }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>



    </form>

</x-app-layout>