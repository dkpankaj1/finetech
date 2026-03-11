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
                        <div class="flex-grow-1">
                            <p class="text-muted small mb-1">Total Balance</p>
                            <h4 class="fw-bold mb-1">₹ 24,58,200</h4>
                            <span class="badge bg-success-subtle text-success border border-success-subtle">
                                <i class="fas fa-arrow-up me-1"></i>+8.2% this month
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
                        <div class="flex-grow-1">
                            <p class="text-muted small mb-1">Total Deposits</p>
                            <h4 class="fw-bold mb-1">₹ 84,00,500</h4>
                            <span class="badge bg-info-subtle text-info border border-info-subtle">
                                <i class="fas fa-arrow-up me-1"></i>+3.5% this month
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

        {{-- Active Loans --}}
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <p class="text-muted small mb-1">Active Loans</p>
                            <h4 class="fw-bold mb-1">₹ 12,15,000</h4>
                            <span class="badge bg-warning-subtle text-warning border border-warning-subtle">
                                <i class="fas fa-arrow-down me-1"></i>-1.2% this month
                            </span>
                        </div>
                        <div class="ms-3 rounded-3 d-flex align-items-center justify-content-center bg-warning bg-opacity-10"
                            style="width:52px;height:52px;">
                            <i class="fas fa-file-invoice-dollar fa-lg text-warning"></i>
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
                        <div class="flex-grow-1">
                            <p class="text-muted small mb-1">Branches</p>
                            <h4 class="fw-bold mb-1">12</h4>
                            <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">
                                <i class="fas fa-plus me-1"></i>2 added this year
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
            ['fas fa-users', 'text-primary', 'bg-primary', 'Total Users', '1,248', '48 new this month'],
            ['fas fa-exchange-alt', 'text-success', 'bg-success', "Today's Txns", '342', 'processed today'],
            ['fas fa-clock', 'text-danger', 'bg-danger', 'Pending', '17', 'awaiting approval'],
            ['fas fa-landmark', 'text-info', 'bg-info', 'FD Accounts', '890', 'active FDs'],
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
                        <i class="fas fa-chart-line me-2"></i>Balance Trend (2026)
                    </h6>
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle">Monthly</span>
                </div>
                <div class="card-body">
                    <canvas id="balanceChart" height="110"></canvas>
                </div>
            </div>

            {{-- Recent Transactions --}}
            <div class="card border-0">
                <div class="card-header bg-success bg-opacity-10 border-0 py-3 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-semibold text-success">
                        <i class="fas fa-exchange-alt me-2"></i>Recent Transactions
                    </h6>
                    <a href="#" class="btn btn-sm btn-outline-success">View All</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3">#</th>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th>Account</th>
                                    <th>Type</th>
                                    <th class="text-end pe-3">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ([
                                    ['TXN10021', '28 Feb 2026', 'Salary Credit', 'SB-00421', 'credit', '₹ 85,000'],
                                    ['TXN10020', '27 Feb 2026', 'Electricity Bill', 'SB-00421', 'debit', '₹ 2,340'],
                                    ['TXN10019', '26 Feb 2026', 'FD Maturity', 'FD-00102', 'credit', '₹ 1,24,500'],
                                    ['TXN10018', '25 Feb 2026', 'Loan EMI', 'LN-00034', 'debit', '₹ 9,200'],
                                    ['TXN10017', '24 Feb 2026', 'NEFT Transfer', 'SB-00421', 'debit', '₹ 15,000'],
                                    ['TXN10016', '24 Feb 2026', 'Interest Credit', 'SB-00421', 'credit', '₹ 1,240'],
                                ] as $i => [$txn, $date, $desc, $acc, $type, $amt])
                                    <tr>
                                        <td class="ps-3 text-muted small">{{ $txn }}</td>
                                        <td class="small">{{ $date }}</td>
                                        <td class="small fw-semibold">{{ $desc }}</td>
                                        <td>
                                            <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">
                                                {{ $acc }}
                                            </span>
                                        </td>
                                        <td>
                                            @if ($type === 'credit')
                                                <span class="badge bg-success-subtle text-success border border-success-subtle">
                                                    <i class="fas fa-arrow-down me-1"></i>Credit
                                                </span>
                                            @else
                                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle">
                                                    <i class="fas fa-arrow-up me-1"></i>Debit
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-end pe-3 small fw-semibold {{ $type === 'credit' ? 'text-success' : 'text-danger' }}">
                                            {{ $type === 'debit' ? '-' : '+' }}{{ $amt }}
                                        </td>
                                    </tr>
                                @endforeach
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
                            ['fas fa-paper-plane', 'primary', 'Send Money'],
                            ['fas fa-hand-holding-usd', 'success', 'Request'],
                            ['fas fa-plus-circle', 'info', 'Top Up'],
                            ['fas fa-file-invoice', 'warning', 'Pay Bills'],
                            ['fas fa-university', 'secondary', 'Branches'],
                            ['fas fa-users', 'danger', 'Users'],
                        ] as [$icon, $color, $label])
                            <div class="col-4">
                                <a href="#"
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
                    @foreach ([
                        ['Mumbai Main', 'MH', '₹ 9,24,000', 92],
                        ['Delhi Central', 'DL', '₹ 7,12,000', 71],
                        ['Bangalore HQ', 'KA', '₹ 6,80,000', 68],
                        ['Chennai South', 'TN', '₹ 4,20,000', 42],
                    ] as [$name, $state, $balance, $pct])
                        <div class="px-3 py-2 border-bottom">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <div class="fw-semibold small">{{ $name }}
                                    <span class="badge bg-secondary-subtle text-secondary ms-1">{{ $state }}</span>
                                </div>
                                <span class="small text-muted">{{ $balance }}</span>
                            </div>
                            <div class="progress" style="height:4px;">
                                <div class="progress-bar bg-info" style="width:{{ $pct }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Notifications --}}
            <div class="card border-0">
                <div class="card-header bg-danger bg-opacity-10 border-0 py-3">
                    <h6 class="mb-0 fw-semibold text-danger">
                        <i class="fas fa-bell me-2"></i>Notifications
                    </h6>
                </div>
                <div class="card-body p-0">
                    @foreach ([
                        ['success', 'fas fa-check-circle', 'Salary of ₹85,000 credited.', '2 min ago'],
                        ['warning', 'fas fa-clock', 'Loan EMI due in 3 days.', '1 hr ago'],
                        ['info', 'fas fa-info-circle', 'FD FD-00102 matured. Renew now.', 'Yesterday'],
                        ['danger', 'fas fa-exclamation-triangle', '17 transactions pending approval.', 'Today'],
                    ] as [$color, $icon, $text, $time])
                        <div class="d-flex align-items-start gap-2 px-3 py-2 border-bottom">
                            <div class="mt-1 text-{{ $color }}"><i class="{{ $icon }} fa-fw"></i></div>
                            <div class="flex-grow-1">
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
                                data: [18000, 21000, 24582, 22000, 26000, 29000, 31000, 28500, 33000, 35000, 38000, 41000],
                                borderColor: '#556ee6',
                                backgroundColor: 'rgba(85,110,230,0.1)',
                                fill: true,
                                tension: 0.4,
                                pointBackgroundColor: '#556ee6',
                                pointRadius: 4,
                            },
                            {
                                label: 'Deposits (₹)',
                                data: [60000, 65000, 72000, 69000, 75000, 80000, 84000, 82000, 88000, 91000, 94000, 98000],
                                borderColor: '#34c38f',
                                backgroundColor: 'rgba(52,195,143,0.07)',
                                fill: true,
                                tension: 0.4,
                                pointBackgroundColor: '#34c38f',
                                pointRadius: 4,
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
                                    callback: v => '₹' + (v / 1000) + 'k'
                                }
                            }
                        }
                    }
                });
            });
        </script>
    @endpush

</x-app-layout>