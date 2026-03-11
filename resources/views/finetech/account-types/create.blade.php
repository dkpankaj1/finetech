<x-app-layout>

    {{-- Page Header --}}
    <div class="py-3 py-lg-4">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h4 class="page-title mb-0">
                    <i class="fas fa-plus-circle me-2 text-primary"></i>Create Account Type
                </h4>
            </div>
            <div class="col-lg-6">
                <div class="d-none d-lg-block">
                    <ol class="breadcrumb m-0 float-end">
                        <li class="breadcrumb-item"><a href="{{ route('finetech.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('finetech.account-types.index') }}">Account Types</a></li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('finetech.account-types.store') }}" method="POST">
        @csrf

        {{-- Action Bar --}}
        <div class="card border-0 mb-3">
            <div class="card-body py-2 d-flex justify-content-between align-items-center">
                <span class="text-muted small">
                    <i class="fas fa-info-circle me-1"></i>Fill in all required fields to add a new account type.
                </span>
                <div>
                    <x-button text="Back" icon="back" variant="outline-secondary" href="{{ route('finetech.account-types.index') }}" />
                    <x-button text="Create Account Type" icon="add" variant="primary" />
                </div>
            </div>
        </div>

        {{-- Section: Basic Information --}}
        <div class="card border-0 mb-3">
            <div class="card-header bg-primary bg-opacity-10 border-0 py-3">
                <h6 class="mb-0 fw-semibold text-primary">
                    <i class="fas fa-layer-group me-2"></i>Basic Information
                </h6>
            </div>
            <div class="card-body pt-4 pb-2">
                <div class="row g-3">
                    <div class="col-md-6">
                        <x-input-label name="name" text="Account Type Name" />
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-font text-muted"></i></span>
                            <x-input-field name="name" placeholder="e.g. Savings Account" class="border-start-0 ps-0" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <x-input-label name="code" text="Account Code" />
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-hashtag text-muted"></i></span>
                            <x-input-field name="code" placeholder="e.g. SAV" class="border-start-0 ps-0" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Section: Rates & Limits --}}
        <div class="card border-0 mb-3">
            <div class="card-header bg-success bg-opacity-10 border-0 py-3">
                <h6 class="mb-0 fw-semibold text-success">
                    <i class="fas fa-percentage me-2"></i>Rates & Limits
                </h6>
            </div>
            <div class="card-body pt-4 pb-2">
                <div class="row g-3">
                    <div class="col-md-4">
                        <x-input-label name="interest_rate" text="Interest Rate (%)" />
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-percentage text-muted"></i></span>
                            <x-input-field name="interest_rate" type="number" step="0.01" placeholder="e.g. 4.50" class="border-start-0 ps-0" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <x-input-label name="minimum_balance" text="Minimum Balance" />
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-coins text-muted"></i></span>
                            <x-input-field name="minimum_balance" type="number" step="0.01" placeholder="e.g. 500.00" class="border-start-0 ps-0" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <x-input-label name="maximum_balance" text="Maximum Balance" />
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-coins text-muted"></i></span>
                            <x-input-field name="maximum_balance" type="number" step="0.01" placeholder="e.g. 1000000.00" class="border-start-0 ps-0" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <x-input-label name="daily_deposit_limit" text="Daily Deposit Limit" />
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-arrow-circle-down text-muted"></i></span>
                            <x-input-field name="daily_deposit_limit" type="number" step="0.01" placeholder="e.g. 50000.00" class="border-start-0 ps-0" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <x-input-label name="daily_withdrawal_limit" text="Daily Withdrawal Limit" />
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-arrow-circle-up text-muted"></i></span>
                            <x-input-field name="daily_withdrawal_limit" type="number" step="0.01" placeholder="e.g. 25000.00" class="border-start-0 ps-0" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <x-input-label name="monthly_free_transactions" text="Monthly Free Transactions" />
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-exchange-alt text-muted"></i></span>
                            <x-input-field name="monthly_free_transactions" type="number" placeholder="e.g. 10" class="border-start-0 ps-0" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Section: Flags --}}
        <div class="card border-0 mb-3">
            <div class="card-header bg-warning bg-opacity-10 border-0 py-3">
                <h6 class="mb-0 fw-semibold text-warning">
                    <i class="fas fa-toggle-on me-2"></i>Flags & Status
                </h6>
            </div>
            <div class="card-body pt-4 pb-2">
                <div class="row g-3">
                    <div class="col-md-6">
                        <x-input-label name="requires_kyc" text="Requires KYC" />
                        <select name="requires_kyc" id="requires_kyc" class="form-select @error('requires_kyc') is-invalid @enderror">
                            <option value="1" {{ old('requires_kyc', '1') == '1' ? 'selected' : '' }}>Yes</option>
                            <option value="0" {{ old('requires_kyc') == '0' ? 'selected' : '' }}>No</option>
                        </select>
                        @error('requires_kyc')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <x-input-label name="is_active" text="Status" />
                        <select name="is_active" id="is_active" class="form-select @error('is_active') is-invalid @enderror">
                            <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('is_active')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Bottom Action Bar --}}
        <div class="card border-0 mb-4">
            <div class="card-body py-2 d-flex justify-content-end">
                <x-button text="Cancel" icon="cancel" variant="outline-secondary" href="{{ route('finetech.account-types.index') }}" />
                <x-button text="Create Account Type" icon="add" variant="primary" />
            </div>
        </div>

    </form>

</x-app-layout>
