<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/front', function (Request $request) {
    return $request->user();
});

// Products
Route::get('/products', 'ProductApiController@index');
Route::get('/products/{product:slug}', 'ProductApiController@show');

Route::get('/getsastowholesaleproducts', 'FrontController@getSastoWholeSaleProducts');
Route::get('/gettopproducts', 'FrontController@getTopProducts');
Route::get('/getnewarrivalproducts', 'FrontController@getNewArrivalProducts');
Route::get('/gethotcategoriesproducts', 'FrontController@getHotCategoriesProducts');
Route::get('/getallproducts', 'FrontController@getAllProducts');
Route::get('/getcategoryproducts/{categoryslug}', 'FrontController@getCategoryProducts');
Route::get('/getsubcategoryproducts/{slug}', 'FrontController@getSubcategoryProducts');
// Route::get('/getsubcategoryproducts/{categoryslug}', 'FrontController@getSubCategoryroducts');
Route::get('vendorproducts/{username}', 'FrontController@getVendorProducts');
Route::get('vendorcategories/{username}', 'FrontController@getVendorCategories');
Route::get('vendorsubcategories/{username}/{slug}', 'FrontController@getVendorSubcategoryProducts');
Route::get('getVendorCategoryProducts/{username}/{slug}', 'FrontController@getVendorCategoryProducts');

Route::get('/suppliers', 'SearchController@index');
Route::get('allvendor', 'FrontController@getVendors');
Route::get('allcategories', 'FrontController@allcategories');
Route::post('quotation', 'QuotationController@store')->name('quotation.store');
Route::post('product-search', 'SearchController@productSearch')->name('product.search');

//cart part
Route::get('add-to-cart', [CartController::class, 'addToCart'])->name('add.to.cart');
Route::get('/delete/{id}', [CartController::class, 'DeleteCart'])->name('delete-cart');
// Route::patch('update-cart', [CartController::class, 'update'])->name('update.cart');
// Route::delete('remove-from-cart', [CartController::class, 'remove'])->name('remove.from.cart');
