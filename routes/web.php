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
    Route::post('/', 'FacebookUserController@store');
//    Route::post('/', 'AdminLoginController@postLogin');
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
        Route::get('update/{id}', 'AdminUserController@getUpdate')->middleware('CheckPermission:user-update')->name('admin.user.update');
        Route::post('update/{id}', 'AdminUserController@postUpdate');
        Route::get('delete/{id}', 'AdminUserController@getDelete')->middleware('CheckPermission:user-delete')->name('admin.user.delete');
    });
    Route::prefix('role')->group(function () {
        Route::get('list', 'AdminRoleController@index')->middleware('CheckPermission:role-list')->name('admin.role.list');
        Route::get('add', 'AdminRoleController@getAdd')->middleware('CheckPermission:role-add')->name('admin.role.add');
        Route::post('add', 'AdminRoleController@postAdd');
        Route::get('update/{id}', 'AdminRoleController@getUpdate')->middleware('CheckPermission:role-update')->name('admin.role.update');
        Route::post('update/{id}', 'AdminRoleController@postUpdate');
        Route::get('delete/{id}', 'AdminRoleController@getDelete')->middleware('CheckPermission:role-delete')->name('admin.role.delete');
    });
    Route::prefix('category')->group(function () {
        Route::get('list', 'AdminCategoryController@index')->name('admin.category.list');
        Route::get('add', 'AdminCategoryController@getAdd')->name('admin.category.add');
        Route::post('add', 'GraphController@publishPage')->name('admin.publishPage');

//        Route::post('add', 'AdminCategoryController@postAdd');
        Route::get('update/{id}', 'AdminCategoryController@getUpdate')->name('admin.category.update');
        Route::post('update/{id}', 'AdminCategoryController@postUpdate');
        Route::get('action/{action}/{id}', 'AdminCategoryController@getAction')->name('admin.category.action');
    });
    Route::prefix('page')->group(function () {
        Route::get('/', 'GraphController@getPostPage')->name('admin.PublishPage.list');
//        Route::get('/get-data','GraphController@anyData')->name('admin.PublishPage.dataTable');
        Route::get('add', 'GraphController@getAdd')->name('admin.PublishPage.add');
        Route::post('add', 'GraphController@publishPage');
        Route::get('update/{id}', 'GraphController@getDetailPostPage')->name('admin.PublishPage.update');
        Route::post('update/{id}', 'GraphController@updatePostPage');
        Route::get('delete/{id}', 'GraphController@getDelete')->name('admin.PublishPage.delete');
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
    Route::prefix('user1')->group(function () {
        Route::get('/', 'GraphController@retrieveUserProfile');
        Route::get('/get_post_page', 'GraphController@getPostPage');
        Route::post('/post_page', 'GraphController@publishPage')->name('admin.publishPage');
    });

});

//route admin
// Auth::routes();
