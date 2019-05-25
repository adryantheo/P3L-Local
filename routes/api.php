<?php

use Illuminate\Http\Request;

Route::post('/login', 'UserController@login');
Route::post('/register', 'UserController@register');
Route::post('/upload-gambar', 'SparepartController@uploadGambar');
Route::get('/pegawai', 'UserController@index');
Route::post('/pegawai/{user}', 'UserController@update');
Route::delete('/pegawai/{user}', 'UserController@destroy');
Route::get('/kustomer/all', 'KustomerController@all');
Route::get('/kendaraan/all', 'KendaraanController@all');
Route::get('/kendaraan/findKendaraan/{plat}', 'KendaraanController@findKendaraan');
Route::get('/kustomer/findKustomer/{notelp}', 'KustomerController@findKustomer');
Route::patch('/sales/{sales}', 'SalesController@update');
Route::delete('/sales/{sales}', 'SalesController@destroy');
Route::get('/sales/all', 'SalesController@all');
Route::get('/pesanbarang/all', 'PesananBarangController@all');
Route::delete('/pesanbarang/{pesanan_Barang}', 'PesananBarangController@destroy');
Route::patch('/pesanbarang/{pesanan_Barang}', 'PesananBarangController@update');
Route::get('/detailpesanan/all', 'DetailPesananController@all');
Route::get('/detailpesanan/{detail_Pesanan}', 'DetailPesananController@show');
Route::delete('/detailpesanan/{detail_Pesanan}', 'DetailPesananController@destroy');
Route::patch('/detailpesanan/{detail_Pesanan}', 'DetailPesananController@update');
Route::get('/sparepart/all', 'SparepartController@all');
Route::post('/sparepart/{sparepart}', 'SparepartController@update');
Route::post('/pegawai/gantipass', 'UserController@gantipassword');
Route::patch('/transaksi-service/{transaksi_Service}', 'TransaksiServiceController@update');
Route::get('/transaksi-service/{transaksi_Service}', 'TransaksiServiceController@show');
Route::patch('/transaksi-sparepart/{transaksi_Sparepart}', 'TransaksiSparepartController@update');
Route::patch('/transaksi-paid/{transaksi}', 'TransaksiController@paid');
Route::get('/transaksi/unpaid', 'TransaksiController@unpaid');
Route::get('/kendaraan/find-kendaraan/{plat}', 'KendaraanController@findKendaraan');
Route::get('/transaksi/pendapatan/total', 'TransaksiController@getPendapatanTotal');
Route::get('/transaksi/pendapatan/service', 'TransaksiController@getPendapatanService');
Route::get('/transaksi/pendapatan/sparepart', 'TransaksiController@getPendapatanSparepart');
Route::get('/laporan/income/{tahun}', 'LaporanController@getIncomeYear');
Route::get('/laporan/pendapatan/{tahun}/', 'LaporanController@getIncomeMonth');
Route::get('/laporan/best/{tahun}/', 'LaporanController@getSparepart');
Route::get('/laporan/most/{tahun}/', 'LaporanController@getJasa');
Route::get('/laporan/most-number/{tahun}/', 'LaporanController@getJasaNumber');
Route::get('/laporan/outcome/{tahun}/', 'LaporanController@getOutcome');
Route::get('/laporan/stok/{tahun}/{Tipe}', 'LaporanController@getStok');
Route::delete('/transaksi-service/{transaksi_Service}', 'TransaksiServiceController@destroy');
Route::delete('/transaksi-sparepart/{transaksi_Sparepart}', 'TransaksiSparepartController@destroy');
Route::get('/pesanbarang/{pesan_Barang}', 'PesananBarangController@show');



Route::resource('/pesanbarang', 'PesananBarangController')->except(['all','destroy', 'patch', 'show']);
Route::resource('/detailpesanan', 'DetailPesananController')->except(['all', 'destroy', 'show', 'patch']);
Route::resource('/kustomer', 'KustomerController')->except(['search', 'all','listNamaKustomer']);
Route::resource('/kendaraan', 'KendaraanController')->except(['all', 'findKendaraan']);
Route::resource('/transaksi', 'TransaksiController')->except(['paid', 'unpaid','getPendapatanTotal']);
Route::resource('/transaksi-service', 'TransaksiServiceController')->except(['destroy']);
Route::resource('/transaksi-sparepart', 'TransaksiSparepartController')->except(['destroy']);
Route::resource('/service', 'ServiceController');
Route::resource('/sales', 'SalesController')->except(['update','destroy', 'all']);
Route::resource('/sparepart', 'SparepartController')->except(['uploadGambar','update']);



Route::group(['middleware' => 'auth:api'], function(){

   
    Route::resource('/pegawai', 'UserController')->except(['delete','update','index', 'login', 'register', 'gantipassword']);
    
});
