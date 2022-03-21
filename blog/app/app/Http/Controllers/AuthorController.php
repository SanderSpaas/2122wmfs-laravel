<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Author;
use App\Models\Blogpost;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Tag;

class AuthorController extends Controller
{
    //getting data
    public function author($id)
    {
        if ($author = Blogpost::with('author', 'tags', 'category')->where('author_id', $id)->get()) {
            return ['data' => $author];
        } else {
            return response()->json([
                'message' => 'No tag found with author: ' . $id
            ], 404);
        }
    }
    public function authors()
    {
        return ['data' => Author::all()];
    }



    //adding data
    public function addAuthor(Request $request)
    {
        $request->validate(['first_name' => 'required|max:30', 'last_name' => 'required|max:30', 'email' => 'required|email|unique:authors', 'website' => 'required|max:30', 'location' => 'required|max:50']);
        $author = new Author();
        $author->first_name = $request->first_name;
        $author->last_name = $request->last_name;
        $author->email = $request->email;
        $author->website = $request->website;
        $author->location = $request->location;
        $author->save();
        return response()->json(['message' => 'The author: ' . $request->first_name . ' has been created'], 201);
    }


    //deleting data
    public function deleteAuthor(Request $request)
    {
        if (!Author::find($request->id)) {
            return response()->json(['message' => 'The author id: ' . $request->id . ' could not be found'], 404);
        } else {
            return Author::destroy($request->id);
        }
    }
}
