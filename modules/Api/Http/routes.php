<?php
Route::group(['prefix' => 'api/v1', 'namespace' => 'Modules\Api\Http\Controllers'], function() {
    // $user_id = \Authorizer::getResourceOwnerId();

    Route::resource('users', 'UserController');
    
    Route::resource('pages', 'PagesController');
});
