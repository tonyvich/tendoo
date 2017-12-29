<?php
Route::get( 'dashboard/foo', 'FooController@index' )->name( 'dashboard.foo.index' );
Route::get( 'dashboard/foo/bar', 'FooController@bar' )->name( 'dashboard.bar.index' );
Route::get( 'dashboard/something', 'FooController@go' );