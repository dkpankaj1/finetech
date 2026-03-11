<x-app-layout>

    {{-- Page Header --}}
    <div class="py-3 py-lg-4">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h4 class="page-title mb-0">
                    <i class="fas fa-edit me-2 text-info"></i>Edit KYC Document
                </h4>
            </div>
            <div class="col-lg-6">
                <div class="d-none d-lg-block">
                    <ol class="breadcrumb m-0 float-end">
                        <li class="breadcrumb-item"><a href="{{ route('finetech.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('finetech.kyc-documents.index') }}">KYC Documents</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('finetech.kyc-documents.update', $kycDocument) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Action Bar --}}
        <div class="card border-0 mb-3">
            <div class="card-body py-2 d-flex justify-content-between align-items-center">
                <span class="text-muted small">
                    <i class="fas fa-info-circle me-1"></i>
                    Editing <strong>{{ str_replace('_', ' ', ucfirst($kycDocument->document_type)) }}</strong> &mdash; {{ $kycDocument->document_number }}
                </span>
                <div>
                    <x-button text="Back" icon="back" variant="outline-secondary" href="{{ route('finetech.kyc-documents.index') }}" />
                    <x-button text="Save Changes" icon="save" variant="info" />
                </div>
            </div>
        </div>

        {{-- Section 1: Customer & Document Type --}}
        <div class="card border-0 mb-3">
            <div class="card-header bg-primary bg-opacity-10 border-0 py-3">
                <h6 class="mb-0 fw-semibold text-primary">
                    <i class="fas fa-id-card me-2"></i>Document Information
                </h6>
            </div>
            <div class="card-body pt-4 pb-2">
                <div class="row g-3">
                    <div class="col-md-6">
                        <x-input-label name="customer_id" text="Customer" />
                        <select name="customer_id" id="customer_id" class="form-select @error('customer_id') is-invalid @enderror">
                            <option value="">-- Select Customer --</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}" {{ old('customer_id', $kycDocument->customer_id) == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->first_name }} {{ $customer->last_name }} ({{ $customer->customer_number }})
                                </option>
                            @endforeach
                        </select>
                        @error('customer_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <x-input-label name="document_type" text="Document Type" />
                        <select name="document_type" id="document_type" class="form-select @error('document_type') is-invalid @enderror">
                            <option value="">-- Select Document Type --</option>
                            @foreach (['national_id' => 'National ID', 'passport' => 'Passport', 'driving_license' => 'Driving License', 'voter_id' => 'Voter ID', 'aadhaar' => 'Aadhaar', 'pan_card' => 'PAN Card'] as $value => $label)
                                <option value="{{ $value }}" {{ old('document_type', $kycDocument->document_type) == $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('document_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <x-input-label name="document_number" text="Document Number" />
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-hashtag text-muted"></i></span>
                            <x-input-field name="document_number" placeholder="e.g. ABCDE1234F" value="{{ old('document_number', $kycDocument->document_number) }}" class="border-start-0 ps-0" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <x-input-label name="expiry_date" text="Expiry Date (optional)" />
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-calendar text-muted"></i></span>
                            <x-input-field name="expiry_date" type="date" value="{{ old('expiry_date', $kycDocument->expiry_date) }}" class="border-start-0 ps-0" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Section 2: Document Images --}}
        <div class="card border-0 mb-3">
            <div class="card-header bg-success bg-opacity-10 border-0 py-3">
                <h6 class="mb-0 fw-semibold text-success">
                    <i class="fas fa-image me-2"></i>Document Images
                </h6>
            </div>
            <div class="card-body pt-4 pb-2">
                <div class="row g-3">
                    <div class="col-md-6">
                        <x-input-label name="front_image" text="Front Image" />
                        <input type="file" name="front_image" id="front_image" accept="image/*"
                            class="form-control @error('front_image') is-invalid @enderror">
                        @error('front_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @if ($kycDocument->front_image)
                            <div class="mt-2">
                                <img src="{{ asset($kycDocument->front_image) }}" alt="Front" class="rounded border" width="120" style="object-fit:cover;">
                                <span class="text-muted small ms-2">Current front image</span>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <x-input-label name="back_image" text="Back Image (optional)" />
                        <input type="file" name="back_image" id="back_image" accept="image/*"
                            class="form-control @error('back_image') is-invalid @enderror">
                        @error('back_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @if ($kycDocument->back_image)
                            <div class="mt-2">
                                <img src="{{ asset($kycDocument->back_image) }}" alt="Back" class="rounded border" width="120" style="object-fit:cover;">
                                <span class="text-muted small ms-2">Current back image</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Section 3: Review Status --}}
        <div class="card border-0 mb-3">
            <div class="card-header bg-warning bg-opacity-10 border-0 py-3">
                <h6 class="mb-0 fw-semibold text-warning">
                    <i class="fas fa-clipboard-check me-2"></i>Review Status
                </h6>
            </div>
            <div class="card-body pt-4 pb-2">
                <div class="row g-3">
                    <div class="col-md-4">
                        <x-input-label name="status" text="Verification Status" />
                        <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                            <option value="pending" {{ old('status', $kycDocument->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="verified" {{ old('status', $kycDocument->status) == 'verified' ? 'selected' : '' }}>Verified</option>
                            <option value="rejected" {{ old('status', $kycDocument->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-8">
                        <x-input-label name="remark" text="Remark (optional)" />
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-comment text-muted"></i></span>
                            <textarea name="remark" id="remark" rows="2"
                                class="form-control border-start-0 ps-0 @error('remark') is-invalid @enderror"
                                placeholder="Any remarks or reason for rejection">{{ old('remark', $kycDocument->remark) }}</textarea>
                        </div>
                        @error('remark')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Bottom Action Bar --}}
        <div class="card border-0 mb-4">
            <div class="card-body py-2 d-flex justify-content-end">
                <x-button text="Cancel" icon="cancel" variant="outline-secondary" href="{{ route('finetech.kyc-documents.index') }}" />
                <x-button text="Save Changes" icon="save" variant="info" />
            </div>
        </div>

    </form>

</x-app-layout>
