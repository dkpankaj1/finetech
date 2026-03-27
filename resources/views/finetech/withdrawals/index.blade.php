<x-app-layout>

    {{-- Page Header --}}
    <div class="py-3 py-lg-4">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h4 class="page-title mb-0">
                    <i class="fas fa-arrow-up-right-dots me-2 text-primary"></i>Withdrawals
                </h4>
            </div>
            <div class="col-lg-6">
                <div class="d-none d-lg-block">
                    <ol class="breadcrumb m-0 float-end">
                        <li class="breadcrumb-item"><a href="{{ route('finetech.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Withdrawals</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    {{-- Action Bar --}}
    <div class="card border-0 mb-3">
        <div class="card-body py-2 d-flex justify-content-between align-items-center">
            <span class="text-muted small">
                <i class="fas fa-info-circle me-1"></i>
                Total <strong>{{ $withdrawals->count() }}</strong> withdrawal(s) recorded.
            </span>
            <x-button icon="add" variant="primary" text="New Withdrawal" href="{{ route('finetech.withdrawals.create') }}" />
        </div>
    </div>

    {{-- Table Card --}}
    <div class="card border-0">
        <div class="card-header bg-primary bg-opacity-10 border-0 py-3">
            <h6 class="mb-0 card-title">
                <i class="fas fa-list me-2"></i>Withdrawal History
            </h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">#</th>
                            <th>Reference</th>
                            <th>Account</th>
                            <th>Customer</th>
                            <th>Source</th>
                            <th class="text-end">Amount</th>
                            <th>Withdrawn At</th>
                            <th>By</th>
                            <th class="text-end pe-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($withdrawals as $key => $withdrawal)
                            <tr>
                                <td class="ps-3 text-muted small">{{ ++$key }}</td>
                                <td>
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle">
                                        {{ $withdrawal->reference_no }}
                                    </span>
                                </td>
                                <td>
                                    <div class="fw-semibold small">{{ $withdrawal->account->account_number }}</div>
                                    <div class="text-muted" style="font-size:11px;">{{ $withdrawal->currency->code }}</div>
                                </td>
                                <td class="small">
                                    {{ $withdrawal->customer->first_name }} {{ $withdrawal->customer->last_name }}
                                </td>
                                <td>
                                    <span class="badge bg-info-subtle text-info border border-info-subtle">
                                        {{ ucwords(str_replace('_', ' ', $withdrawal->source)) }}
                                    </span>
                                </td>
                                <td class="text-end fw-semibold small text-danger">
                                    -{{ $withdrawal->currency->symbol }}{{ number_format($withdrawal->amount, 2) }}
                                </td>
                                <td class="small text-muted">
                                    {{ $withdrawal->withdrawn_at->format('d M Y h:i A') }}
                                </td>
                                <td class="small">{{ $withdrawal->withdrawer->name ?? 'System' }}</td>
                                <td class="text-end pe-3">
                                    <x-button size="sm" icon="show" variant="outline-primary"
                                        href="{{ route('finetech.withdrawals.show', $withdrawal) }}" text="View" />
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-5 text-muted">
                                    <i class="fas fa-arrow-up-right-dots fa-2x mb-2 d-block opacity-25"></i>
                                    No withdrawals found. <a href="{{ route('finetech.withdrawals.create') }}">Record one now</a>.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</x-app-layout>
