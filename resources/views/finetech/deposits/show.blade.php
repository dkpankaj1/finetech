<x-app-layout>

    {{-- Page Header --}}
    <div class="py-3 py-lg-4">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h4 class="page-title mb-0">
                    <i class="fas fa-receipt me-2 text-primary"></i>Deposit Details
                </h4>
            </div>
            <div class="col-lg-6">
                <div class="d-none d-lg-block">
                    <ol class="breadcrumb m-0 float-end">
                        <li class="breadcrumb-item"><a href="{{ route('finetech.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('finetech.deposits.index') }}">Deposits</a></li>
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
                Reference <strong>{{ $deposit->reference_no }}</strong>.
            </span>
            <div>
                <x-button text="Back" icon="back" variant="outline-secondary" href="{{ route('finetech.deposits.index') }}" />
                <x-button text="New Deposit" icon="add" variant="primary" href="{{ route('finetech.deposits.create') }}" />
            </div>
        </div>
    </div>

    <div class="row g-3">

        <div class="col-md-4">
            <div class="card border-0 text-center">
                <div class="card-body py-4">
                    <div class="mb-3">
                        <div class="rounded-circle bg-success-subtle text-success d-flex align-items-center justify-content-center mx-auto" style="width:80px;height:80px;font-size:28px;">
                            <i class="fas fa-wallet"></i>
                        </div>
                    </div>
                    <h5 class="fw-bold mb-1">{{ $deposit->reference_no }}</h5>
                    <p class="text-muted small mb-1">{{ $deposit->account->account_number }}</p>
                    <p class="text-muted small mb-2">{{ $deposit->customer->first_name }} {{ $deposit->customer->last_name }}</p>

                    <div class="mt-3">
                        <div class="small text-muted">Deposit Amount</div>
                        <h4 class="fw-bold text-success mb-0">
                            {{ $deposit->currency->symbol }}{{ number_format($deposit->amount, 2) }}
                        </h4>
                    </div>
                </div>
                <div class="card-footer bg-light border-0 py-3">
                    <div class="small text-muted">Deposited At</div>
                    <div class="fw-semibold small">{{ $deposit->deposited_at->format('d M Y h:i A') }}</div>
                </div>
            </div>
        </div>

        <div class="col-md-8">

            <div class="card border-0 mb-3">
                <div class="card-header bg-primary bg-opacity-10 border-0 py-3">
                    <h6 class="mb-0 fw-semibold text-primary"><i class="fas fa-file-invoice me-2"></i>Transaction Info</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @foreach ([
                            ['fas fa-hashtag', 'Reference No', $deposit->reference_no],
                            ['fas fa-wallet', 'Account No', $deposit->account->account_number],
                            ['fas fa-user', 'Customer', $deposit->customer->first_name . ' ' . $deposit->customer->last_name],
                            ['fas fa-code-branch', 'Branch', $deposit->branch->name ?? '—'],
                            ['fas fa-coins', 'Currency', $deposit->currency->name . ' (' . $deposit->currency->code . ')'],
                            ['fas fa-money-bill-wave', 'Amount', $deposit->currency->symbol . number_format($deposit->amount, 2)],
                            ['fas fa-exchange-alt', 'Source', ucwords(str_replace('_', ' ', $deposit->source))],
                            ['fas fa-user-shield', 'Deposited By', $deposit->depositor->name ?? 'System'],
                            ['fas fa-calendar-check', 'Deposited At', $deposit->deposited_at->format('d M Y h:i A')],
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

                    @if ($deposit->remarks)
                        <div class="mt-3 pt-3 border-top">
                            <div class="d-flex align-items-start gap-2">
                                <span class="text-muted mt-1"><i class="fas fa-comment fa-fw"></i></span>
                                <div>
                                    <div class="small text-muted">Remarks</div>
                                    <div class="fw-semibold">{{ $deposit->remarks }}</div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

</x-app-layout>
