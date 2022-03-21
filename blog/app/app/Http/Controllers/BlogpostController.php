<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Author;
use App\Models\Blogpost;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Tag;

class BlogpostController extends Controller
{
    public function blogpost($id)
    {
        if ($blogpost = Blogpost::with('author', 'comments', 'tags', 'category')->find($id)) {
            return ['data' => $blogpost];
        } else {
            return response()->json([
                'message' => 'No blogpost found with ID: ' . $id
            ], 404);
        }
    }
    public function blogposts()
    {
        return ['data' => Blogpost::all()];
    }

    public function addBlogpost(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:blogposts|max:125',
            'content' => 'required',
            'category_id' => 'required',
            'author_id' => 'required',
            'image' => 'required', //image|mimes:jpeg,png|
            'featured' => 'numeric'
        ]);

        if ($request->featured == null) {
            $request['featured'] = '0';
        } else {
            $request['featured'] = '1';
        }
        if (!Author::find($request->author_id)) {
            return response()->json(['message' => 'The author id: ' . $request->author_id . ' could not be found'], 404);
        }
        if (!Author::find($request->category_id)) {
            return response()->json(['message' => 'The category id: ' . $request->category_id . ' could not be found'], 404);
        } else {
            $blogpost = new Blogpost();
            $blogpost->title = $request->title;
            $blogpost->content = $request->content;
            $blogpost->image = $request->image;
            $blogpost->featured = $request->featured;
            $blogpost->author_id = $request->author_id;
            $blogpost->category_id = $request->category_id;
            $blogpost->save();
        }
        return response()->json(['message' => 'The blogpost: ' . $request->title . ' has been created'], 201);
    }
    public function deleteBlogpost(Request $request)
    {
        if (!Blogpost::find($request->id)) {
            return response()->json(['message' => 'The blogpost id: ' . $request->id . ' could not be found'], 404);
        } else {
            return Blogpost::destroy($request->id);
        }
    }

    public function featured()
    {
        return ['data' => Blogpost::where('featured', 1)->get()];
    }

    public function search(Request $request)
    {
        // $request->validate([
        //     'title' => 'required|unique:blogposts|max:125',
        //     'content' => 'required',
        //     'category_id' => 'required',
        //     'author_id' => 'required',
        //     'image' => 'required', //image|mimes:jpeg,png|
        //     'featured' => 'numeric'
        // ]);

        $terms = explode(" ", strtolower($request->term));
        $tags = explode(" ", strtolower($request->tags));
        $blogposts = Blogpost::orderBy('title')->paginate(6);

        if (count($request->all()) > 0) {
            $blogposts = Blogpost::query();

            //search term
            if ($terms[0] !== "") {
                if ($request->filled('term')) {
                    $termArray = explode(',', $request->term);
                    for ($i = 0; $i < count($termArray); $i++) {
                        $blogposts->where('title', 'like', '%' . $termArray[$i] . '%');
                    }
                }
            }

            //tags
            if ($tags[0] !== "") {
                // dump($tags);
                $blogposts = $blogposts->whereHas('tags', function ($query) use ($tags) {
                    if (count($tags) >= 1) {
                        $query->where('tags.title', 'like', '%' . $tags[0] . '%');
                        for ($i = 1; $i < count($tags); $i++) {
                            $query->orwhere('tags.title', 'like', '%' . $tags[$i] . '%');
                        }
                    } else {
                        for ($i = 0; $i < count($tags); $i++) {
                            $query->where('tags.title', 'like', '%' . $tags[$i] . '%');
                        }
                    }
                });
            }

            //author
            if ($request->filled('author_id')) {
                $blogposts->where('author_id', $request->author_id);
            }
            //category
            if ($request->filled('category_id')) {
                $blogposts->where('category_id', $request->category_id);
            }

            //blogposts after
            if ($request->filled('after')) {
                $blogposts->where('created_at', '>', $request->after);
            }
            //blogposts before
            if ($request->filled('before')) {
                $blogposts->where('created_at', '<', $request->before);
            }

            //sort by
            if ($request->sort == 'title') {
                $blogposts->orderBy('title');
            } else if ($request->sort == 'most_recent') {
                $blogposts->orderBy('created_at', 'desc');
            } else {
                $blogposts->orderBy('created_at');
            }

            //zoeken
            return $blogposts->paginate(6);
        }
    }
}
