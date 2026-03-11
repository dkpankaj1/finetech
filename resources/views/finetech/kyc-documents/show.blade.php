<x-app-layout>

    {{-- Page Header --}}
    <div class="py-3 py-lg-4">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h4 class="page-title mb-0">
                    <i class="fas fa-eye me-2 text-info"></i>KYC Document Details
                </h4>
            </div>
            <div class="col-lg-6">
                <div class="d-none d-lg-block">
                    <ol class="breadcrumb m-0 float-end">
                        <li class="breadcrumb-item"><a href="{{ route('finetech.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('finetech.kyc-documents.index') }}">KYC Documents</a></li>
                        <li class="breadcrumb-item active">Details</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">

        {{-- Left Column: Summary Card --}}
        <div class="col-lg-4 mb-3">
            <div class="card border-0 h-100">
                <div class="card-body text-center py-4">
                    <div class="d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 rounded-circle mb-3"
                        style="width: 80px; height: 80px;">
                        @php
                            $docIcons = [
                                'national_id' => 'fa-id-card',
                                'passport' => 'fa-passport',
                                'driving_license' => 'fa-car',
                                'voter_id' => 'fa-person-booth',
                                'aadhaar' => 'fa-fingerprint',
                                'pan_card' => 'fa-credit-card',
                            ];
                        @endphp
                        <i class="fas {{ $docIcons[$kycDocument->document_type] ?? 'fa-file-alt' }} fa-2x text-primary"></i>
                    </div>
                    <h5 class="fw-bold mb-1">{{ str_replace('_', ' ', ucfirst($kycDocument->document_type)) }}</h5>
                    <p class="text-muted mb-3">{{ $kycDocument->document_number }}</p>

                    {{-- Status Badge --}}
                    @php
                        $statusColors = ['verified' => 'success', 'pending' => 'warning', 'rejected' => 'danger'];
                    @endphp
                    <span class="badge bg-{{ $statusColors[$kycDocument->status] ?? 'secondary' }} px-3 py-2 fs-6 mb-3">
                        <i class="fas {{ $kycDocument->status === 'verified' ? 'fa-check-circle' : ($kycDocument->status === 'rejected' ? 'fa-times-circle' : 'fa-clock') }} me-1"></i>
                        {{ ucfirst($kycDocument->status) }}
                    </span>

                    {{-- Customer Badge --}}
                    <div class="mb-3">
                        <span class="badge bg-info bg-opacity-10 text-info px-3 py-2">
                            <i class="fas fa-user me-1"></i>
                            {{ $kycDocument->customer->first_name }} {{ $kycDocument->customer->last_name }}
                            ({{ $kycDocument->customer->customer_number }})
                        </span>
                    </div>

                    <hr>
                    <div class="text-start small text-muted">
                        <p class="mb-1"><i class="fas fa-calendar-plus me-2"></i><strong>Created:</strong> {{ $kycDocument->created_at->format('d M Y, h:i A') }}</p>
                        <p class="mb-0"><i class="fas fa-calendar-check me-2"></i><strong>Updated:</strong> {{ $kycDocument->updated_at->format('d M Y, h:i A') }}</p>
                    </div>

                    <hr>
                    <div class="d-flex gap-2 justify-content-center">
                        <x-button text="Edit" icon="edit" variant="info" size="sm" href="{{ route('finetech.kyc-documents.edit', $kycDocument) }}" />
                        <x-button text="Back" icon="back" variant="outline-secondary" size="sm" href="{{ route('finetech.kyc-documents.index') }}" />
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Column: Detail Cards --}}
        <div class="col-lg-8">

            {{-- Document Information --}}
            <div class="card border-0 mb-3">
                <div class="card-header bg-primary bg-opacity-10 border-0 py-3">
                    <h6 class="mb-0 fw-semibold text-primary">
                        <i class="fas fa-id-card me-2"></i>Document Information
                    </h6>
                </div>
                <div class="card-body pb-1">
                    <table class="table table-borderless table-sm mb-0">
                        <tbody>
                            <tr>
                                <td class="text-muted fw-medium" width="35%">Customer</td>
                                <td>{{ $kycDocument->customer->first_name }} {{ $kycDocument->customer->last_name }} ({{ $kycDocument->customer->customer_number }})</td>
                            </tr>
                            <tr>
                                <td class="text-muted fw-medium">Document Type</td>
                                <td>
                                    <span class="badge bg-primary bg-opacity-10 text-primary">
                                        {{ str_replace('_', ' ', ucfirst($kycDocument->document_type)) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted fw-medium">Document Number</td>
                                <td class="fw-semibold">{{ $kycDocument->document_number }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted fw-medium">Expiry Date</td>
                                <td>
                                    @if ($kycDocument->expiry_date)
                                        {{ \Carbon\Carbon::parse($kycDocument->expiry_date)->format('d M Y') }}
                                        @if (\Carbon\Carbon::parse($kycDocument->expiry_date)->isPast())
                                            <span class="badge bg-danger ms-1">Expired</span>
                                        @endif
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Document Images --}}
            <div class="card border-0 mb-3">
                <div class="card-header bg-success bg-opacity-10 border-0 py-3">
                    <h6 class="mb-0 fw-semibold text-success">
                        <i class="fas fa-image me-2"></i>Document Images
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <p class="fw-medium text-muted mb-2">Front Image</p>
                            @if ($kycDocument->front_image)
                                <a href="{{ asset($kycDocument->front_image) }}" target="_blank">
                                    <img src="{{ asset($kycDocument->front_image) }}" alt="Front Image"
                                        class="img-fluid rounded border shadow-sm" style="max-height: 250px; object-fit: cover;">
                                </a>
                            @else
                                <div class="text-center text-muted border rounded py-5">
                                    <i class="fas fa-image fa-2x mb-2 d-block"></i>No front image
                                </div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <p class="fw-medium text-muted mb-2">Back Image</p>
                            @if ($kycDocument->back_image)
                                <a href="{{ asset($kycDocument->back_image) }}" target="_blank">
                                    <img src="{{ asset($kycDocument->back_image) }}" alt="Back Image"
                                        class="img-fluid rounded border shadow-sm" style="max-height: 250px; object-fit: cover;">
                                </a>
                            @else
                                <div class="text-center text-muted border rounded py-5">
                                    <i class="fas fa-image fa-2x mb-2 d-block"></i>No back image
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Review Status --}}
            <div class="card border-0 mb-3">
                <div class="card-header bg-warning bg-opacity-10 border-0 py-3">
                    <h6 class="mb-0 fw-semibold text-warning">
                        <i class="fas fa-clipboard-check me-2"></i>Review Status
                    </h6>
                </div>
                <div class="card-body pb-1">
                    <table class="table table-borderless table-sm mb-0">
                        <tbody>
                            <tr>
                                <td class="text-muted fw-medium" width="35%">Verification Status</td>
                                <td>
                                    <span class="badge bg-{{ $statusColors[$kycDocument->status] ?? 'secondary' }}">
                                        {{ ucfirst($kycDocument->status) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted fw-medium">Reviewed By</td>
                                <td>
                                    @if ($kycDocument->reviewer)
                                        <i class="fas fa-user-check me-1 text-success"></i>{{ $kycDocument->reviewer->name }}
                                    @else
                                        <span class="text-muted">Not yet reviewed</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted fw-medium">Reviewed At</td>
                                <td>
                                    @if ($kycDocument->reviewed_at)
                                        {{ \Carbon\Carbon::parse($kycDocument->reviewed_at)->format('d M Y, h:i A') }}
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted fw-medium">Remark</td>
                                <td>{{ $kycDocument->remark ?? 'No remark' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

</x-app-layout>
