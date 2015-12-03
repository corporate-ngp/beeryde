<?php
//Admin user management basic
Route::group(['prefix' => 'admin', 'namespace' => 'Modules\Admin\Http\Controllers', 'before' => 'auth'], function() {
    Route::get('/', ['uses' => 'DashboardController@index', 'permission' => 'index']);
    Route::get('/dashboard', ['uses' => 'DashboardController@index', 'permission' => 'index']);

// user management
    Route::get('user/data', ['as' => 'admin.user.apilist', 'uses' => 'UserController@getData', 'permission' => 'index']);
    Route::get('user/trashed', ['as' => 'admin.user.trashedlisting.index', 'uses' => 'UserController@trashed', 'permission' => 'index']);
    Route::get('user/trashed-data', ['as' => 'admin.user.apitrashedlist.index', 'uses' => 'UserController@getTrashedData', 'permission' => 'index']);
    Route::get('user/links', ['as' => 'admin.user.apiuserlinks.index', 'uses' => 'UserController@getUserLinks', 'permission' => 'index']);
    Route::post('user/group-action', ['as' => 'admin.user.groupaction', 'uses' => 'UserController@groupAction', 'permission' => 'update']);
    Route::post('user/check-avalability', ['as' => 'admin.user.checkfieldavalability.update', 'uses' => 'UserController@checkAvalability', 'permission' => 'update']);
    Route::resource('user', 'UserController');

// link category
    Route::get('link-category/data', ['as' => 'admin.link-category.apilist', 'uses' => 'LinkCategoryController@getData', 'permission' => 'index']);
    Route::post('link-category/group-action', ['as' => 'admin.link-category.groupaction', 'uses' => 'LinkCategoryController@groupAction', 'permission' => 'update']);
    Route::resource('link-category', 'LinkCategoryController');

// Permission Link Management
    Route::get('links/data', ['as' => 'admin.links.apilist', 'uses' => 'LinksController@getData', 'permission' => 'index']);
    Route::post('links/group-action', ['as' => 'admin.links.groupaction', 'uses' => 'LinksController@groupAction', 'permission' => 'update']);
    Route::resource('links', 'LinksController');

// Login Process
    Route::post('auth/authenticate', ['as' => 'admin.auth.authenticate', 'uses' => 'Auth\AuthController@authUsername', 'permission' => 'index']);

//manage ipadresses
    Route::get('ipaddress/data', ['as' => 'admin.ipaddress.apilist', 'uses' => 'IpAddressController@getData', 'permission' => 'index']);
    Route::post('ipaddress/group-action', ['as' => 'admin.ipaddress.groupaction', 'uses' => 'IpAddressController@groupAction', 'permission' => 'update']);
    Route::resource('ipaddress', 'IpAddressController');

// Configuration setting management
    Route::get('config-settings/data', ['as' => 'admin.config-settings.list', 'uses' => 'ConfigSettingController@getData', 'permission' => 'index']);
    Route::resource('config-settings', 'ConfigSettingController');

// Configuration Categories Management
    Route::get('config-categories/data', ['as' => 'admin.config-categories.list', 'uses' => 'ConfigCategoryController@getData', 'permission' => 'index']);
    Route::resource('config-categories', 'ConfigCategoryController');

// User Types Management
    Route::get('user-type/data', ['as' => 'admin.user-type.list', 'uses' => 'UserTypeController@getData', 'permission' => 'index']);
    Route::resource('user-type', 'UserTypeController');

// System emails
    Route::resource('system-emails', 'SystemEmailController');

// Pages Management
    Route::get('manage-pages/data', ['as' => 'admin.manage-pages.apilist', 'uses' => 'ManagePagesController@getData', 'permission' => 'index']);
    Route::post('manage-pages/group-action', ['as' => 'admin.manage-pages.groupaction', 'uses' => 'ManagePagesController@groupAction', 'permission' => 'update']);
    Route::resource('manage-pages', 'ManagePagesController');

// User Type Links
    Route::resource('usertype-links', 'UserTypeLinksController');

//manage faq category

    Route::get('faq-categories/data', ['as' => 'admin.faq-categories.list', 'uses' => 'FaqCategoryController@getData', 'permission' => 'index']);
    Route::resource('faq-categories', 'FaqCategoryController');

//manage faq
    Route::get('faqs/data', ['as' => 'admin.faqs.list', 'uses' => 'FaqController@getData', 'permission' => 'index']);
    Route::resource('faqs', 'FaqController');

//admin myprofile
    Route::put('myprofile/update-avatar', ['as' => 'admin.myprofile.update-avatar', 'uses' => 'MyProfileController@updateAvatar', 'permission' => 'update']);
    Route::put('myprofile/change-password', ['as' => 'admin.myprofile.change-password', 'uses' => 'MyProfileController@changePassword', 'permission' => 'update']);
    Route::resource('myprofile', 'MyProfileController');

//manage country category
    Route::get('countries/data', ['as' => 'admin.countries.list', 'uses' => 'CountryController@getData', 'permission' => 'index']);
    Route::resource('countries', 'CountryController');

//manage State
    Route::get('states/data', ['as' => 'admin.states.list', 'uses' => 'StateController@getData', 'permission' => 'index']);
    Route::resource('states', 'StateController');

//manage cities category
    Route::get('cities/stateData/{cid}', ['as' => 'admin.cities.stateList', 'uses' => 'CityController@getStateData', 'permission' => 'index']);
    Route::get('cities/data', ['as' => 'admin.cities.list', 'uses' => 'CityController@getData', 'permission' => 'index']);
    Route::resource('cities', 'CityController');

//manage locations category
    Route::post('locations/data', ['as' => 'admin.locations.list', 'uses' => 'LocationsController@indexFront', 'permission' => 'index']);
    Route::resource('locations', 'LocationsController');

//View User Login Logs
    Route::get('login-logs/data', ['as' => 'admin.login-logs.apilist', 'uses' => 'LoginLogsController@getData', 'permission' => 'index']);
    Route::post('login-logs/group-action', ['as' => 'admin.login-logs.groupaction', 'uses' => 'LoginLogsController@groupAction', 'permission' => 'update']);
    Route::resource('login-logs', 'LoginLogsController');

//file management
    Route::get('filemanager/show', ['as' => 'admin.filemanager.show', 'uses' => 'FilemanagerLaravelController@getShow']);
    Route::get('filemanager/connectors', ['as' => 'admin.filemanager', 'uses' => 'FilemanagerLaravelController@getConnectors']);
    Route::post('filemanager/connectors', ['as' => 'admin.filemanager', 'uses' => 'FilemanagerLaravelController@postConnectors']);
    Route::resource('medias', 'MediasController');

//site management
    Route::get('site-user/data', ['as' => 'admin.site-user.apilist', 'uses' => 'SiteUserController@getData']);
    Route::get('site-user/trashed', ['as' => 'admin.site-user.trashedlisting.index', 'uses' => 'SiteUserController@trashed']);
    Route::get('site-user/trashed-data', ['as' => 'admin.site-user.apitrashedlist.index', 'uses' => 'SiteUserController@getTrashedData']);
    Route::post('site-user/group-action', ['as' => 'admin.site-user.groupaction', 'uses' => 'SiteUserController@groupAction']);
    Route::resource('site-user', 'SiteUserController');
    
//manage car brands
    Route::get('car-brands/data', ['as' => 'admin.car-brands.list', 'uses' => 'CarBrandController@getData']);
    Route::resource('car-brands', 'CarBrandController');

//manage car models
    Route::get('car-models/data', ['as' => 'admin.car-models.list', 'uses' => 'CarModelController@getData']);
    Route::resource('car-models', 'CarModelController');

//manage cars
    Route::get('cars/carModelData/{cid}', ['as' => 'admin.cars.carModelList', 'uses' => 'CarController@getCarModelData']);
    Route::get('cars/data', ['as' => 'admin.cars.list', 'uses' => 'CarController@getData']);
    Route::resource('cars', 'CarController');
    
//manage cars
    Route::get('rides/data', ['as' => 'admin.rides.list', 'uses' => 'RideController@getData']);
    Route::resource('rides', 'RideController');
    
    
    ################ PLEASE WRITE YOUR ROUTES ABOVE THIS CODE ##################################
    Route::controllers([
        'auth' => 'Auth\AuthController',
        'password' => 'Auth\PasswordController',
    ]);
});
