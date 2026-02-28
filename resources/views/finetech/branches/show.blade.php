<x-app-layout>

    {{-- Page Header --}}
    <div class="py-3 py-lg-4">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h4 class="page-title mb-0">
                    <i class="fas fa-code-branch me-2 text-primary"></i>Branch Details
                </h4>
            </div>
            <div class="col-lg-6">
                <div class="d-none d-lg-block">
                    <ol class="breadcrumb m-0 float-end">
                        <li class="breadcrumb-item"><a href="{{ route('finetech.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('finetech.branches.index') }}">Branches</a></li>
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
                Viewing details of <strong>{{ $branch->name }}</strong>.
            </span>
            <div>
                <x-button text="Back" icon="back" variant="outline-secondary" href="{{ route('finetech.branches.index') }}" />
                <x-button text="Edit Branch" icon="edit" variant="info" href="{{ route('finetech.branches.edit', $branch) }}" />
            </div>
        </div>
    </div>

    <div class="row g-3">

        {{-- Left: Summary Card --}}
        <div class="col-md-4">
            <div class="card border-0 text-center">
                <div class="card-body py-4">
                    <div class="mb-3">
                        <span class="display-6 text-primary"><i class="fas fa-university"></i></span>
                    </div>
                    <h5 class="fw-bold mb-1">{{ $branch->name }}</h5>
                    <p class="text-muted small mb-2">{{ $branch->city }}, {{ $branch->state }}</p>
                    <div class="mb-2">
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3">{{ $branch->code }}</span>
                    </div>
                    @if ($branch->is_main_branch)
                        <span class="badge bg-warning-subtle text-warning border border-warning px-3 py-1">
                            <i class="fas fa-star me-1"></i>Main Branch
                        </span>
                    @endif
                    <div class="mt-2">
                        @if ($branch->is_active)
                            <span class="badge bg-success-subtle text-success border border-success px-3 py-1">
                                <i class="fas fa-circle me-1" style="font-size:8px;vertical-align:middle;"></i>Active
                            </span>
                        @else
                            <span class="badge bg-danger-subtle text-danger border border-danger px-3 py-1">
                                <i class="fas fa-circle me-1" style="font-size:8px;vertical-align:middle;"></i>Inactive
                            </span>
                        @endif
                    </div>
                </div>
                <div class="card-footer bg-light border-0 py-3">
                    <div class="row text-center">
                        <div class="col-6 border-end">
                            <div class="small text-muted">Created</div>
                            <div class="fw-semibold small">{{ $branch->created_at->format('d M Y') }}</div>
                        </div>
                        <div class="col-6">
                            <div class="small text-muted">Updated</div>
                            <div class="fw-semibold small">{{ $branch->updated_at->diffForHumans() }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right: Details --}}
        <div class="col-md-8">

            {{-- Branch Identity --}}
            <div class="card border-0 mb-3">
                <div class="card-header bg-primary bg-opacity-10 border-0 py-3">
                    <h6 class="mb-0 fw-semibold text-primary"><i class="fas fa-id-badge me-2"></i>Branch Identity</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @foreach ([
                            ['fas fa-hashtag', 'IFSC Code', $branch->ifsc_code],
                            ['fas fa-barcode', 'MICR Code', $branch->micr_code],
                            ['fas fa-globe', 'SWIFT / BIC', $branch->swift_code],
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

            {{-- Contact --}}
            <div class="card border-0 mb-3">
                <div class="card-header bg-success bg-opacity-10 border-0 py-3">
                    <h6 class="mb-0 fw-semibold text-success"><i class="fas fa-phone-alt me-2"></i>Contact Information</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @foreach ([
                            ['fas fa-phone', 'Phone', $branch->phone_number],
                            ['fas fa-phone-square', 'Alternate Phone', $branch->alternate_phone],
                            ['fas fa-envelope', 'Email', $branch->email],
                            ['fas fa-fax', 'Fax', $branch->fax],
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
                                    <div class="fw-semibold">{{ $branch->address ?: '—' }}</div>
                                </div>
                            </div>
                        </div>
                        @foreach ([
                            ['fas fa-city', 'City', $branch->city],
                            ['fas fa-map', 'State', $branch->state],
                            ['fas fa-mail-bulk', 'Postal Code', $branch->postal_code],
                            ['fas fa-globe', 'Country', $branch->country ? ucfirst($branch->country) : null],
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
                        @if ($branch->latitude && $branch->longitude)
                            <div class="col-sm-6">
                                <div class="d-flex align-items-start gap-2">
                                    <span class="text-muted mt-1"><i class="fas fa-crosshairs fa-fw"></i></span>
                                    <div>
                                        <div class="small text-muted">Coordinates</div>
                                        <div class="fw-semibold">{{ $branch->latitude }}, {{ $branch->longitude }}</div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Manager --}}
            <div class="card border-0 mb-3">
                <div class="card-header bg-info bg-opacity-10 border-0 py-3">
                    <h6 class="mb-0 fw-semibold text-info"><i class="fas fa-user-tie me-2"></i>Branch Manager</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @foreach ([
                            ['fas fa-user', 'Manager Name', $branch->manager_name],
                            ['fas fa-envelope', 'Manager Email', $branch->manager_email],
                            ['fas fa-phone', 'Manager Phone', $branch->manager_phone],
                            ['fas fa-clock', 'Opening Time', $branch->getRawOriginal('opening_time')],
                            ['fas fa-clock', 'Closing Time', $branch->getRawOriginal('closing_time')],
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

            @if ($branch->remarks)
                <div class="card border-0 mb-3">
                    <div class="card-header bg-secondary bg-opacity-10 border-0 py-3">
                        <h6 class="mb-0 fw-semibold text-secondary"><i class="fas fa-sticky-note me-2"></i>Remarks</h6>
                    </div>
                    <div class="card-body">
                        <p class="mb-0 text-muted">{{ $branch->remarks }}</p>
                    </div>
                </div>
            @endif

        </div>
    </div>

</x-app-layout>
