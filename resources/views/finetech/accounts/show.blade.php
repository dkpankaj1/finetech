<x-app-layout>

    @php
        $netFlow = $totalDeposited - $totalWithdrawn;
    @endphp

    <div class="py-3 py-lg-4">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <h4 class="page-title mb-0">
                    <i class="fas fa-university me-2 text-primary"></i>Account Analytics
                </h4>
                <p class="text-muted small mb-0 mt-1">
                    {{ $account->account_number }} | {{ $account->customer->first_name }} {{ $account->customer->last_name }}
                </p>
            </div>
            <div class="col-lg-5 text-lg-end">
                <x-button text="Back" icon="back" variant="outline-secondary" href="{{ route('finetech.accounts.index') }}" />
                <x-button text="Edit" icon="edit" variant="info" href="{{ route('finetech.accounts.edit', $account) }}" />
                <x-button text="Transactions" icon="show" variant="primary"
                    href="{{ route('finetech.transactions.index', ['account_id' => $account->id]) }}" />
            </div>
        </div>
    </div>

    <div class="row g-3 mb-3">
        <div class="col-md-3">
            <div class="card border-0 h-100">
                <div class="card-body">
                    <div class="small text-muted">Current Balance</div>
                    <h5 class="fw-bold text-primary mb-0">{{ $account->currency->symbol }}{{ number_format($account->current_balance, 2) }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 h-100">
                <div class="card-body">
                    <div class="small text-muted">Total Deposited</div>
                    <h5 class="fw-bold text-success mb-0">+{{ $account->currency->symbol }}{{ number_format($totalDeposited, 2) }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 h-100">
                <div class="card-body">
                    <div class="small text-muted">Total Withdrawn</div>
                    <h5 class="fw-bold text-danger mb-0">-{{ $account->currency->symbol }}{{ number_format($totalWithdrawn, 2) }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 h-100">
                <div class="card-body">
                    <div class="small text-muted">Net Flow</div>
                    <h5 class="fw-bold {{ $netFlow >= 0 ? 'text-success' : 'text-danger' }} mb-0">
                        {{ $netFlow >= 0 ? '+' : '-' }}{{ $account->currency->symbol }}{{ number_format(abs($netFlow), 2) }}
                    </h5>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-lg-4">
            <div class="card border-0 mb-3">
                <div class="card-header bg-primary bg-opacity-10 border-0 py-3">
                    <h6 class="mb-0 fw-semibold text-primary"><i class="fas fa-id-card me-2"></i>Profile</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center" style="width:56px;height:56px;">
                            <i class="fas fa-user"></i>
                        </div>
                        <div>
                            <div class="fw-semibold">{{ $account->customer->first_name }} {{ $account->customer->last_name }}</div>
                            <div class="small text-muted">{{ $account->customer->customer_number }}</div>
                        </div>
                    </div>

                    <div class="small text-muted mb-1">Account Number</div>
                    <div class="fw-semibold mb-2">{{ $account->account_number }}</div>

                    <div class="small text-muted mb-1">Account Type</div>
                    <div class="fw-semibold mb-2">{{ $account->accountType->name }} ({{ $account->accountType->code }})</div>

                    <div class="small text-muted mb-1">Branch</div>
                    <div class="fw-semibold mb-2">{{ $account->branch->name ?? '—' }}</div>

                    <div class="small text-muted mb-1">Status</div>
                    @switch($account->status)
                        @case('active')
                            <span class="badge bg-success-subtle text-success border border-success-subtle">Active</span>
                            @break
                        @case('frozen')
                            <span class="badge bg-info-subtle text-info border border-info-subtle">Frozen</span>
                            @break
                        @case('dormant')
                            <span class="badge bg-warning-subtle text-warning border border-warning-subtle">Dormant</span>
                            @break
                        @default
                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle">Closed</span>
                    @endswitch

                    @if ($account->status_reason)
                        <hr>
                        <div class="small text-muted mb-1">Status Reason</div>
                        <div class="fw-semibold small">{{ $account->status_reason }}</div>
                    @endif
                </div>
            </div>

            <div class="card border-0 mb-3">
                <div class="card-header bg-warning bg-opacity-10 border-0 py-3">
                    <h6 class="mb-0 fw-semibold text-warning"><i class="fas fa-clock me-2"></i>Dates</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between border-bottom py-2">
                        <span class="small text-muted">Opened At</span>
                        <span class="small fw-semibold">{{ $account->opened_at->format('d M Y') }}</span>
                    </div>
                    <div class="d-flex justify-content-between border-bottom py-2">
                        <span class="small text-muted">Last Transaction</span>
                        <span class="small fw-semibold">{{ $account->last_transaction_at?->format('d M Y H:i') ?: '—' }}</span>
                    </div>
                    <div class="d-flex justify-content-between border-bottom py-2">
                        <span class="small text-muted">Updated</span>
                        <span class="small fw-semibold">{{ $account->updated_at->diffForHumans() }}</span>
                    </div>
                    <div class="d-flex justify-content-between pt-2">
                        <span class="small text-muted">Opened By</span>
                        <span class="small fw-semibold">{{ $account->openedBy->name ?? '—' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card border-0 mb-3">
                <div class="card-header bg-success bg-opacity-10 border-0 py-3 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-semibold text-success"><i class="fas fa-arrow-down me-2"></i>Recent Deposits</h6>
                    <x-button size="sm" text="New" icon="add" variant="outline-success" href="{{ route('finetech.deposits.create') }}" />
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-sm align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3">Reference</th>
                                    <th>Date</th>
                                    <th>Source</th>
                                    <th class="text-end pe-3">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($recentDeposits as $deposit)
                                    <tr>
                                        <td class="ps-3 small fw-semibold">{{ $deposit->reference_no }}</td>
                                        <td class="small text-muted">{{ $deposit->deposited_at?->format('d M Y h:i A') }}</td>
                                        <td class="small">{{ ucwords(str_replace('_', ' ', $deposit->source)) }}</td>
                                        <td class="text-end pe-3 small fw-semibold text-success">+{{ $account->currency->symbol }}{{ number_format($deposit->amount, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-3 text-muted small">No deposits found for this account.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card border-0 mb-3">
                <div class="card-header bg-danger bg-opacity-10 border-0 py-3 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-semibold text-danger"><i class="fas fa-arrow-up me-2"></i>Recent Withdrawals</h6>
                    <x-button size="sm" text="New" icon="add" variant="outline-danger" href="{{ route('finetech.withdrawals.create') }}" />
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-sm align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3">Reference</th>
                                    <th>Date</th>
                                    <th>Source</th>
                                    <th class="text-end pe-3">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($recentWithdrawals as $withdrawal)
                                    <tr>
                                        <td class="ps-3 small fw-semibold">{{ $withdrawal->reference_no }}</td>
                                        <td class="small text-muted">{{ $withdrawal->withdrawn_at?->format('d M Y h:i A') }}</td>
                                        <td class="small">{{ ucwords(str_replace('_', ' ', $withdrawal->source)) }}</td>
                                        <td class="text-end pe-3 small fw-semibold text-danger">-{{ $account->currency->symbol }}{{ number_format($withdrawal->amount, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-3 text-muted small">No withdrawals found for this account.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card border-0 mb-3">
                <div class="card-header bg-info bg-opacity-10 border-0 py-3 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-semibold text-info"><i class="fas fa-box me-2"></i>Fixed Deposits (FDS)</h6>
                    <x-button size="sm" text="New" icon="add" variant="outline-info" href="{{ route('finetech.fds.create') }}" />
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-sm align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3">FD No</th>
                                    <th>Opened</th>
                                    <th>Maturity</th>
                                    <th>Status</th>
                                    <th class="text-end pe-3">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($fixedDeposits as $fd)
                                    <tr>
                                        <td class="ps-3 small fw-semibold">{{ $fd->fd_number }}</td>
                                        <td class="small text-muted">{{ $fd->opened_at?->format('d M Y') }}</td>
                                        <td class="small text-muted">{{ $fd->maturity_date?->format('d M Y') }}</td>
                                        <td>
                                            <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">
                                                {{ ucwords(str_replace('_', ' ', $fd->status)) }}
                                            </span>
                                        </td>
                                        <td class="text-end pe-3 small fw-semibold">{{ $account->currency->symbol }}{{ number_format($fd->maturity_amount, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-3 text-muted small">No FDS records found for this account.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
