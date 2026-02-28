<x-app-layout>

    {{-- Page Header --}}
    <div class="py-3 py-lg-4">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h4 class="page-title mb-0">
                    <i class="fas fa-user-plus me-2 text-primary"></i>Create User
                </h4>
            </div>
            <div class="col-lg-6">
                <div class="d-none d-lg-block">
                    <ol class="breadcrumb m-0 float-end">
                        <li class="breadcrumb-item"><a href="{{ route('finetech.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('finetech.users.index') }}">Users</a></li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('finetech.users.store') }}" method="POST">
        @csrf

        {{-- Action Bar --}}
        <div class="card border-0  mb-3">
            <div class="card-body py-2 d-flex justify-content-between align-items-center">
                <span class="text-muted small"><i class="fas fa-info-circle me-1"></i> Fill in all required fields to create a new user account.</span>
                <div>
                    <x-button text="Back" icon="back" variant="outline-secondary" href="{{ route('finetech.users.index') }}" />
                    <x-button text="Create User" icon="add" variant="primary" />
                </div>
            </div>
        </div>

        {{-- Section 1: Account Information --}}
        <div class="card border-0  mb-3">
            <div class="card-header bg-primary bg-opacity-10 border-0 py-3">
                <h6 class="mb-0 fw-semibold text-primary">
                    <i class="fas fa-envelope me-2"></i>Account Information
                </h6>
            </div>
            <div class="card-body pt-4 pb-2">
                <div class="row g-3">
                    <div class="col-md-6">
                        <x-input-label name="name" text="Full Name" />
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-user text-muted"></i></span>
                            <x-input-field name="name" placeholder="Enter full name" class="border-start-0 ps-0" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <x-input-label name="email" text="Email Address" />
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-envelope text-muted"></i></span>
                            <x-input-field name="email" type="email" placeholder="example@email.com" class="border-start-0 ps-0" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <x-input-label name="password" text="Password" />
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-lock text-muted"></i></span>
                            <x-input-field name="password" type="password" placeholder="Enter password" class="border-start-0 ps-0" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <x-input-label name="password_confirmation" text="Confirm Password" />
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-lock text-muted"></i></span>
                            <x-input-field name="password_confirmation" type="password" placeholder="Re-enter password" class="border-start-0 ps-0" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Section 2: Personal Details --}}
        <div class="card border-0  mb-3">
            <div class="card-header bg-success bg-opacity-10 border-0 py-3">
                <h6 class="mb-0 fw-semibold text-success">
                    <i class="fas fa-id-card me-2"></i>Personal Details
                </h6>
            </div>
            <div class="card-body pt-4 pb-2">
                <div class="row g-3">
                    <div class="col-md-6">
                        <x-input-label name="aadhar_number" text="Aadhar Number" />
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-fingerprint text-muted"></i></span>
                            <x-input-field name="aadhar_number" placeholder="xxxx-xxxx-xxxx" class="border-start-0 ps-0" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <x-input-label name="phone_number" text="Phone Number" />
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-phone text-muted"></i></span>
                            <x-input-field name="phone_number" placeholder="+91-9700000000" class="border-start-0 ps-0" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Section 3: Address --}}
        <div class="card border-0  mb-3">
            <div class="card-header bg-warning bg-opacity-10 border-0 py-3">
                <h6 class="mb-0 fw-semibold text-warning">
                    <i class="fas fa-map-marker-alt me-2"></i>Address
                </h6>
            </div>
            <div class="card-body pt-4 pb-2">
                <div class="row g-3">
                    <div class="col-md-8">
                        <x-input-label name="address" text="Street Address" />
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-home text-muted"></i></span>
                            <x-input-field name="address" placeholder="Enter street address" class="border-start-0 ps-0" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <x-input-label name="city" text="City" />
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-city text-muted"></i></span>
                            <x-input-field name="city" placeholder="City" class="border-start-0 ps-0" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <x-input-label name="state" text="State" />
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-map text-muted"></i></span>
                            <x-input-field name="state" placeholder="State" class="border-start-0 ps-0" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <x-input-label name="postal_code" text="Postal Code" />
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-mail-bulk text-muted"></i></span>
                            <x-input-field name="postal_code" placeholder="e.g. 400001" class="border-start-0 ps-0" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <x-input-label name="country" text="Country" />
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-globe text-muted"></i></span>
                            <x-input-field name="country" placeholder="Country" value="india" class="border-start-0 ps-0" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Section 4: Account Settings --}}
        <div class="card border-0  mb-3">
            <div class="card-header bg-info bg-opacity-10 border-0 py-3">
                <h6 class="mb-0 fw-semibold text-info">
                    <i class="fas fa-cog me-2"></i>Account Settings
                </h6>
            </div>
            <div class="card-body pt-4 pb-2">
                <div class="row g-3">
                    <div class="col-md-6">
                        <x-input-label name="is_active" text="Account Status" />
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-toggle-on text-muted"></i></span>
                            <select name="is_active" class="form-select border-start-0">
                                <option value="">-- Select Status --</option>
                                <option value="1" {{ old('is_active') == '1' ? 'selected' : '' }}>
                                    Active
                                </option>
                                <option value="0" {{ old('is_active') === '0' ? 'selected' : '' }}>
                                    Inactive
                                </option>
                            </select>
                        </div>
                        @error('is_active')
                            <div class="invalid-feedback d-block my-1 text-danger">✖ {{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <x-input-label name="role" text="Assign Role" />
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-user-shield text-muted"></i></span>
                            <select name="role" class="form-select border-start-0">
                                <option value="">-- Select Role --</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>
                                        {{ ucfirst($role->name) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('role')
                            <div class="invalid-feedback d-block my-1 text-danger">✖ {{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Bottom Action Bar --}}
        <div class="card border-0  mb-4">
            <div class="card-body py-2 d-flex justify-content-end">
                <x-button text="Cancel" icon="cancel" variant="outline-secondary" href="{{ route('finetech.users.index') }}" />
                <x-button text="Create User" icon="add" variant="primary" />
            </div>
        </div>

    </form>

</x-app-layout>