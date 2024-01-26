<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Website extends Model
{
    use HasFactory;
    protected $table = 'websites';

    protected $fillable = [
        'name',
        'url'
    ];

    //relationship
    //one to many with subscriber model
    public function subscribers()
    {
        return $this->hasMany(Subscriber::class);
    }
    //one to many with post model
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

}
