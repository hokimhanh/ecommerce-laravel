@extends('layouts.admin.main')

@section('title', 'Edit | Blog')

@section('vendor_css')
@parent
@endsection

@section('content')
<div class="main-content">
    <div class="container-fluid">
        <h2 class="page-title">Blog</h2>
        <!-- FORM -->
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">Edit Blog</h3>
            </div>
            <div class="panel-body">
                @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                    @endforeach
                </div>
                @endif
                <form id="editBlogForm" action="{{ route('admin.blogs.update', ['blog' => $blog->id]) }}" method="POST"
                    enctype='multipart/form-data'>
                    @method('patch')
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name">Title*</label>
                                <input type="text" class="form-control" id="title" name="title"
                                    value="{{old('title',$blog->title)}}" placeholder="Please enter title blog">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="description">Description*</label>
                                <input type="text" class="form-control" id="discount" name="description"
                                    value="{{ old('description',$blog->description) }}"
                                    placeholder="Please enter description">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="prod_image">Cover Image*</label>
                                <div class="metric">
                                    <div class="cover-img-preview">
                                        <img src="{{ asset('files/'.$blog->cover_image) }}" width="40%"
                                            style="display: block;margin: auto;margin-bottom: 25px">
                                    </div>
                                    <div class="parent-upload">
                                        <label class="btn btn-success"><i class="fa fa-upload"></i> Choose
                                            image</label>
											<input type="text" name="old_cover_image" value="{{$blog->cover_image}}"
                                            hidden>
                                        <input type="file" id="image" name="cover_image[]" accept=".jpg, .jpeg, .png"
                                            onchange="imagesPreview(this, 'div.cover-img-preview');">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="content">Content*</label>
                                <textarea id="content" name="content">{!! old('content',$blog->content) !!}</textarea>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary pull-right">Save changes</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
@parent
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js">
</script>
<script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
@include('admin.blogs.script')
<script type="text/javascript">
$(document).ready(function() {
    // validate form
    $('#editBlogForm').validate({
        rules: {
            title: {
                required: true,
                maxlength: 255
            },
            description: {
                required: true,
                maxlength: 255
            }
        },
        errorPlacement: function(error, element) {
            console.log(element);
            if (element.is('input[type=file]')) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        }
    });
});
</script>
@endsection