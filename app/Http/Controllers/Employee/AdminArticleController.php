<?php

namespace App\Http\Controllers\Employee;

use Carbon\Carbon;
use App\Models\Article;
use App\Models\Category;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class AdminArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:employee');
        $this->middleware('permission:write article|read article|update article|delete article', ['only' => ['index','show']]);
        $this->middleware('permission:write article', ['only' => ['create','store']]);
        $this->middleware('permission:update article', ['only' => ['edit','update']]);
        $this->middleware('permission:delete article', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::with('articleImage')->paginate(2);
        return view('Employee.article.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    $categories = Category::all();
    $employees = Employee::all();
    // if($allCategories && $allEmployees)
        return view('Employee.article.create', compact(['categories', 'employees']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|min:3',
            'body' => 'required|min:10',
            // 'is_feature' => ''
            'category' => 'exists:categories,id',
            'employee' => 'exists:employees,id',
        ]);

        Article::create([
            'title' => $request->title,
            'body' => $request->body,
            'is_feature' => $request->isFeature ? 1 : 0,
            'categories_id' => $request->category,
            'employees_id' => $request->employee,
        ]);

        Session::flash('done', 'Article is added successufully');

        // return redirect('Employee.article.index');
        return redirect()->route('employee.article-images.create');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $articles = Article::find($id);
        $categories = Category::all();
        $employees = Employee::all();
        return view('Employee.article.edit', compact('articles', 'categories', 'employees'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($request->all());
$article = Article::findOrfail($id);
        $request->validate([
            // $id => 'required|exists:articles,id',
            'title' => 'required|min:3',
            'body' => 'required|min:10',
            'category' => 'exists:categories,id',
            'employee' => 'exists:employees,id',
        ]);

        $article->update([
            'title' => $request->title,
            'body' => $request->body,
            'is_feature' => $request->isFeature ? 1 : 0,
            'categories_id' => $request->category,
            'employees_id' => $request->employee,
        ]);

        Session::flash('done', "Updated successfully!");
        return redirect()->route('employee.article-images.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $x = new AdminArticleImagesController;
        $x->index();
        // $article = Article::findOrFail($id);
        $article = Article::with('articleImage')->findOrFail($id);
        Storage::drive('public')->delete(str_replace('/storage/', '', $article->articleImage->url_main));
        Storage::drive('public')->delete(str_replace('/storage/', '', $article->articleImage->url_sub1));
        Storage::drive('public')->delete(str_replace('/storage/', '', $article->articleImage->url_sub2));

        $article->delete();
        Session::flash('done', 'deleted successfully');
        return redirect()->route('employee.articles.index');
    }
}
