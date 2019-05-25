<?php



Route::any('/{any}', function () {
    return view('welcome');
})->where('any', '.*');

Route::any('{page}', function(){return view('welcome');});

Route::get('/admin/{page}', function(){ return view('welcome');});
Route::get('/karyawan/{page}', function(){ return view('welcome');});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
