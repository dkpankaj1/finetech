<x-app-layout>

    {{-- Page Header --}}
    <div class="py-3 py-lg-4">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h4 class="page-title mb-0">
                    <i class="fas fa-file-invoice-dollar me-2 text-primary"></i>Transactions
                </h4>
            </div>
            <div class="col-lg-6">
                <div class="d-none d-lg-block">
                    <ol class="breadcrumb m-0 float-end">
                        <li class="breadcrumb-item"><a href="{{ route('finetech.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Transactions</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="card border-0 mb-3">
        <div class="card-header bg-primary bg-opacity-10 border-0 py-3">
            <h6 class="mb-0 card-title"><i class="fas fa-filter me-2"></i>Filter Transactions</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('finetech.transactions.index') }}">
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <x-input-label name="type" text="Type" />
                        <select name="type" id="type" class="form-select">
                            <option value="">All</option>
                            <option value="deposit" {{ ($filters['type'] ?? '') === 'deposit' ? 'selected' : '' }}>Deposit</option>
                            <option value="withdrawal" {{ ($filters['type'] ?? '') === 'withdrawal' ? 'selected' : '' }}>Withdrawal</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <x-input-label name="account_id" text="Account" />
                        <select name="account_id" id="account_id" class="form-select">
                            <option value="">All Accounts</option>
                            @foreach ($accounts as $account)
                                <option value="{{ $account->id }}" {{ (string) ($filters['account_id'] ?? '') === (string) $account->id ? 'selected' : '' }}>
                                    {{ $account->account_number }} - {{ $account->customer?->first_name }} {{ $account->customer?->last_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <x-input-label name="from_date" text="From" />
                        <input type="date" name="from_date" id="from_date" class="form-control" value="{{ $filters['from_date'] ?? '' }}">
                    </div>

                    <div class="col-md-2">
                        <x-input-label name="to_date" text="To" />
                        <input type="date" name="to_date" id="to_date" class="form-control" value="{{ $filters['to_date'] ?? '' }}">
                    </div>

                    <div class="col-md-2 d-flex">
                        <x-button text="Apply" icon="search" variant="primary" type="submit" />
                        <x-button text="Reset" icon="refresh" variant="outline-secondary" type="button" onclick="window.location='{{ route('finetech.transactions.index') }}'" />
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Table --}}
    <div class="card border-0">
        <div class="card-header bg-success bg-opacity-10 border-0 py-3 d-flex justify-content-between align-items-center">
            <h6 class="mb-0 card-title"><i class="fas fa-list me-2"></i>Transaction Timeline</h6>
            <span class="badge bg-light text-dark border">{{ $transactions->count() }} record(s)</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">#</th>
                            <th>Reference</th>
                            <th>Type</th>
                            <th>Account</th>
                            <th>Customer</th>
                            <th>Source</th>
                            <th class="text-end">Amount</th>
                            <th>Date & Time</th>
                            <th>By</th>
                            <th class="text-end pe-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transactions as $index => $transaction)
                            <tr>
                                <td class="ps-3 text-muted small">{{ $index + 1 }}</td>
                                <td>
                                    <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">
                                        {{ $transaction['reference_no'] }}
                                    </span>
                                </td>
                                <td>
                                    @if ($transaction['transaction_type'] === 'deposit')
                                        <span class="badge bg-success-subtle text-success border border-success-subtle">Deposit</span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle">Withdrawal</span>
                                    @endif
                                </td>
                                <td class="small fw-semibold">{{ $transaction['account_no'] }}</td>
                                <td class="small">{{ $transaction['customer_name'] }}</td>
                                <td class="small">{{ ucwords(str_replace('_', ' ', $transaction['source'])) }}</td>
                                <td class="text-end fw-semibold small {{ $transaction['transaction_type'] === 'deposit' ? 'text-success' : 'text-danger' }}">
                                    {{ $transaction['transaction_type'] === 'deposit' ? '+' : '-' }}{{ $transaction['currency_symbol'] }}{{ number_format($transaction['amount'], 2) }}
                                </td>
                                <td class="small text-muted">{{ optional($transaction['transacted_at'])->format('d M Y h:i A') }}</td>
                                <td class="small">{{ $transaction['created_by'] }}</td>
                                <td class="text-end pe-3">
                                    <a href="{{ $transaction['show_url'] }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye me-1"></i>View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center py-5 text-muted">
                                    <i class="fas fa-receipt fa-2x mb-2 d-block opacity-25"></i>
                                    No transactions found for selected filters.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</x-app-layout>
