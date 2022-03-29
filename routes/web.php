<?php


use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\MerchantController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\PropertyController;
use App\Http\Controllers\Admin\PropertyOptionController;
use App\Http\Controllers\Admin\SkuController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BasketController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\MainController;
use App\Http\Middleware\CheckPromocode;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes([
    'reset' => false,
    'confirm' => false,
    'verify' => false,
]);
Route::get('locale/{locale}', [MainController::class, 'changeLocale'])->name('locale');
Route::get('currency/{currencyCode}', [MainController::class, 'changeCurrency'])->name('currency');
Route::get('/logout', [LoginController::class, 'logout'])->name('get-logout');

Route::middleware(['set_locale'])->group(function () {
    Route::middleware(['auth'])->group(function () {
        Route::group([
            'prefix' => 'person',
            'as' => 'person.'
        ], function () {
            Route::get('/orders', [App\Http\Controllers\Person\OrderController::class, 'index'])->name('orders.index');
            Route::get('/orders/show/{id}', [App\Http\Controllers\Person\OrderController::class, 'show'])->name('order.show');
        });
        Route::group([
            'prefix' => 'admin'
        ], function () {
            Route::group(['middleware' => 'is_admin'], function () {
                Route::get('/orders', [OrderController::class, 'index'])->name('home');
                Route::get('/orders/show/{id}', [OrderController::class, 'show'])->name('order.show');
                Route::resource('categories',CategoryController::class);
                Route::resource('products',ProductController::class);
                Route::resource('products/{product}/skus',SkuController::class);
                Route::resource('properties', PropertyController::class);
                Route::resource('merchants', MerchantController::class);
                Route::get('merchant/{merchant}/token',[MerchantController::class, 'updateToken'] )->name('merchants.update_token');
                Route::resource('properties/{property}/property-options', PropertyOptionController::class);
                Route::resource('coupon', CouponController::class);
            });

        });
    });

    Route::get('/', [MainController::class, 'index'])->name('home.index');
    Route::get('/categories', [MainController::class, 'categories'])->name('categories');
    Route::get('/categories/{category}', [MainController::class, 'category'])->name('category');
    Route::post('subscription/{sku}', [MainController::class, 'subscribe'])->name('subscription');

    Route::group(['prefix' => 'basket'], function (){
        Route::post('/add/{sku}', [BasketController::class, 'addToBasket'])->name('addToBasket');
        Route::group([
            'middleware' => 'basket_not_empty',
        ], function () {
            Route::get('/place', [BasketController::class, 'basketPlace'])->name('basketPlace');
            Route::get('/', [BasketController::class, 'basket'])->name('basket');
            Route::post('/place', [BasketController::class, 'basketConfirm'])->name('basketConfirm');
            Route::post('/delete/{sku}', [BasketController::class, 'removeFromBasket'])->name('removeFromBasket');
            Route::post('/coupon', [BasketController::class, 'setCoupon'])->name('setCoupon');
        });

    });

    Route::get('/{category}/{product}/{sku}', [MainController::class, 'sku'])->name('sku');


});




