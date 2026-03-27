<x-app-layout>

    {{-- Page Header --}}
    <div class="py-3 py-lg-4">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h4 class="page-title mb-0">
                    <i class="fas fa-plus-circle me-2 text-primary"></i>Create FDS
                </h4>
            </div>
            <div class="col-lg-6">
                <div class="d-none d-lg-block">
                    <ol class="breadcrumb m-0 float-end">
                        <li class="breadcrumb-item"><a href="{{ route('finetech.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('finetech.fds.index') }}">FDS</a></li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('finetech.fds.store') }}" method="POST">
        @csrf

        {{-- Action Bar --}}
        <div class="card border-0 mb-3">
            <div class="card-body py-2 d-flex justify-content-between align-items-center">
                <span class="text-muted small">
                    <i class="fas fa-info-circle me-1"></i>Choose account and configure tenure, rate, and principal amount.
                </span>
                <div>
                    <x-button text="Back" icon="back" variant="outline-secondary" href="{{ route('finetech.fds.index') }}" />
                    <x-button text="Create FDS" icon="save" variant="primary" />
                </div>
            </div>
        </div>

        <div class="card border-0 mb-3">
            <div class="card-header bg-primary bg-opacity-10 border-0 py-3">
                <h6 class="mb-0 fw-semibold text-primary">
                    <i class="fas fa-box me-2"></i>FDS Information
                </h6>
            </div>
            <div class="card-body pt-4 pb-2">
                <div class="row g-3">
                    <div class="col-md-12">
                        <x-input-label name="account_id" text="Funding Account" />
                        <select name="account_id" id="account_id" class="form-select @error('account_id') is-invalid @enderror">
                            <option value="">-- Select Active Account --</option>
                            @foreach ($accounts as $account)
                                <option value="{{ $account->id }}" {{ old('account_id') == $account->id ? 'selected' : '' }}>
                                    {{ $account->account_number }} -
                                    {{ $account->customer->first_name }} {{ $account->customer->last_name }} -
                                    {{ $account->currency->code }} {{ number_format($account->current_balance, 2) }}
                                </option>
                            @endforeach
                        </select>
                        @error('account_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <x-input-label name="principal_amount" text="Principal Amount" />
                        <input type="number" step="0.01" min="0.01" name="principal_amount" id="principal_amount"
                            value="{{ old('principal_amount') }}"
                            class="form-control @error('principal_amount') is-invalid @enderror"
                            placeholder="0.00">
                        @error('principal_amount')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <x-input-label name="interest_rate" text="Interest Rate (%)" />
                        <input type="number" step="0.01" min="0" max="100" name="interest_rate" id="interest_rate"
                            value="{{ old('interest_rate', '7.00') }}"
                            class="form-control @error('interest_rate') is-invalid @enderror"
                            placeholder="7.00">
                        @error('interest_rate')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <x-input-label name="tenure_months" text="Tenure (Months)" />
                        <input type="number" min="1" max="600" name="tenure_months" id="tenure_months"
                            value="{{ old('tenure_months', '12') }}"
                            class="form-control @error('tenure_months') is-invalid @enderror"
                            placeholder="12">
                        @error('tenure_months')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <x-input-label name="opened_at" text="Open Date" />
                        <input type="date" name="opened_at" id="opened_at"
                            value="{{ old('opened_at', now()->toDateString()) }}"
                            class="form-control @error('opened_at') is-invalid @enderror">
                        @error('opened_at')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <x-input-label name="remarks" text="Remarks (optional)" />
                        <textarea name="remarks" id="remarks" rows="3"
                            class="form-control @error('remarks') is-invalid @enderror"
                            placeholder="Any note for this FDS">{{ old('remarks') }}</textarea>
                        @error('remarks')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Bottom Action Bar --}}
        <div class="card border-0 mb-4">
            <div class="card-body py-2 d-flex justify-content-end">
                <x-button text="Cancel" icon="cancel" variant="outline-secondary" href="{{ route('finetech.fds.index') }}" />
                <x-button text="Create FDS" icon="save" variant="primary" />
            </div>
        </div>

    </form>

</x-app-layout>
