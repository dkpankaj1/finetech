<x-app-layout>

    {{-- Page Header --}}
    <div class="py-3 py-lg-4">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h4 class="page-title mb-0">
                    <i class="fas fa-layer-group me-2 text-primary"></i>Account Type Details
                </h4>
            </div>
            <div class="col-lg-6">
                <div class="d-none d-lg-block">
                    <ol class="breadcrumb m-0 float-end">
                        <li class="breadcrumb-item"><a href="{{ route('finetech.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('finetech.account-types.index') }}">Account Types</a></li>
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
                Viewing details of <strong>{{ $accountType->name }}</strong>.
            </span>
            <div>
                <x-button text="Back" icon="back" variant="outline-secondary" href="{{ route('finetech.account-types.index') }}" />
                <x-button text="Edit Account Type" icon="edit" variant="info" href="{{ route('finetech.account-types.edit', $accountType) }}" />
            </div>
        </div>
    </div>

    <div class="row g-3">

        {{-- Left: Summary Card --}}
        <div class="col-md-4">
            <div class="card border-0 text-center">
                <div class="card-body py-4">
                    <div class="mb-3">
                        <span class="display-6 text-primary"><i class="fas fa-layer-group"></i></span>
                    </div>
                    <h5 class="fw-bold mb-1">{{ $accountType->name }}</h5>
                    <p class="text-muted small mb-2">{{ $accountType->code }}</p>
                    <div class="mb-2">
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3">{{ $accountType->code }}</span>
                        @if ($accountType->is_active)
                            <span class="badge bg-success-subtle text-success border border-success-subtle px-3">Active</span>
                        @else
                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3">Inactive</span>
                        @endif
                    </div>
                </div>
                <div class="card-footer bg-light border-0 py-3">
                    <div class="row text-center">
                        <div class="col-6 border-end">
                            <div class="small text-muted">Created</div>
                            <div class="fw-semibold small">{{ $accountType->created_at->format('d M Y') }}</div>
                        </div>
                        <div class="col-6">
                            <div class="small text-muted">Updated</div>
                            <div class="fw-semibold small">{{ $accountType->updated_at->diffForHumans() }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right: Details --}}
        <div class="col-md-8">

            {{-- Basic Information --}}
            <div class="card border-0 mb-3">
                <div class="card-header bg-primary bg-opacity-10 border-0 py-3">
                    <h6 class="mb-0 fw-semibold text-primary"><i class="fas fa-info-circle me-2"></i>Basic Information</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @foreach ([
                            ['fas fa-font', 'Account Type Name', $accountType->name],
                            ['fas fa-hashtag', 'Account Code', $accountType->code],
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

            {{-- Rates & Limits --}}
            <div class="card border-0 mb-3">
                <div class="card-header bg-success bg-opacity-10 border-0 py-3">
                    <h6 class="mb-0 fw-semibold text-success"><i class="fas fa-percentage me-2"></i>Rates & Limits</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @foreach ([
                            ['fas fa-percentage', 'Interest Rate', number_format($accountType->interest_rate, 2) . '%'],
                            ['fas fa-coins', 'Minimum Balance', number_format($accountType->minimum_balance, 2)],
                            ['fas fa-coins', 'Maximum Balance', $accountType->maximum_balance ? number_format($accountType->maximum_balance, 2) : null],
                            ['fas fa-arrow-circle-down', 'Daily Deposit Limit', $accountType->daily_deposit_limit ? number_format($accountType->daily_deposit_limit, 2) : null],
                            ['fas fa-arrow-circle-up', 'Daily Withdrawal Limit', $accountType->daily_withdrawal_limit ? number_format($accountType->daily_withdrawal_limit, 2) : null],
                            ['fas fa-exchange-alt', 'Monthly Free Transactions', $accountType->monthly_free_transactions],
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

            {{-- Flags & Status --}}
            <div class="card border-0 mb-3">
                <div class="card-header bg-warning bg-opacity-10 border-0 py-3">
                    <h6 class="mb-0 fw-semibold text-warning"><i class="fas fa-toggle-on me-2"></i>Flags & Status</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <div class="d-flex align-items-start gap-2">
                                <span class="text-muted mt-1"><i class="fas fa-id-card fa-fw"></i></span>
                                <div>
                                    <div class="small text-muted">Requires KYC</div>
                                    <div class="fw-semibold">
                                        @if ($accountType->requires_kyc)
                                            <span class="badge bg-warning-subtle text-warning border border-warning-subtle">Yes</span>
                                        @else
                                            <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">No</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex align-items-start gap-2">
                                <span class="text-muted mt-1"><i class="fas fa-toggle-on fa-fw"></i></span>
                                <div>
                                    <div class="small text-muted">Status</div>
                                    <div class="fw-semibold">
                                        @if ($accountType->is_active)
                                            <span class="badge bg-success-subtle text-success border border-success-subtle">Active</span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle">Inactive</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</x-app-layout>
