<x-app-layout>

    {{-- Page Header --}}
    <div class="py-3 py-lg-4">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h4 class="page-title mb-0">
                    <i class="fas fa-user me-2 text-primary"></i>User Profile
                </h4>
            </div>
            <div class="col-lg-6">
                <div class="d-none d-lg-block">
                    <ol class="breadcrumb m-0 float-end">
                        <li class="breadcrumb-item"><a href="{{ route('finetech.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('finetech.users.index') }}">Users</a></li>
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
                Viewing profile of <strong>{{ $user->name }}</strong>.
            </span>
            <div>
                <x-button text="Back" icon="back" variant="outline-secondary" href="{{ route('finetech.users.index') }}" />
                <x-button text="Edit User" icon="edit" variant="info" href="{{ route('finetech.users.edit', $user) }}" />
            </div>
        </div>
    </div>

    <div class="row g-3">

        {{-- Left: Profile Card --}}
        <div class="col-md-4">
            <div class="card border-0 text-center">
                <div class="card-body py-4">
                    <img src="{{ $user->profileImage() }}" alt="{{ $user->name }}"
                        class="rounded-circle img-thumbnail mb-3"
                        style="width:110px;height:110px;object-fit:cover;border-width:3px;">
                    <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
                    <p class="text-muted small mb-2">{{ $user->email }}</p>
                    <div class="mb-3">
                        @forelse ($user->getRoleNames() as $role)
                            <span class="badge bg-primary px-3 py-1">{{ ucfirst($role) }}</span>
                        @empty
                            <span class="badge bg-secondary px-3 py-1">No Role</span>
                        @endforelse
                    </div>
                    @if ($user->is_active)
                        <span class="badge bg-success-subtle text-success border border-success px-3 py-1">
                            <i class="fas fa-circle me-1" style="font-size:8px;vertical-align:middle;"></i>Active
                        </span>
                    @else
                        <span class="badge bg-danger-subtle text-danger border border-danger px-3 py-1">
                            <i class="fas fa-circle me-1" style="font-size:8px;vertical-align:middle;"></i>Inactive
                        </span>
                    @endif
                </div>
                <div class="card-footer bg-light border-0 py-3">
                    <div class="row text-center">
                        <div class="col-6 border-end">
                            <div class="small text-muted">Joined</div>
                            <div class="fw-semibold small">{{ $user->created_at->format('d M Y') }}</div>
                        </div>
                        <div class="col-6">
                            <div class="small text-muted">Updated</div>
                            <div class="fw-semibold small">{{ $user->updated_at->diffForHumans() }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right: Details --}}
        <div class="col-md-8">

            {{-- Account Information --}}
            <div class="card border-0 mb-3">
                <div class="card-header bg-primary bg-opacity-10 border-0 py-3">
                    <h6 class="mb-0 fw-semibold text-primary">
                        <i class="fas fa-envelope me-2"></i>Account Information
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <div class="d-flex align-items-start gap-2">
                                <span class="text-muted mt-1"><i class="fas fa-user fa-fw"></i></span>
                                <div>
                                    <div class="small text-muted">Full Name</div>
                                    <div class="fw-semibold">{{ $user->name ?: '—' }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex align-items-start gap-2">
                                <span class="text-muted mt-1"><i class="fas fa-envelope fa-fw"></i></span>
                                <div>
                                    <div class="small text-muted">Email Address</div>
                                    <div class="fw-semibold">{{ $user->email ?: '—' }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex align-items-start gap-2">
                                <span class="text-muted mt-1"><i class="fas fa-shield-alt fa-fw"></i></span>
                                <div>
                                    <div class="small text-muted">Email Verified</div>
                                    <div>
                                        @if ($user->email_verified_at)
                                            <span class="badge bg-success">
                                                <i class="fas fa-check me-1"></i>{{ $user->email_verified_at->format('d M Y') }}
                                            </span>
                                        @else
                                            <span class="badge bg-warning text-dark"><i class="fas fa-clock me-1"></i>Not Verified</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex align-items-start gap-2">
                                <span class="text-muted mt-1"><i class="fas fa-user-shield fa-fw"></i></span>
                                <div>
                                    <div class="small text-muted">Assigned Role</div>
                                    <div>
                                        @forelse ($user->getRoleNames() as $role)
                                            <span class="badge bg-primary">{{ ucfirst($role) }}</span>
                                        @empty
                                            <span class="text-muted">No role assigned</span>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Personal Details --}}
            <div class="card border-0 mb-3">
                <div class="card-header bg-success bg-opacity-10 border-0 py-3">
                    <h6 class="mb-0 fw-semibold text-success">
                        <i class="fas fa-id-card me-2"></i>Personal Details
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <div class="d-flex align-items-start gap-2">
                                <span class="text-muted mt-1"><i class="fas fa-fingerprint fa-fw"></i></span>
                                <div>
                                    <div class="small text-muted">Aadhar Number</div>
                                    <div class="fw-semibold">{{ $user->aadhar_number ?: '—' }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex align-items-start gap-2">
                                <span class="text-muted mt-1"><i class="fas fa-phone fa-fw"></i></span>
                                <div>
                                    <div class="small text-muted">Phone Number</div>
                                    <div class="fw-semibold">{{ $user->phone_number ?: '—' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Address --}}
            <div class="card border-0 mb-3">
                <div class="card-header bg-warning bg-opacity-10 border-0 py-3">
                    <h6 class="mb-0 fw-semibold text-warning">
                        <i class="fas fa-map-marker-alt me-2"></i>Address
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-sm-8">
                            <div class="d-flex align-items-start gap-2">
                                <span class="text-muted mt-1"><i class="fas fa-home fa-fw"></i></span>
                                <div>
                                    <div class="small text-muted">Street Address</div>
                                    <div class="fw-semibold">{{ $user->address ?: '—' }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="d-flex align-items-start gap-2">
                                <span class="text-muted mt-1"><i class="fas fa-city fa-fw"></i></span>
                                <div>
                                    <div class="small text-muted">City</div>
                                    <div class="fw-semibold">{{ $user->city ?: '—' }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="d-flex align-items-start gap-2">
                                <span class="text-muted mt-1"><i class="fas fa-map fa-fw"></i></span>
                                <div>
                                    <div class="small text-muted">State</div>
                                    <div class="fw-semibold">{{ $user->state ?: '—' }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="d-flex align-items-start gap-2">
                                <span class="text-muted mt-1"><i class="fas fa-mail-bulk fa-fw"></i></span>
                                <div>
                                    <div class="small text-muted">Postal Code</div>
                                    <div class="fw-semibold">{{ $user->postal_code ?: '—' }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="d-flex align-items-start gap-2">
                                <span class="text-muted mt-1"><i class="fas fa-globe fa-fw"></i></span>
                                <div>
                                    <div class="small text-muted">Country</div>
                                    <div class="fw-semibold">{{ $user->country ? ucfirst($user->country) : '—' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</x-app-layout>
