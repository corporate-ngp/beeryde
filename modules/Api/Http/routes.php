<?php
Route::group(['prefix' => 'api', 'namespace' => 'Modules\Api\Http\Controllers', 'middleware' => 'authorise'], function() {
    
    Route::get('verify/email/{token}', ['as' => 'confirmation_path', 'uses' => 'UserController@confirmEmail']);
});

Route::group(['prefix' => 'api/v1', 'namespace' => 'Modules\Api\Http\Controllers', 'middleware' => ['authorise']], function() {
    // $user_id = \Authorizer::getResourceOwnerId();

    # users related 
    Route::post('users/login', ['as' => 'api.users.login', 'uses' => 'UserController@login']);
    Route::post('users/logout', ['as' => 'api.users.logout', 'uses' => 'UserController@logout']);
    Route::post('users/sendemail', ['as' => 'api.users.sendemail', 'uses' => 'UserController@sendEmail']);
    Route::post('users/sendotp', ['as' => 'api.users.sendotp', 'uses' => 'UserController@sendOtp']);
    Route::resource('users', 'UserController');
    

    # site content pages
    Route::resource('pages', 'PagesController');
       
    # car brands
    Route::resource('car-brands', 'CarBrandsController');
    
    # car brand models
    Route::resource('car-models', 'CarModelsController');
    
    # user cars
    Route::resource('cars', 'CarsController');
    
    # ride sharing
    Route::resource('rides', 'RideController');
    
});
