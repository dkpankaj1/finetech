<x-app-layout>

    <div class="py-3 py-lg-4">
        <div class="row">
            <div class="col-lg-6">
                <h4 class="page-title mb-0">Dashboard</h4>
            </div>
            <div class="col-lg-6">
                <div class="d-none d-lg-block">
                    <ol class="breadcrumb m-0 float-end">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">Home</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="row g-3">
                <div class="col-sm-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <h6 class="text-muted mb-2">Available Balance</h6>
                                    <h4 class="mb-0">$24,582.00</h4>
                                </div>
                                <div class="avatar-sm rounded bg-soft-success">
                                    <span class="avatar-title">
                                        <i class="ti ti-wallet"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <h6 class="text-muted mb-2">Savings</h6>
                                    <h4 class="mb-0">$8,400.50</h4>
                                </div>
                                <div class="avatar-sm rounded bg-soft-primary">
                                    <span class="avatar-title">
                                        <i class="ti ti-piggy-bank"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <h6 class="text-muted mb-2">Loans</h6>
                                    <h4 class="mb-0">$12,150.00</h4>
                                </div>
                                <div class="avatar-sm rounded bg-soft-warning">
                                    <span class="avatar-title">
                                        <i class="ti ti-report-money"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <h6 class="text-muted mb-2">Credit Card</h6>
                                    <h4 class="mb-0">$1,200.25</h4>
                                </div>
                                <div class="avatar-sm rounded bg-soft-danger">
                                    <span class="avatar-title">
                                        <i class="ti ti-credit-card"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-3">Recent Transactions</h5>
                    <div class="table-responsive">
                        <table class="table table-hover table-centered mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th>Type</th>
                                    <th class="text-end">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>2026-02-20</td>
                                    <td>Salary Payment</td>
                                    <td><span class="badge bg-success">Credit</span></td>
                                    <td class="text-end">$4,500.00</td>
                                </tr>
                                <tr>
                                    <td>2026-02-19</td>
                                    <td>Grocery Store</td>
                                    <td><span class="badge bg-danger">Debit</span></td>
                                    <td class="text-end">-$124.32</td>
                                </tr>
                                <tr>
                                    <td>2026-02-18</td>
                                    <td>Electricity Bill</td>
                                    <td><span class="badge bg-danger">Debit</span></td>
                                    <td class="text-end">-$78.00</td>
                                </tr>
                                <tr>
                                    <td>2026-02-17</td>
                                    <td>Interest</td>
                                    <td><span class="badge bg-success">Credit</span></td>
                                    <td class="text-end">$12.40</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-body">
                    <h5 class="card-title mb-3">Balance Trend</h5>
                    <canvas id="balanceChart" height="120"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Quick Actions</h5>
                    <div class="d-grid gap-2">
                        <a href="#" class="btn btn-primary">Send Money</a>
                        <a href="#" class="btn btn-outline-secondary">Request Payment</a>
                        <a href="#" class="btn btn-outline-success">Top Up</a>
                        <a href="#" class="btn btn-outline-danger">Pay Bills</a>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-body">
                    <h5 class="card-title">Notifications</h5>
                    <ul class="list-unstyled mb-0">
                        <li class="py-2 border-bottom">
                            <small class="text-muted">Feb 20</small>
                            <div>Payment of <strong>$4,500</strong> received.</div>
                        </li>
                        <li class="py-2 border-bottom">
                            <small class="text-muted">Feb 19</small>
                            <div>Subscription renewed: <strong>$15</strong>.</div>
                        </li>
                        <li class="py-2">
                            <small class="text-muted">Feb 18</small>
                            <div>New loan offer available.</div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var ctx = document.getElementById('balanceChart');
                if (ctx) {
                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                            datasets: [{
                                label: 'Balance',
                                data: [12000, 14000, 15000, 18000, 20000, 22000, 24582],
                                borderColor: '#556ee6',
                                backgroundColor: 'rgba(85,110,230,0.1)',
                                fill: true,
                                tension: 0.3
                            }]
                        },
                        options: { responsive: true, maintainAspectRatio: false }
                    });
                }
            });
        </script>
    @endpush

</x-app-layout>