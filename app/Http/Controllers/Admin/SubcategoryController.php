<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Subcategory, Category};
use App\Http\Requests\SubcategoryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DataTables;

class SubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()) {
            $subcategories = Subcategory::with(['category:id,name',])
                ->orderBy(Category::select('name')
                ->whereColumn('categories.id','subcategories.category_id'))
                ->get();
           
            return DataTables::of($subcategories)
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
        return view('admin.subcategories.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubcategoryRequest $request)
    {
        $fields = $request->validated(); 
        $fields['slug'] = Str::slug($fields['name']);
        
        $subcategory = Subcategory::create($fields);

        return response()->json([
            'message' => 'Created subcategory successfully'],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Subcategory $subcategory)
    {
        return response()->json($subcategory);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SubcategoryRequest $request, Subcategory $subcategory)
    {
        $fields = $request->validated(); 
        $fields['slug'] = Str::slug($fields['name']);

        $subcategory->update($fields);

        return response()->json([
            'message' => 'Updated subcategory successfully'],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subcategory $subcategory)
    { 
        $subcategory->delete();

        return response()->json([
            'message' => 'Deleted subcategory successfully'],200);
    }
}
