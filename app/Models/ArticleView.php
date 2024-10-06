<?php

namespace App\Models;

use App\Models\User;
use App\Models\Article;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ArticleView extends Model
{
    use HasFactory;

    protected $fillable = [
        'articles_id',
        'users_id',
    ];

    public function article(){
        return $this->belongsTo(Article::class, 'articles_id');
    }
    public function user(){
        return $this->belongsTo(User::class,'users_id');
    }
}
