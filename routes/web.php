<?php

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

Route::get('/', function () {
    return view('welcome');
})->name('root');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/products/search', [App\Http\Controllers\ProductSearchController::class, 'index'])->name('products.search');
Route::get('/product/view/{id}', [App\Http\Controllers\ProductSearchController::class, 'view'])->name('product.view');

Auth::routes();

Route::post('login', [App\Http\Controllers\Auth\LoginController::class, 'postLogin'])->name('login.post');

Route::group(['middleware' => 'auth'], function() {

    Route::post('/add_to_cart', [App\Http\Controllers\CartController::class, 'add'])->name('add_to_cart');
    // Route::post('/update_cart_item', [App\Http\Controllers\CartController::class, 'update'])->name('update_cart_item');
    Route::post('/remove_cart_item', [App\Http\Controllers\CartController::class, 'remove'])->name('remove_cart_item');
    Route::get('/cart', [App\Http\Controllers\CartController::class, 'cart'])->name('cart');
    Route::get('/checkout', [App\Http\Controllers\CartController::class, 'checkout'])->name('checkout');
    Route::post('/make_payment', [App\Http\Controllers\PaymentController::class, 'make_payment'])->name('make_payment');

    Route::get('/orders', [App\Http\Controllers\UserController::class, 'orders'])->name('orders');
    Route::get('/order/summary/{id}', [App\Http\Controllers\UserController::class, 'order_summary'])->name('order.view');

    Route::get('/products', [App\Http\Controllers\ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [App\Http\Controllers\ProductController::class, 'create'])->name('products.create');
    Route::post('/products/store', [App\Http\Controllers\ProductController::class, 'store'])->name('products.store');
    Route::get('/products/edit/{id}', [App\Http\Controllers\ProductController::class, 'edit'])->name('products.edit');
    Route::post('/products/update', [App\Http\Controllers\ProductController::class, 'update'])->name('products.update');
    Route::post('/products/delete', [App\Http\Controllers\ProductController::class, 'delete'])->name('products.delete');

});



// Admin Routes
Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::get('/login', [App\Http\Controllers\Admin\AdminAuthController::class, 'getLogin'])->name('adminLogin');
    Route::post('/login', [App\Http\Controllers\Admin\AdminAuthController::class, 'postLogin'])->name('adminLoginPost');
 
    Route::group(['middleware' => 'adminauth'], function () {
        // Route::get('/', function () {
        //     return view('vendor.adminlte.dashboard');
        // })->name('adminDashboard');

        Route::get('/', [App\Http\Controllers\Admin\AdminAuthController::class, 'adminDashboard'])->name('adminDashboard');
        Route::get('/logout', [App\Http\Controllers\Admin\AdminAuthController::class, 'adminLogout'])->name('adminLogout');


        Route::get('/users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('admin.users.index');
        Route::get('/users/create', [App\Http\Controllers\Admin\UserController::class, 'create'])->name('admin.users.create');
        Route::post('/users/store', [App\Http\Controllers\Admin\UserController::class, 'store'])->name('admin.users.store');
        Route::get('/users/edit/{id}', [App\Http\Controllers\Admin\UserController::class, 'edit'])->name('admin.users.edit');
        Route::post('/users/update', [App\Http\Controllers\Admin\UserController::class, 'update'])->name('admin.users.update');
        Route::post('/users/delete', [App\Http\Controllers\Admin\UserController::class, 'delete'])->name('admin.users.delete');

        Route::get('/categories', [App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('admin.categories.index');
        Route::get('/categories/create', [App\Http\Controllers\Admin\CategoryController::class, 'create'])->name('admin.categories.create');
        Route::post('/categories/store', [App\Http\Controllers\Admin\CategoryController::class, 'store'])->name('admin.categories.store');
        Route::get('/categories/edit/{id}', [App\Http\Controllers\Admin\CategoryController::class, 'edit'])->name('admin.categories.edit');
        Route::post('/categories/update', [App\Http\Controllers\Admin\CategoryController::class, 'update'])->name('admin.categories.update');
        Route::post('/categories/delete', [App\Http\Controllers\Admin\CategoryController::class, 'delete'])->name('admin.categories.delete');

        Route::get('/products', [App\Http\Controllers\Admin\ProductController::class, 'index'])->name('admin.products.index');
        Route::get('/products/create', [App\Http\Controllers\Admin\ProductController::class, 'create'])->name('admin.products.create');
        Route::post('/products/store', [App\Http\Controllers\Admin\ProductController::class, 'store_product'])->name('admin.products.store');
        Route::get('/products/edit/{id}', [App\Http\Controllers\Admin\ProductController::class, 'edit'])->name('admin.products.edit');
        Route::post('/products/update', [App\Http\Controllers\Admin\ProductController::class, 'update_product'])->name('admin.products.update');
        Route::post('/products/delete', [App\Http\Controllers\Admin\ProductController::class, 'delete'])->name('admin.products.delete');

        Route::match(['GET', 'POST'], '/settings', [App\Http\Controllers\Admin\SettingController::class, 'index'])->name('admin.settings.index');

        Route::get('/orders', [App\Http\Controllers\Admin\OrderController::class, 'index'])->name('admin.orders.index');
        Route::get('/order/summary/{id}', [App\Http\Controllers\Admin\OrderController::class, 'summary'])->name('admin.order.summary');

    });
});
