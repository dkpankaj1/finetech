<x-app-layout>

    <div class="py-3 py-lg-4">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h4 class="page-title mb-0">
                    <i class="fas fa-paper-plane me-2 text-primary"></i>New Transfer
                </h4>
            </div>
            <div class="col-lg-6">
                <div class="d-none d-lg-block">
                    <ol class="breadcrumb m-0 float-end">
                        <li class="breadcrumb-item"><a href="{{ route('finetech.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('finetech.transfers.index') }}">Transfers</a></li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('finetech.transfers.store') }}" method="POST">
        @csrf

        <div class="card border-0 mb-3">
            <div class="card-body py-2 d-flex justify-content-between align-items-center">
                <span class="text-muted small">Transfer between internal accounts or to other bank account.</span>
                <div>
                    <x-button text="Back" icon="back" variant="outline-secondary" href="{{ route('finetech.transfers.index') }}" />
                    <x-button text="Transfer" icon="save" variant="primary" />
                </div>
            </div>
        </div>

        <div class="card border-0 mb-3">
            <div class="card-header bg-primary bg-opacity-10 border-0 py-3">
                <h6 class="mb-0 fw-semibold text-primary"><i class="fas fa-exchange-alt me-2"></i>Transfer Details</h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <x-input-label name="source_account_id" text="Source Account" />
                        <select name="source_account_id" class="form-select @error('source_account_id') is-invalid @enderror">
                            <option value="">-- Select Source Account --</option>
                            @foreach ($accounts as $account)
                                <option value="{{ $account->id }}" {{ old('source_account_id') == $account->id ? 'selected' : '' }}>
                                    {{ $account->account_number }} - {{ $account->customer->first_name }} {{ $account->customer->last_name }} - {{ $account->currency->symbol }}{{ number_format($account->current_balance, 2) }}
                                </option>
                            @endforeach
                        </select>
                        @error('source_account_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-3">
                        <x-input-label name="transfer_type" text="Transfer Type" />
                        <select name="transfer_type" id="transfer_type" class="form-select @error('transfer_type') is-invalid @enderror">
                            <option value="internal" {{ old('transfer_type', 'internal') === 'internal' ? 'selected' : '' }}>Internal</option>
                            <option value="external" {{ old('transfer_type') === 'external' ? 'selected' : '' }}>Other Bank</option>
                        </select>
                        @error('transfer_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-3">
                        <x-input-label name="amount" text="Amount" />
                        <input type="number" step="0.01" min="0.01" name="amount" value="{{ old('amount') }}" class="form-control @error('amount') is-invalid @enderror" placeholder="0.00">
                        @error('amount')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <x-input-label name="destination_account_id" text="Destination Account (Internal)" />
                        <select name="destination_account_id" class="form-select @error('destination_account_id') is-invalid @enderror">
                            <option value="">-- Select Destination Account --</option>
                            @foreach ($accounts as $account)
                                <option value="{{ $account->id }}" {{ old('destination_account_id') == $account->id ? 'selected' : '' }}>
                                    {{ $account->account_number }} - {{ $account->customer->first_name }} {{ $account->customer->last_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('destination_account_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <x-input-label name="beneficiary_name" text="Beneficiary Name (Other Bank)" />
                        <input type="text" name="beneficiary_name" value="{{ old('beneficiary_name') }}" class="form-control @error('beneficiary_name') is-invalid @enderror">
                        @error('beneficiary_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-4">
                        <x-input-label name="destination_bank_name" text="Destination Bank" />
                        <input type="text" name="destination_bank_name" value="{{ old('destination_bank_name') }}" class="form-control @error('destination_bank_name') is-invalid @enderror">
                        @error('destination_bank_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-4">
                        <x-input-label name="destination_account_number" text="Destination Account No." />
                        <input type="text" name="destination_account_number" value="{{ old('destination_account_number') }}" class="form-control @error('destination_account_number') is-invalid @enderror">
                        @error('destination_account_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-4">
                        <x-input-label name="destination_ifsc" text="IFSC" />
                        <input type="text" name="destination_ifsc" value="{{ old('destination_ifsc') }}" class="form-control @error('destination_ifsc') is-invalid @enderror">
                        @error('destination_ifsc')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <x-input-label name="transferred_at" text="Transfer Date & Time" />
                        <input type="datetime-local" name="transferred_at" value="{{ old('transferred_at', now()->format('Y-m-d\\TH:i')) }}" class="form-control @error('transferred_at') is-invalid @enderror">
                        @error('transferred_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <x-input-label name="remarks" text="Remarks" />
                        <input type="text" name="remarks" value="{{ old('remarks') }}" class="form-control @error('remarks') is-invalid @enderror">
                        @error('remarks')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
        </div>

    </form>

</x-app-layout>
