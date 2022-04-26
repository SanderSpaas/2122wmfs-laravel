<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use App\Models\Author;
use App\Models\Blogpost;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Tag;
class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $blogposts = Blogpost::where('featured', 1)->with('Category', 'tags')->orderBy('created_at', 'desc')->paginate(10);
        // dump($blogposts);
        $categories = Category::all();
        $recentBlogposts = Blogpost::orderBy('created_at', 'desc')->limit(10)->get();
        return view('register', compact('blogposts', 'categories', 'recentBlogposts'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:authors'],
            'location' => ['required', 'string', 'max:255'],
            'website' => ['required', 'string', 'max:255', 'unique:authors'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $author = Author::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'location' => $request->location,
            'website' => $request->website,
        ]);

        event(new Registered($author));

        Auth::login($author);

        return redirect(RouteServiceProvider::HOME);
    }
}
