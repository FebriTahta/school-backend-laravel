<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\MapelController;

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

Auth::routes();

Route::group(['middleware' => ['auth', 'CheckRole:admin']], function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    
    Route::controller(DashboardController::class)->group(function(){
        route::get('/admin-dashboard','admin_dashboard_page');
    });

    Route::controller(JurusanController::class)->group(function(){
        Route::get('/admin-jurusan-&-kelas','admin_jurusan_kelas_page');
        Route::get('/admin-total-jurusan-&-kelas','total_jurusan_kelas');
        Route::post('/admin-post-jurusan-&-kelas','post_jurusan_kelas');
        Route::get('/admin-jurusan-dropdown','jurusan_dropdown');
        Route::get('/admin-tingkat-dropdown','tingkat_dropdown');
        Route::get('/admin-chagne-dropdown-jurusan/{jurusan_id}','change_dropdown_jurusan');
        Route::get('/admin-chagne-dropdown-tingkat/{tingkat_id}','change_dropdown_tingkat');
        Route::post('/admin-remove-kelas','remove_kelas');
        Route::get('/admin-daftar-jurusan','daftar_jurusan');
        Route::post('/admin-remove-jurusan','remove_jurusan');
        Route::post('/admin-update-kelas','update_kelas');
        Route::post('/admin-update-jurusan','update_jurusan');
    });

    Route::controller(MapelController::class)->group(function(){
        Route::get('/admin-mapel','admin_mapel');
        Route::get('/admin-total-mapel','total_mapel');
        Route::get('/admin-get-mapel','get_mapel');
        Route::post('/admin-remove-mapel','remove_mapel');
        Route::post('/admin-post-mapel','post_mapel');
        Route::post('/admin-update-mapel','update_mapel');
    });

    Route::controller(SiswaController::class)->group(function(){
        Route::get('/admin-siswa','admin_siswa');
    });

});

Route::group(['middleware' => ['auth', 'CheckRole:siswa']], function () {
    
});