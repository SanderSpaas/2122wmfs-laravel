<?php

use App\Http\Controllers\apiController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BlogpostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//get routes
Route::get('/categories/{id}', [CategoryController::class, "category"])->where('id', '[0-9]+');
Route::get('/categories', [CategoryController::class, "categories"]);
Route::get('/tags', [TagController::class, "tags"]);
Route::get('/tags/{id}', [TagController::class, "tag"])->where('id', '[0-9]+');
Route::get('/authors', [AuthorController::class, "authors"]);
Route::get('/authors/{id}', [AuthorController::class, "author"])->where('id', '[0-9]+');
Route::get('/blogposts', [BlogpostController::class, "blogposts"]);
Route::get('/blogposts/{id}', [BlogpostController::class, "blogpost"])->where('id', '[0-9]+');
Route::get('/blogposts/category/{id}', [BlogpostController::class, "categoryBlogposts"])->where('id', '[0-9]+');
Route::get('/featured', [BlogpostController::class, "featured"]);

//search
Route::get('/blogposts/search', [BlogpostController::class, "search"]);

//add routes
Route::post('/categories', [CategoryController::class, "addCategory"]);
Route::post('/tags', [TagController::class, "addTag"]);
Route::post('/authors', [AuthorController::class, "addAuthor"]);
Route::post('/comments', [CommentController::class, "addComment"]);
Route::post('/blogposts', [BlogpostController::class, "addBlogpost"]);

//delete routes
Route::delete('/categories/{id}', [CategoryController::class, "deleteCategory"])->where('id', '[0-9]+');
Route::delete('/tags/{id}', [TagController::class, "deleteTag"])->where('id', '[0-9]+');
Route::delete('/authors/{id}', [AuthorController::class, "deleteAuthor"])->where('id', '[0-9]+');
Route::delete('/comments/{id}', [CommentController::class, "deleteComment"])->where('id', '[0-9]+');
Route::delete('/blogposts/{id}', [BlogpostController::class, "deleteBlogpost"])->where('id', '[0-9]+');

Route::fallback(function () {
    return response()->json([
        'message' => 'Url not found.'
    ], 404);
});
