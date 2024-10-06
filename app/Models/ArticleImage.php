<?php

namespace App\Models;

use App\Models\Article;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ArticleImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'url_main',
        'url_sub1',
        'url_sub2',
        'articles_id',
    ];
    public function article(){
       return $this->belongsTo(Article::class);
    }
}
