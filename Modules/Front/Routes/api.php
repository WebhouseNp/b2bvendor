<?php

use Illuminate\Http\Request;
use Modules\Front\Http\Controllers\CheckoutController;
use Modules\Front\Http\Controllers\CustomerApiController;
use Modules\Front\Http\Controllers\NewArrivalsProductApiController;
use Modules\Front\Http\Controllers\OrderApiController;
use Modules\User\Http\Controllers\ProfileController;

Route::middleware('auth:api')->get('/front', function (Request $request) {
    return $request->user();
});

// Products
Route::get('/products', 'ProductApiController@index');
Route::get('/products/{slug}', 'ProductApiController@show');
Route::get('/p/new-arrivals-products', [NewArrivalsProductApiController::class, 'index']);
Route::get('/p/new-arrivals', [NewArrivalsProductApiController::class, 'getNewArrivals']);
Route::get('/p/top-products', 'ProductApiController@getTopProducts');
Route::get('/p/sasto-wholesale-mall-products', 'ProductApiController@sastoWholesaleMallProducts');
Route::get('/p/you-may-like-products', 'ProductApiController@youMayLike');

Route::get('/products/{product_id}/images', 'ProductImageApiController@index');

Route::get('/vendors', 'VendorApiController@index');
Route::get('/vendors/{vendor}', 'VendorApiController@show');
Route::get('/vendors/find-by-user-id/{userId}', 'VendorApiController@showByUserId');
Route::get('/v/latest-suppliers', 'VendorApiController@getLatestVendors');

//customer
// Route::get('/profile/{profile}', 'CustomerApiController@show');

Route::get('/getsastowholesaleproducts', 'FrontController@getSastoWholeSaleProducts');

Route::get('/getallproducts', 'FrontController@getAllProducts');
Route::get('/getcategoryproducts/{categoryslug}', 'FrontController@getCategoryProducts');
Route::get('/getsubcategoryproducts/{slug}', 'FrontController@getSubcategoryProducts');
// Route::get('/getsubcategoryproducts/{categoryslug}', 'FrontController@getSubCategoryroducts');
Route::get('vendorproducts/{username}', 'FrontController@getVendorProducts');
Route::get('vendorcategories/{username}', 'FrontController@getVendorCategories');
Route::get('vendorsubcategories/{username}/{slug}', 'FrontController@getVendorSubcategoryProducts');
Route::get('getVendorCategoryProducts/{username}/{slug}', 'FrontController@getVendorCategoryProducts');

Route::get('/suppliers', 'SearchController@index');
Route::get('allcategories', 'FrontController@allcategories'); // Not in use since we were pulling a lot more than we need
Route::get('categories', 'CategoryApiController@index');
Route::get('vendor-category', 'CategoryApiController@vendorCatgeory');
Route::get('megamenu', 'CategoryApiController@megamenu');
Route::get('hot-categories', 'CategoryApiController@hotCategories');

Route::post('quotation', 'QuotationController@store')->name('quotation.store');
Route::post('product-search', 'SearchController@productSearch')->name('product.search');

//cart part
Route::get('add-to-cart', [CartController::class, 'addToCart'])->name('add.to.cart');
Route::get('/delete/{id}', [CartController::class, 'DeleteCart'])->name('delete-cart');
// Route::patch('update-cart', [CartController::class, 'update'])->name('update.cart');
// Route::delete('remove-from-cart', [CartController::class, 'remove'])->name('remove.from.cart');

// customer address
Route::get('my-address', [ProfileController::class, 'getAddress'])->middleware('auth:api');

// Checkout
Route::post('checkout', [CheckoutController::class, 'store'])->middleware('auth:api');
Route::get('customer/orders', [OrderApiController::class, 'index'])->middleware('auth:api');
Route::get('customer/orders/{order}', [OrderApiController::class, 'show'])->middleware('auth:api');

//category for vendor
Route::get('vendor-category', 'CategoryApiController@vendorCatgeory');

