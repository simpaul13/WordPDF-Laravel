<?php

use App\Http\Controllers\ConvertController;
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

Route::post('/convert', [\App\Http\Controllers\ConvertController::class, 'convert'])->name('convert');

Route::get('/', function () {
    return view('welcome');
});
