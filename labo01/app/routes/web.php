<?php

use GuzzleHttp\Psr7\Request;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/concerts', function (Request $request) {
    if($request->has('search')){
        return redirect('search/' . $request->search);
    }
    return view('concerts',['term'=>'','concerts'=>[]]);
});

Route::get('/search/{term}', function ($term) {

        return 'zoek maar op' . $term;
});

Route::post('/search/{id}/toggle', function ($id) {

    return 'zoek maar op' . $id;
});
