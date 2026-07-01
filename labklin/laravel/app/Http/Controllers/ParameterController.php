<?php

namespace App\Http\Controllers;

use App\Models\Parameter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ParameterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $menu = 'kesmas';
        $submenu = 'parameter';
        $parameters = DB::table('kesmas_parameters')
            ->when($request->input('name'), function ($query, $test_name) {
                return $query->where('parameter_name', 'like', '%' . $test_name . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate(10);
        return view('pages.parameters.index', compact('parameters', 'menu', 'submenu'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $menu = 'kesmas';
        $submenu = 'parameter';
        $panels = DB::table('kesmas_parameters')->where('parameter_category', 'Panel')->orderBy('parameter_name', 'asc')->get();
        return view('pages.parameters.create', compact('menu', 'submenu', 'panels'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'parameter_code' => 'required|string|max:255||unique:kesmas_parameters,parameter_code',
            'parameter_name' => 'required|string|max:255',
            'parameter_method' => 'required|string|max:255',
            'parameter_unit' => 'required|string|max:255',
            'parameter_category' => 'required|string|max:255',
            'parameter_group' => 'required|string|max:255',
            'parameter_subgroup' => 'required|string|max:255',
            'parameter_specimen' => 'required|string|max:255',
            'parameter_parent' => 'nullable|string|max:255',
            'parameter_reference_type' => 'required|string|max:255',
            'parameter_reference_value' => 'required|string|max:255',
            'parameter_price' => 'required|numeric',
            'parameter_acreditation' => 'required|string|max:255',
            'parameter_time' => 'required|integer',
            'parameter_status' => 'required|string|max:255',
            'parameter_description' => 'nullable|string',
        ]);
        $encode = md5($request->input('parameter_code') . '-' . $request->input('parameter_name'));

        DB::table('kesmas_parameters')->insert([
            'parameter_code' => $request->input('parameter_code'),
            'parameter_name' => $request->input('parameter_name'),
            'parameter_method' => $request->input('parameter_method'),
            'parameter_unit' => $request->input('parameter_unit'),
            'parameter_category' => $request->input('parameter_category'),
            'parameter_group' => $request->input('parameter_group'),
            'parameter_subgroup' => $request->input('parameter_subgroup'),
            'parameter_specimen' => $request->input('parameter_specimen'),
            'parameter_container' => $request->input('parameter_container'),
            'parameter_parent' => $request->input('parameter_parent'),
            'parameter_reference_type' => $request->input('parameter_reference_type'),
            'parameter_reference_value' => $request->input('parameter_reference_value'),
            'parameter_price' => $request->input('parameter_price'),
            'parameter_acreditation' => $request->input('parameter_acreditation'),
            'parameter_time' => $request->input('parameter_time'),
            'parameter_status' => $request->input('parameter_status'),
            'parameter_description' => $request->input('parameter_description'),
            'parameter_encode' => $encode,
        ]);

        return redirect()->route('parameter.index')->with('success', 'Parameter created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $menu = 'kesmas';
        $submenu = 'parameter';
        $parameters = Parameter::findOrFail($id);
        $panels = DB::table('kesmas_parameters')->where('parameter_category', 'Panel')->orderBy('parameter_name', 'asc')->get();
        
        return view('pages.parameters.edit', compact('parameters', 'menu', 'submenu', 'panels'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'parameter_code' => 'required|string|max:255|unique:kesmas_parameters,parameter_code,' . $id,
            'parameter_name' => 'required|string|max:255',
            'parameter_method' => 'required|string|max:255',
            'parameter_unit' => 'required|string|max:255',
            'parameter_category' => 'required|string|max:255',
            'parameter_group' => 'required|string|max:255',
            'parameter_subgroup' => 'required|string|max:255',
            'parameter_specimen' => 'required|string|max:255',
            'parameter_parent' => 'nullable|string|max:255',
            'parameter_reference_type' => 'required|string|max:255',
            'parameter_reference_value' => 'required|string|max:255',
            'parameter_price' => 'required|numeric',
            'parameter_acreditation' => 'required|string|max:255',
            'parameter_time' => 'required|integer',
            'parameter_status' => 'required|string|max:255',
            'parameter_description' => 'nullable|string',
        ]);

        $encode = md5($request->input('parameter_code') . '-' . $request->input('parameter_name'));

        DB::table('kesmas_parameters')
            ->where('id', $id)
            ->update([
                'parameter_code' => $request->input('parameter_code'),
                'parameter_name' => $request->input('parameter_name'),
                'parameter_method' => $request->input('parameter_method'),
                'parameter_unit' => $request->input('parameter_unit'),
                'parameter_category' => $request->input('parameter_category'),
                'parameter_group' => $request->input('parameter_group'),
                'parameter_subgroup' => $request->input('parameter_subgroup'),
                'parameter_specimen' => $request->input('parameter_specimen'),
                'parameter_parent' => $request->input('parameter_parent'),
                'parameter_container' => $request->input('parameter_container'),
                'parameter_reference_type' => $request->input('parameter_reference_type'),
                'parameter_reference_value' => $request->input('parameter_reference_value'),
                'parameter_price' => $request->input('parameter_price'),
                'parameter_acreditation' => $request->input('parameter_acreditation'),
                'parameter_time' => $request->input('parameter_time'),
                'parameter_status' => $request->input('parameter_status'),
                'parameter_description' => $request->input('parameter_description'),
                'parameter_encode' => $encode,
            ]);

        return redirect()->route('parameter.index')->with('success', 'Parameter updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
