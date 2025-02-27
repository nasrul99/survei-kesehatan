<?php

use App\Filament\Masyarakat\Pages\Auth\Register;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MasyarakatController;
use App\Http\Controllers\UserController;

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
/*
Route::get('/', function () {
    return view('welcome');
});
*/
//--------------halaman frontend------------------
Route::get('/', function () {
    return view('medilab.home');
})->name('home');

Route::get('/home', function () {
    return view('medilab.home');
});

Route::get('/gallery', function () {
    return view('medilab.gallery');
});

Route::get('/privasi', function () {
    return view('medilab.privasi');
});


Route::get('/email/verify/{id}/{hash}', function (Request $request, Register $register) {
    return $register->setValidatedEmail($request);
})->name('verification.verify');






