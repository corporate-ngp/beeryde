<?php

Route::group(['prefix' => 'api', 'namespace' => 'Modules\Api\Http\Controllers'], function() {
    Route::post('oauth/access_token', function() {
        // User try to login or registered           
        $accessToken = \Authorizer::issueAccessToken();
        // $user_id = \Authorizer::getResourceOwnerId();
        return \Response::json($accessToken);
    });
});

Route::group(['prefix' => 'api/v1', 'namespace' => 'Modules\Api\Http\Controllers', 'middleware' => 'oauth'], function() {
    // $user_id = \Authorizer::getResourceOwnerId();

    Route::resource('users', 'UserController', array('only' => array('update')));

    Route::post('users/updatephone', array('as' => 'users.updatephone', 'uses' => 'UserController@updatePhone'));
});
