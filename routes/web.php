<?php

use Illuminate\Support\Facades\Auth;
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

// $proxy_url = 'https://whistleblower.mnk.co.id';
// $proxy_schema = 'https';
// URL::forceRootUrl($proxy_url);
// URL::forceScheme($proxy_schema);

Route::get('/', 'FrontController@index')->name('index');
Route::get('/formpengaduan', 'FrontController@createreport')->name('createreport');
Route::post('/formpengaduan', 'FrontController@storereport')->name('storereport');
Route::get('/infopengaduan/{id}', 'FrontController@inforeport')->name('inforeport');
Route::post('/lacakpengaduan', 'FrontController@tracereport')->name('tracereport');
Route::post('/checksessionreport', 'FrontController@checksessionreport')->name('checksessionreport');
Route::get('/lacakpengaduan/{id}', 'FrontController@tracingreport')->name('tracingreport');
Route::post('/unggahbuktipengaduan/{id}', 'FrontController@uploadevidence')->name('uploadevidence');
Route::get('/detailpengaduan/{id}', 'FrontController@detailreport')->name('detailreport');
Route::post('/verifikasitoken', 'FrontController@tokenverification')->name('tokenverification');
Route::get('/hasilpengaduan/{id}', 'FrontController@resultreport')->name('resultreport');
Route::get('/tanyainvestigator/{id}', 'FrontController@askquestion')->name('askquestion');
Route::post('/tanyainvestigator/sent/{id}', 'FrontController@sentaskquestion')->name('sentaskquestion');

Auth::routes(['register' => false, 'reset' => false, 'verify' => false]);

Route::group(['middleware' => 'auth'],function(){
    Route::group(['prefix' => 'dashboard'], function () {

        Route::get('/', 'DashboardController@index')->name('dashboard');
        Route::get('/help', 'DashboardController@help')->name('help');

        Route::post('/getnotification', 'DashboardController@getnotification')->name('getnotification');
        Route::post('/getchart', 'DashboardController@getchart')->name('getchart');

        Route::resource('complaint', 'ComplaintController');
        Route::group(['prefix' => 'complaint', 'as' => 'complaint.'], function () {
            Route::post('/{id}/initialinvestigation', 'ComplaintController@initialinvestigation')->name('initialinvestigation');
            Route::post('/{id}/investigation', 'ComplaintController@investigation')->name('investigation');
            Route::post('/emailstore', 'ComplaintController@emailstore')->name('emailstore');
            Route::get('/{id}/print', 'ComplaintController@print')->name('print');
            Route::get('{id}/getdata', 'ComplaintController@getdata')->name('getdata');
        });

        Route::resource('discussion', 'DiscussionController');
        Route::group(['prefix' => 'discussion', 'as' => 'discussion.'], function () {
            Route::post('/{id}/reply', 'DiscussionController@reply')->name('reply');
            Route::get('/notification/feedback', 'DiscussionController@feedbacknotification')->name('feedbacknotification');
            Route::post('/{id}/getdiscussion', 'DiscussionController@getdiscussion')->name('getdiscussion');
        });

        Route::resource('user', 'UserController');
        Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
            Route::post('getdatauser/{id}','UserController@getdatauser')->name('getdatauser');
            Route::get('/{id}/profil', 'UserController@profile')->name('profile');
            Route::post('/{id}/profilupdate', 'UserController@profileupdate')->name('profileupdate');
        });

        Route::resource('role', 'RoleController');

        Route::resource('privilege', 'PrivilegeController');

        Route::group(['prefix' => 'report', 'as' => 'report.'], function () {
            Route::get('/', 'ReportController@index')->name('index');
            Route::post('/check', 'ReportController@check')->name('check');
            Route::get('/print/{id}', 'ReportController@print')->name('print');
        });

        Route::group(['prefix' => 'setting', 'as' => 'setting.'], function () {
            Route::get('/', 'SettingController@index')->name('index');
            Route::match(['put', 'patch'], '/update', 'SettingController@update')->name('update');
        });

        Route::group(['prefix' => 'cms', 'as' => 'cms.'], function () {
            Route::get('/', 'CMSController@index')->name('index');
            Route::match(['put', 'patch'], '/update', 'CMSController@update')->name('update');
        });

        Route::group(['prefix' => 'inbox', 'as' => 'inbox.'], function () {
            Route::get('/', 'InboxController@index')->name('index');
            Route::get('/synchronize', 'InboxController@synchronize')->name('synchronize');
            Route::post('/store', 'InboxController@store')->name('store');
            Route::post('/reademail', 'InboxController@reademail')->name('reademail');
            Route::post('/detailemail/{msgno}', 'InboxController@detailemail')->name('detailemail');
        });

        Route::group(['prefix' => 'log', 'as' => 'log.'], function () {
            Route::get('/', 'LogController@index')->name('index');
            Route::post('/datatable', 'LogController@datatable')->name('datatable');
        });

        Route::apiResource('status', 'StatusController');
        Route::group(['prefix' => 'status', 'as' => 'status.'], function () {
            Route::post('getdata/{id}', 'StatusController@getdata')->name('getdata');
        });

        Route::group(['prefix' => 'technical', 'as' => 'technical.'], function () {
            Route::get('/', 'TechnicalController@index')->name('index');
        });
    });

});



