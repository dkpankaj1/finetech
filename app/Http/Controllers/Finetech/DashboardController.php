<?php

namespace App\Http\Controllers\Finetech;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\AccountType;
use App\Models\Branch;
use App\Models\Customer;
use App\Models\KycDocument;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $now = now();
        $startOfMonth = $now->copy()->startOfMonth();
        $startOfYear = $now->copy()->startOfYear();

        // ── KPI Row 1 ──
        $totalBalance = Account::sum('current_balance');
        $totalDeposits = Account::sum('opening_balance');
        $totalCustomers = Customer::count();
        $totalBranches = Branch::count();

        $newCustomersThisMonth = Customer::where('created_at', '>=', $startOfMonth)->count();
        $newBranchesThisYear = Branch::where('created_at', '>=', $startOfYear)->count();

        // ── KPI Row 2 ──
        $totalUsers = User::count();
        $newUsersThisMonth = User::where('created_at', '>=', $startOfMonth)->count();
        $totalAccounts = Account::count();
        $activeAccounts = Account::where('status', 'active')->count();
        $pendingKyc = KycDocument::where('status', 'pending')->count();
        $activeAccountTypes = AccountType::where('is_active', true)->count();

        // ── Top Branches (by total current_balance) ──
        $topBranches = Branch::select('branches.id', 'branches.name', 'branches.state')
            ->leftJoin('accounts', 'accounts.branch_id', '=', 'branches.id')
            ->selectRaw('COALESCE(SUM(accounts.current_balance), 0) as total_balance')
            ->groupBy('branches.id', 'branches.name', 'branches.state')
            ->orderByDesc('total_balance')
            ->limit(4)
            ->get();

        $maxBranchBalance = (float) $topBranches->max('total_balance') ?: 1;

        // ── Recent Accounts ──
        $recentAccounts = Account::with(['customer', 'accountType', 'branch'])
            ->latest()
            ->limit(6)
            ->get();

        // ── Monthly Account Counts for Chart (current year) ──
        $monthlyAccounts = Account::selectRaw("EXTRACT(MONTH FROM created_at) as month, COUNT(*) as count, COALESCE(SUM(current_balance), 0) as balance")
            ->whereYear('created_at', $now->year)
            ->groupByRaw('EXTRACT(MONTH FROM created_at)')
            ->orderByRaw('EXTRACT(MONTH FROM created_at)')
            ->pluck('balance', 'month')
            ->toArray();

        $monthlyCount = Account::selectRaw("EXTRACT(MONTH FROM created_at) as month, COUNT(*) as count")
            ->whereYear('created_at', $now->year)
            ->groupByRaw('EXTRACT(MONTH FROM created_at)')
            ->orderByRaw('EXTRACT(MONTH FROM created_at)')
            ->pluck('count', 'month')
            ->toArray();

        $chartBalances = [];
        $chartCounts = [];
        for ($m = 1; $m <= 12; $m++) {
            $chartBalances[] = (float) ($monthlyAccounts[$m] ?? 0);
            $chartCounts[] = (int) ($monthlyCount[$m] ?? 0);
        }

        return view('finetech.dashboard.index', compact(
            'totalBalance',
            'totalDeposits',
            'totalCustomers',
            'totalBranches',
            'newCustomersThisMonth',
            'newBranchesThisYear',
            'totalUsers',
            'newUsersThisMonth',
            'totalAccounts',
            'activeAccounts',
            'pendingKyc',
            'activeAccountTypes',
            'topBranches',
            'maxBranchBalance',
            'recentAccounts',
            'chartBalances',
            'chartCounts',
        ));
    }
}