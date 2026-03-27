<?php

namespace App\Http\Controllers\Finetech;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\FixedDeposit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FdsController extends Controller
{
    private array $rules = [
        'account_id' => 'required|exists:accounts,id',
        'principal_amount' => 'required|numeric|gt:0',
        'interest_rate' => 'required|numeric|min:0|max:100',
        'tenure_months' => 'required|integer|min:1|max:600',
        'opened_at' => 'required|date',
        'remarks' => 'nullable|string|max:500',
    ];

    public function index()
    {
        return view('finetech.fds.index', [
            'fds' => FixedDeposit::with(['account.customer', 'branch', 'currency', 'creator'])
                ->latest()
                ->get(),
        ]);
    }

    public function create()
    {
        return view('finetech.fds.create', [
            'accounts' => Account::with(['customer', 'branch', 'currency', 'accountType'])
                ->where('status', 'active')
                ->orderBy('account_number')
                ->get(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate($this->rules);

        try {
            $fd = DB::transaction(function () use ($request) {
                $account = Account::with(['customer', 'branch', 'currency', 'accountType'])
                    ->lockForUpdate()
                    ->findOrFail($request->account_id);

                if ($account->status !== 'active') {
                    throw new \RuntimeException('Only active accounts can open FDS.');
                }

                $principal = (float) $request->principal_amount;
                if ((float) $account->current_balance < $principal) {
                    throw new \RuntimeException('Insufficient balance to open FDS.');
                }

                $openedAt = Carbon::parse($request->opened_at);
                $tenureMonths = (int) $request->tenure_months;
                $interestRate = (float) $request->interest_rate;

                $maturityDate = $openedAt->copy()->addMonths($tenureMonths);
                $maturityAmount = $principal + (($principal * $interestRate * $tenureMonths) / 1200);

                $fd = FixedDeposit::create([
                    'fd_number' => $this->generateFdNumber(),
                    'account_id' => $account->id,
                    'customer_id' => $account->customer_id,
                    'branch_id' => $account->branch_id,
                    'currency_id' => $account->currency_id,
                    'principal_amount' => $principal,
                    'interest_rate' => $interestRate,
                    'tenure_months' => $tenureMonths,
                    'maturity_amount' => round($maturityAmount, 2),
                    'status' => 'active',
                    'opened_at' => $openedAt->toDateString(),
                    'maturity_date' => $maturityDate->toDateString(),
                    'remarks' => $request->remarks,
                    'created_by' => Auth::id(),
                ]);

                $account->decrement('current_balance', $principal);
                $account->update(['last_transaction_at' => $openedAt]);

                return $fd;
            });

            toastr()->success('FDS created successfully.');
            return redirect()->route('finetech.fds.show', $fd);
        } catch (\Throwable $e) {
            toastr()->error($e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function show(FixedDeposit $fd)
    {
        $fd->load(['account.customer', 'branch', 'currency', 'creator']);

        return view('finetech.fds.show', [
            'fd' => $fd,
        ]);
    }

    private function generateFdNumber(): string
    {
        $year = date('Y');
        $last = FixedDeposit::where('fd_number', 'like', "FDS-{$year}-%")
            ->orderByDesc('id')
            ->value('fd_number');

        $nextNumber = 1;
        if ($last) {
            $parts = explode('-', $last);
            $nextNumber = (int) end($parts) + 1;
        }

        return sprintf('FDS-%s-%06d', $year, $nextNumber);
    }
}
