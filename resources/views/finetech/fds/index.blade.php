<x-app-layout>

    {{-- Page Header --}}
    <div class="py-3 py-lg-4">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h4 class="page-title mb-0">
                    <i class="fas fa-box me-2 text-primary"></i>FDS
                </h4>
            </div>
            <div class="col-lg-6">
                <div class="d-none d-lg-block">
                    <ol class="breadcrumb m-0 float-end">
                        <li class="breadcrumb-item"><a href="{{ route('finetech.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">FDS</li>
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
                Total <strong>{{ $fds->count() }}</strong> FDS record(s).
            </span>
            <x-button icon="add" variant="primary" text="Create FDS" href="{{ route('finetech.fds.create') }}" />
        </div>
    </div>

    {{-- Table Card --}}
    <div class="card border-0">
        <div class="card-header bg-primary bg-opacity-10 border-0 py-3">
            <h6 class="mb-0 card-title">
                <i class="fas fa-list me-2"></i>FDS List
            </h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">#</th>
                            <th>FD Number</th>
                            <th>Account</th>
                            <th>Customer</th>
                            <th class="text-end">Principal</th>
                            <th>Rate</th>
                            <th>Tenure</th>
                            <th class="text-end">Maturity</th>
                            <th>Status</th>
                            <th class="text-end pe-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($fds as $key => $fd)
                            <tr>
                                <td class="ps-3 text-muted small">{{ ++$key }}</td>
                                <td>
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle">{{ $fd->fd_number }}</span>
                                </td>
                                <td class="small fw-semibold">{{ $fd->account->account_number }}</td>
                                <td class="small">{{ $fd->customer->first_name }} {{ $fd->customer->last_name }}</td>
                                <td class="text-end small">{{ $fd->currency->symbol }}{{ number_format($fd->principal_amount, 2) }}</td>
                                <td class="small">{{ number_format($fd->interest_rate, 2) }}%</td>
                                <td class="small">{{ $fd->tenure_months }} months</td>
                                <td class="text-end fw-semibold small">{{ $fd->currency->symbol }}{{ number_format($fd->maturity_amount, 2) }}</td>
                                <td>
                                    @if ($fd->status === 'active')
                                        <span class="badge bg-success-subtle text-success border border-success-subtle">Active</span>
                                    @elseif ($fd->status === 'matured')
                                        <span class="badge bg-info-subtle text-info border border-info-subtle">Matured</span>
                                    @elseif ($fd->status === 'closed')
                                        <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">Closed</span>
                                    @else
                                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle">Premature Closed</span>
                                    @endif
                                </td>
                                <td class="text-end pe-3">
                                    <x-button size="sm" icon="show" variant="outline-primary" text="View"
                                        href="{{ route('finetech.fds.show', $fd) }}" />
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center py-5 text-muted">
                                    <i class="fas fa-box fa-2x mb-2 d-block opacity-25"></i>
                                    No FDS records found. <a href="{{ route('finetech.fds.create') }}">Create one now</a>.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</x-app-layout>
