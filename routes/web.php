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
Route::prefix('admin-login')->namespace('Backend\Auth')->group(function () {
    Route::get('/', 'AdminLoginController@getLogin')->middleware('AdminCheckLogin')->name('admin.user.login');
    Route::post('/login', 'FacebookUserController@store');
    Route::post('/', 'AdminLoginController@postLogin');
    Route::get('logout', 'AdminLoginController@getLogout')->name('admin.user.logout');
});


Route::prefix('admin')->namespace('Backend')->middleware('AdminCheckLogout')->group(function () {
    //dropzon
    Route::post('store-product-photos', 'filecontroller@storeproductphoto')->name('file.store_product_photos');
    Route::post('delete', 'filecontroller@delete')->name('file.delete');

    Route::get('/', 'DasboardController@index')->name('admin.dasboard');
    Route::prefix('user')->group(function () {
        Route::get('list', 'AdminUserController@index')->name('admin.user.list');
        Route::get('add', 'AdminUserController@getAdd')->name('admin.user.add');
        Route::post('add', 'AdminUserController@postAdd');
        Route::get('update/{id}', 'AdminUserController@getUpdate')->name('admin.user.update');
        Route::post('update/{id}', 'AdminUserController@postUpdate');
        Route::get('delete/{id}', 'AdminUserController@getDelete')->name('admin.user.delete');
    });
    Route::prefix('page')->group(function () {
        Route::get('/', 'GraphController@index')->name('admin.PublishPage.list');
//        Route::get('/get-data','GraphController@anyData')->name('admin.PublishPage.dataTable');
        Route::get('add', 'GraphController@getAdd')->name('admin.PublishPage.add');
        Route::post('add', 'GraphController@store');
        Route::get('update/{id}', 'GraphController@detail')->name('admin.PublishPage.update');
        Route::post('update/{id}', 'GraphController@update');
        Route::get('repost/{id}', 'GraphController@repost')->name('admin.PublishPage.repost');
        Route::get('delete/{id}', 'GraphController@delete')->name('admin.PublishPage.delete');
        Route::get('/test', 'GraphController@getPageIds');
    });
    Route::prefix('product')->group(function () {
        Route::get('list', 'AdminProductController@index')->name('admin.product.list');
        Route::get('add', 'AdminProductController@getAdd')->name('admin.product.add');
        Route::post('add', 'AdminProductController@postAdd');
        Route::get('update/{id}', 'AdminProductController@getUpdate')->name('admin.product.update');
        Route::post('update/{id}', 'AdminProductController@postUpdate');
        Route::get('delete/{id}', 'AdminProductController@getDelete')->name('admin.product.delete');
        Route::get('ajax-show-modal', 'AdminProductController@ajaxShowModal')->name('admin.product.ajax.modal');
    });

});

//route admin
// Auth::routes();
