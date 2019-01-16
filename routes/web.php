<?php

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
    return view('auth/login');
})->name("base_url");

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/companies', 'CompanyController@index')->name('companies');
    Route::get('get-data-companies', 'CompanyController@getData')->name("get.data.companies");
    Route::get('delete-data-companies', 'CompanyController@deleteRow')->name("get.data.companies.delete");
    Route::post('insert-data-companies', 'CompanyController@store')->name("insert.data.companies");
    Route::post('update-data-companies/{company}', 'CompanyController@update')->name("update.data.companies");

    Route::get('/employees', 'EmployeeController@index')->name('employees');
    Route::get('get-data-employees', 'EmployeeController@getData')->name("get.data.employees");
    Route::get('delete-data-employees', 'EmployeeController@deleteRow')->name("get.data.employees.delete");
    Route::post('insert-data-employees', 'EmployeeController@store')->name("insert.data.employees");
    Route::post('update-data-employees/{employee}', 'EmployeeController@update')->name("update.data.employees");
});
