<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
     //   session()->flush();
     //   dd(session());
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
        $product = Product::where('slug', $productSlug)->first();
        return view('product/product', compact('product'));
    }


}
