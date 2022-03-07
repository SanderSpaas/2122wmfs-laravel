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

Route::get('/', [MainController::class, "homepage"]);
Route::get('/blogpost{post_id}', [MainController::class, "blogpost"], ['post_id']);

// Route::controller('/fiddles', 'FiddleController');
Route::get('/fiddles', [FiddleController::class, "fiddles"]);

Route::get('add', [MainController::class, 'add']);
Route::get('category/{category}', [MainController::class, 'category']);
Route::get('blogpost/{id}', [MainController::class, 'blogpost'])->where(['id' => '[0-9]+']);
Route::get('author/{id}', [MainController::class, 'author'])->where(['id' => '[0-9]+']);

Route::post('add', [MainController::class, 'store']);