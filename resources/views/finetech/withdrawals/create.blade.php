<x-app-layout>

    {{-- Page Header --}}
    <div class="py-3 py-lg-4">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h4 class="page-title mb-0">
                    <i class="fas fa-minus-circle me-2 text-primary"></i>New Withdrawal
                </h4>
            </div>
            <div class="col-lg-6">
                <div class="d-none d-lg-block">
                    <ol class="breadcrumb m-0 float-end">
                        <li class="breadcrumb-item"><a href="{{ route('finetech.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('finetech.withdrawals.index') }}">Withdrawals</a></li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('finetech.withdrawals.store') }}" method="POST">
        @csrf

        {{-- Action Bar --}}
        <div class="card border-0 mb-3">
            <div class="card-body py-2 d-flex justify-content-between align-items-center">
                <span class="text-muted small">
                    <i class="fas fa-info-circle me-1"></i>Select an active account and enter withdrawal details.
                </span>
                <div>
                    <x-button text="Back" icon="back" variant="outline-secondary" href="{{ route('finetech.withdrawals.index') }}" />
                    <x-button text="Save Withdrawal" icon="save" variant="danger" />
                </div>
            </div>
        </div>

        <div class="card border-0 mb-3">
            <div class="card-header bg-danger bg-opacity-10 border-0 py-3">
                <h6 class="mb-0 fw-semibold text-danger">
                    <i class="fas fa-arrow-up-right-dots me-2"></i>Withdrawal Information
                </h6>
            </div>
            <div class="card-body pt-4 pb-2">
                <div class="row g-3">
                    <div class="col-md-12">
                        <x-input-label name="account_id" text="Account" />
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

                    <div class="col-md-4">
                        <x-input-label name="amount" text="Amount" />
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-money-bill-wave text-muted"></i></span>
                            <input type="number" step="0.01" min="0.01" name="amount" id="amount"
                                value="{{ old('amount') }}"
                                class="form-control border-start-0 ps-0 @error('amount') is-invalid @enderror"
                                placeholder="0.00">
                        </div>
                        @error('amount')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <x-input-label name="source" text="Source" />
                        <select name="source" id="source" class="form-select @error('source') is-invalid @enderror">
                            <option value="cash" {{ old('source', 'cash') == 'cash' ? 'selected' : '' }}>Cash</option>
                            <option value="bank_transfer" {{ old('source') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                            <option value="cheque" {{ old('source') == 'cheque' ? 'selected' : '' }}>Cheque</option>
                            <option value="online" {{ old('source') == 'online' ? 'selected' : '' }}>Online</option>
                            <option value="other" {{ old('source') == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('source')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <x-input-label name="withdrawn_at" text="Withdrawn At" />
                        <input type="datetime-local" name="withdrawn_at" id="withdrawn_at"
                            value="{{ old('withdrawn_at', now()->format('Y-m-d\\TH:i')) }}"
                            class="form-control @error('withdrawn_at') is-invalid @enderror">
                        @error('withdrawn_at')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <x-input-label name="remarks" text="Remarks (optional)" />
                        <textarea name="remarks" id="remarks" rows="3"
                            class="form-control @error('remarks') is-invalid @enderror"
                            placeholder="Add note for this withdrawal transaction">{{ old('remarks') }}</textarea>
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
                <x-button text="Cancel" icon="cancel" variant="outline-secondary" href="{{ route('finetech.withdrawals.index') }}" />
                <x-button text="Save Withdrawal" icon="save" variant="danger" />
            </div>
        </div>

    </form>

</x-app-layout>
