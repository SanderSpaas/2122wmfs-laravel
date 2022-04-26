<?php

use App\Http\Controllers\FiddleController;
use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;

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



Route::get('/fiddles', [FiddleController::class, "fiddles"])->middleware('guest');

Route::get('/', [MainController::class, "homepage"])->middleware('guest');
Route::get('category/{category}', [MainController::class, 'category'])->middleware('guest');
Route::get('blogpost/{id}', [MainController::class, 'blogpost'])->where(['id' => '[0-9]+'])->middleware('guest');
Route::get('author/{id}', [MainController::class, 'author'])->where(['id' => '[0-9]+'])->middleware('guest');
Route::get('/search', [MainController::class, "search"])->middleware('guest');
Route::get('add', [MainController::class, 'add'])->middleware('auth');
Route::post('add', [MainController::class, 'store'])->middleware('auth');


require __DIR__.'/auth.php';
