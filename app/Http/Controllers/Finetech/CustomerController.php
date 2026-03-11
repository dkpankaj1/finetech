<?php

namespace App\Http\Controllers\Finetech;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Customer;
use App\Support\ImageHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    private array $rules = [
        'first_name'    => 'required|string|max:255',
        'last_name'     => 'required|string|max:255',
        'email'         => 'required|email|max:255',
        'phone'         => 'required|string|max:20',
        'date_of_birth' => 'nullable|date|before:today',
        'gender'        => 'nullable|in:male,female,other',
        'photo'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        'address'       => 'required|string|max:255',
        'city'          => 'required|string|max:100',
        'state'         => 'required|string|max:100',
        'postal_code'   => 'required|string|max:20',
        'country'       => 'required|string|max:100',
        'branch_id'     => 'required|exists:branches,id',
        'status'        => 'required|in:active,inactive,suspended,blacklisted',
        'kyc_status'    => 'required|in:pending,verified,rejected,expired',
        'status_reason' => 'nullable|string|max:500',
    ];

    public function index()
    {
        return view('finetech.customers.index', [
            'customers' => Customer::with('branch')->latest()->get(),
        ]);
    }

    public function create()
    {
        return view('finetech.customers.create', [
            'branches' => Branch::where('is_active', true)->get(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate(array_merge($this->rules, [
            'email' => 'required|email|max:255|unique:customers,email',
        ]));

        try {
            $photoPath = null;
            if ($request->hasFile('photo')) {
                $photoPath = (new ImageHandler('customers'))->upload($request->file('photo'), 300, 300);
            }

            Customer::create([
                'customer_number'  => $this->generateCustomerNumber(),
                'first_name'       => $request->first_name,
                'last_name'        => $request->last_name,
                'email'            => $request->email,
                'phone'            => $request->phone,
                'date_of_birth'    => $request->date_of_birth,
                'gender'           => $request->gender,
                'photo'            => $photoPath,
                'address'          => $request->address,
                'city'             => $request->city,
                'state'            => $request->state,
                'postal_code'      => $request->postal_code,
                'country'          => $request->country ?? 'India',
                'branch_id'        => $request->branch_id,
                'created_by'       => Auth::id(),
                'status'           => $request->status,
                'kyc_status'       => $request->kyc_status,
                'status_reason'    => $request->status_reason,
            ]);

            toastr()->success('Customer created successfully.');
            return redirect()->route('finetech.customers.index');
        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function show(Customer $customer)
    {
        $customer->load('branch', 'creator');
        return view('finetech.customers.show', ['customer' => $customer]);
    }

    public function edit(Customer $customer)
    {
        return view('finetech.customers.edit', [
            'customer' => $customer,
            'branches' => Branch::where('is_active', true)->get(),
        ]);
    }

    public function update(Request $request, Customer $customer)
    {
        $request->validate(array_merge($this->rules, [
            'email' => 'required|email|max:255|unique:customers,email,' . $customer->id,
        ]));

        try {
            $photoPath = $customer->photo;
            if ($request->hasFile('photo')) {
                $imageHandler = new ImageHandler('customers');
                if ($customer->photo) {
                    $imageHandler->delete($customer->photo);
                }
                $photoPath = $imageHandler->upload($request->file('photo'), 300, 300);
            }

            $customer->update([
                'first_name'       => $request->first_name,
                'last_name'        => $request->last_name,
                'email'            => $request->email,
                'phone'            => $request->phone,
                'date_of_birth'    => $request->date_of_birth,
                'gender'           => $request->gender,
                'photo'            => $photoPath,
                'address'          => $request->address,
                'city'             => $request->city,
                'state'            => $request->state,
                'postal_code'      => $request->postal_code,
                'country'          => $request->country,
                'branch_id'        => $request->branch_id,
                'status'           => $request->status,
                'kyc_status'       => $request->kyc_status,
                'status_reason'    => $request->status_reason,
            ]);

            toastr()->success('Customer updated successfully.');
            return redirect()->route('finetech.customers.index');
        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function destroy(Customer $customer)
    {
        try {
            if ($customer->photo) {
                (new ImageHandler('customers'))->delete($customer->photo);
            }
            $customer->delete();
            toastr()->success('Customer deleted successfully.');
            return redirect()->route('finetech.customers.index');
        } catch (\Exception $e) {
            toastr()->error('Failed to delete customer. Please try again.');
            return redirect()->back();
        }
    }

    private function generateCustomerNumber(): string
    {
        $year = date('Y');
        $last = Customer::where('customer_number', 'like', "CUS-{$year}-%")
            ->orderByDesc('id')
            ->value('customer_number');

        $nextNumber = 1;
        if ($last) {
            $parts = explode('-', $last);
            $nextNumber = (int) end($parts) + 1;
        }

        return sprintf('CUS-%s-%05d', $year, $nextNumber);
    }
}
