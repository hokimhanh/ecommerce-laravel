@extends('layouts.admin.main')

@section('title', 'Sliders')

@section('vendor_css')
@parent
<link href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
<div class="main-content">
    <div class="container-fluid">
        <h2 class="page-title">Sliders</h2>
        <div class="form-group">
            <button type="button" class="btn btn-primary" onclick="onCreate()">Create new</button> 
        </div>
        <!-- TABLE HOVER -->
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">Slider Table</h3>
            </div>
            <div class="panel-body">
                <table id="sliderTable" class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th class="text-center">Name</th>
                            <th>Product</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@include('admin.sliders.create-edit-modal')
@include('layouts.admin.elements.delete-modal')
@endsection

@section('script')
@parent
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@include('admin.sliders.script')
@endsection