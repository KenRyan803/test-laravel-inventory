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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();
Route::get('/', 'HomeController@index')->name('home');

Route::get('profiles/getinfo', 'ProfileController@getinfo');
Route::post('profiles/{id}', 'ProfileController@update');
Route::get('customer/get_customer_list', 'CustomerController@get_customer_list');
Route::get('customer/get_transactions_list/{customer_id}', 'CustomerController@get_transactions_list');
Route::get('customer/get_invoice_details/{invoice_no}', 'CustomerController@get_invoice_details');
Route::get('customer/get_customer_invoice_details/{invoice_no}', 'CustomerController@get_customer_invoice_details');
Route::get('pointofsale/get_customers', 'POSController@get_customers');
Route::get('pointofsale/get_product_listing', 'POSController@get_product_listing');
Route::get('pointofsale/get_sales_transaction_no', 'POSController@get_sales_transaction_no');
Route::get('product_category/get_category', 'ProductCategoryController@get_product_category');
Route::get('product/get_product_list', 'ProductController@get_product_list');
Route::get('product/get_product_info_list/{barcode_no}', 'ProductController@get_product_info_list');
Route::get('product/get_product_details/{barcode_no}', 'ProductController@get_product_details');
Route::get('product/get_product_info_latest_details/{barcode_no}', 'ProductController@get_product_info_latest_details');
Route::post('product/update_status', 'ProductController@update_status');
Route::get('stockentry/get_recent_stock_entry', 'StockEntryController@get_recent_stock_entry');
Route::get('view_stockentry/get_stock_entry', 'ViewStockEntryController@get_stock_entry');
Route::get('view_stockentry/get_stock_entry_details/{stock_entry_no}', 'ViewStockEntryController@get_stock_entry_details');
Route::get('view_stockentry/get_stock_entry_list/{stock_entry_no}', 'ViewStockEntryController@get_stock_entry_list');
Route::get('supplier/get_supplier_list', 'SupplierController@get_supplier_list');
Route::get('supplier/get_supplier_list_cmb', 'SupplierController@get_supplier_list_cmb');
Route::get('invoice/get_invoices', 'InvoicesController@get_invoices');
Route::get('invoice/get_invoice_transaction/{invoice_no}', 'InvoicesController@get_invoice_transaction');
Route::get('invoice/get_invoice_transaction_details/{invoice_no}', 'InvoicesController@get_invoice_transaction_details');
Route::get('systemlog/getauth', 'MiscController@getauth');
Route::get('systemlog/getlogs', 'MiscController@getlogs');

Route::resources([
    'invoice' => 'InvoicesController',
    'profiles' => 'ProfileController',
    'systemlog' => 'MiscController',
    'pointofsale' => 'POSController',
    'product_category' => 'ProductCategoryController',
    'product' => 'ProductController',
    'stockentry' => 'StockEntryController',
    'view_stockentry' => 'ViewStockEntryController',
    'supplier' => 'SupplierController',
]);

// Route::get('{path}', 'HomeController@index')->where('path', '([A-z\d\-\/_.]+)?');
Route::get('/{any}', 'HomeController@index')->where('any', '.*');