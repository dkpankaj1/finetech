<x-app-layout>

    {{-- Page Header --}}
    <div class="py-3 py-lg-4">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h4 class="page-title mb-0">
                    <i class="fas fa-plus-circle me-2 text-primary"></i>Open New Account
                </h4>
            </div>
            <div class="col-lg-6">
                <div class="d-none d-lg-block">
                    <ol class="breadcrumb m-0 float-end">
                        <li class="breadcrumb-item"><a href="{{ route('finetech.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('finetech.accounts.index') }}">Accounts</a></li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('finetech.accounts.store') }}" method="POST">
        @csrf

        {{-- Action Bar --}}
        <div class="card border-0 mb-3">
            <div class="card-body py-2 d-flex justify-content-between align-items-center">
                <span class="text-muted small">
                    <i class="fas fa-info-circle me-1"></i>Fill in all required fields to open a new account. Account number will be generated automatically.
                </span>
                <div>
                    <x-button text="Back" icon="back" variant="outline-secondary" href="{{ route('finetech.accounts.index') }}" />
                    <x-button text="Create Account" icon="add" variant="primary" />
                </div>
            </div>
        </div>

        {{-- Section 1: Account Setup --}}
        <div class="card border-0 mb-3">
            <div class="card-header bg-primary bg-opacity-10 border-0 py-3">
                <h6 class="mb-0 fw-semibold text-primary">
                    <i class="fas fa-university me-2"></i>Account Setup
                </h6>
            </div>
            <div class="card-body pt-4 pb-2">
                <div class="row g-3">
                    <div class="col-md-6">
                        <x-input-label name="customer_id" text="Customer" />
                        <select name="customer_id" id="customer_id" class="form-select @error('customer_id') is-invalid @enderror">
                            <option value="">-- Select Customer --</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->first_name }} {{ $customer->last_name }} ({{ $customer->customer_number }})
                                </option>
                            @endforeach
                        </select>
                        @error('customer_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <x-input-label name="account_type_id" text="Account Type" />
                        <select name="account_type_id" id="account_type_id" class="form-select @error('account_type_id') is-invalid @enderror">
                            <option value="">-- Select Account Type --</option>
                            @foreach ($accountTypes as $type)
                                <option value="{{ $type->id }}" {{ old('account_type_id') == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }} ({{ $type->code }})
                                </option>
                            @endforeach
                        </select>
                        @error('account_type_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Section 2: Branch & Currency --}}
        <div class="card border-0 mb-3">
            <div class="card-header bg-success bg-opacity-10 border-0 py-3">
                <h6 class="mb-0 fw-semibold text-success">
                    <i class="fas fa-code-branch me-2"></i>Branch & Currency
                </h6>
            </div>
            <div class="card-body pt-4 pb-2">
                <div class="row g-3">
                    <div class="col-md-6">
                        <x-input-label name="branch_id" text="Branch" />
                        <select name="branch_id" id="branch_id" class="form-select @error('branch_id') is-invalid @enderror">
                            <option value="">-- Select Branch --</option>
                            @foreach ($branches as $branch)
                                <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                                    {{ $branch->name }} ({{ $branch->code }})
                                </option>
                            @endforeach
                        </select>
                        @error('branch_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <x-input-label name="currency_id" text="Currency" />
                        <select name="currency_id" id="currency_id" class="form-select @error('currency_id') is-invalid @enderror">
                            <option value="">-- Select Currency --</option>
                            @foreach ($currencies as $currency)
                                <option value="{{ $currency->id }}" {{ old('currency_id') == $currency->id ? 'selected' : '' }}>
                                    {{ $currency->name }} ({{ $currency->symbol }})
                                </option>
                            @endforeach
                        </select>
                        @error('currency_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Section 3: Balance & Dates --}}
        <div class="card border-0 mb-3">
            <div class="card-header bg-warning bg-opacity-10 border-0 py-3">
                <h6 class="mb-0 fw-semibold text-warning">
                    <i class="fas fa-coins me-2"></i>Balance & Dates
                </h6>
            </div>
            <div class="card-body pt-4 pb-2">
                <div class="row g-3">
                    <div class="col-md-4">
                        <x-input-label name="opening_balance" text="Opening Balance" />
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-money-bill-wave text-muted"></i></span>
                            <x-input-field name="opening_balance" type="number" placeholder="0.00" value="{{ old('opening_balance', '0.00') }}" class="border-start-0 ps-0" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <x-input-label name="opened_at" text="Opening Date" />
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-calendar text-muted"></i></span>
                            <x-input-field name="opened_at" type="date" value="{{ old('opened_at', date('Y-m-d')) }}" class="border-start-0 ps-0" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <x-input-label name="closed_at" text="Closing Date (optional)" />
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-calendar-times text-muted"></i></span>
                            <x-input-field name="closed_at" type="date" class="border-start-0 ps-0" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Section 4: Status --}}
        <div class="card border-0 mb-3">
            <div class="card-header bg-info bg-opacity-10 border-0 py-3">
                <h6 class="mb-0 fw-semibold text-info">
                    <i class="fas fa-cog me-2"></i>Status
                </h6>
            </div>
            <div class="card-body pt-4 pb-2">
                <div class="row g-3">
                    <div class="col-md-4">
                        <x-input-label name="status" text="Account Status" />
                        <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                            <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="frozen" {{ old('status') == 'frozen' ? 'selected' : '' }}>Frozen</option>
                            <option value="dormant" {{ old('status') == 'dormant' ? 'selected' : '' }}>Dormant</option>
                            <option value="closed" {{ old('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-8">
                        <x-input-label name="status_reason" text="Status Reason (optional)" />
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-comment text-muted"></i></span>
                            <textarea name="status_reason" id="status_reason" rows="2"
                                class="form-control border-start-0 ps-0 @error('status_reason') is-invalid @enderror"
                                placeholder="Reason for freezing/closing (if applicable)">{{ old('status_reason') }}</textarea>
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
                <x-button text="Cancel" icon="cancel" variant="outline-secondary" href="{{ route('finetech.accounts.index') }}" />
                <x-button text="Create Account" icon="add" variant="primary" />
            </div>
        </div>

    </form>

</x-app-layout>
