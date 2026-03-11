<x-app-layout>

    {{-- Page Header --}}
    <div class="py-3 py-lg-4">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h4 class="page-title mb-0">
                    <i class="fas fa-money-bill-wave me-2 text-primary"></i>Currency Details
                </h4>
            </div>
            <div class="col-lg-6">
                <div class="d-none d-lg-block">
                    <ol class="breadcrumb m-0 float-end">
                        <li class="breadcrumb-item"><a href="{{ route('finetech.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('finetech.currencies.index') }}">Currencies</a></li>
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
                Viewing details of <strong>{{ $currency->name }}</strong>.
            </span>
            <div>
                <x-button text="Back" icon="back" variant="outline-secondary" href="{{ route('finetech.currencies.index') }}" />
                <x-button text="Edit Currency" icon="edit" variant="info" href="{{ route('finetech.currencies.edit', $currency) }}" />
            </div>
        </div>
    </div>

    <div class="row g-3">

        {{-- Left: Summary Card --}}
        <div class="col-md-4">
            <div class="card border-0 text-center">
                <div class="card-body py-4">
                    <div class="mb-3">
                        <span class="display-6 text-primary"><i class="fas fa-money-bill-wave"></i></span>
                    </div>
                    <h5 class="fw-bold mb-1">{{ $currency->name }}</h5>
                    <p class="text-muted small mb-2">{{ $currency->symbol }} &mdash; {{ $currency->code }}</p>
                    <div class="mb-2">
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3">{{ $currency->code }}</span>
                    </div>
                </div>
                <div class="card-footer bg-light border-0 py-3">
                    <div class="row text-center">
                        <div class="col-6 border-end">
                            <div class="small text-muted">Created</div>
                            <div class="fw-semibold small">{{ $currency->created_at->format('d M Y') }}</div>
                        </div>
                        <div class="col-6">
                            <div class="small text-muted">Updated</div>
                            <div class="fw-semibold small">{{ $currency->updated_at->diffForHumans() }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right: Details --}}
        <div class="col-md-8">

            {{-- Currency Information --}}
            <div class="card border-0 mb-3">
                <div class="card-header bg-primary bg-opacity-10 border-0 py-3">
                    <h6 class="mb-0 fw-semibold text-primary"><i class="fas fa-info-circle me-2"></i>Currency Information</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @foreach ([
                            ['fas fa-font', 'Currency Name', $currency->name],
                            ['fas fa-hashtag', 'Currency Code', $currency->code],
                            ['fas fa-dollar-sign', 'Symbol', $currency->symbol],
                            ['fas fa-exchange-alt', 'Exchange Rate', number_format($currency->exchange_rate, 6)],
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

        </div>
    </div>

</x-app-layout>