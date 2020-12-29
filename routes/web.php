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

//Auth::routes(['verify' => true]);
Route::get('register/{invitingKey?}', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('password/confirm', 'Auth\ConfirmPasswordController@showConfirmForm')->name('password.confirm');
Route::post('password/confirm', 'Auth\ConfirmPasswordController@confirm');
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
Route::post('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');
Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
Route::get('email/verify/{id}/{hash}', 'Auth\VerificationController@verify')->name('verification.verify');


Route::get('/', 'HomeController@index')->name('home');

Route::get('/user', 'UsersController@index')->name('user.index')->middleware(['auth','verified']);
Route::get('/user/edit', 'UsersController@edit')->name('user.edit')->middleware(['auth','verified']);
Route::patch('/user', 'UsersController@update')->name('user.update')->middleware(['auth','verified']);
Route::get('/user/{user}/items', 'UsersController@items')->name('user.items');
Route::delete('/user/{user}', 'UsersController@destroy')->name('user.destroy')->middleware(['auth','verified']);

Route::get('/invitation', 'InvitationsController@index')->name('invitation.index')->middleware(['auth','verified']);

Route::get('/address/edit', 'AddressesController@edit')->name('address.edit');
Route::patch('/address', 'AddressesController@update')->name('address.update');

Route::get('/item/create', 'ItemsController@create')->name('item.create')->middleware(['auth','verified']);
Route::post('/item', 'ItemsController@store')->name('item.store')->middleware(['auth','verified']);
Route::get('/item/{item}', 'ItemsController@show')->name('item.show');
Route::get('/item/{item}/edit', 'ItemsController@edit')->name('item.edit');
Route::get('/item/{item}/transfer', 'ItemsController@transfer')->name('item.transfer');
Route::patch('/item/{item}', 'ItemsController@update')->name('item.update');
Route::get('/item/{item}/buy', 'ItemsController@buy')->name('item.buy')->middleware(['auth','verified']);
Route::delete('/item/{item}', 'ItemsController@destroy')->name('item.destroy');
Route::get('/item/{item}/restore', 'ItemsController@restore')->name('item.restore');

Route::get('/transaction/{transaction}/deliveryAddress/create', 'DeliveryAddressesController@create')->name('deliveryAddress.create');
Route::post('/transaction/{transaction}/deliveryAddress', 'DeliveryAddressesController@store')->name('deliveryAddress.store');

Route::get('/transaction/{transaction}/confirm', 'TransactionsController@confirm')->name('transaction.confirm');
Route::post('/transaction/{transaction}', 'TransactionsController@save')->name('transaction.save');
Route::get('/transaction/{transaction}', 'TransactionsController@show')->name('transaction.show');
Route::delete('/transaction/{transaction}', 'TransactionsController@destroy')->name('transaction.destroy');

Route::get('/category/create', 'CategoriesController@create')->name('category.create');
Route::post('/category', 'CategoriesController@store')->name('category.store');
Route::get('/category/{category}', 'CategoriesController@show')->name('category.show');
Route::get('/category', 'CategoriesController@index')->name('category.index');
Route::get('/category/{category}/edit', 'CategoriesController@edit')->name('category.edit');
Route::patch('/category/{category}', 'CategoriesController@update')->name('category.update');
Route::delete('/category/{category}', 'CategoriesController@destroy')->name('category.destroy');

Route::get('/transaction/{transaction}/claim/create', 'ClaimsController@create')->name('claim.create');
Route::post('/transaction/{transaction}/claim', 'ClaimsController@store')->name('claim.store');
Route::get('/claim', 'ClaimsController@index')->name('claim.index');
Route::get('/claim/{claim}', 'ClaimsController@show')->name('claim.show');
Route::get('/claim/{claim}/edit', 'ClaimsController@edit')->name('claim.edit');
Route::patch('/claim/{claim}', 'ClaimsController@update')->name('claim.update');

Route::get('/transaction/{transaction}/comment/create', 'CommentsController@create')->name('comment.create');
Route::get('/user/{user}/comments', 'CommentsController@show')->name('comment.show');
Route::get('/search','SearchController@index')->name('search');
Route::get('/searchInCategory/{category}','SearchInCategoryController@search')->name('searchInCategory');

Route::get('/accounts', 'AccountsController@index')->name('accounts.index');
Route::patch('/accounts/{user}', 'AccountsController@update')->name('accounts.update');
Route::patch('/accounts/mail/{user}', 'AccountsController@sendMail')->name('accounts.send-mail');

Route::get('/transaction/{transaction}/comment/create', 'CommentsController@create')->name('comment.create');
Route::post('/transaction/{transaction}/comment', 'CommentsController@store')->name('comment.store');
Route::get('/comment/{comment}', 'CommentsController@show')->name('comment.show');
Route::get('/comment/{user}/usercomments', 'CommentsController@usercomments')->name('comment.usercomments');

Route::get('/message/{user}/message/create', 'MessageController@create')->name('message.create');
Route::post('/message/{user}/message', 'MessageController@store')->name('message.store');
Route::get('/inbox', 'MessageController@show')->name('message.show');
Route::get('/inbox/{conversation}', 'MessageController@showConversation')->name('message.conversation');
Route::post('/message/{conversation}', 'MessageController@store2')->name('message.store2');







