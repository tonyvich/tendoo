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
    Route::get( '/dashboard/users', 'DashboardController@users_list' )->name( 'dashboard.users.list' );
    Route::get( '/dashboard/users/create', 'DashboardController@users_create' )->name( 'dashboard.users.create' );
    Route::get( '/dashboard/users/{id}', 'DashboardController@users_edit' )->name( 'dashboard.users.edit' );
    Route::get( '/dashboard/modules', 'DashboardController@modulesList' )->name( 'dashboard.modules.list' );
    Route::get( '/dashboard/modules/upload', 'DashboardController@uploadModule' )->name( 'dashboard.modules.upload' );
    Route::get( '/dashboard/modules/enable/{namespace}', 'DashboardController@enableModule' )->name( 'dashboard.modules.enable' );
    Route::get( '/dashboard/modules/disable/{namespace}', 'DashboardController@disableModule' )->name( 'dashboard.modules.disable' );
    Route::get( '/dashboard/modules/delete/{namespace}', 'DashboardController@deleteModule' )->name( 'dashboard.modules.delete' );
    Route::get( '/dashboard/modules/extract/{namespace}', 'DashboardController@extractModule' )->name( 'dashboard.modules.extract' );
    Route::get( '/dashboard/settings/general', 'DashboardController@generalSettings' )->name( 'dashboard.settings.general' );
    Route::get( '/dashboard/security', 'DashboardController@security' )->name( 'dashboard.security' );
    
    Route::get( '/login', 'AuthController@loginIndex' )->name( 'login.index' )->middleware( 'expect.unlogged' );
    Route::get( '/logout', 'AuthController@LogoutIndex' )->name( 'logout.index' );
    Route::get( '/register', 'AuthController@registerIndex' )->name( 'register.index' )->middleware( 'expect.unlogged' );
    
    Route::post( '/dashboard/modules/post', 'DashboardController@postModule' )->name( 'dashboard.modules.post' );
    Route::post( '/dashboard/options/post', 'DashboardController@postOptions' )->name( 'dashboard.options.post' );
    Route::post( '/login/post', 'AuthController@postLogin' )->name( 'login.post' )->middleware( 'expect.unlogged' );
    Route::post( '/register/post', 'AuthController@postLogin' )->name( 'register.post' )->middleware( 'expect.unlogged' );
});

Route::middleware([ 'app.notInstalled' ])->group( function(){
    Route::get( '/do-setup/{step?}', 'SetupController@steps' )->name( 'setup.step' );
    Route::post( '/do-setup/post/database', 'SetupController@post_database' )->name( 'setup.post.database' );
    Route::post( '/do-setup/post/app-details', 'SetupController@post_appdetails' )->name( 'setup.post.app-details' );
});
