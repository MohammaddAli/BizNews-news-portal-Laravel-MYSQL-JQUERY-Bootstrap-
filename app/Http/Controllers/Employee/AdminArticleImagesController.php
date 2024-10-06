<?php

namespace App\Http\Controllers\Employee;

use Log;
use App\Models\Article;
use App\Models\ArticleImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class AdminArticleImagesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return 1;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $articles = Article::all();
        return view('Employee.articleImages.create', compact('articles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'mainCover' => 'required|file|image|mimes:jpeg,png,jpg,gif,svg,webp',
            'firstSubCover' => 'required|file|image|mimes:jpeg,png,jpg,gif,svg,webp',
            'secondSubCover' => 'required|file|image|mimes:jpeg,png,jpg,gif,svg,webp',
            'singleNewsTitle' => 'required|exists:articles,id',
        ]);

        $url_main = $request->file('mainCover')->store('Employees/articleImages', 'public');
        $url_sub1 = $request->file('firstSubCover')->store('Employees/articleImages', 'public');
        $url_sub2 = $request->file('secondSubCover')->store('Employees/articleImages', 'public');
        // dd("/storage/{$url_main}");
        ArticleImage::create([
            'url_main' => "/storage/{$url_main}",
            'url_sub1' => "/storage/{$url_sub1}",
            'url_sub2' => "/storage/{$url_sub2}",
            "articles_id" => $request->singleNewsTitle
        ]);

        Session::flash('success', 'image was added successfully !');
        return redirect()->route('employee.articles.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $articles_id)
    {
        // $articleImages = ArticleImage::where('articles_id', '=', $articles_id)->get();
        // return view('Employee.article.index', compact('articleImages'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $articleImages = ArticleImage::where('articles_id', '=', $id)->get()->first();
        return view('Employee.articleImages.edit', compact('articleImages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $articleImage = ArticleImage::findOrFail($id);
        $request->validate([
            'mainCover' => 'nullable|file|image|mimes:jpeg,png,jpg,gif,svg,webp',
            'firstSubCover' => 'nullable|file|image|mimes:jpeg,png,jpg,gif,svg,webp',
            'secondSubCover' => 'nullable|file|image|mimes:jpeg,png,jpg,gif,svg,webp',
        ]);

        $url_main = $articleImage->url_main;
        $url_sub1 = $articleImage->url_sub1;
        $url_sub2 = $articleImage->url_sub2;

        if($request->hasFile('mainCover')){
            // $imagePath = substr($articleImage->url_main, 9);   OR
            $imagePath = str_replace('/storage/', '', $articleImage->url_main);
            Storage::disk('public')->delete($imagePath);
            $url_main = $request->file('mainCover')->store('Employees/articleImages', 'public');
            $url_main = "/storage/{$url_main}";
        }
        if($request->hasFile('firstSubCover')){
            $imagePath = str_replace('/storage/', '', $articleImage->url_sub1);
            Storage::disk('public')->delete($imagePath);
            $url_sub1 = $request->file('firstSubCover')->store('Employees/articleImages', 'public');
            $url_sub1 = "/storage/{$url_sub1}";
        }
        if($request->hasFile('secondSubCover')){
            $imagePath = str_replace('/storage/', '', $articleImage->url_sub2);
            Storage::disk('public')->delete($imagePath);
            $url_sub2 = $request->file('secondSubCover')->store('Employees/articleImages', 'public');
            $url_sub2 = "/storage/{$url_sub2}";
        }
        $articleImage->update([
            'url_main' => $url_main,
            'url_sub1' => $url_sub1,
            'url_sub2' => $url_sub2,
        ]);

        Session::flash('done', "images updated successfully");
        return redirect()->route('employee.articles.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
