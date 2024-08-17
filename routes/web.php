<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KabupatenController;
use App\Http\Controllers\Admin\PendudukController;
use App\Http\Controllers\Admin\ProvinsiController;
use App\Http\Controllers\ProvinsiKabupatenController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::prefix('admin')->group(function () {
        //route dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard.index');
        Route::get('/test', [PendudukController::class, 'test'])->name('test');
        //route propinsi
        Route::resource('/provinsi', ProvinsiController::class, ['as' => 'admin']);
        Route::resource('/kabupaten', KabupatenController::class, ['as' => 'admin']);
        Route::resource('/penduduk', PendudukController::class, ['as' => 'admin']);
        
        Route::post('/penduduk/kabupaten', [PendudukController::class, 'getKabupaten'])->name('admin.penduduk.getKabupaten');     
});
