<?php

// use GuzzleHttp\Psr7\Request;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

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
    return redirect('/concerts');
});

Route::get('/concerts', function (Request $request) {
    if ($request->has('search') && $request->search != '') {
        return redirect('search/' . $request->search);
    } else {
        $concerts = DB::select('select * from concerts');
        return view('concerts', ['term' => '', 'concerts' => $concerts]);
    }
});

Route::get('/search/{term}', function ($term) {
    $concerts = DB::select('SELECT * from concerts WHERE title LIKE ?', ["%" . $term . "%"]);
    return view('concerts', ['term' => $term, 'concerts' => $concerts]);
});

Route::post('/concerts/{id}/toggle', function (Request $request, $id) {
    DB::update('update concerts set fav = ? WHERE id = ?', [1 - $request->switch, $id]);
    return redirect('concerts');
});

Route::get('/concerts/{id}', function ($id) {
    $concert = DB::select('SELECT * from concerts INNER JOIN images ON concerts.id = concert_id WHERE concerts.id = ? ;' , [$id]);
    return view('concert', ['concert' => $concert]);
});

Route::get('/concerts/{id}/{idImg}', function ($id, $idImg) {
    $concert = DB::select('SELECT * from concerts INNER JOIN images ON concerts.id = concert_id WHERE images.id = ? ;', [$idImg]);
    return view('concertImage', ['concert' => $concert[0]]);
});
