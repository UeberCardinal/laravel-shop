<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryFormRequest;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::paginate(20);
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
    {
        $params = $request->all();
        if ($request->has('image')) {
            $pathImg = $request->file('image')->store('/categories');
            $params['image'] = $pathImg;
        }

        $category = Category::create($params);
        $request->session()->flash('success', 'Категория добавлена!');
        return redirect()->route('categories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::find($id);
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCategoryRequest $request, $id)
    {
        $params = $request->all();
        $category = Category::find($id);
        if (!is_null($request->image)){
            if (!is_null($category->image)) {
                Storage::delete($category->image);
            }
            $imgPath = $request->file('image')->store('/categories');
            $params['image'] = $imgPath;
        }

        $category->update($params);
        $request->session()->flash('success', 'Категория обновлена!');
        return redirect()->route('categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        if (!$category->products->count()) {
            if (!is_null($category->image)) {
                Storage::delete($category->image);
            }
            $category->delete();
            return redirect()->route('categories.index')->with('success', 'Категория удалена');
        }
        return redirect()->route('categories.index')->with('error', 'К категории привязаны продукты');

    }
}
