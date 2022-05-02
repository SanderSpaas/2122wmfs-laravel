<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Author extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = ['first_name', 'last_name', 'email', 'website', 'location', 'updated_at', 'password', 'rememberTokem'];
    protected $hidden = ['id', 'created_at', 'password'];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function blogposts()
    {
        return $this->hasMany(Blogpost::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
