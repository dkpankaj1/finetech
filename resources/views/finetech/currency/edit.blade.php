<x-app-layout>

    {{-- Page Header --}}
    <div class="py-3 py-lg-4">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h4 class="page-title mb-0">
                    <i class="fas fa-edit me-2 text-info"></i>Edit Currency
                </h4>
            </div>
            <div class="col-lg-6">
                <div class="d-none d-lg-block">
                    <ol class="breadcrumb m-0 float-end">
                        <li class="breadcrumb-item"><a href="{{ route('finetech.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('finetech.currencies.index') }}">Currencies</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('finetech.currencies.update', $currency) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Action Bar --}}
        <div class="card border-0 mb-3">
            <div class="card-body py-2 d-flex justify-content-between align-items-center">
                <span class="text-muted small">
                    <i class="fas fa-info-circle me-1"></i>
                    Editing <strong>{{ $currency->name }}</strong> &mdash; Last updated {{ $currency->updated_at->diffForHumans() }}.
                </span>
                <div>
                    <x-button text="Back" icon="back" variant="outline-secondary" href="{{ route('finetech.currencies.index') }}" />
                    <x-button text="Save Changes" icon="save" variant="info" />
                </div>
            </div>
        </div>

        {{-- Section: Currency Details --}}
        <div class="card border-0 mb-3">
            <div class="card-header bg-primary bg-opacity-10 border-0 py-3">
                <h6 class="mb-0 fw-semibold text-primary">
                    <i class="fas fa-money-bill-wave me-2"></i>Currency Details
                </h6>
            </div>
            <div class="card-body pt-4 pb-2">
                <div class="row g-3">
                    <div class="col-md-6">
                        <x-input-label name="name" text="Currency Name" />
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-font text-muted"></i></span>
                            <x-input-field name="name" placeholder="e.g. US Dollar" value="{{ old('name', $currency->name) }}" class="border-start-0 ps-0" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <x-input-label name="code" text="Currency Code" />
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-hashtag text-muted"></i></span>
                            <x-input-field name="code" placeholder="e.g. USD" value="{{ old('code', $currency->code) }}" class="border-start-0 ps-0" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <x-input-label name="symbol" text="Symbol" />
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-dollar-sign text-muted"></i></span>
                            <x-input-field name="symbol" placeholder="e.g. $" value="{{ old('symbol', $currency->symbol) }}" class="border-start-0 ps-0" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <x-input-label name="exchange_rate" text="Exchange Rate" />
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-exchange-alt text-muted"></i></span>
                            <x-input-field name="exchange_rate" type="number" placeholder="e.g. 1.000000" value="{{ old('exchange_rate', $currency->exchange_rate) }}" class="border-start-0 ps-0" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Bottom Action Bar --}}
        <div class="card border-0 mb-4">
            <div class="card-body py-2 d-flex justify-content-end">
                <x-button text="Cancel" icon="cancel" variant="outline-secondary" href="{{ route('finetech.currencies.index') }}" />
                <x-button text="Save Changes" icon="save" variant="info" />
            </div>
        </div>

    </form>

</x-app-layout>