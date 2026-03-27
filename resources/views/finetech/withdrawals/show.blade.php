<x-app-layout>

    {{-- Page Header --}}
    <div class="py-3 py-lg-4">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h4 class="page-title mb-0">
                    <i class="fas fa-receipt me-2 text-primary"></i>Withdrawal Details
                </h4>
            </div>
            <div class="col-lg-6">
                <div class="d-none d-lg-block">
                    <ol class="breadcrumb m-0 float-end">
                        <li class="breadcrumb-item"><a href="{{ route('finetech.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('finetech.withdrawals.index') }}">Withdrawals</a></li>
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
                Reference <strong>{{ $withdrawal->reference_no }}</strong>.
            </span>
            <div>
                <x-button text="Back" icon="back" variant="outline-secondary" href="{{ route('finetech.withdrawals.index') }}" />
                <x-button text="New Withdrawal" icon="add" variant="danger" href="{{ route('finetech.withdrawals.create') }}" />
            </div>
        </div>
    </div>

    <div class="row g-3">

        <div class="col-md-4">
            <div class="card border-0 text-center">
                <div class="card-body py-4">
                    <div class="mb-3">
                        <div class="rounded-circle bg-danger-subtle text-danger d-flex align-items-center justify-content-center mx-auto" style="width:80px;height:80px;font-size:28px;">
                            <i class="fas fa-arrow-up-right-dots"></i>
                        </div>
                    </div>
                    <h5 class="fw-bold mb-1">{{ $withdrawal->reference_no }}</h5>
                    <p class="text-muted small mb-1">{{ $withdrawal->account->account_number }}</p>
                    <p class="text-muted small mb-2">{{ $withdrawal->customer->first_name }} {{ $withdrawal->customer->last_name }}</p>

                    <div class="mt-3">
                        <div class="small text-muted">Withdrawal Amount</div>
                        <h4 class="fw-bold text-danger mb-0">
                            -{{ $withdrawal->currency->symbol }}{{ number_format($withdrawal->amount, 2) }}
                        </h4>
                    </div>
                </div>
                <div class="card-footer bg-light border-0 py-3">
                    <div class="small text-muted">Withdrawn At</div>
                    <div class="fw-semibold small">{{ $withdrawal->withdrawn_at->format('d M Y h:i A') }}</div>
                </div>
            </div>
        </div>

        <div class="col-md-8">

            <div class="card border-0 mb-3">
                <div class="card-header bg-danger bg-opacity-10 border-0 py-3">
                    <h6 class="mb-0 fw-semibold text-danger"><i class="fas fa-file-invoice me-2"></i>Transaction Info</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @foreach ([
                            ['fas fa-hashtag', 'Reference No', $withdrawal->reference_no],
                            ['fas fa-wallet', 'Account No', $withdrawal->account->account_number],
                            ['fas fa-user', 'Customer', $withdrawal->customer->first_name . ' ' . $withdrawal->customer->last_name],
                            ['fas fa-code-branch', 'Branch', $withdrawal->branch->name ?? '—'],
                            ['fas fa-coins', 'Currency', $withdrawal->currency->name . ' (' . $withdrawal->currency->code . ')'],
                            ['fas fa-money-bill-wave', 'Amount', '-' . $withdrawal->currency->symbol . number_format($withdrawal->amount, 2)],
                            ['fas fa-exchange-alt', 'Source', ucwords(str_replace('_', ' ', $withdrawal->source))],
                            ['fas fa-user-shield', 'Withdrawn By', $withdrawal->withdrawer->name ?? 'System'],
                            ['fas fa-calendar-check', 'Withdrawn At', $withdrawal->withdrawn_at->format('d M Y h:i A')],
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

                    @if ($withdrawal->remarks)
                        <div class="mt-3 pt-3 border-top">
                            <div class="d-flex align-items-start gap-2">
                                <span class="text-muted mt-1"><i class="fas fa-comment fa-fw"></i></span>
                                <div>
                                    <div class="small text-muted">Remarks</div>
                                    <div class="fw-semibold">{{ $withdrawal->remarks }}</div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

</x-app-layout>
