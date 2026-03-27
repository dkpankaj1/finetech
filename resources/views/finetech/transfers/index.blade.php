<x-app-layout>

    <div class="py-3 py-lg-4">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h4 class="page-title mb-0">
                    <i class="fas fa-exchange-alt me-2 text-primary"></i>Transfers
                </h4>
            </div>
            <div class="col-lg-6">
                <div class="d-none d-lg-block">
                    <ol class="breadcrumb m-0 float-end">
                        <li class="breadcrumb-item"><a href="{{ route('finetech.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Transfers</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 mb-3">
        <div class="card-body py-2 d-flex justify-content-between align-items-center">
            <span class="text-muted small">Total <strong>{{ $transfers->count() }}</strong> transfer(s).</span>
            <x-button icon="add" variant="primary" text="New Transfer" href="{{ route('finetech.transfers.create') }}" />
        </div>
    </div>

    <div class="card border-0">
        <div class="card-header bg-primary bg-opacity-10 border-0 py-3">
            <h6 class="mb-0 card-title"><i class="fas fa-list me-2"></i>Transfer History</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">#</th>
                            <th>Reference</th>
                            <th>Type</th>
                            <th>From</th>
                            <th>To</th>
                            <th class="text-end">Amount</th>
                            <th>Date</th>
                            <th class="text-end pe-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transfers as $key => $transfer)
                            <tr>
                                <td class="ps-3 small text-muted">{{ ++$key }}</td>
                                <td><span class="badge bg-primary-subtle text-primary border border-primary-subtle">{{ $transfer->reference_no }}</span></td>
                                <td>
                                    <span class="badge {{ $transfer->transfer_type === 'internal' ? 'bg-success-subtle text-success border border-success-subtle' : 'bg-warning-subtle text-warning border border-warning-subtle' }}">
                                        {{ ucfirst($transfer->transfer_type) }}
                                    </span>
                                </td>
                                <td class="small">{{ $transfer->sourceAccount->account_number }}</td>
                                <td class="small">
                                    @if ($transfer->transfer_type === 'internal')
                                        {{ $transfer->destinationAccount?->account_number ?? '—' }}
                                    @else
                                        {{ $transfer->destination_bank_name }} ({{ $transfer->destination_account_number }})
                                    @endif
                                </td>
                                <td class="text-end small fw-semibold">{{ $transfer->currency->symbol }}{{ number_format($transfer->amount, 2) }}</td>
                                <td class="small text-muted">{{ $transfer->transferred_at->format('d M Y h:i A') }}</td>
                                <td class="text-end pe-3">
                                    <x-button size="sm" icon="show" variant="outline-primary" text="View" href="{{ route('finetech.transfers.show', $transfer) }}" />
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">No transfers found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</x-app-layout>
