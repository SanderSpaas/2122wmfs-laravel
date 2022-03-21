<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Author;
use App\Models\Blogpost;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Tag;

class CommentController extends Controller
{
    public function addComment(Request $request)
    {
        $request->validate(['content' => 'required|max:255', 'blogpost_id' => 'required|numeric', 'author_id' => 'required|numeric']);
        if (!Author::find($request->blogpost_id)) {
            return response()->json(['message' => 'The blogpost id: ' . $request->blogpost_id . ' could not be found'], 404);
        }
        if (!Author::find($request->author_id)) {
            return response()->json(['message' => 'The author id: ' . $request->author_id . ' could not be found'], 404);
        } else {
            $comment = new Comment();
            $comment->content = $request->content;
            $comment->blogpost_id = $request->blogpost_id;
            $comment->author_id = $request->author_id;
            $comment->save();
        }

        return response()->json(['message' => 'The comment: ' . $request->title . ' has been created'], 201);
    }
    public function deleteComment(Request $request)
    {
        if (!Comment::find($request->id)) {
            return response()->json(['message' => 'The comment id: ' . $request->id . ' could not be found'], 404);
        } else {
            Comment::destroy($request->id);
            return response()->json(['message' => 'The id: ' . $request->id . ' has been deleted'], 201);
        }
    }
}
