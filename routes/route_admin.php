<?php



Route::prefix('admin-login')->namespace('Backend\Auth')->group(function () {
    Route::get('/', 'AdminLoginController@getLogin')->middleware('AdminCheckLogin')->name('admin.user.login');
    Route::post('/', 'AdminLoginController@postLogin');
    Route::get('logout', 'AdminLoginController@getLogout')->name('admin.user.logout');
});


Route::prefix('admin')->namespace('Backend')->middleware('AdminCheckLogout')->group(function () {
    //dropzon
    Route::post('store-product-photos', 'filecontroller@storeproductphoto')->name('file.store_product_photos');
    Route::post('delete', 'filecontroller@delete')->name('file.delete');

    Route::get('/', 'DasboardController@index')->name('admin.dasboard');
    Route::prefix('user')->group(function () {
        Route::get('list', 'AdminUserController@index')->middleware('CheckPermission:user-list')->name('admin.user.list');
        Route::get('add', 'AdminUserController@getAdd')->middleware('CheckPermission:user-add')->name('admin.user.add');
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
        Route::post('add', 'AdminCategoryController@postAdd');
        Route::get('update/{id}', 'AdminCategoryController@getUpdate')->name('admin.category.update');
        Route::post('update/{id}', 'AdminCategoryController@postUpdate');
        Route::get('action/{action}/{id}', 'AdminCategoryController@getAction')->name('admin.category.action');
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