<?php


use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BasketController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\MainController;
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
Route::get('/logout', [LoginController::class, 'logout'])->name('get-logout');
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
        });

    });
});



Route::get('/', [MainController::class, 'index'])->name('home.index');
Route::get('/categories', [MainController::class, 'categories'])->name('categories');
Route::get('/categories/{category}', [MainController::class, 'category'])->name('category');

Route::group(['prefix' => 'basket'], function (){
    Route::post('/add/{id}', [BasketController::class, 'addToBasket'])->name('addToBasket');
    Route::group([
        'middleware' => 'basket_not_empty',
    ], function () {
        Route::get('/place', [BasketController::class, 'basketPlace'])->name('basketPlace');
        Route::get('/', [BasketController::class, 'basket'])->name('basket');
        Route::post('/place', [BasketController::class, 'basketConfirm'])->name('basketConfirm');
        Route::post('/delete/{id}', [BasketController::class, 'removeFromBasket'])->name('removeFromBasket');
    });

});

Route::get('/{category}/{product}', [MainController::class, 'product'])->name('product');




