<x-app-layout>

    {{-- Page Header --}}
    <div class="py-3 py-lg-4">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h4 class="page-title mb-0">
                    <i class="fas fa-user me-2 text-primary"></i>Customer Details
                </h4>
            </div>
            <div class="col-lg-6">
                <div class="d-none d-lg-block">
                    <ol class="breadcrumb m-0 float-end">
                        <li class="breadcrumb-item"><a href="{{ route('finetech.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('finetech.customers.index') }}">Customers</a></li>
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
                Viewing details of <strong>{{ $customer->first_name }} {{ $customer->last_name }}</strong>.
            </span>
            <div>
                <x-button text="Back" icon="back" variant="outline-secondary" href="{{ route('finetech.customers.index') }}" />
                <x-button text="Edit Customer" icon="edit" variant="info" href="{{ route('finetech.customers.edit', $customer) }}" />
            </div>
        </div>
    </div>

    <div class="row g-3">

        {{-- Left: Summary Card --}}
        <div class="col-md-4">
            <div class="card border-0 text-center">
                <div class="card-body py-4">
                    <div class="mb-3">
                        @if ($customer->photo)
                            <img src="{{ asset($customer->photo) }}" alt="" class="rounded-circle" width="80" height="80" style="object-fit:cover;">
                        @else
                            <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center mx-auto" style="width:80px;height:80px;font-size:28px;">
                                {{ strtoupper(substr($customer->first_name, 0, 1) . substr($customer->last_name, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                    <h5 class="fw-bold mb-1">{{ $customer->first_name }} {{ $customer->last_name }}</h5>
                    <p class="text-muted small mb-2">{{ $customer->customer_number }}</p>
                    <div class="mb-2">
                        @switch($customer->status)
                            @case('active')
                                <span class="badge bg-success-subtle text-success border border-success-subtle px-3">Active</span>
                                @break
                            @case('inactive')
                                <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-3">Inactive</span>
                                @break
                            @case('suspended')
                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-3">Suspended</span>
                                @break
                            @case('blacklisted')
                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3">Blacklisted</span>
                                @break
                        @endswitch
                        @switch($customer->kyc_status)
                            @case('verified')
                                <span class="badge bg-success-subtle text-success border border-success-subtle px-3">KYC Verified</span>
                                @break
                            @case('pending')
                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-3">KYC Pending</span>
                                @break
                            @case('rejected')
                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3">KYC Rejected</span>
                                @break
                            @case('expired')
                                <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-3">KYC Expired</span>
                                @break
                        @endswitch
                    </div>
                </div>
                <div class="card-footer bg-light border-0 py-3">
                    <div class="row text-center">
                        <div class="col-6 border-end">
                            <div class="small text-muted">Created</div>
                            <div class="fw-semibold small">{{ $customer->created_at->format('d M Y') }}</div>
                        </div>
                        <div class="col-6">
                            <div class="small text-muted">Updated</div>
                            <div class="fw-semibold small">{{ $customer->updated_at->diffForHumans() }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right: Details --}}
        <div class="col-md-8">

            {{-- Personal Information --}}
            <div class="card border-0 mb-3">
                <div class="card-header bg-primary bg-opacity-10 border-0 py-3">
                    <h6 class="mb-0 fw-semibold text-primary"><i class="fas fa-user me-2"></i>Personal Information</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @foreach ([
                            ['fas fa-user', 'First Name', $customer->first_name],
                            ['fas fa-user', 'Last Name', $customer->last_name],
                            ['fas fa-calendar', 'Date of Birth', $customer->date_of_birth ? \Carbon\Carbon::parse($customer->date_of_birth)->format('d M Y') : null],
                            ['fas fa-venus-mars', 'Gender', $customer->gender ? ucfirst($customer->gender) : null],
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

            {{-- Contact Information --}}
            <div class="card border-0 mb-3">
                <div class="card-header bg-success bg-opacity-10 border-0 py-3">
                    <h6 class="mb-0 fw-semibold text-success"><i class="fas fa-phone-alt me-2"></i>Contact Information</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @foreach ([
                            ['fas fa-envelope', 'Email', $customer->email],
                            ['fas fa-phone', 'Phone', $customer->phone],
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

            {{-- Address --}}
            <div class="card border-0 mb-3">
                <div class="card-header bg-warning bg-opacity-10 border-0 py-3">
                    <h6 class="mb-0 fw-semibold text-warning"><i class="fas fa-map-marker-alt me-2"></i>Address</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-sm-8">
                            <div class="d-flex align-items-start gap-2">
                                <span class="text-muted mt-1"><i class="fas fa-home fa-fw"></i></span>
                                <div>
                                    <div class="small text-muted">Street Address</div>
                                    <div class="fw-semibold">{{ $customer->address ?: '—' }}</div>
                                </div>
                            </div>
                        </div>
                        @foreach ([
                            ['fas fa-city', 'City', $customer->city],
                            ['fas fa-map', 'State', $customer->state],
                            ['fas fa-mail-bulk', 'Postal Code', $customer->postal_code],
                            ['fas fa-globe', 'Country', $customer->country ? ucfirst($customer->country) : null],
                        ] as [$icon, $label, $value])
                            <div class="col-sm-4">
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

            {{-- Branch & Status --}}
            <div class="card border-0 mb-3">
                <div class="card-header bg-info bg-opacity-10 border-0 py-3">
                    <h6 class="mb-0 fw-semibold text-info"><i class="fas fa-cog me-2"></i>Branch & Status</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <div class="d-flex align-items-start gap-2">
                                <span class="text-muted mt-1"><i class="fas fa-code-branch fa-fw"></i></span>
                                <div>
                                    <div class="small text-muted">Branch</div>
                                    <div class="fw-semibold">{{ $customer->branch->name ?? '—' }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex align-items-start gap-2">
                                <span class="text-muted mt-1"><i class="fas fa-user-shield fa-fw"></i></span>
                                <div>
                                    <div class="small text-muted">Created By</div>
                                    <div class="fw-semibold">{{ $customer->creator->name ?? '—' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if ($customer->status_reason)
                        <div class="mt-3 pt-3 border-top">
                            <div class="d-flex align-items-start gap-2">
                                <span class="text-muted mt-1"><i class="fas fa-comment fa-fw"></i></span>
                                <div>
                                    <div class="small text-muted">Status Reason</div>
                                    <div class="fw-semibold">{{ $customer->status_reason }}</div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

</x-app-layout>
