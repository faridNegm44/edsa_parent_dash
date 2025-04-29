<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $table = 'posts';

    protected $fillable = [
        'address', 'description', 'tags', 'image',
    ];

    public function tags_name(){
        return $this->belongsTo(Tag::class, 'tags');
    }
}
