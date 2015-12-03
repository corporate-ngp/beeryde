<?php
Route::model('user', 'Modules\Admin\Models\User');
Route::model('link-category', 'Modules\Admin\Models\LinkCategory');
Route::model('config_categories', 'Modules\Admin\Models\ConfigCategory');
Route::model('links', 'Modules\Admin\Models\Links');
Route::model('config_settings', 'Modules\Admin\Models\ConfigSetting');
Route::model('user_type', 'Modules\Admin\Models\UserType');
Route::model('system_emails', 'Modules\Admin\Models\SystemEmail');
Route::model('myprofile', 'Modules\Admin\Models\User');
Route::model('faq_categories', 'Modules\Admin\Models\FaqCategory');
Route::model('faqs', 'Modules\Admin\Models\Faq');
Route::model('manage_pages', 'Modules\Admin\Models\Page');
Route::model('ipaddress', 'Modules\Admin\Models\IpAddress');
Route::model('countries', 'Modules\Admin\Models\Country');
Route::model('states', 'Modules\Admin\Models\State');
Route::model('cities', 'Modules\Admin\Models\City');
Route::model('site_user', 'Modules\Admin\Models\SiteUser');
Route::model('car_brands', 'Modules\Admin\Models\CarBrand');
Route::model('car_models', 'Modules\Admin\Models\CarModel');
Route::model('cars', 'Modules\Admin\Models\Car');
Route::model('rides', 'Modules\Admin\Models\Ride');


Route::bind('usertype_links', function($type) {
    $userTypeRepository = new Modules\Admin\Repositories\UserTypeRepository(new Modules\Admin\Models\UserType);
    $userTypeLinks = $userTypeRepository->getLinksByUserType($type);
    if ($userTypeLinks->isEmpty()) {
        abort(404);
        Log::info("Invalid Input");
    }
    return $userTypeLinks;
});
