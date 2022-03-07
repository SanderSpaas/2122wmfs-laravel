<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Author;
use App\Models\Blogpost;
use App\Models\Category;
use App\Models\Comment;
use Egulias\EmailValidator\Warning\Comment as WarningComment;

class MainController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function homepage()
    {
        $blogposts = Blogpost::where('featured', 1)->with('Category')->orderBy('created_at', 'ASC')->paginate(10);
        dump($blogposts);
        $categories = Category::all();
        return view('homepage', compact('blogposts', 'categories'));
    }
    public function blogpost(int $id)
    {
        $recentBlogposts = Blogpost::orderBy('created_at', 'ASC')->limit(10)->get();
        $categories = Category::all();
        $blogpost = Blogpost::where('id', $id)->with('Author')->orderBy('created_at', 'ASC')->paginate(10);
        $commentsBlogpost = Blogpost::where('id', $id)->with('Comments')->orderBy('created_at', 'ASC')->paginate(10);
        return view('blogpost', compact('blogpost', 'commentsBlogpost', 'recentBlogposts', 'categories'));
    }
    public function category(int $categoryID)
    {
        $recentBlogposts = Blogpost::orderBy('created_at', 'ASC')->limit(10)->get();
        $categories = Category::all();
        $blogposts = Blogpost::where('category_id', $categoryID)->with('Author')->with('Category')->orderBy('created_at', 'ASC')->paginate(10);
        dump($blogposts);
        return view('category', compact('blogposts', 'recentBlogposts', 'categories'));
    }
    public function add()
    {
        $recentBlogposts = Blogpost::orderBy('created_at', 'desc')->limit(10)->get();
        $categories = Category::all();
        $authors = Author::all();
        return view('add', ['recentBlogposts' => $recentBlogposts, 'categories' => $categories, 'authors' => $authors]);
    }
    public function author(int $id)
    {
        $recentBlogposts = Blogpost::orderBy('created_at', 'desc')->limit(10)->get();
        $categories = Category::all();
        $author = Author::where('id', $id)->get();
        $blogposts = Blogpost::where('author_id', $id)->get();
        dump($blogposts);
        return view('author', compact('blogposts', 'author', 'recentBlogposts', 'categories'));
    }

    public function store(Request $request)
    {
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
        return redirect('/');
    }
}
