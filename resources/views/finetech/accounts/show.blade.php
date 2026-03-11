<x-app-layout>

    {{-- Page Header --}}
    <div class="py-3 py-lg-4">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h4 class="page-title mb-0">
                    <i class="fas fa-university me-2 text-primary"></i>Account Details
                </h4>
            </div>
            <div class="col-lg-6">
                <div class="d-none d-lg-block">
                    <ol class="breadcrumb m-0 float-end">
                        <li class="breadcrumb-item"><a href="{{ route('finetech.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('finetech.accounts.index') }}">Accounts</a></li>
                        <li class="breadcrumb-item active">View</li>
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
                Viewing account <strong>{{ $account->account_number }}</strong>.
            </span>
            <div>
                <x-button text="Back" icon="back" variant="outline-secondary" href="{{ route('finetech.accounts.index') }}" />
                <x-button text="Edit Account" icon="edit" variant="info" href="{{ route('finetech.accounts.edit', $account) }}" />
            </div>
        </div>
    </div>

    <div class="row g-3">

        {{-- Left: Summary Card --}}
        <div class="col-md-4">
            <div class="card border-0 text-center">
                <div class="card-body py-4">
                    <div class="mb-3">
                        <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center mx-auto" style="width:80px;height:80px;font-size:28px;">
                            <i class="fas fa-university"></i>
                        </div>
                    </div>
                    <h5 class="fw-bold mb-1">{{ $account->account_number }}</h5>
                    <p class="text-muted small mb-1">{{ $account->accountType->name }}</p>
                    <p class="text-muted small mb-2">{{ $account->customer->first_name }} {{ $account->customer->last_name }}</p>
                    <div class="mb-2">
                        @switch($account->status)
                            @case('active')
                                <span class="badge bg-success-subtle text-success border border-success-subtle px-3">Active</span>
                                @break
                            @case('frozen')
                                <span class="badge bg-info-subtle text-info border border-info-subtle px-3">Frozen</span>
                                @break
                            @case('dormant')
                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-3">Dormant</span>
                                @break
                            @case('closed')
                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3">Closed</span>
                                @break
                        @endswitch
                    </div>
                    <div class="mt-3">
                        <div class="small text-muted">Current Balance</div>
                        <h4 class="fw-bold text-primary mb-0">
                            {{ $account->currency->symbol }}{{ number_format($account->current_balance, 2) }}
                        </h4>
                    </div>
                </div>
                <div class="card-footer bg-light border-0 py-3">
                    <div class="row text-center">
                        <div class="col-6 border-end">
                            <div class="small text-muted">Opened</div>
                            <div class="fw-semibold small">{{ $account->opened_at->format('d M Y') }}</div>
                        </div>
                        <div class="col-6">
                            <div class="small text-muted">Updated</div>
                            <div class="fw-semibold small">{{ $account->updated_at->diffForHumans() }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right: Details --}}
        <div class="col-md-8">

            {{-- Account Information --}}
            <div class="card border-0 mb-3">
                <div class="card-header bg-primary bg-opacity-10 border-0 py-3">
                    <h6 class="mb-0 fw-semibold text-primary"><i class="fas fa-university me-2"></i>Account Information</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @foreach ([
                            ['fas fa-hashtag', 'Account Number', $account->account_number],
                            ['fas fa-layer-group', 'Account Type', $account->accountType->name . ' (' . $account->accountType->code . ')'],
                            ['fas fa-user', 'Customer', $account->customer->first_name . ' ' . $account->customer->last_name],
                            ['fas fa-id-badge', 'Customer Number', $account->customer->customer_number],
                        ] as [$icon, $label, $value])
                            <div class="col-sm-6">
                                <div class="d-flex align-items-start gap-2">
                                    <span class="text-muted mt-1"><i class="{{ $icon }} fa-fw"></i></span>
                                    <div>
                                        <div class="small text-muted">{{ $label }}</div>
                                        <div class="fw-semibold">{{ $value ?: '—' }}</div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Branch & Currency --}}
            <div class="card border-0 mb-3">
                <div class="card-header bg-success bg-opacity-10 border-0 py-3">
                    <h6 class="mb-0 fw-semibold text-success"><i class="fas fa-code-branch me-2"></i>Branch & Currency</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @foreach ([
                            ['fas fa-building', 'Branch', $account->branch->name ?? '—'],
                            ['fas fa-coins', 'Currency', $account->currency->name . ' (' . $account->currency->symbol . ')'],
                        ] as [$icon, $label, $value])
                            <div class="col-sm-6">
                                <div class="d-flex align-items-start gap-2">
                                    <span class="text-muted mt-1"><i class="{{ $icon }} fa-fw"></i></span>
                                    <div>
                                        <div class="small text-muted">{{ $label }}</div>
                                        <div class="fw-semibold">{{ $value ?: '—' }}</div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Balance Details --}}
            <div class="card border-0 mb-3">
                <div class="card-header bg-warning bg-opacity-10 border-0 py-3">
                    <h6 class="mb-0 fw-semibold text-warning"><i class="fas fa-coins me-2"></i>Balance & Dates</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @foreach ([
                            ['fas fa-money-bill-wave', 'Opening Balance', $account->currency->symbol . number_format($account->opening_balance, 2)],
                            ['fas fa-wallet', 'Current Balance', $account->currency->symbol . number_format($account->current_balance, 2)],
                            ['fas fa-calendar-check', 'Opened At', $account->opened_at->format('d M Y')],
                            ['fas fa-calendar-times', 'Closed At', $account->closed_at?->format('d M Y')],
                            ['fas fa-clock', 'Last Transaction', $account->last_transaction_at?->format('d M Y H:i')],
                        ] as [$icon, $label, $value])
                            <div class="col-sm-6">
                                <div class="d-flex align-items-start gap-2">
                                    <span class="text-muted mt-1"><i class="{{ $icon }} fa-fw"></i></span>
                                    <div>
                                        <div class="small text-muted">{{ $label }}</div>
                                        <div class="fw-semibold">{{ $value ?: '—' }}</div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Status & Staff --}}
            <div class="card border-0 mb-3">
                <div class="card-header bg-info bg-opacity-10 border-0 py-3">
                    <h6 class="mb-0 fw-semibold text-info"><i class="fas fa-cog me-2"></i>Status & Staff</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <div class="d-flex align-items-start gap-2">
                                <span class="text-muted mt-1"><i class="fas fa-user-shield fa-fw"></i></span>
                                <div>
                                    <div class="small text-muted">Opened By</div>
                                    <div class="fw-semibold">{{ $account->openedBy->name ?? '—' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if ($account->status_reason)
                        <div class="mt-3 pt-3 border-top">
                            <div class="d-flex align-items-start gap-2">
                                <span class="text-muted mt-1"><i class="fas fa-comment fa-fw"></i></span>
                                <div>
                                    <div class="small text-muted">Status Reason</div>
                                    <div class="fw-semibold">{{ $account->status_reason }}</div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

</x-app-layout>
