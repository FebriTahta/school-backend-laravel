<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\AngkatanController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\PelajaranController;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\UserController;
use GuzzleHttp\Psr7\Request;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Rels;

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
    return redirect('login');
});

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::controller(UserController::class)->group(function(){
    Route::get('/admin-daftar-user','daftar_user');
    Route::post('/admin-ubah-password','ubah_password');
    Route::post('/admin-ubah-photo','ubah_photo');
});
 
Route::group(['middleware' => ['auth', 'CheckRole:admin']], function () {

    Route::controller(UserController::class)->group(function () {
        Route::get('admin-daftar-user', 'daftar_user');
    });

    Route::controller(DashboardController::class)->group(function () {
        route::get('/admin-dashboard', 'admin_dashboard_page');
    });

    Route::controller(JurusanController::class)->group(function () {
        Route::get('/admin-jurusan', 'admin_jurusan');
        Route::post('/admin-post-jurusan', 'post_jurusan');

        Route::get('/admin-jurusan-&-kelas', 'admin_jurusan_kelas_page');
        Route::get('/admin-total-jurusan-&-kelas', 'total_jurusan_kelas');
        Route::post('/admin-post-jurusan-&-kelas', 'post_jurusan_kelas');
        Route::get('/admin-tingkat-dropdown', 'tingkat_dropdown');
        Route::get('/admin-jurusan-dropdown', 'jurusan_dropdown');
        Route::get('/admin-angkatan-dropdown', 'angkatan_dropdown');
        Route::get('/admin-dropdown-mapel-kelas/{kelas_id}', 'mapelkelas_dropdown');
        Route::get('/admin-chagne-dropdown-jurusan/{jurusan_id}', 'change_dropdown_jurusan');
        Route::get('/admin-chagne-dropdown-angkatan/{angkatan_id}', 'change_dropdown_angkatan');
        Route::post('/admin-remove-kelas', 'remove_kelas');
        Route::get('/admin-daftar-jurusan', 'daftar_jurusan');
        Route::post('/admin-remove-jurusan', 'remove_jurusan');
        Route::post('/admin-update-kelas', 'update_kelas');
        Route::post('/admin-update-jurusan', 'update_jurusan');
    });

    Route::controller(AngkatanController::class)->group(function () {
        Route::get('/admin-angkatan', 'admin_angkatan');
        Route::get('/admin-total-angkatan', 'total_angkatan');
        Route::post('/admin-post-angkatan', 'post_angkatan');
        Route::post('/admin-remove-angkatan', 'remove_angkatan');
    });

    Route::controller(MapelController::class)->group(function () {
        Route::get('/admin-mapel', 'admin_mapel');
        Route::get('/admin-total-mapel', 'total_mapel');
        Route::get('/admin-get-mapel', 'get_mapel');
        Route::post('/admin-remove-mapel', 'remove_mapel');
        Route::post('/admin-post-mapel', 'post_mapel');
        Route::post('/admin-update-mapel', 'update_mapel');

        Route::post('/admin-post-kelas-mapel', 'post_kelas_mapel');
    });

    Route::controller(SiswaController::class)->group(function () {
        Route::get('/admin-siswa', 'admin_siswa');
        Route::get('/admin-siswa-kelas/{kelas_id}', 'siswa_kelas');
        Route::post('/admin-ubah-status-siswa', 'status_siswa');
    });

    Route::controller(ExportController::class)->group(function () {
        Route::get('/admin-download-template-siswa/{kelas_id}', 'download_template_siswa');
        Route::get('/admin-download-template-guru', 'download_template_guru');
        Route::get('/admin-download-template-mapel', 'download_template_mapel');
        Route::get('/admin-download-template-quiz', 'download_template_quiz');
    });

    Route::controller(ImportController::class)->group(function () {
        Route::post('/admin-import-data-siswa', 'import_data_siswa');
        Route::post('/admin-import-data-guru', 'import_data_guru');
        Route::post('/admin-import-data-mapel', 'import_data_mapel');
        Route::post('/admin-import-data-quiz', 'import_data_quiz');
    });

    Route::controller(GuruController::class)->group(function () {
        Route::get('/admin-guru', 'admin_guru');
        Route::get('/admin-total-guru', 'total_guru');
        Route::post('/admin-post-guru', 'post_guru');

        Route::post('/admin-post-mapel-master', 'post_mapel_master');
    });
});

Route::group(['middleware' => ['auth', 'CheckRole:siswa']], function () {
    Route::controller(LandingController::class)->group(function () {
        Route::get('/home-lms', 'home_lms');
    });
});

Route::group(['middleware' => ['auth', 'CheckRole:guru']], function () {
    Route::controller(LandingController::class)->group(function () {
        Route::get('/home-lms-guru', 'home_lms_guru');
        Route::get('/home-lms-guru', 'home_lms_guru');
        Route::get('/guru-download-template-ujian/{number_soal}', 'download_template_ujian');
    });
    Route::controller(ImportController::class)->group(function () {
        Route::post('/admin-import-data-quiz', 'import_data_quiz');
    });
    Route::controller(GuruController::class)->group(function() {
        Route::post('/update-photo-guru','update_photo');
        Route::post('/update-photo-guru2','update_photo2');
        Route::post('/update-bio','update_bio');
    });
});

Route::group(['middleware' => ['auth', 'CheckRole:guru,siswa']], function () {
    Route::controller(PelajaranController::class)->group(function () {
        Route::get('/mapel/{mapelmaster_id}', 'mapel_mapelmaster');
        Route::get('/mapel-siswa/{mapelmaster_id}', 'mapel_mapelmaster_siswa');
        Route::post('/post-tugas-siswa','add_tugas_siswa');
    });
    Route::controller(MateriController::class)->group(function () {
        Route::post('/post-materi', 'post_materi');
        Route::post('/post-vids', 'post_vids');
        Route::post('/post-docs', 'post_docs');
        Route::get('/download-docs/{docs_id}', 'download_docs');
    });
});

// Route::get('/do-quiz',function(){
//     return view('fe_page.do_quiz');
// });

Route::get('/do-quiz/{ujian_id}', [QuizController::class, 'doQuiz'])->name('doQuiz');
Route::post('/post-quiz', [QuizController::class, 'postQuiz'])->name('postQuiz');
