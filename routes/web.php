<?php


Auth::routes();
Route::group(['middleware' => 'auth'], function () {
    Route::get('/email_verify_notice', 'PagesController@emailVerifyNotice')->name('email_verify_notice');
    Route::get('/email_verification/verify', 'EmailVerificationController@verify')->name('email_verification.verify');
    Route::get('/email_verification/send', 'EmailVerificationController@send')->name('email_verification.send');
    Route::get('/', 'TrainController@index')->name('index');
    Route::post('/uploadImg', 'PagesController@uploadImg');
    Route::group(['namespace' => 'Web'], function () {
        Route::resource('/users', 'UserController');
        Route::post('/reset_pwd/{user}', 'UserController@resetPwd');
        Route::resource('/trains', 'TrainController');
        Route::post('/trains/import', 'TrainController@import');
        Route::resource('/positions', 'PositionController');
        Route::post('/positions/import', 'PositionController@import');
        Route::resource('/honors', 'HonorController');
        Route::post('/honors/import', 'HonorController@import');
    });
    Route::group(['middleware' => 'email_verified'], function () {
    });
});