<x-app-layout>

    <div class="py-3 py-lg-4">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h4 class="page-title mb-0"><i class="fas fa-receipt me-2 text-primary"></i>Transfer Details</h4>
            </div>
            <div class="col-lg-6 text-lg-end">
                <x-button text="Back" icon="back" variant="outline-secondary" href="{{ route('finetech.transfers.index') }}" />
                <x-button text="New Transfer" icon="add" variant="primary" href="{{ route('finetech.transfers.create') }}" />
            </div>
        </div>
    </div>

    <div class="card border-0 mb-3">
        <div class="card-header bg-primary bg-opacity-10 border-0 py-3">
            <h6 class="mb-0 fw-semibold text-primary">Reference: {{ $transfer->reference_no }}</h6>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="small text-muted">Transfer Type</div>
                    <div class="fw-semibold">{{ ucfirst($transfer->transfer_type) }}</div>
                </div>
                <div class="col-md-6">
                    <div class="small text-muted">Amount</div>
                    <div class="fw-semibold">{{ $transfer->currency->symbol }}{{ number_format($transfer->amount, 2) }}</div>
                </div>
                <div class="col-md-6">
                    <div class="small text-muted">Source Account</div>
                    <div class="fw-semibold">{{ $transfer->sourceAccount->account_number }}</div>
                </div>
                <div class="col-md-6">
                    <div class="small text-muted">Source Customer</div>
                    <div class="fw-semibold">{{ $transfer->sourceAccount->customer->first_name }} {{ $transfer->sourceAccount->customer->last_name }}</div>
                </div>

                @if ($transfer->transfer_type === 'internal')
                    <div class="col-md-6">
                        <div class="small text-muted">Destination Account</div>
                        <div class="fw-semibold">{{ $transfer->destinationAccount?->account_number }}</div>
                    </div>
                    <div class="col-md-6">
                        <div class="small text-muted">Destination Customer</div>
                        <div class="fw-semibold">{{ $transfer->destinationAccount?->customer?->first_name }} {{ $transfer->destinationAccount?->customer?->last_name }}</div>
                    </div>
                @else
                    <div class="col-md-6">
                        <div class="small text-muted">Destination Bank</div>
                        <div class="fw-semibold">{{ $transfer->destination_bank_name }}</div>
                    </div>
                    <div class="col-md-6">
                        <div class="small text-muted">Beneficiary</div>
                        <div class="fw-semibold">{{ $transfer->beneficiary_name }}</div>
                    </div>
                    <div class="col-md-6">
                        <div class="small text-muted">Destination Account No.</div>
                        <div class="fw-semibold">{{ $transfer->destination_account_number }}</div>
                    </div>
                    <div class="col-md-6">
                        <div class="small text-muted">IFSC</div>
                        <div class="fw-semibold">{{ $transfer->destination_ifsc }}</div>
                    </div>
                @endif

                <div class="col-md-6">
                    <div class="small text-muted">Transferred At</div>
                    <div class="fw-semibold">{{ $transfer->transferred_at->format('d M Y h:i A') }}</div>
                </div>
                <div class="col-md-6">
                    <div class="small text-muted">By</div>
                    <div class="fw-semibold">{{ $transfer->transferBy->name ?? 'System' }}</div>
                </div>
                <div class="col-md-6">
                    <div class="small text-muted">Source Opening -> Closing</div>
                    <div class="fw-semibold">{{ $transfer->currency->symbol }}{{ number_format($transfer->sourceTransaction?->opening_balance ?? 0, 2) }} -> {{ $transfer->currency->symbol }}{{ number_format($transfer->sourceTransaction?->closing_balance ?? 0, 2) }}</div>
                </div>
                @if ($transfer->destinationTransaction)
                    <div class="col-md-6">
                        <div class="small text-muted">Destination Opening -> Closing</div>
                        <div class="fw-semibold">{{ $transfer->currency->symbol }}{{ number_format($transfer->destinationTransaction->opening_balance, 2) }} -> {{ $transfer->currency->symbol }}{{ number_format($transfer->destinationTransaction->closing_balance, 2) }}</div>
                    </div>
                @endif
                @if ($transfer->remarks)
                    <div class="col-12">
                        <div class="small text-muted">Remarks</div>
                        <div class="fw-semibold">{{ $transfer->remarks }}</div>
                    </div>
                @endif
            </div>
        </div>
    </div>

</x-app-layout>
