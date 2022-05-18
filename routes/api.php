<?php
Route::group([
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('signup', 'AuthController@signup');
    Route::post('me', 'AuthController@me');
});

Route::apiResource('/employee', 'Api\EmployeeController');
Route::apiResource('/supplier', 'Api\SupplierController');
Route::apiResource('/category', 'Api\CategoryController');
Route::apiResource('/product', 'Api\ProductController');
Route::apiResource('/expense', 'Api\ExpenseController');
Route::apiResource('/customer', 'Api\CustomerController');

// Salary routes:
Route::Post('/salary/paid/{id}', 'Api\SalaryController@Paid');
Route::Get('/salary', 'Api\SalaryController@AllSalary');
Route::Get('/salary/view/{id}', 'Api\SalaryController@ViewSalary');
Route::Get('/salary/edit/{id}', 'Api\SalaryController@EditSalary');
Route::patch('/salary/update/{id}', 'Api\SalaryController@UpdateSalary');

// POS
Route::Get('/getting/product/{id}', 'Api\PosController@GetProduct');
Route::Get('/today/sell', 'Api\PosController@todaySell');
Route::Get('/today/income', 'Api\PosController@TodayIncome');
Route::Get('/today/due', 'Api\PosController@TodayDue');
Route::Get('/today/expense', 'Api\PosController@TodayExpense');
Route::Get('/off/stock', 'Api\PosController@OffStock');

// Adding-Cart routes: 
Route::Get('/add/cart/{id}', 'Api\CartController@AddToCart');
Route::Get('/get/cart', 'Api\CartController@getCart');
Route::Get('/delete/cart/{id}', 'Api\CartController@deleteCart');
Route::Get('/increment/cart/{id}', 'Api\CartController@increment');
Route::Get('/decrement/cart/{id}', 'Api\CartController@decrement');

// Vat
Route::Get('/vat', 'Api\CartController@vat');
Route::Post('/orderdone', 'Api\PosController@OrderDone');     

// Order && Order-search
Route::Get('/order', 'Api\OrderController@TodayOrder');
Route::Get('/order/view/{id}', 'Api\OrderController@ViewOrder');
Route::Get('/order/view/all/{id}', 'Api\OrderController@ViewOrderAll');
Route::Post('/search/order', 'Api\OrderController@SearchOrder');


