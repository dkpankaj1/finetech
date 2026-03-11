<x-app-layout>

    {{-- Page Header --}}
    <div class="py-3 py-lg-4">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h4 class="page-title mb-0">
                    <i class="fas fa-edit me-2 text-info"></i>Edit Customer
                </h4>
            </div>
            <div class="col-lg-6">
                <div class="d-none d-lg-block">
                    <ol class="breadcrumb m-0 float-end">
                        <li class="breadcrumb-item"><a href="{{ route('finetech.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('finetech.customers.index') }}">Customers</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('finetech.customers.update', $customer) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Action Bar --}}
        <div class="card border-0 mb-3">
            <div class="card-body py-2 d-flex justify-content-between align-items-center">
                <span class="text-muted small">
                    <i class="fas fa-info-circle me-1"></i>
                    Editing <strong>{{ $customer->first_name }} {{ $customer->last_name }}</strong> &mdash; {{ $customer->customer_number }}
                </span>
                <div>
                    <x-button text="Back" icon="back" variant="outline-secondary" href="{{ route('finetech.customers.index') }}" />
                    <x-button text="Save Changes" icon="save" variant="info" />
                </div>
            </div>
        </div>

        {{-- Section 1: Personal Information --}}
        <div class="card border-0 mb-3">
            <div class="card-header bg-primary bg-opacity-10 border-0 py-3">
                <h6 class="mb-0 fw-semibold text-primary">
                    <i class="fas fa-user me-2"></i>Personal Information
                </h6>
            </div>
            <div class="card-body pt-4 pb-2">
                <div class="row g-3">
                    <div class="col-md-4">
                        <x-input-label name="first_name" text="First Name" />
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-user text-muted"></i></span>
                            <x-input-field name="first_name" placeholder="Enter first name" value="{{ old('first_name', $customer->first_name) }}" class="border-start-0 ps-0" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <x-input-label name="last_name" text="Last Name" />
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-user text-muted"></i></span>
                            <x-input-field name="last_name" placeholder="Enter last name" value="{{ old('last_name', $customer->last_name) }}" class="border-start-0 ps-0" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <x-input-label name="date_of_birth" text="Date of Birth" />
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-calendar text-muted"></i></span>
                            <x-input-field name="date_of_birth" type="date" value="{{ old('date_of_birth', $customer->date_of_birth) }}" class="border-start-0 ps-0" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <x-input-label name="gender" text="Gender" />
                        <select name="gender" id="gender" class="form-select @error('gender') is-invalid @enderror">
                            <option value="">-- Select Gender --</option>
                            <option value="male" {{ old('gender', $customer->gender) == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender', $customer->gender) == 'female' ? 'selected' : '' }}>Female</option>
                            <option value="other" {{ old('gender', $customer->gender) == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('gender')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <x-input-label name="photo" text="Profile Photo" />
                        <input type="file" name="photo" id="photo" accept="image/*"
                            class="form-control @error('photo') is-invalid @enderror">
                        @error('photo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @if ($customer->photo)
                            <div class="mt-2">
                                <img src="{{ asset($customer->photo) }}" alt="Current photo" class="rounded" width="60" height="60" style="object-fit:cover;">
                                <span class="text-muted small ms-2">Current photo</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Section 2: Contact Information --}}
        <div class="card border-0 mb-3">
            <div class="card-header bg-success bg-opacity-10 border-0 py-3">
                <h6 class="mb-0 fw-semibold text-success">
                    <i class="fas fa-phone-alt me-2"></i>Contact Information
                </h6>
            </div>
            <div class="card-body pt-4 pb-2">
                <div class="row g-3">
                    <div class="col-md-6">
                        <x-input-label name="email" text="Email Address" />
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-envelope text-muted"></i></span>
                            <x-input-field name="email" type="email" placeholder="customer@example.com" value="{{ old('email', $customer->email) }}" class="border-start-0 ps-0" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <x-input-label name="phone" text="Phone Number" />
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-phone text-muted"></i></span>
                            <x-input-field name="phone" placeholder="+91-9700000000" value="{{ old('phone', $customer->phone) }}" class="border-start-0 ps-0" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Section 3: Address --}}
        <div class="card border-0 mb-3">
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
                            <x-input-field name="address" placeholder="Enter street address" value="{{ old('address', $customer->address) }}" class="border-start-0 ps-0" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <x-input-label name="city" text="City" />
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-city text-muted"></i></span>
                            <x-input-field name="city" placeholder="City" value="{{ old('city', $customer->city) }}" class="border-start-0 ps-0" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <x-input-label name="state" text="State" />
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-map text-muted"></i></span>
                            <x-input-field name="state" placeholder="State" value="{{ old('state', $customer->state) }}" class="border-start-0 ps-0" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <x-input-label name="postal_code" text="Postal Code" />
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-mail-bulk text-muted"></i></span>
                            <x-input-field name="postal_code" placeholder="e.g. 400001" value="{{ old('postal_code', $customer->postal_code) }}" class="border-start-0 ps-0" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <x-input-label name="country" text="Country" />
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-globe text-muted"></i></span>
                            <x-input-field name="country" placeholder="Country" value="{{ old('country', $customer->country) }}" class="border-start-0 ps-0" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Section 4: Branch & Status --}}
        <div class="card border-0 mb-3">
            <div class="card-header bg-info bg-opacity-10 border-0 py-3">
                <h6 class="mb-0 fw-semibold text-info">
                    <i class="fas fa-cog me-2"></i>Branch & Status
                </h6>
            </div>
            <div class="card-body pt-4 pb-2">
                <div class="row g-3">
                    <div class="col-md-4">
                        <x-input-label name="branch_id" text="Branch" />
                        <select name="branch_id" id="branch_id" class="form-select @error('branch_id') is-invalid @enderror">
                            <option value="">-- Select Branch --</option>
                            @foreach ($branches as $branch)
                                <option value="{{ $branch->id }}" {{ old('branch_id', $customer->branch_id) == $branch->id ? 'selected' : '' }}>
                                    {{ $branch->name }} ({{ $branch->code }})
                                </option>
                            @endforeach
                        </select>
                        @error('branch_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <x-input-label name="status" text="Status" />
                        <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                            <option value="active" {{ old('status', $customer->status) == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $customer->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="suspended" {{ old('status', $customer->status) == 'suspended' ? 'selected' : '' }}>Suspended</option>
                            <option value="blacklisted" {{ old('status', $customer->status) == 'blacklisted' ? 'selected' : '' }}>Blacklisted</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <x-input-label name="kyc_status" text="KYC Status" />
                        <select name="kyc_status" id="kyc_status" class="form-select @error('kyc_status') is-invalid @enderror">
                            <option value="pending" {{ old('kyc_status', $customer->kyc_status) == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="verified" {{ old('kyc_status', $customer->kyc_status) == 'verified' ? 'selected' : '' }}>Verified</option>
                            <option value="rejected" {{ old('kyc_status', $customer->kyc_status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            <option value="expired" {{ old('kyc_status', $customer->kyc_status) == 'expired' ? 'selected' : '' }}>Expired</option>
                        </select>
                        @error('kyc_status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-12">
                        <x-input-label name="status_reason" text="Status Reason (optional)" />
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-comment text-muted"></i></span>
                            <textarea name="status_reason" id="status_reason" rows="2"
                                class="form-control border-start-0 ps-0 @error('status_reason') is-invalid @enderror"
                                placeholder="Reason for suspend/blacklist (if applicable)">{{ old('status_reason', $customer->status_reason) }}</textarea>
                        </div>
                        @error('status_reason')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Bottom Action Bar --}}
        <div class="card border-0 mb-4">
            <div class="card-body py-2 d-flex justify-content-end">
                <x-button text="Cancel" icon="cancel" variant="outline-secondary" href="{{ route('finetech.customers.index') }}" />
                <x-button text="Save Changes" icon="save" variant="info" />
            </div>
        </div>

    </form>

</x-app-layout>
