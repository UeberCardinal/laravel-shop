<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductsFilterRequest;
use App\Http\Requests\SubscriptionRequest;
use App\Models\Category;
use App\Models\Currency;
use App\Models\Models\Subscription;
use App\Models\Product;
use App\Models\Sku;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;


class MainController extends Controller
{
    public function index(ProductsFilterRequest $request)
    {
        //dd($request->all());
        $skusQuery = Sku::with(['product', 'product.category']);
        if ($request->filled('price_from')) {
            $skusQuery->where('price', '>=', $request->price_from);
        }

        if ($request->filled('price_to')) {
            $skusQuery->where('price', '<=', $request->price_to);
        }

        foreach (['hit', 'new', 'recommend'] as $field) {
            if ($request->has($field)) {
                $skusQuery->whereHas('product', function($query) use ($field){
                    $query->$field();
                });
            }
        }

        //$products = $skusQuery->paginate(6);
        $skus = $skusQuery->paginate(6)->withPath("?" .$request->getQueryString());
        return view('index', compact('skus'));

        /*  $products = Product::paginate(6);

          return view('index', compact('products', 'categories'));*/
    }

    public function categories()
    {
        return view('category/categories');
    }

    public function category($category )
    {
        $category = Category::where('slug', $category)->first();
       // $products = Product::where('category_id', $categoryObj->id)->paginate(6);
        $skus = Sku::query()->paginate(10);

        return view('category/category', compact('category', 'skus'));
    }

    public function sku($categorySlug, $productSlug, Sku $sku)
    {
        if ($sku->product->slug != $productSlug){
            abort(404, 'Product not found');
        }

        if ($sku->product->category->slug != $categorySlug){
            abort(404, 'Category not found');
        }
        $product = Product::withTrashed()->where('slug', $productSlug)->first();
        return view('product/product', compact('sku'));
    }

    public function subscribe(SubscriptionRequest $request, Sku $sku)
    {
        Subscription::create([
            'email' => $request->email,
            'sku_id' => $sku->id
        ]);


        return redirect()->back()->with('success', '??????????????, ???? ???????????????? ?? ???????? ?????? ?????????????? ????????????');
    }

    public function changeLocale($locale)
    {
        session(['locale' => $locale]);
        App::setLocale($locale);
        return redirect()->back();
    }

    public function changeCurrency($currencyCode)
    {
        $currency = Currency::byCode($currencyCode)->firstOrFail();
        session(['currency' => $currency->code]);
        return redirect()->back();
    }




}
