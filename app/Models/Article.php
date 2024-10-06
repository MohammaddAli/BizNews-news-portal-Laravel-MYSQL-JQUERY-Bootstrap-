<?php

namespace App\Models;

use App\Models\Comment;
use App\Models\Category;
use App\Models\Employee;
use App\Models\ArticleView;
use App\Models\ArticleImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'body',
        'is_feature',
        'categories_id',
        'employees_id',
    ];
    public function articleImage(){
       return $this->hasOne(ArticleImage::class,'articles_id');
    }
    public function category(){
        return $this->belongsTo(Category::class,'categories_id');
    }
    public function employee(){
        return $this->belongsTo(Employee::class,'employees_id');
    }
    public function articleViews(){
        return $this->hasMany(ArticleView::class, 'articles_id');
    }
    public function comments(){
        return $this->hasMany(Comment::class, 'articles_id');
    }
}
