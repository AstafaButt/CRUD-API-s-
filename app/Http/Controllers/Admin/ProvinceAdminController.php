<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Province;
use App\Models\Country;
use Illuminate\Http\Request;

class ProvinceAdminController extends Controller
{
    public function index()
    {
        $provinces = Province::with('country')->get();
        return view('admin.provinces.index', compact('provinces'));
    }

    public function create()
    {
        $countries = Country::all();
        return view('admin.provinces.create', compact('countries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'country_id' => 'required|exists:countries,id',
        ]);

        Province::create($request->all());

        return redirect()->route('admin.provinces.index')->with('success', 'Province created successfully.');
    }

    public function edit(Province $province)
    {
        $countries = Country::all();
        return view('admin.provinces.edit', compact('province', 'countries'));
    }

    public function update(Request $request, Province $province)
    {
        $request->validate([
            'name' => 'required',
            'country_id' => 'required|exists:countries,id',
        ]);

        $province->update($request->all());

        return redirect()->route('admin.provinces.index')->with('success', 'Province updated successfully.');
    }

    public function destroy(Province $province)
    {
        $province->delete();

        return redirect()->route('admin.provinces.index')->with('success', 'Province deleted.');
    }
}
