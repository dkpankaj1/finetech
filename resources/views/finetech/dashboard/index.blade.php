<x-app-layout>

    {{-- Page Header --}}
    <div class="py-3 py-lg-4">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h4 class="page-title mb-0">
                    <i class="fas fa-tachometer-alt me-2 text-primary"></i>Dashboard
                </h4>
                <p class="text-muted small mb-0 mt-1">
                    Welcome back, <strong>{{ auth()->user()->name }}</strong>! &mdash;
                    {{ now()->format('l, d F Y') }}
                </p>
            </div>
            <div class="col-lg-6">
                <div class="d-none d-lg-block">
                    <ol class="breadcrumb m-0 float-end">
                        <li class="breadcrumb-item"><a href="{{ route('finetech.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Home</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    {{-- ─── Row 1: KPI Cards ─────────────────────────────────────────────── --}}
    <div class="row g-3 mb-3">

        {{-- Total Balance --}}
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="grow">
                            <p class="text-muted small mb-1">Total Balance</p>
                            <h4 class="fw-bold mb-1">₹ {{ number_format($totalBalance, 2) }}</h4>
                            <span class="badge bg-success-subtle text-success border border-success-subtle">
                                <i class="fas fa-wallet me-1"></i>All accounts
                            </span>
                        </div>
                        <div class="ms-3 rounded-3 d-flex align-items-center justify-content-center bg-primary bg-opacity-10"
                            style="width:52px;height:52px;">
                            <i class="fas fa-wallet fa-lg text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Deposits --}}
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="grow">
                            <p class="text-muted small mb-1">Total Deposits</p>
                            <h4 class="fw-bold mb-1">₹ {{ number_format($totalDeposits, 2) }}</h4>
                            <span class="badge bg-info-subtle text-info border border-info-subtle">
                                <i class="fas fa-piggy-bank me-1"></i>Opening balances
                            </span>
                        </div>
                        <div class="ms-3 rounded-3 d-flex align-items-center justify-content-center bg-info bg-opacity-10"
                            style="width:52px;height:52px;">
                            <i class="fas fa-piggy-bank fa-lg text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Customers --}}
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="grow">
                            <p class="text-muted small mb-1">Total Customers</p>
                            <h4 class="fw-bold mb-1">{{ number_format($totalCustomers) }}</h4>
                            <span class="badge bg-warning-subtle text-warning border border-warning-subtle">
                                <i class="fas fa-user-plus me-1"></i>{{ $newCustomersThisMonth }} new this month
                            </span>
                        </div>
                        <div class="ms-3 rounded-3 d-flex align-items-center justify-content-center bg-warning bg-opacity-10"
                            style="width:52px;height:52px;">
                            <i class="fas fa-user-friends fa-lg text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Branches --}}
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="grow">
                            <p class="text-muted small mb-1">Branches</p>
                            <h4 class="fw-bold mb-1">{{ number_format($totalBranches) }}</h4>
                            <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">
                                <i class="fas fa-plus me-1"></i>{{ $newBranchesThisYear }} added this year
                            </span>
                        </div>
                        <div class="ms-3 rounded-3 d-flex align-items-center justify-content-center bg-secondary bg-opacity-10"
                            style="width:52px;height:52px;">
                            <i class="fas fa-code-branch fa-lg text-secondary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- ─── Row 2: Secondary Stats ──────────────────────────────────────────── --}}
    <div class="row g-3 mb-3">
        @foreach ([
            ['fas fa-users', 'text-primary', 'bg-primary', 'Total Users', number_format($totalUsers), $newUsersThisMonth . ' new this month'],
            ['fas fa-university', 'text-success', 'bg-success', 'Total Accounts', number_format($totalAccounts), $activeAccounts . ' active'],
            ['fas fa-clock', 'text-danger', 'bg-danger', 'Pending KYC', number_format($pendingKyc), 'awaiting review'],
            ['fas fa-landmark', 'text-info', 'bg-info', 'Account Types', number_format($activeAccountTypes), 'active types'],
        ] as [$icon, $textColor, $bgColor, $label, $value, $sub])
            <div class="col-sm-6 col-xl-3">
                <div class="card border-0 h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="rounded-3 d-flex align-items-center justify-content-center {{ $bgColor }} bg-opacity-10"
                            style="width:42px;height:42px;flex-shrink:0;">
                            <i class="{{ $icon }} {{ $textColor }}"></i>
                        </div>
                        <div>
                            <p class="text-muted small mb-0">{{ $label }}</p>
                            <h5 class="fw-bold mb-0">{{ $value }}</h5>
                            <p class="text-muted mb-0" style="font-size:11px;">{{ $sub }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- ─── Row 3: Main Content ─────────────────────────────────────────────── --}}
    <div class="row g-3">

        {{-- Left: Chart + Transactions --}}
        <div class="col-lg-8">

            {{-- Balance Trend Chart --}}
            <div class="card border-0 mb-3">
                <div class="card-header bg-primary bg-opacity-10 border-0 py-3 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-semibold text-primary">
                        <i class="fas fa-chart-line me-2"></i>Account Trend ({{ now()->year }})
                    </h6>
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle">Monthly</span>
                </div>
                <div class="card-body">
                    <canvas id="balanceChart" height="110"></canvas>
                </div>
            </div>

            {{-- Recent Accounts --}}
            <div class="card border-0">
                <div class="card-header bg-success bg-opacity-10 border-0 py-3 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-semibold text-success">
                        <i class="fas fa-university me-2"></i>Recent Accounts
                    </h6>
                    <a href="{{ route('finetech.accounts.index') }}" class="btn btn-sm btn-outline-success">View All</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3">Account #</th>
                                    <th>Customer</th>
                                    <th>Type</th>
                                    <th>Branch</th>
                                    <th>Status</th>
                                    <th class="text-end pe-3">Balance</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($recentAccounts as $account)
                                    <tr>
                                        <td class="ps-3 text-muted small">{{ $account->account_number }}</td>
                                        <td class="small fw-semibold">{{ $account->customer?->first_name }} {{ $account->customer?->last_name }}</td>
                                        <td>
                                            <span class="badge bg-info-subtle text-info border border-info-subtle">
                                                {{ $account->accountType?->name ?? '-' }}
                                            </span>
                                        </td>
                                        <td class="small">{{ $account->branch?->name ?? '-' }}</td>
                                        <td>
                                            @if ($account->status === 'active')
                                                <span class="badge bg-success-subtle text-success border border-success-subtle">
                                                    <i class="fas fa-check-circle me-1"></i>Active
                                                </span>
                                            @elseif ($account->status === 'inactive')
                                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle">
                                                    <i class="fas fa-pause-circle me-1"></i>Inactive
                                                </span>
                                            @else
                                                <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">
                                                    {{ ucfirst($account->status ?? 'N/A') }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-end pe-3 small fw-semibold">
                                            ₹ {{ number_format($account->current_balance, 2) }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">No accounts found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

        {{-- Right: Sidebar Widgets --}}
        <div class="col-lg-4">

            {{-- Quick Actions --}}
            <div class="card border-0 mb-3">
                <div class="card-header bg-warning bg-opacity-10 border-0 py-3">
                    <h6 class="mb-0 fw-semibold text-warning">
                        <i class="fas fa-bolt me-2"></i>Quick Actions
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row g-2">
                        @foreach ([
                            ['fas fa-user-plus', 'primary', 'New Customer', route('finetech.customers.create')],
                            ['fas fa-plus-circle', 'success', 'New Account', route('finetech.accounts.create')],
                            ['fas fa-id-card', 'info', 'KYC Docs', route('finetech.kyc-documents.index')],
                            ['fas fa-file-invoice', 'warning', 'Acc. Types', route('finetech.account-types.index')],
                            ['fas fa-university', 'secondary', 'Branches', route('finetech.branches.index')],
                            ['fas fa-users', 'danger', 'Users', route('finetech.users.index')],
                        ] as [$icon, $color, $label, $link])
                            <div class="col-4">
                                <a href="{{ $link }}"
                                    class="d-flex flex-column align-items-center justify-content-center rounded-3 p-2 text-decoration-none bg-{{ $color }} bg-opacity-10 border border-{{ $color }}-subtle"
                                    style="min-height:68px;">
                                    <i class="{{ $icon }} text-{{ $color }} mb-1"></i>
                                    <span class="text-{{ $color }} fw-semibold" style="font-size:11px;">{{ $label }}</span>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Top Branches --}}
            <div class="card border-0 mb-3">
                <div class="card-header bg-info bg-opacity-10 border-0 py-3">
                    <h6 class="mb-0 fw-semibold text-info">
                        <i class="fas fa-code-branch me-2"></i>Top Branches
                    </h6>
                </div>
                <div class="card-body p-0">
                    @forelse ($topBranches as $branch)
                        <div class="px-3 py-2 border-bottom">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <div class="fw-semibold small">{{ $branch->name }}
                                    <span class="badge bg-secondary-subtle text-secondary ms-1">{{ $branch->state ?? '-' }}</span>
                                </div>
                                <span class="small text-muted">₹ {{ number_format($branch->total_balance, 2) }}</span>
                            </div>
                            <div class="progress" style="height:4px;">
                                <div class="progress-bar bg-info" style="width:{{ round(($branch->total_balance / $maxBranchBalance) * 100) }}%"></div>
                            </div>
                        </div>
                    @empty
                        <div class="px-3 py-3 text-center text-muted small">No branches found.</div>
                    @endforelse
                </div>
            </div>

            {{-- System Summary --}}
            <div class="card border-0">
                <div class="card-header bg-danger bg-opacity-10 border-0 py-3">
                    <h6 class="mb-0 fw-semibold text-danger">
                        <i class="fas fa-info-circle me-2"></i>System Summary
                    </h6>
                </div>
                <div class="card-body p-0">
                    @foreach ([
                        ['primary', 'fas fa-users', number_format($totalUsers) . ' registered users in the system.', $newUsersThisMonth . ' new this month'],
                        ['success', 'fas fa-university', number_format($totalAccounts) . ' total accounts created.', $activeAccounts . ' currently active'],
                        ['warning', 'fas fa-id-card', number_format($pendingKyc) . ' KYC documents pending review.', 'Action required'],
                        ['info', 'fas fa-user-friends', number_format($totalCustomers) . ' customers onboarded.', $newCustomersThisMonth . ' new this month'],
                    ] as [$color, $icon, $text, $time])
                        <div class="d-flex align-items-start gap-2 px-3 py-2 border-bottom">
                            <div class="mt-1 text-{{ $color }}"><i class="{{ $icon }} fa-fw"></i></div>
                            <div class="grow">
                                <div class="small">{{ $text }}</div>
                                <div class="text-muted" style="font-size:11px;">{{ $time }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark';
                const gridColor = isDark ? 'rgba(255,255,255,0.07)' : 'rgba(0,0,0,0.06)';
                const textColor = isDark ? '#adb5bd' : '#6c757d';

                new Chart(document.getElementById('balanceChart'), {
                    type: 'line',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                        datasets: [
                            {
                                label: 'Balance (₹)',
                                data: @json($chartBalances),
                                borderColor: '#556ee6',
                                backgroundColor: 'rgba(85,110,230,0.1)',
                                fill: true,
                                tension: 0.4,
                                pointBackgroundColor: '#556ee6',
                                pointRadius: 4,
                            },
                            {
                                label: 'Accounts Opened',
                                data: @json($chartCounts),
                                borderColor: '#34c38f',
                                backgroundColor: 'rgba(52,195,143,0.07)',
                                fill: true,
                                tension: 0.4,
                                pointBackgroundColor: '#34c38f',
                                pointRadius: 4,
                                yAxisID: 'y1',
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: { mode: 'index', intersect: false },
                        plugins: {
                            legend: {
                                labels: { color: textColor, usePointStyle: true, pointStyleWidth: 8 }
                            }
                        },
                        scales: {
                            x: { grid: { color: gridColor }, ticks: { color: textColor } },
                            y: {
                                grid: { color: gridColor },
                                ticks: {
                                    color: textColor,
                                    callback: v => '₹' + (v / 1000).toLocaleString() + 'k'
                                }
                            },
                            y1: {
                                position: 'right',
                                grid: { drawOnChartArea: false },
                                ticks: {
                                    color: textColor,
                                    stepSize: 1,
                                }
                            }
                        }
                    }
                });
            });
        </script>
    @endpush

</x-app-layout>