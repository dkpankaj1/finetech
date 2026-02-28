<?php

namespace App\Http\Controllers\Finetech;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    private array $rules = [
        'name'            => 'required|string|max:255',
        'code'            => 'required|string|max:50',
        'ifsc_code'       => 'nullable|string|max:20',
        'micr_code'       => 'nullable|string|max:20',
        'swift_code'      => 'nullable|string|max:20',
        'address'         => 'required|string|max:255',
        'city'            => 'required|string|max:100',
        'state'           => 'required|string|max:100',
        'postal_code'     => 'required|string|max:20',
        'country'         => 'required|string|max:100',
        'latitude'        => 'nullable|numeric',
        'longitude'       => 'nullable|numeric',
        'phone_number'    => 'required|string|max:20',
        'alternate_phone' => 'nullable|string|max:20',
        'email'           => 'nullable|email|max:255',
        'fax'             => 'nullable|string|max:20',
        'opening_time'    => 'nullable|date_format:H:i,H:i:s',
        'closing_time'    => 'nullable|date_format:H:i,H:i:s',
        'manager_name'    => 'nullable|string|max:255',
        'manager_email'   => 'nullable|email|max:255',
        'manager_phone'   => 'nullable|string|max:20',
        'is_active'       => 'required|boolean',
        'is_main_branch'  => 'nullable|boolean',
        'remarks'         => 'nullable|string',
    ];

    public function index()
    {
        return view('finetech.branches.index', [
            'branches' => Branch::latest()->get(),
        ]);
    }

    public function create()
    {
        return view('finetech.branches.create');
    }

    public function store(Request $request)
    {
        $request->validate(array_merge($this->rules, [
            'code' => 'required|string|max:50|unique:branches,code',
        ]));

        try {
            Branch::create([
                'name'            => $request->name,
                'code'            => strtoupper($request->code),
                'ifsc_code'       => $request->ifsc_code,
                'micr_code'       => $request->micr_code,
                'swift_code'      => $request->swift_code,
                'address'         => $request->address,
                'city'            => $request->city,
                'state'           => $request->state,
                'postal_code'     => $request->postal_code,
                'country'         => $request->country ?? 'India',
                'latitude'        => $request->latitude,
                'longitude'       => $request->longitude,
                'phone_number'    => $request->phone_number,
                'alternate_phone' => $request->alternate_phone,
                'email'           => $request->email,
                'fax'             => $request->fax,
                'opening_time'    => $request->opening_time,
                'closing_time'    => $request->closing_time,
                'manager_name'    => $request->manager_name,
                'manager_email'   => $request->manager_email,
                'manager_phone'   => $request->manager_phone,
                'is_active'       => $request->is_active,
                'is_main_branch'  => $request->boolean('is_main_branch', false),
                'remarks'         => $request->remarks,
            ]);

            toastr()->success('Branch created successfully.');
            return redirect()->route('finetech.branches.index');
        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function show(Branch $branch)
    {
        return view('finetech.branches.show', ['branch' => $branch]);
    }

    public function edit(Branch $branch)
    {
        return view('finetech.branches.edit', ['branch' => $branch]);
    }

    public function update(Request $request, Branch $branch)
    {
        $request->validate(array_merge($this->rules, [
            'code' => 'required|string|max:50|unique:branches,code,' . $branch->id,
        ]));

        try {
            $branch->update([
                'name'            => $request->name,
                'code'            => strtoupper($request->code),
                'ifsc_code'       => $request->ifsc_code,
                'micr_code'       => $request->micr_code,
                'swift_code'      => $request->swift_code,
                'address'         => $request->address,
                'city'            => $request->city,
                'state'           => $request->state,
                'postal_code'     => $request->postal_code,
                'country'         => $request->country,
                'latitude'        => $request->latitude,
                'longitude'       => $request->longitude,
                'phone_number'    => $request->phone_number,
                'alternate_phone' => $request->alternate_phone,
                'email'           => $request->email,
                'fax'             => $request->fax,
                'opening_time'    => $request->opening_time,
                'closing_time'    => $request->closing_time,
                'manager_name'    => $request->manager_name,
                'manager_email'   => $request->manager_email,
                'manager_phone'   => $request->manager_phone,
                'is_active'       => $request->is_active,
                'is_main_branch'  => $request->boolean('is_main_branch', false),
                'remarks'         => $request->remarks,
            ]);

            toastr()->success('Branch updated successfully.');
            return redirect()->route('finetech.branches.index');
        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function destroy(Branch $branch)
    {
        try {
            $branch->delete();
            toastr()->success('Branch deleted successfully.');
            return redirect()->route('finetech.branches.index');
        } catch (\Exception $e) {
            toastr()->error('Failed to delete branch. Please try again.');
            return redirect()->back();
        }
    }
}
