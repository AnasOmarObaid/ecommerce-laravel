<?php
$router->pattern('id', '[0-9]+');
Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ],
    function () {
        Route::group(['middleware' => ['auth']], function () {
            Route::prefix('dashboard')->group(function () {
                Route::resource('home', 'HomeController');

                //-- User Route
                Route::resource('/user/show', 'UserController');
                Route::get('/user/create', 'UserController@create'); // -- display the form to insert new member
                Route::post('/user/create', 'UserController@insert'); // -- to insert the user in table
                Route::get('/user/edit/{id}', 'UserController@edit'); // -- to edit the user
                Route::post('/user/edit/{id}', 'UserController@update'); // -- to update the user
                Route::delete('/users/delete/{id}', 'UserController@delete')->name('delete'); // -- to delete the customer

                // -- Department Route
                Route::get('/department/show', 'DepartmentController@index')->name('show.department');
                Route::put('/department/create', 'DepartmentController@insert')->name('create.departments');
                Route::get('/department/edit/{id}', 'DepartmentController@edit')->name('edit.departments');
                Route::put('/department/update/{id}', 'DepartmentController@update')->name('update.departments');
                Route::delete('/department/delete/{id}', 'DepartmentController@delete')->name('delete.departments');

                // -- Product Route
                Route::get('/product/show', 'ProductController@index')->name('show.products');
                Route::get('/product/create', 'ProductController@create')->name('create.products');
                Route::put('/product/create', 'ProductController@store')->name('store.products');
                Route::get('product/edit/{id}', 'ProductController@edit')->name('edit.products');
                Route::delete('product/delete/{id}', 'ProductController@destroy')->name('delete.products');
                Route::post('products/hide/{id}', 'ProductController@hideProduct')->name('hide.products');
                Route::post('products/allow/{id}', 'ProductController@allowProduct')->name('allow.products');
                Route::put('products/update/{id}', 'ProductController@update')->name('update.products');

                // -- Clints Route 
                Route::get('/client/show', 'ClientController@index')->name('show.clients');
                Route::put('/client/store', 'ClientController@store')->name('store.clients');
                Route::get('/client/edit/{id}', 'ClientController@edit')->name('edit.clients');
                Route::put('/client/update/{id}', 'ClientController@update')->name('update.clients');
                Route::delete('client/delete/{id}', 'ClientController@destroy')->name('delete.clients');
                // -- Order Route for client
                Route::get('client/{id}/order/create', 'Clients\OrderController@create')->name('client.create.order');
                Route::put('client/{id}/order/store', 'Clients\OrderController@store')->name('client.store.order');

                //-- Order Route For Public Order
                Route::resource('order', 'OrderController')->except(['show', 'create', 'store']);
            });
        });
    }
);
