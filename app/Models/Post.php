<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $table = 'posts';

    protected $fillable = [
        'website_id',
        'title',
        'description'
    ];

     // Belongs-to relationship with the Website model
     public function website()
     {
         return $this->belongsTo(Website::class);
     }

     // Belongs-to relationship with the Website model
    //  public function post()
    //  {
    //     return $this->belongsTo(post::class);
    //  }
}
