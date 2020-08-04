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
});

Auth::routes(['verify' => true]);

Route::middleware(['verified'])->group(function () {
    Route::get('/home', 'HomeController@index')->name('user.dashboard');
});

// Route::get('/home', 'HomeController@index')->name('user.dashboard');
Route::post('/user/logout', 'Auth\LoginController@userLogout')->name('user.logout');



Route::prefix('/admin')->group(function(){

    //Login Routes
    Route::get('/login', 'Auth\AdminLoginController@showloginform')->name('admin.login');
    Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
    Route::post('/logout','Auth\AdminLoginController@logout')->name('admin.logout');


    //Forgot Password Routes
    Route::get('/password/reset','Auth\AdminForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
    Route::post('/password/email','Auth\AdminForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');

    //Reset Password Routes
    Route::get('/password/reset/{token}','Auth\AdminResetPasswordController@showResetForm')->name('admin.password.reset');
    Route::post('/password/reset','Auth\AdminResetPasswordController@reset')->name('admin.password.update');

    //Admin Home Page
    Route::get('/', 'AdminController@index')->name('admin.dashboard');

});

Route::get('send-mail', function () {

    $details = [
        'title' => 'Mail from ItSolutionStuff.com',
        'body' => 'This is for testing email using smtp'
    ];

    \Mail::to('sahilofficial671@gmail.com')->send(new \App\Mail\MyTestMail($details));

    dd("Email is Sent.");
});
