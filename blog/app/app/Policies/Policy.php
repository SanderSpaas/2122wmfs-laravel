<?php

namespace App\Policies;

use App\Models\Author;
use App\Models\Blogpost;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class Policy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(Author $author)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\Author  $author
     * @param  \App\Models\Blogpost  $blogpost
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(Author $author, Blogpost $blogpost)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(Author $author)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\Author  $author
     * @param  \App\Models\Blogpost  $blogpost
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(Author $author, Blogpost $blogpost)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\Author  $author
     * @param  \App\Models\Blogpost  $blogpost
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(Author $author, Blogpost $blogpost)
    {
        // return Blogpost::find($blogpost)->get()->author_id === $author;
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\Author  $author
     * @param  \App\Models\Blogpost  $blogpost
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(Author $author, Blogpost $blogpost)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\Author  $author
     * @param  \App\Models\Blogpost  $blogpost
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(Author $author, Blogpost $blogpost)
    {
        //
    }
}
