<?php

namespace App\Http\Controllers\Finetech;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use Illuminate\Http\Request;

class CurrencyMasterController extends Controller
{
    private array $rules = [
        'name'          => 'required|string|max:255',
        'code'          => 'required|string|max:10',
        'symbol'        => 'required|string|max:10',
        'exchange_rate' => 'required|numeric|min:0',
    ];

    public function index()
    {
        return view('finetech.currency.index', [
            'currencies' => Currency::latest()->get(),
        ]);
    }

    public function create()
    {
        return view('finetech.currency.create');
    }

    public function store(Request $request)
    {
        $request->validate(array_merge($this->rules, [
            'code' => 'required|string|max:10|unique:currencies,code',
        ]));

        try {
            Currency::create([
                'name'          => $request->name,
                'code'          => strtoupper($request->code),
                'symbol'        => $request->symbol,
                'exchange_rate' => $request->exchange_rate,
            ]);

            toastr()->success('Currency created successfully.');
            return redirect()->route('finetech.currencies.index');
        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function show(Currency $currency)
    {
        return view('finetech.currency.show', ['currency' => $currency]);
    }

    public function edit(Currency $currency)
    {
        return view('finetech.currency.edit', ['currency' => $currency]);
    }

    public function update(Request $request, Currency $currency)
    {
        $request->validate(array_merge($this->rules, [
            'code' => 'required|string|max:10|unique:currencies,code,' . $currency->id,
        ]));

        try {
            $currency->update([
                'name'          => $request->name,
                'code'          => strtoupper($request->code),
                'symbol'        => $request->symbol,
                'exchange_rate' => $request->exchange_rate,
            ]);

            toastr()->success('Currency updated successfully.');
            return redirect()->route('finetech.currencies.index');
        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function destroy(Currency $currency)
    {
        try {
            $currency->delete();
            toastr()->success('Currency deleted successfully.');
            return redirect()->route('finetech.currencies.index');
        } catch (\Exception $e) {
            toastr()->error('Failed to delete currency. Please try again.');
            return redirect()->back();
        }
    }
}
