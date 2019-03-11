<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard.index');
});
/**
 * Auth routes
 */
Route::group(['namespace' => 'Auth'], function () {

    // Authentication Routes...
    Route::get('login', 'LoginController@showLoginForm')->name('login');
    Route::post('login', 'LoginController@login');
    Route::get('logout', 'LoginController@logout')->name('logout');

    // Registration Routes...
    if (config('auth.users.registration')) {
        Route::get('register', 'RegisterController@showRegistrationForm')->name('register');
        Route::post('register', 'RegisterController@register');
    }

    // Password Reset Routes...
    Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'ResetPasswordController@reset');

    // Confirmation Routes...
    if (config('auth.users.confirm_email')) {
        Route::get('confirm/{user_by_code}', 'ConfirmController@confirm')->name('confirm');
        Route::get('confirm/resend/{user_by_email}', 'ConfirmController@sendEmail')->name('confirm.send');
    }

    // Social Authentication Routes...
//    Route::get('social/redirect/{provider}', 'SocialLoginController@redirect')->name('social.redirect');
//    Route::get('social/login/{provider}', 'SocialLoginController@login')->name('social.login');
});

/**
 * Backend routes
 */
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin'], function () {

    // Dashboard
    Route::get('/', 'DashboardController@index')->name('dashboard');

});

//Users
Route::get('users', 'UserController@index');
Route::get('users/{user}', 'UserController@show');
Route::get('users/{user}/edit', 'UserController@edit');
Route::put('users/{user}', 'UserController@update');
Route::delete('users/{user}', 'UserController@destroy');
//Route::get('permissions', 'PermissionController@index')->name('permissions');
//Route::get('permissions/{user}/repeat', 'PermissionController@repeat')->name('permissions.repeat');

Route::get('/', 'HomeController@index');

Route::get('users', 'UserController@dashboard')->name('users.dashboard');
Route::get('companies', 'CompanyController@dashboard')->name('companies.dashboard');
Route::get('categories', 'CategoryController@dashboard')->name('categories.dashboard');
Route::get('pricelists', 'PricelistController@dashboard')->name('pricelists.dashboard');
Route::get('entities', 'EntityController@dashboard')->name('entities.dashboard');
Route::get('products', 'ProductController@dashboard')->name('products.dashboard');
Route::get('documents', 'DocumentController@dashboard')->name('documents.dashboard');
Route::get('fiscalpos', 'FiscalposController@dashboard')->name('fiscalpos.dashboard');
//Route::get('models', 'HomeController@dashboard')->name('home.models');
Route::get('models', 'FiscalposController@models')->name('home.models');

/**
 * Membership
 */
//Route::group(['as' => 'protection.'], function () {
//    Route::get('membership', 'MembershipController@index')->name('membership')->middleware('protection:' . config('protection.membership.product_module_number') . ',protection.membership.failed');
//    Route::get('membership/access-denied', 'MembershipController@failed')->name('membership.failed');
//    Route::get('membership/clear-cache/', 'MembershipController@clearValidationCache')->name('membership.clear_validation_cache');
//});
