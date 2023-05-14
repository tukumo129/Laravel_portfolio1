<?php

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

Auth::routes();

Route::group(['middleware' => 'auth'],function() {
    Route::get('/', 'Calendar\PlanSettingController@form')->name("home");
    Route::get('/home', 'Calendar\PlanSettingController@form')->name("home");
    Route::get('/holiday_setting', 'Calendar\HolidaySettingController@form')->name("holiday_setting");
    Route::post('/holiday_setting', 'Calendar\HolidaySettingController@update')->name("update_holiday_setting");
    Route::get('/extra_holiday_setting', 'Calendar\ExtraHolidaySettingController@form')->name("extra_holiday_setting");
    Route::post('/extra_holiday_setting','Calendar\ExtraHolidaySettingController@update')->name("update_extra_holiday_setting");
    Route::get('/plan_setting', 'Calendar\PlanSettingController@form')->name("plan_setting");
    Route::post('/plan_setting','Calendar\PlanSettingController@update')->name("update_plan_setting");
});