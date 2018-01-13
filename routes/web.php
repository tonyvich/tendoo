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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([ 'app.installed' ])->group( function(){
    Route::get( '/dashboard', 'DashboardController@index' )->name( 'dashboard.index' );
    Route::get( '/dashboard/users', 'DashboardController@usersList' )->name( 'dashboard.users.list' );
    Route::get( '/dashboard/users/create', 'DashboardController@createUser' )->name( 'dashboard.users.create' );
    Route::get( '/dashboard/users/profile', 'DashboardController@showProfile' )->name( 'dashboard.users.profile' );
    Route::get( '/dashboard/users/{entry}', 'DashboardController@editUser' )->name( 'dashboard.users.edit' );
    Route::get( '/dashboard/modules', 'DashboardController@modulesList' )->name( 'dashboard.modules.list' );
    Route::get( '/dashboard/modules/upload', 'DashboardController@uploadModule' )->name( 'dashboard.modules.upload' );
    Route::get( '/dashboard/modules/enable/{namespace}', 'DashboardController@enableModule' )->name( 'dashboard.modules.enable' );
    Route::get( '/dashboard/modules/disable/{namespace}', 'DashboardController@disableModule' )->name( 'dashboard.modules.disable' );
    Route::get( '/dashboard/modules/delete/{namespace}', 'DashboardController@deleteModule' )->name( 'dashboard.modules.delete' );
    Route::get( '/dashboard/modules/extract/{namespace}', 'DashboardController@extractModule' )->name( 'dashboard.modules.extract' );
    Route::get( '/dashboard/settings/general', 'DashboardController@generalSettings' )->name( 'dashboard.settings.general' );
    Route::get( '/dashboard/security', 'DashboardController@security' )->name( 'dashboard.security' );
    Route::get( '/dashboard/update', 'DashboardController@update' )->name( 'dashboard.update' );
    Route::get( '/login', 'AuthController@loginIndex' )->name( 'login.index' )->middleware( 'expect.unlogged' );
    Route::get( '/logout', 'AuthController@LogoutIndex' )->name( 'logout.index' );
    Route::get( '/register', 'AuthController@registerIndex' )->name( 'register.index' )->middleware( 'expect.unlogged' );
    
    Route::post( '/dashboard/users/profile', 'DashboardController@showProfile' )->name( 'dashboard.users.post' );
    Route::post( '/dashboard/modules/post', 'DashboardController@postModule' )->name( 'dashboard.modules.post' );
    Route::post( '/dashboard/options/post', 'DashboardController@postOptions' )->name( 'dashboard.options.post' );
    Route::post( '/dashboard/crud/post/{namespace}', 'DashboardController@crudPost' )->name( 'dashboard.crud.post' );
    Route::post( '/dashboard/crud/put/{namespace}/{id}', 'DashboardController@crudPut' )->name( 'dashboard.crud.put' );
    Route::post( '/login/post', 'AuthController@postLogin' )->name( 'login.post' )->middleware( 'expect.unlogged' );
    Route::post( '/register/post', 'AuthController@postLogin' )->name( 'register.post' )->middleware( 'expect.unlogged' );
    
    Route::delete( '/dashboard/crud/{namespace}/{id}', 'DashboardController@crudDelete' )->name( 'dashboard.crud.delete' );

    Route::group([ 'prefix' => '/api/{resource}'], function( $request ) {        
        Route::get( '', 'ApiController@getAll' )->name( 'api.all' );
        Route::get( '{id}', 'ApiController@getOne' )->name( 'api.one' );
        Route::delete( '{id}', 'ApiController@delete' )->name( 'api.delete' );
        Route::put( '{id}', 'ApiController@put' )->name( 'api.put' );
        Route::post( '', 'ApiController@single' )->name( 'api.post' );
    });
});

Route::middleware([ 'app.notInstalled' ])->group( function(){
    Route::get( '/do-setup/{step?}', 'SetupController@steps' )->name( 'setup.step' );
    Route::post( '/do-setup/post/database', 'SetupController@post_database' )->name( 'setup.post.database' );
    Route::post( '/do-setup/post/app-details', 'SetupController@post_appdetails' )->name( 'setup.post.app-details' );
});

Route::get( '/errors/{code}', 'ErrorsController@show' )->name( 'errors' );

Route::get( '/mail', function(){
    return new App\Mail\SetupComplete();
});