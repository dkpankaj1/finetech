<x-app-layout>

    {{-- Page Header --}}
    <div class="py-3 py-lg-4">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h4 class="page-title mb-0">
                    <i class="fas fa-plus-circle me-2 text-primary"></i>Create Currency
                </h4>
            </div>
            <div class="col-lg-6">
                <div class="d-none d-lg-block">
                    <ol class="breadcrumb m-0 float-end">
                        <li class="breadcrumb-item"><a href="{{ route('finetech.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('finetech.currencies.index') }}">Currencies</a></li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('finetech.currencies.store') }}" method="POST">
        @csrf

        {{-- Action Bar --}}
        <div class="card border-0 mb-3">
            <div class="card-body py-2 d-flex justify-content-between align-items-center">
                <span class="text-muted small">
                    <i class="fas fa-info-circle me-1"></i>Fill in all required fields to add a new currency.
                </span>
                <div>
                    <x-button text="Back" icon="back" variant="outline-secondary" href="{{ route('finetech.currencies.index') }}" />
                    <x-button text="Create Currency" icon="add" variant="primary" />
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
                            <x-input-field name="name" placeholder="e.g. US Dollar" class="border-start-0 ps-0" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <x-input-label name="code" text="Currency Code" />
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-hashtag text-muted"></i></span>
                            <x-input-field name="code" placeholder="e.g. USD" class="border-start-0 ps-0" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <x-input-label name="symbol" text="Symbol" />
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-dollar-sign text-muted"></i></span>
                            <x-input-field name="symbol" placeholder="e.g. $" class="border-start-0 ps-0" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <x-input-label name="exchange_rate" text="Exchange Rate" />
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-exchange-alt text-muted"></i></span>
                            <x-input-field name="exchange_rate" type="number" placeholder="e.g. 1.000000" class="border-start-0 ps-0" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Bottom Action Bar --}}
        <div class="card border-0 mb-4">
            <div class="card-body py-2 d-flex justify-content-end">
                <x-button text="Cancel" icon="cancel" variant="outline-secondary" href="{{ route('finetech.currencies.index') }}" />
                <x-button text="Create Currency" icon="add" variant="primary" />
            </div>
        </div>

    </form>

</x-app-layout>