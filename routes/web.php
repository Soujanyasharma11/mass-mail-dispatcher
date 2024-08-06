<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\uploadFile;
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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');
Route::get('/admin', function () {
    return view('admin');
})->middleware(['auth'])->name('admin');

Route::post('upload-file',[uploadFile::class,'store'])->name('admin.upload.csv');
Route::post('send-email',[uploadFile::class,'sendEmail'])->name('admin.send.mail');
Route::get('see-email',[uploadFile::class,'seeEmail'])->name('admin.see.mail');
Route::get('/php', function(){
    phpinfo();
    return false;
});
require __DIR__.'/auth.php';
