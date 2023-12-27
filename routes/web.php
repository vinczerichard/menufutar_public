<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

// Anybody
Auth::routes();
Route::get('logout', 'AuthController@logout');
Route::get('aboutus', 'PageContentController@aboutus');
Route::get('contact', 'PageContentController@contact');

Route::post('postlogin', 'AuthController@postLogin');
Route::post('registration', 'AuthController@postRegistration');
Route::post('verifycoderesend', 'AuthController@verifyCodeResend');
Route::post('forgotpasscode', 'AuthController@forgotPassCodeSend');
Route::get('resetpass/{id}/{hash}', 'AuthController@forgotPassChange');
Route::post('savenewpass', 'AuthController@saveNewPass');
Route::get('authcheck', 'AuthController@check');

Route::get('/', 'HomeController@index');
Route::get('home', 'HomeController@index');
Route::get('location/{id}', 'LocationController@change');
Route::get('getlocations', 'LocationController@getlocations');
Route::get('purgelocation', 'LocationController@purgelocation');
Route::get('miskolc', 'LocationController@miskolc');
Route::get('kazincbarcika', 'LocationController@kazincbarcika');
Route::get('eger', 'LocationController@eger');
Route::get('location', 'LocationController@index');

Route::get('citybylocation/{id}', 'AddressController@citybylocation');
Route::get('streetbycity/{id}', 'AddressController@streetbycity');

Route::resource('menu', 'MenuController');

// Simple Users
Route::resource('myaddresses', 'UserAddressController')->middleware('auth');

// Admin Users
Route::resource('pagecontent', 'PageContentController')->middleware('can:isAdmin');
Route::resource('menueditor', 'MenuEditorController')->middleware('can:isAdmin');
Route::post('menueditor/list', 'MenuEditorController@getlist')->middleware('can:isAdmin');
Route::resource('deliveryroute', 'DeliveryRouteController')->middleware('can:isAdmin');
Route::resource('users', 'UserController')->middleware('can:isAdmin');
Route::post('users/get', 'UserController@getData')->middleware('can:isAdmin');
Route::get('getRolePermission/{id}', 'RolePermissionController@getRolePermission')->middleware('can:isAdmin');
Route::get('getUserPermission/{id}', 'UserPermissionController@getUserPermission')->middleware('can:isAdmin');
Route::resource('permissions', 'PermissionController')->middleware('can:isAdmin');
Route::resource('roles', 'RoleController')->middleware('can:isAdmin');
Route::resource('units', 'UnitController')->middleware('can:isAdmin');
Route::resource('stores', 'StoreController')->middleware('can:isAdmin');
Route::resource('rolepermissions', 'RolePermissionController')->middleware('can:isAdmin');
Route::resource('userpermissions', 'UserPermissionController')->middleware('can:isAdmin');

//Route::get('test', 'TestController@index')->middleware('can:isAdmin');
//Route::get('test2', 'TestController@create')->middleware('can:isAdmin');

