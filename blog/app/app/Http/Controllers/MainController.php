<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\Author;
use App\Models\Blogpost;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Tag;
use BlogpostTag;
use Egulias\EmailValidator\Warning\Comment as WarningComment;
use Facade\Ignition\DumpRecorder\DumpHandler;
use SebastianBergmann\Environment\Console;
use Illuminate\Support\Facades\Auth;

class MainController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function homepage()
    {
        $blogposts = Blogpost::where('featured', 1)->with('Category', 'tags')->orderBy('created_at', 'desc')->paginate(10);
        // dump($blogposts);
        $categories = Category::all();
        return view('homepage', compact('blogposts', 'categories'));
    }
    public function blogpost(int $id)
    {
        $blogPostCheck = Blogpost::findOrFail($id);
        $recentBlogposts = Blogpost::orderBy('created_at', 'desc')->limit(10)->get();
        $categories = Category::all();
        $blogpost = Blogpost::where('id', $id)->with('Author', 'tags')->orderBy('created_at', 'desc')->firstOrFail();
        // dump($blogpost);
        $commentsBlogpost = Comment::where('blogpost_id', $id)->with('Author')->orderBy('created_at', 'desc')->get();
        // dump($commentsBlogpost);
        return view('blogpost', compact('blogpost', 'commentsBlogpost', 'recentBlogposts', 'categories'));
    }

    public function deleteBlogpost(int $id)
    {
        // $this->authorize('delete', Auth::id(), $id);
        Blogpost::findOrFail($id)->delete();
        return redirect('author/' . Auth::id());
    }


    public function category(int $categoryID)
    {
        $categoryCheck = Category::findOrFail($categoryID);
        $recentBlogposts = Blogpost::orderBy('created_at', 'desc')->limit(10)->get();
        $categories = Category::all();
        $blogposts = Blogpost::where('category_id', $categoryID)->with('Author', 'tags', 'Category')->orderBy('created_at', 'desc')->paginate(10);
        // dump($blogposts);
        return view('category', compact('blogposts', 'recentBlogposts', 'categories'));
    }

    public function author(int $id)
    {
        $recentBlogposts = Blogpost::orderBy('created_at', 'desc')->limit(10)->get();
        $categories = Category::all();
        $author = Author::where('id', $id)->firstOrFail();
        $blogposts = Blogpost::where('author_id', $id)->with('tags')->get();
        // dump($blogposts);
        return view('author', compact('blogposts', 'author', 'recentBlogposts', 'categories'));
    }
    public function search(Request $request)
    {

        $categories = Category::all();
        $authors = Author::all();
        // dump($request);

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
            $blogposts = $blogposts->paginate(6)->withQueryString();
        }
        return view('search', compact('blogposts', 'categories', 'authors'));
    }
    public function add()
    {
        $recentBlogposts = Blogpost::orderBy('created_at', 'desc')->limit(10)->get();
        $categories = Category::all();
        $authors = Author::all();
        return view('add', ['recentBlogposts' => $recentBlogposts, 'categories' => $categories, 'authors' => $authors]);
    }

    public function store(Request $request)
    {
        // var_dump($tags);
        $tag =  explode(" ", $request->tags);

        // Voor élk van de tags wordt het volgende uitgevoerd. Indien de tag nog niet bestaat
        // wordt deze toegevoegd als tag. Anders wordt de reeds bestaande tag opgehaald.
        // Vervolgens wordt de tag ook gelinkt aan de blogpost in de databank. Commit.
        $request->validate([
            'title' => 'required|unique:blogposts|max:125',
            'content' => 'required',
            'category_id' => 'required',
            'author_id' => 'required',
            'image' => 'image|mimes:jpeg,png|required'
        ]);
        $path = '';
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public');
        }
        if ($request->featured == null) {
            $request['featured'] = '0';
        } else {
            $request['featured'] = '1';
        }

        $author = Author::findOrFail($request->author_id);
        $category = Category::findOrFail($request->category_id);


        $blogpost = new Blogpost;
        $blogpost->title = $request->title;
        $blogpost->content = $request->input('content');
        $blogpost->featured = $request->featured;
        $blogpost->image = substr($path, 7);
        $blogpost->category()->associate($category);
        $blogpost->author()->associate($author);
        $blogpost->save();

        foreach ($tag as $t) {
            // dump($t);
            // Retrieve tag by name or create it if it doesn't exist...
            $tag = Tag::firstOrCreate([
                'title' => $t
            ]);
            $blogpost->tags()->attach($tag->id); //attach tag to the post
        }

        return redirect('/');
    }
}
