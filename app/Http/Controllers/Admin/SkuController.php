<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SkuRequest;
use App\Models\Product;
use App\Models\Sku;
use Illuminate\Http\Request;

class SkuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        $skus = $product->skus()->paginate(10);
        return view('admin.skus.index', compact('skus', 'product'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Product $product, Sku $sku)
    {
        return view('admin.skus.create', compact('product', 'sku'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SkuRequest $request, Product $product)
    {
        $params = $request->all();
        $params['product_id'] = $product->id;
        $sku = Sku::create($params);
        $sku->propertyOption()->sync($request->property_id);
        return redirect()->route('skus.index', compact('product'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sku  $sku
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product, Sku $sku)
    {
        return view('admin.skus.show', compact('product', 'sku'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sku  $sku
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product, Sku $sku)
    {

        return view('admin.skus.edit', compact('product', 'sku'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sku  $sku
     * @return \Illuminate\Http\Response
     */
    public function update(SkuRequest $request, Product $product, Sku $sku)
    {
        $params = $request->all();
        $params['product_id'] = $product->id;
        $sku->update($params);
        $sku->propertyOption()->sync($request->property_id);
        return redirect()->route('skus.index', compact('product', 'sku'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sku  $sku
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product, Sku $sku)
    {
        $sku->delete();
        return redirect()->route('skus.index', compact('product'));
    }
}
