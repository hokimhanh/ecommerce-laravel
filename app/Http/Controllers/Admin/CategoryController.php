<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Http\Requests\CategoryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DataTables;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()) {
            $categories = Category::latest()->get();
           
            return DataTables::of($categories)
                ->addIndexColumn()
                ->addColumn('actions', function($row) {
                    return '<a href="javascript:void(0)" onclick="onEdit(event.currentTarget)"
                             data-id="'.$row['id'].'" class="btn btn-warning">
                             <i class="lnr lnr-pencil"></i></a>
                            <a href="javascript:void(0)" onclick="onDelete(event.currentTarget)"
                             data-id="'.$row['id'].'" class="btn btn-danger">
                             <i class="lnr lnr-trash"></i></a>';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
        return view('admin.categories.index');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $fields = $request->validated(); 
        $fields['slug'] = Str::slug($fields['name']);

        $category = Category::create($fields);

        return response()->json([
            'message' => 'Created category successfully'],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return response()->json($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $fields = $request->validated(); 
        $fields['slug'] = Str::slug($fields['name']);

        $category->update($fields);

        return response()->json([
            'message' => 'Updated category successfully'],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        if($category->subcategories()->count()) {
            return response()->json([
                'message' => 'Can not delete the category'],409);
        } 
        $category->delete();

        return response()->json([
            'message' => 'Deleted category successfully'],200);
    }
    public function getCategories()
    {
        $categories = Category::get(['id','name']);
        
        return response()->json($categories);
    }

}
