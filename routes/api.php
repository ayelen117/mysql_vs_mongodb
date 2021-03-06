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

Route::resource('users', 'UserController');
Route::resource('currencies', 'CurrencyController');
Route::resource('companies', 'CompanyController');
Route::resource('responsibilities', 'ResponsibilityController');
Route::resource('identifications', 'IdentificationController');
Route::resource('receipts', 'ReceiptController');
Route::resource('categories', 'CategoryController');
Route::resource('fiscalpos', 'FiscalposController');
Route::resource('products', 'ProductController');
Route::resource('pricelists', 'PricelistController');
Route::resource('entities', 'EntityController');
Route::resource('inventories', 'InventoryController');
Route::resource('documents', 'DocumentController');
Route::resource('details', 'DetailController');
Route::resource('transactions', 'TransactionController');
Route::get('/getTotal', 'Controller@getTotal');