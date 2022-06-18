@extends('layouts.admin.main')

@section('title', 'Edit | Products')

@section('vendor_css')
@parent
<link rel="stylesheet" href="{{ asset('admins/assets/vendor/tagsinput/bootstrap-tagsinput.css') }}">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
<div class="main-content">
    <div class="container-fluid">
        <h2 class="page-title">Products</h2>
        <!-- FORM -->
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">Edit Product</h3>
            </div>
            <div class="panel-body">
                @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                    @endforeach
                </div>
                @endif
                <form id="editProductForm" action="{{ route('admin.products.update', ['product' => $product->id]) }}"
                    method="POST" enctype='multipart/form-data'>
                    @method('patch')
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name">Name*</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ old('name', $product->name) }}" placeholder="Please enter product name">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="subcategoryId">Category*</label>
                                <select name="subcategory_id" id="subcategoryId" class="form-control"
                                    style="width: 100%">
                                    <option value="">Choose...</option>
                                    @foreach ($categories as $category )
                                    <optgroup label="{{$category->name}}">
                                        @foreach ($category->subcategories as $subcategory )
                                        <option value="{{$subcategory->id}}" @if ($subcategory->id ==
                                            old('subcategory_id', $product->subcategory_id)) selected @endif>
                                            {{$subcategory->name}}</option>
                                        @endforeach
                                    </optgroup>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="price">Price* ($)</label>
                                <input type="text" class="form-control" id="price" name="price"
                                    value="{{ old('price',$product->price) }}" placeholder="Please enter product price">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="discount">Discount (%)</label>
                                <input type="text" class="form-control" id="discount" name="discount"
                                    value="{{ old('discount',$product->discount) }}"
                                    placeholder="Please enter product discount">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label for="is_in_stock">Status*</label>
                            <select name="is_in_stock" id="isInStock" class="form-control" style="width: 100%">
                                <option value="1">In stock</option>
                                <option value="0" @if (old('is_in_stock',$product->is_in_stock) ==0) selected @endif>
                                    Not Available
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="productAttribute">Product attributes</label>
                            <table class="table table-bordered" id="attributeTable">
                                <tr>
                                    <th class="text-center" width="30%">
                                        <select name="options" id="attributeOption" class="form-control"
                                            style="width: 80%">
                                            <option value="">Select an option</option>
                                            @foreach ($attrArray as $key => $value)
                                            <option value="{{$key}}">
                                                {{$value}}</option>
                                            @endforeach
                                        </select>
                                    </th>
                                    <th class="text-center" width="50%">Option values</th>
                                    <th class="text-center" class="text-center"></th>
                                </tr>
                                @if (count(old('attributes', [])) > 0)
                                @foreach (old('attributes') as $index =>$item)
                                <tr>
                                    <td>{{$attrArray[$index]}}</td>
                                    <td>
                                        <input type="text" name="attributes[{{$index}}]" data-role="tagsinput"
                                            class="form-control" value="{{$item}}">
                                    </td>
                                    <td>
                                        <button type="button" name="remove" class="btn btn-danger btn-sm remove"><span
                                                class="glyphicon glyphicon-minus"></span></button>
                                    </td>
                                </tr>
                                @endforeach

                                @else                              
                                @foreach ($prodAttributeArray as $key =>$value )
                                <tr>
                                    <td>{{$attrArray[$key]}}</td>
                                    <td>
                                        <input type="text" name="attributes[{{$key}}]" data-role="tagsinput"
                                            class="form-control" value="{{$value}}">
                                    </td>
                                    <td>
                                        <button type="button" name="remove" class="btn btn-danger btn-sm remove"><span
                                                class="glyphicon glyphicon-minus"></span></button>
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="prod_image">Images*</label>
                                <div class="metric">
                                    <div class="product-img-preview">
                                        @foreach (json_decode($product->image_list) as $img_item)
                                        <img src="{{ asset('files/'.$img_item) }}" width="120px" style="margin:20px">
                                        @endforeach
                                    </div>
                                    <div class="parent-upload">
                                        <label class="btn btn-success"><i class="fa fa-upload"></i> Choose
                                            images</label>
                                        <input type="text" name="old_prod_images" value="{{$product->image_list}}"
                                            hidden>
                                        <input type="file" id="image" name="prod_images[]" accept=".jpg, .jpeg, .png"
                                            onchange="imagesPreview(this, 'div.product-img-preview');" multiple>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea id="description"
                                    name="description">{!! old('description',$product->description) !!}</textarea>
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
<script src="{{ asset('admins/assets/vendor/tagsinput/bootstrap-tagsinput.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js">
</script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js">
</script>
<script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
@include('admin.products.script')
<script type="text/javascript">
$(document).ready(function() {
    // validate form
    $('#editProductForm').validate({
        rules: {
            name: {
                required: true,
                maxlength: 255
            },
            subcategory_id: {
                required: true,
            },
            price: {
                required: true,
                number: true,
                maxlength: 16
            },
            discount: {
                number: true,
                range: [1, 100]
            }
        },
        errorPlacement: function(error, element) {
            // console.log(element);
            if (element.is('#subcategoryId')) {
                error.insertAfter(element.next('.select2-container'));
            } else if (element.is('input[type=file]')) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        }
    });
});
</script>
@endsection