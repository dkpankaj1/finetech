<x-app-layout>

    {{-- Page Header --}}
    <div class="py-3 py-lg-4">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h4 class="page-title mb-0">
                    <i class="fas fa-users me-2 text-primary"></i>Customers
                </h4>
            </div>
            <div class="col-lg-6">
                <div class="d-none d-lg-block">
                    <ol class="breadcrumb m-0 float-end">
                        <li class="breadcrumb-item"><a href="{{ route('finetech.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Customers</li>
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
                Total <strong>{{ $customers->count() }}</strong> customer(s) registered in the system.
            </span>
            <x-button icon="add" variant="primary" text="Add New Customer" href="{{ route('finetech.customers.create') }}" />
        </div>
    </div>

    {{-- Table Card --}}
    <div class="card border-0">
        <div class="card-header bg-primary bg-opacity-10 border-0 py-3">
            <h6 class="mb-0 card-title">
                <i class="fas fa-list me-2"></i>Manage Customers
            </h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">#</th>
                            <th>Customer</th>
                            <th>Customer No.</th>
                            <th>Contact</th>
                            <th>Branch</th>
                            <th>KYC</th>
                            <th>Status</th>
                            <th class="text-end pe-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($customers as $key => $customer)
                            <tr>
                                <td class="ps-3 text-muted small">{{ ++$key }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        @if ($customer->photo)
                                            <img src="{{ asset($customer->photo) }}" alt="" class="rounded-circle" width="32" height="32" style="object-fit:cover;">
                                        @else
                                            <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center" style="width:32px;height:32px;font-size:13px;">
                                                {{ strtoupper(substr($customer->first_name, 0, 1) . substr($customer->last_name, 0, 1)) }}
                                            </div>
                                        @endif
                                        <div>
                                            <div class="fw-semibold small">{{ $customer->first_name }} {{ $customer->last_name }}</div>
                                            <div class="text-muted" style="font-size:11px;">{{ $customer->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle">
                                        {{ $customer->customer_number }}
                                    </span>
                                </td>
                                <td class="small">
                                    <div><i class="fas fa-phone fa-fw text-muted me-1"></i>{{ $customer->phone }}</div>
                                </td>
                                <td class="small text-muted">
                                    {{ $customer->branch->name ?? '—' }}
                                </td>
                                <td>
                                    @switch($customer->kyc_status)
                                        @case('verified')
                                            <span class="badge bg-success-subtle text-success border border-success-subtle">Verified</span>
                                            @break
                                        @case('pending')
                                            <span class="badge bg-warning-subtle text-warning border border-warning-subtle">Pending</span>
                                            @break
                                        @case('rejected')
                                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle">Rejected</span>
                                            @break
                                        @case('expired')
                                            <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">Expired</span>
                                            @break
                                    @endswitch
                                </td>
                                <td>
                                    @switch($customer->status)
                                        @case('active')
                                            <span class="badge bg-success-subtle text-success border border-success-subtle">Active</span>
                                            @break
                                        @case('inactive')
                                            <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">Inactive</span>
                                            @break
                                        @case('suspended')
                                            <span class="badge bg-warning-subtle text-warning border border-warning-subtle">Suspended</span>
                                            @break
                                        @case('blacklisted')
                                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle">Blacklisted</span>
                                            @break
                                    @endswitch
                                </td>
                                <td class="text-end pe-3">
                                    <div class="d-flex justify-content-end gap-1">
                                        <x-button size="sm" icon="show" variant="outline-primary"
                                            href="{{ route('finetech.customers.show', $customer) }}" text="View" />
                                        <x-button size="sm" icon="edit" variant="outline-info" text="Edit"
                                            href="{{ route('finetech.customers.edit', $customer) }}" />
                                        <button type="button" class="btn btn-sm btn-outline-danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#confirmDeleteModal"
                                            data-delete-url="{{ route('finetech.customers.destroy', $customer) }}"
                                            data-item-name="{{ $customer->first_name }} {{ $customer->last_name }}">
                                            <i class="fas fa-trash me-1"></i>Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="fas fa-users fa-2x mb-2 d-block opacity-25"></i>
                                    No customers found. <a href="{{ route('finetech.customers.create') }}">Create one now</a>.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Confirm Delete Modal --}}
    <x-confirm-delete-model modal-id="confirmDeleteModal" title="Delete Customer"
        message="Are you sure you want to delete this customer? This action cannot be undone." />

</x-app-layout>
