<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class AdminCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:employee');
        $this->middleware('permission:CRUD category', ['only' => ['index','show']]);
        $this->middleware('permission:CRUD category', ['only' => ['create','store']]);
        $this->middleware('permission:CRUD category', ['only' => ['edit','update']]);
        $this->middleware('permission:CRUD category', ['only' => ['destroy']]);
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return view('Employee.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Employee.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $request->validate(['title' => 'required|unique:posts|max:255','body' => 'required',]);
        $request->validate(['name'=> 'required|min:3|unique:categories,name|alpha']);
        $category = Category::create(['name' => $request->name]);
        session()->flash('done', 'category added successfully');
        // return redirect('employee/categories/index');
        return redirect()->route('employee.categories.index');
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
        $category = Category::find($id);
        return view("Employee.category.edit", compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate(['name' => 'required|min:3|unique:categories,name|alpha']);
       $category = Category::find($id);
       $category->update(['name' => $request->name]);
       return redirect('categories');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Category::destroy($id);
        return redirect()->back();
    }
}
