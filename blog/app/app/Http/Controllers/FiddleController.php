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

class FiddleController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function fiddles()
    {
        //Het totaal aantal blogposts, featured blogposts en comments (3x int)
        $BlogpostCount = Blogpost::all()->count();
        dump($BlogpostCount);

        $BlogpostCountFeatured = Blogpost::where('featured', true)->count();
        dump($BlogpostCountFeatured);

        $CommentsCountFeatured = Comment::all()->count();
        dump($CommentsCountFeatured);

        //De blogpost met id 1 (Blogpost-object)
        $blogpostId= Blogpost::findOrFail(2);
        dump($blogpostId);

        //De voornaam van de auteur van blogpost met id 1 (string)
        $blogpostIdName = Blogpost::findOrFail(2)->author()->first()->first_name;
        dump($blogpostIdName);

        //De categorienaam van blogpost met id 1 (string)
        $blogpostIdName = Blogpost::findOrFail(2)->category()->first()->title;
        dump($blogpostIdName);

        //Alle blogposts waarvan de titel met een A begint, aflopend geordend op creaedatum (Eloquent-collection van Blogpost-objecten)
        $blogpostId = Blogpost::where('title', 'like', 'A%')->orderBy('created_at', 'DESC')->get();
        dump($blogpostId);

        //Een alfabetisch lijstje van de categorieën (assoc. array met keys = id en values = title)
        $blogpostId = Category::orderBy('title', 'ASC')->get()->pluck('title', 'id');
        dump($blogpostId);

        //Alle commentaren van de auteur met als voornaam Joris (Eloquent-collecon)
        $blogpostId = Author::where('first_name', 'Joris')->first()->comments;
        dump($blogpostId);

        //Alle blogposts die geen commentaren hebben (Eloquent-collecon)
        $blogpostId = Blogpost::doesntHave('Comments')->get();
        dump($blogpostId);

        //Voeg jezelf toe als auteur met een mass assignment (!) method
        $createAuthor = Author::updateOrCreate([
            'first_name' => 'Sander',
            'last_name' => 'Spaas',
            'email'=> 'sander.spaas@gmail.com',
            'website' => 'sander.com',
            'location' => 'Belgium'
        ]);
        $createAuthor;

        //Maak een commentaar aan in jouw naam (active record patern) bij blogpost 1 en sla op
        $comment = new Comment;
        $comment->content = "nou wat een leuke website zeg";
        $comment->blogpost_id = '2';
        $comment->author_id = Author::where('first_name', 'Sander')->first()->id;
        $comment->save();
    }
}
