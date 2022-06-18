<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Http\Requests\BlogRequest;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DataTables;

class BlogController extends Controller
{
    protected $imageService;

	public function __construct(ImageService $imageService)
	{
		$this->imageService = $imageService;
	}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()) {
			$blogs = Blog::with('user:id,name')->latest()
				->get(['id','title','user_id','created_at']);
                
			return DataTables::of($blogs)
				->addIndexColumn()
				->addColumn('actions', function($row) {
					return '<a href="/admin/blogs/'.$row['id'].'/edit" class="btn btn-warning">
							<i class="lnr lnr-pencil"></i></a>
							<a href="javascript:void(0)" onclick="onDelete(event.currentTarget)"
							 data-id="'.$row['id'].'" class="btn btn-danger">
                             <i class="lnr lnr-trash"></i></a>';
				})
				->rawColumns(['actions'])
				->make(true);
		}
		return view('admin.blogs.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.blogs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BlogRequest $request)
    {
        $fields = $request->safe()->except(['cover_image']); 
        $fields['slug'] = Str::slug($fields['title']);
        $fields['user_id'] = auth()->user()->id;

        if($request->hasfile('cover_image')) {
		    $fields['cover_image'] = implode(
                $this->imageService->uploadImage($request->cover_image));
		}

        $blog = Blog::create($fields);

        return redirect()->route('admin.blogs.index')->with(
            'status', 'Blog created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Blog $blog)
    {  
       return view('admin.blogs.edit', compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BlogRequest $request, Blog $blog)
    {
        $fields = $request->safe()->except(['cover_image','old_cover_image']); 
        $fields['slug'] = Str::slug($fields['title']);

        if($request->hasfile('cover_image')) {
            $this->imageService->deleteImage(explode(' ',$request->old_cover_image));
		    $fields['cover_image'] = implode(
                $this->imageService->uploadImage($request->cover_image));
		}

        $blog->update($fields);

        return redirect()->route('admin.blogs.index')
		    ->with('status', 'Blog updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blog $blog)
    {
		$this->imageService->deleteImage(explode(' ',$blog->cover_image));
		$blog->delete();

		return response()->json([
            'message' => 'Deleted blog successfully'],200);
    }
}
