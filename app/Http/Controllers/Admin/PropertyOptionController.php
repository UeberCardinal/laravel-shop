<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PropertyOptionRequest;
use App\Models\Property;
use App\Models\PropertyOption;
use Illuminate\Http\Request;

class PropertyOptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Property $property)
    {
        $propertyOptions = PropertyOption::where('property_id', $property->id)->paginate(10);
        return view('admin.properties.property_options.index', compact( 'propertyOptions', 'property'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Property $property)
    {
        return view('admin.properties.property_options.create', compact('property'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PropertyOptionRequest $request, Property $property)
    {
        $propertyOptions = PropertyOption::where('property_id', $property->id)->paginate(10);
        $request['property_id'] = $property->id;
        PropertyOption::create($request->all());
        return redirect()->route('property-options.index', compact( 'propertyOptions', 'property'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PropertyOption  $propertyOption
     * @return \Illuminate\Http\Response
     */
    public function show(PropertyOption $propertyOption)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PropertyOption  $propertyOption
     * @return \Illuminate\Http\Response
     */
    public function edit(Property $property, PropertyOption $propertyOption)
    {
        return view('admin.properties.property_options.edit', compact('property', 'propertyOption'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PropertyOption  $propertyOption
     * @return \Illuminate\Http\Response
     */
    public function update(PropertyOptionRequest $request, Property $property, PropertyOption $propertyOption)
    {
        $propertyOptions = PropertyOption::where('property_id', $property->id)->paginate(10);
        $propertyOption->update($request->all());

        return redirect()->route('property-options.index', compact( 'propertyOptions', 'property'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PropertyOption  $propertyOption
     * @return \Illuminate\Http\Response
     */
    public function destroy(Property $property, PropertyOption $propertyOption)
    {
        $propertyOption->delete();
        return redirect()->route('property-options.index', $property);
    }
}
