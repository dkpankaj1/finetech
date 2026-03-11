<x-app-layout>

    {{-- Page Header --}}
    <div class="py-3 py-lg-4">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h4 class="page-title mb-0">
                    <i class="fas fa-money-bill-wave me-2 text-primary"></i>Currency Masters
                </h4>
            </div>
            <div class="col-lg-6">
                <div class="d-none d-lg-block">
                    <ol class="breadcrumb m-0 float-end">
                        <li class="breadcrumb-item"><a href="{{ route('finetech.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Currencies</li>
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
                Total <strong>{{ $currencies->count() }}</strong> currency(ies) registered in the system.
            </span>
            <x-button icon="add" variant="primary" text="Add New Currency" href="{{ route('finetech.currencies.create') }}" />
        </div>
    </div>

    {{-- Table Card --}}
    <div class="card border-0">
        <div class="card-header bg-primary bg-opacity-10 border-0 py-3">
            <h6 class="mb-0 card-title">
                <i class="fas fa-list me-2"></i>Manage Currencies
            </h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">#</th>
                            <th>Name</th>
                            <th>Code</th>
                            <th>Symbol</th>
                            <th>Exchange Rate</th>
                            <th>Last Updated</th>
                            <th class="text-end pe-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($currencies as $key => $currency)
                            <tr>
                                <td class="ps-3 text-muted small">{{ ++$key }}</td>
                                <td>
                                    <div class="fw-semibold small">{{ $currency->name }}</div>
                                </td>
                                <td>
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle">
                                        {{ $currency->code }}
                                    </span>
                                </td>
                                <td>
                                    <span class="fw-semibold text-success">{{ $currency->symbol }}</span>
                                </td>
                                <td class="small">
                                    {{ number_format($currency->exchange_rate, 6) }}
                                </td>
                                <td class="small text-muted">{{ $currency->updated_at->diffForHumans() }}</td>
                                <td class="text-end pe-3">
                                    <div class="d-flex justify-content-end gap-1">
                                        <x-button size="sm" icon="show" variant="outline-primary"
                                            href="{{ route('finetech.currencies.show', $currency) }}" text="View" />
                                        <x-button size="sm" icon="edit" variant="outline-info" text="Edit"
                                            href="{{ route('finetech.currencies.edit', $currency) }}" />
                                        <button type="button" class="btn btn-sm btn-outline-danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#confirmDeleteModal"
                                            data-delete-url="{{ route('finetech.currencies.destroy', $currency) }}"
                                            data-item-name="{{ $currency->name }}">
                                            <i class="fas fa-trash me-1"></i>Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="fas fa-money-bill-wave fa-2x mb-2 d-block opacity-25"></i>
                                    No currencies found. <a href="{{ route('finetech.currencies.create') }}">Create one now</a>.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Confirm Delete Modal --}}
    <x-confirm-delete-model modal-id="confirmDeleteModal" title="Delete Currency"
        message="Are you sure you want to delete this currency? This action cannot be undone." />

</x-app-layout>
