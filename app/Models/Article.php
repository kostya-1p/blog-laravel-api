<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'text',
        'author_id',
        'cover_image_name',
        'created_at',
        'updated_at'
    ];

    public function categories()
    {

    }
}
