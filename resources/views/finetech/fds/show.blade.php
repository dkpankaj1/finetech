<x-app-layout>

    {{-- Page Header --}}
    <div class="py-3 py-lg-4">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h4 class="page-title mb-0">
                    <i class="fas fa-box me-2 text-primary"></i>FDS Details
                </h4>
            </div>
            <div class="col-lg-6">
                <div class="d-none d-lg-block">
                    <ol class="breadcrumb m-0 float-end">
                        <li class="breadcrumb-item"><a href="{{ route('finetech.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('finetech.fds.index') }}">FDS</a></li>
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
                FD Number <strong>{{ $fd->fd_number }}</strong>.
            </span>
            <div>
                <x-button text="Back" icon="back" variant="outline-secondary" href="{{ route('finetech.fds.index') }}" />
                <x-button text="Create FDS" icon="add" variant="primary" href="{{ route('finetech.fds.create') }}" />
            </div>
        </div>
    </div>

    <div class="row g-3">

        <div class="col-md-4">
            <div class="card border-0 text-center">
                <div class="card-body py-4">
                    <div class="mb-3">
                        <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center mx-auto" style="width:80px;height:80px;font-size:28px;">
                            <i class="fas fa-box"></i>
                        </div>
                    </div>
                    <h5 class="fw-bold mb-1">{{ $fd->fd_number }}</h5>
                    <p class="text-muted small mb-1">{{ $fd->account->account_number }}</p>
                    <p class="text-muted small mb-2">{{ $fd->customer->first_name }} {{ $fd->customer->last_name }}</p>

                    <div class="mt-3">
                        <div class="small text-muted">Maturity Amount</div>
                        <h4 class="fw-bold text-primary mb-0">
                            {{ $fd->currency->symbol }}{{ number_format($fd->maturity_amount, 2) }}
                        </h4>
                    </div>
                </div>
                <div class="card-footer bg-light border-0 py-3">
                    <div class="small text-muted">Maturity Date</div>
                    <div class="fw-semibold small">{{ $fd->maturity_date?->format('d M Y') }}</div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card border-0 mb-3">
                <div class="card-header bg-primary bg-opacity-10 border-0 py-3">
                    <h6 class="mb-0 fw-semibold text-primary"><i class="fas fa-file-invoice me-2"></i>FDS Information</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @foreach ([
                            ['fas fa-hashtag', 'FD Number', $fd->fd_number],
                            ['fas fa-wallet', 'Account', $fd->account->account_number],
                            ['fas fa-user', 'Customer', $fd->customer->first_name . ' ' . $fd->customer->last_name],
                            ['fas fa-code-branch', 'Branch', $fd->branch->name ?? '—'],
                            ['fas fa-coins', 'Currency', $fd->currency->name . ' (' . $fd->currency->code . ')'],
                            ['fas fa-money-bill-wave', 'Principal', $fd->currency->symbol . number_format($fd->principal_amount, 2)],
                            ['fas fa-percentage', 'Interest Rate', number_format($fd->interest_rate, 2) . '%'],
                            ['fas fa-calendar-alt', 'Tenure', $fd->tenure_months . ' months'],
                            ['fas fa-chart-line', 'Maturity Amount', $fd->currency->symbol . number_format($fd->maturity_amount, 2)],
                            ['fas fa-calendar-check', 'Open Date', $fd->opened_at?->format('d M Y')],
                            ['fas fa-calendar-day', 'Maturity Date', $fd->maturity_date?->format('d M Y')],
                            ['fas fa-user-shield', 'Created By', $fd->creator->name ?? 'System'],
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

                    @if ($fd->remarks)
                        <div class="mt-3 pt-3 border-top">
                            <div class="d-flex align-items-start gap-2">
                                <span class="text-muted mt-1"><i class="fas fa-comment fa-fw"></i></span>
                                <div>
                                    <div class="small text-muted">Remarks</div>
                                    <div class="fw-semibold">{{ $fd->remarks }}</div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>

</x-app-layout>
