<x-app-layout>

    {{-- Page Header --}}
    <div class="py-3 py-lg-4">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h4 class="page-title mb-0">
                    <i class="fas fa-edit me-2 text-info"></i>Edit Branch
                </h4>
            </div>
            <div class="col-lg-6">
                <div class="d-none d-lg-block">
                    <ol class="breadcrumb m-0 float-end">
                        <li class="breadcrumb-item"><a href="{{ route('finetech.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('finetech.branches.index') }}">Branches</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('finetech.branches.update', $branch) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Action Bar --}}
        <div class="card border-0 mb-3">
            <div class="card-body py-2 d-flex justify-content-between align-items-center">
                <span class="text-muted small">
                    <i class="fas fa-info-circle me-1"></i>
                    Editing <strong>{{ $branch->name }}</strong> &mdash; Last updated {{ $branch->updated_at->diffForHumans() }}.
                </span>
                <div>
                    <x-button text="Back" icon="back" variant="outline-secondary" href="{{ route('finetech.branches.index') }}" />
                    <x-button text="Save Changes" icon="save" variant="info" />
                </div>
            </div>
        </div>

        {{-- Section 1: Branch Identity --}}
        <div class="card border-0 mb-3">
            <div class="card-header bg-primary bg-opacity-10 border-0 py-3">
                <h6 class="mb-0 fw-semibold text-primary">
                    <i class="fas fa-id-badge me-2"></i>Branch Identity
                </h6>
            </div>
            <div class="card-body pt-4 pb-2">
                <div class="row g-3">
                    <div class="col-md-6">
                        <x-input-label name="name" text="Branch Name" />
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-code-branch text-muted"></i></span>
                            <x-input-field name="name" placeholder="Enter branch name" value="{{ old('name', $branch->name) }}" class="border-start-0 ps-0" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <x-input-label name="code" text="Branch Code" />
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-hashtag text-muted"></i></span>
                            <x-input-field name="code" placeholder="e.g. BR001" value="{{ old('code', $branch->code) }}" class="border-start-0 ps-0" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <x-input-label name="ifsc_code" text="IFSC Code" />
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-university text-muted"></i></span>
                            <x-input-field name="ifsc_code" placeholder="e.g. SBIN0001234" value="{{ old('ifsc_code', $branch->ifsc_code) }}" class="border-start-0 ps-0" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <x-input-label name="micr_code" text="MICR Code" />
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-barcode text-muted"></i></span>
                            <x-input-field name="micr_code" placeholder="9-digit MICR code" value="{{ old('micr_code', $branch->micr_code) }}" class="border-start-0 ps-0" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <x-input-label name="swift_code" text="SWIFT / BIC Code" />
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-globe text-muted"></i></span>
                            <x-input-field name="swift_code" placeholder="e.g. SBININBB" value="{{ old('swift_code', $branch->swift_code) }}" class="border-start-0 ps-0" />
                        </div>
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
                    <div class="col-md-3">
                        <x-input-label name="phone_number" text="Phone Number" />
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-phone text-muted"></i></span>
                            <x-input-field name="phone_number" placeholder="+91-9700000000" value="{{ old('phone_number', $branch->phone_number) }}" class="border-start-0 ps-0" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <x-input-label name="alternate_phone" text="Alternate Phone" />
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-phone-square text-muted"></i></span>
                            <x-input-field name="alternate_phone" placeholder="+91-9700000000" value="{{ old('alternate_phone', $branch->alternate_phone) }}" class="border-start-0 ps-0" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <x-input-label name="email" text="Email Address" />
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-envelope text-muted"></i></span>
                            <x-input-field name="email" type="email" placeholder="branch@bank.com" value="{{ old('email', $branch->email) }}" class="border-start-0 ps-0" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <x-input-label name="fax" text="Fax" />
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-fax text-muted"></i></span>
                            <x-input-field name="fax" placeholder="Fax number" value="{{ old('fax', $branch->fax) }}" class="border-start-0 ps-0" />
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
                            <x-input-field name="address" placeholder="Enter street address" value="{{ old('address', $branch->address) }}" class="border-start-0 ps-0" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <x-input-label name="city" text="City" />
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-city text-muted"></i></span>
                            <x-input-field name="city" placeholder="City" value="{{ old('city', $branch->city) }}" class="border-start-0 ps-0" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <x-input-label name="state" text="State" />
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-map text-muted"></i></span>
                            <x-input-field name="state" placeholder="State" value="{{ old('state', $branch->state) }}" class="border-start-0 ps-0" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <x-input-label name="postal_code" text="Postal Code" />
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-mail-bulk text-muted"></i></span>
                            <x-input-field name="postal_code" placeholder="e.g. 400001" value="{{ old('postal_code', $branch->postal_code) }}" class="border-start-0 ps-0" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <x-input-label name="country" text="Country" />
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-globe text-muted"></i></span>
                            <x-input-field name="country" placeholder="Country" value="{{ old('country', $branch->country) }}" class="border-start-0 ps-0" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <x-input-label name="latitude" text="Latitude" />
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-crosshairs text-muted"></i></span>
                            <x-input-field name="latitude" placeholder="e.g. 19.0760" value="{{ old('latitude', $branch->latitude) }}" class="border-start-0 ps-0" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <x-input-label name="longitude" text="Longitude" />
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-crosshairs text-muted"></i></span>
                            <x-input-field name="longitude" placeholder="e.g. 72.8777" value="{{ old('longitude', $branch->longitude) }}" class="border-start-0 ps-0" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Section 4: Branch Manager --}}
        <div class="card border-0 mb-3">
            <div class="card-header bg-info bg-opacity-10 border-0 py-3">
                <h6 class="mb-0 fw-semibold text-info">
                    <i class="fas fa-user-tie me-2"></i>Branch Manager
                </h6>
            </div>
            <div class="card-body pt-4 pb-2">
                <div class="row g-3">
                    <div class="col-md-4">
                        <x-input-label name="manager_name" text="Manager Name" />
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-user text-muted"></i></span>
                            <x-input-field name="manager_name" placeholder="Full name" value="{{ old('manager_name', $branch->manager_name) }}" class="border-start-0 ps-0" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <x-input-label name="manager_email" text="Manager Email" />
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-envelope text-muted"></i></span>
                            <x-input-field name="manager_email" type="email" placeholder="manager@bank.com" value="{{ old('manager_email', $branch->manager_email) }}" class="border-start-0 ps-0" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <x-input-label name="manager_phone" text="Manager Phone" />
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-phone text-muted"></i></span>
                            <x-input-field name="manager_phone" placeholder="+91-9700000000" value="{{ old('manager_phone', $branch->manager_phone) }}" class="border-start-0 ps-0" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <x-input-label name="opening_time" text="Opening Time" />
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-clock text-muted"></i></span>
                            <x-input-field name="opening_time" type="time" value="{{ old('opening_time', $branch->getRawOriginal('opening_time')) }}" class="border-start-0 ps-0" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <x-input-label name="closing_time" text="Closing Time" />
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-clock text-muted"></i></span>
                            <x-input-field name="closing_time" type="time" value="{{ old('closing_time', $branch->getRawOriginal('closing_time')) }}" class="border-start-0 ps-0" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Section 5: Settings --}}
        <div class="card border-0 mb-3">
            <div class="card-header bg-secondary bg-opacity-10 border-0 py-3">
                <h6 class="mb-0 fw-semibold text-secondary">
                    <i class="fas fa-cog me-2"></i>Settings
                </h6>
            </div>
            <div class="card-body pt-4 pb-2">
                <div class="row g-3">
                    <div class="col-md-4">
                        <x-input-label name="is_active" text="Status" />
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-toggle-on text-muted"></i></span>
                            <select name="is_active" class="form-select border-start-0">
                                <option value="">-- Select Status --</option>
                                <option value="1" {{ old('is_active', $branch->is_active) == '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('is_active', $branch->is_active) == '0' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                        @error('is_active')
                            <div class="invalid-feedback d-block my-1 text-danger">✖ {{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 d-flex align-items-end pb-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_main_branch" id="is_main_branch" value="1"
                                {{ old('is_main_branch', $branch->is_main_branch) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold" for="is_main_branch">
                                <i class="fas fa-star me-1 text-warning"></i>Mark as Main Branch
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <x-input-label name="remarks" text="Remarks" />
                        <textarea name="remarks" class="form-control" rows="2"
                            placeholder="Optional internal notes...">{{ old('remarks', $branch->remarks) }}</textarea>
                        @error('remarks')
                            <div class="invalid-feedback d-block my-1 text-danger">✖ {{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Bottom Action Bar --}}
        <div class="card border-0 mb-4">
            <div class="card-body py-2 d-flex justify-content-end">
                <x-button text="Cancel" icon="cancel" variant="outline-secondary" href="{{ route('finetech.branches.index') }}" />
                <x-button text="Save Changes" icon="save" variant="info" />
            </div>
        </div>

    </form>

</x-app-layout>
