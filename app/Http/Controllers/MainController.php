<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductsFilterRequest;
use App\Http\Requests\SubscriptionRequest;
use App\Models\Category;
use App\Models\Currency;
use App\Models\Models\Subscription;
use App\Models\Product;
use Illuminate\Support\Facades\App;


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

      /*  $products = Product::paginate(6);

        return view('index', compact('products', 'categories'));*/
    }

    public function categories()
    {
        return view('category/categories');
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

    public function subscribe(SubscriptionRequest $request, Product $product)
    {
        Subscription::create([
            'email' => $request->email,
            'product_id' => $product->id
        ]);


        return redirect()->back()->with('success', 'Спасибо, мы свяжимся с Вами при наличии товара');
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
