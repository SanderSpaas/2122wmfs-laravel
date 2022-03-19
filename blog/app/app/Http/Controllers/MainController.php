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
        $blogposts = Blogpost::with('Category', 'tags')->orderBy('created_at', 'desc')->paginate(10);
        $categories = Category::all();
        $authors = Author::all();
        dump($request);

        $blogposts = Blogpost::query();

        //search term
        if ($request->filled('term')) { // might be some other condition e.g. has(), == 0
            $blogposts = Blogpost::where('title', 'like', '%' . $request->term . '%');
        }

        //Tags
        // if ($request->filled('tags')) { // might be some other condition e.g. has(), == 0
        //     $tagsArray = explode(',', $request->tags);
        //     $blogposts = $blogposts->whereIn('title', $tagsArray);
        // }

        //category

        //author
        $request->author;
        //blogposts after

        //blogposts before

        //sort by

        //zoeken
        $blogposts = Blogpost::get();
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
