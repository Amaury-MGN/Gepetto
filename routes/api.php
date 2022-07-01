<?php


use Illuminate\Support\Facades\Route;



Route::group(['middleware' => 'auth:sanctum'], function () {
    // Payment Stripe
    Route::get('/stripe', 'API\StripePaymentController@stripe');
    Route::post('/stripe', 'API\StripePaymentController@stripePost');
    // Tickets
    Route::post('/ticket', 'API\ticketController@store');
    Route::get('/tickets', 'API\ticketController@index');
    Route::get('/ticketsSearch', 'API\ticketController@indexSearch');
    Route::get('/tickets/{id}', 'API\ticketController@show');
    Route::patch('/ticketUpdate/{id}', 'API\ticketController@update')->middleware('IsAdmin');

    // Orders
    Route::post('/orders', 'API\OrderController@store');
    Route::get('/orders', 'API\OrderController@index');
    Route::get('/ordersSearch', 'API\OrderController@indexSearch');
    Route::get('/orders/{id}', 'API\OrderController@show');
    Route::patch('/ordersUpdate/{id}', 'API\OrderController@update')->middleware('IsAdmin');

    // Estimates
    Route::post('/estimates', 'API\EstimateController@store');
    Route::get('/estimates', 'API\EstimateController@index');
    Route::get('/estimatesSearch', 'API\EstimateController@indexSearch');
    Route::get('/estimates/{id}', 'API\EstimateController@show');
    Route::patch('/estimates/{id}', 'API\EstimateController@update');
    Route::Delete('/estimatesUpdate/{id}', 'API\EstimateController@delete')->middleware('IOrAdmin');

    // Users
    Route::get('/users', 'API\UserController@index')->middleware('IsAdmin');
    Route::get('/usersSearch', 'API\UserController@indexSearch')->middleware('IsAdmin');
    Route::get('/user/{id}', 'API\UserController@show');
    // Route::get('/userModal/{id}', 'API\UserController@showModal');
    Route::get('/userRole', 'API\UserController@guardRole');


    // DDL files
    Route::get('/estimateUserDownload/{id}', 'API\FileController@estimateUserDownload')->middleware('IOrAdmin');
    Route::get('/estimateAdminDownload/{id}', 'API\FileController@estimateAdminDownload');

    Route::get('/estimateAdminFile/{id}', 'API\EstimateAdminController@show');
    Route::post('/estimateAdminFile/{id}', 'API\EstimateAdminController@store')->middleware('IOrAdmin');

    // Patch imgs and Posts from the static Website
    Route::get('/posts', 'API\PostController@index')->middleware('IsAdmin');
    Route::post('/post/{id}', 'API\PostController@update')->middleware('IsAdmin');
    Route::post('/imagesWebsites/{id}', 'API\ImagesWebsiteController@update')->middleware('IsAdmin');

    // All image DB routes
    Route::post('/imagesStorages', 'API\ImagesStorageController@store')->middleware('IsAdmin');
    Route::get('/imagesStorages', 'API\ImagesStorageController@index')->middleware('IsAdmin');

    // Only the images on the website at the moment
    Route::get('/imagesWebsites', 'API\imagesWebsiteController@index')->middleware('IsAdmin');
});
// Authentification
Route::prefix('auth')->group(function () {
    Route::post('/register', 'API\AuthController@register');
    Route::post('/adminRegister', 'API\AuthController@AdminRegister')->middleware('auth:sanctum', 'IsAdmin');;
    Route::post('/login', 'API\AuthController@login');
    Route::post('/logout', 'API\AuthController@logout')->middleware('auth:sanctum');
    Route::post('/editInformations/{id}', 'API\AuthController@update')->middleware('auth:sanctum');
    // Route::get('refresh', 'API\AuthController@refresh');

});


// Route::post('/posts', 'API\PostController@store')->middleware('IsAdmin');
Route::get('/post/{id}', 'API\PostController@show');
// Route::post('/imagesWebsites', 'API\ImagesWebsiteController@store')->middleware('IsAdmin');
Route::get('/imagesWebsite/{id}', 'API\ImagesWebsiteController@show');
