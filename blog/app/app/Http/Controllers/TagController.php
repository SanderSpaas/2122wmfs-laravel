<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Author;
use App\Models\Blogpost;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Tag;


class TagController extends Controller
{
    public function tag($id)
    {
        if ($tag = Tag::find($id)) {
            return ['data' => $tag];
        } else {
            return response()->json([
                'message' => 'No tag found with ID: ' . $id
            ], 404);
        }
    }
    public function tags()
    {
        return ['data' => Tag::all()];
    }

    public function addTag(Request $request)
    {
        $request->validate(['title' => 'required|unique:tags|max:30', '']);
        $tag = new Tag();
        $tag->title = $request->title;
        $tag->save();
        return response()->json(['message' => 'The tag: ' . $request->title . ' has been created'], 201);
    }

    public function deleteTag(Request $request)
    {
        if (!Tag::find($request->id)) {
            return response()->json(['message' => 'The tag id: ' . $request->id . ' could not be found'], 404);
        } else {
            Tag::destroy($request->id);
            return response()->json(['message' => 'The id: ' . $request->id . ' has been deleted'], 201);
        }
    }
}
