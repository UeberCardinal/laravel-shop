<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductsFilterRequest;
use App\Models\Category;
use App\Models\Product;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MainController extends Controller
{
    public function index(ProductsFilterRequest $request)
    {
        //    session()->flush();
            $productsQuery = Product::with('category');

            if($request->filled('price_from')) {
                $productsQuery->where('price', '>=', $request->price_from);
            }

            if($request->filled('price_to')) {
                $productsQuery->where('price', '<=', $request->price_to);
            }

            foreach (['hit', 'new', 'recommend'] as $field) {
                if ($request->has($field)) {
                    $productsQuery->$field();
                }
            }

            $products = $productsQuery->paginate(6);

            return view('index', compact('products'));




        $products = Product::paginate(6);
        return view('index', compact('products'));
    }

    public function categories()
    {
        $categories = Category::get();
        return view('category/categories', compact('categories'));
    }

    public function category($category)
    {
        $categoryObj = Category::where('slug', $category)->first();
        $products = Product::where('category_id', $categoryObj->id)->paginate(6);

        return view('category/category', compact('categoryObj', 'products'));
    }

    public function product($categorySlug, $productSlug)
    {
        $product = Product::withTrashed()->where('slug', $productSlug)->first();
        return view('product/product', compact('product'));
    }


}
