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

Route::get( '/dashboard', 'DashboardController@index' )
->name( 'dashboard.index' );

Route::get( '/dashboard/users', 'DashboardController@users_list' )
->name( 'dashboard.users.list' );

Route::get( '/dashboard/users/create', 'DashboardController@users_create' )
->name( 'dashboard.users.create' );

Route::get( '/dashboard/users/{id}', 'DashboardController@users_edit' )
->name( 'dashboard.users.edit' );

Route::get( '/dashboard/modules', 'DashboardController@modules_list' )
->name( 'dashboard.modules.list' );

Route::get( '/dashboard/modules/upload', 'DashboardController@modules_upload' )
->name( 'dashboard.modules.upload' );

Route::get( '/dashboard/modules/enable/{namespace}', 'DashboardController@modules_enable' )
->name( 'dashboard.modules.enable' );

Route::get( '/dashboard/modules/disable/{namespace}', 'DashboardController@modules_enable' )
->name( 'dashboard.modules.disable' );

Route::get( '/dashboard/settings/{namespace?}', 'DashboardController@settings' )
->name( 'dashboard.settings' );

Route::get( '/do-setup/{step?}', 'SetupController@steps' )
->name( 'setup.step' );



Route::post( '/do-setup/post/database', 'SetupController@post_database' )
->name( 'setup.post.database' );

Route::post( '/do-setup/post/app-details', 'SetupController@post_appdetails' )
->name( 'setup.post.app-details' );
