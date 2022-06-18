@extends('layouts.admin.main')

@section('title', 'Dashboard')

@section('vendor_css')
@parent
@endsection

@section('content')
<div class="main-content">
    <div class="container-fluid">
        <!-- OVERVIEW -->
        <div class="panel panel-headline">
            <div class="panel-heading">
                <h3 class="panel-title">Overview</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="metric">
                            <span class="icon"><i class="fa fa-eye"></i></span>
                            <p>
                                <span class="number">{{$users}}</span>
                                <span class="title">Users</span>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="metric">
                            <span class="icon"><i class="fa fa-shopping-bag"></i></span>
                            <p>
                                <span class="number">{{$products}}</span>
                                <span class="title">Products</span>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="metric">
                            <span class="icon"><i class="fa fa-shopping-cart"></i></span>
                            <p>
                                <span class="number">{{$pendingOrders}}</span>
                                <span class="title">Pending orders</span>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="metric">
                            <span class="icon"><i class="fa fa-bar-chart"></i></span>
                            <p>
                                <span class="number">${{number_format($income, 2)}}</span>
                                <span class="title">Income</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END OVERVIEW -->
        <div class="row">
            <div class="col-md-12">
                <!-- RECENT PURCHASES -->
                <div class="panel">
                    <div class="panel-heading">
                        <h3 class="panel-title">Top 10 featured products of the month</h3>
                    </div>
                    <div class="panel-body no-padding">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th class="text-center">Discount (%)</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($featuredProducts as $product)
                                <tr>
                                    <td>{{$product->name}}</td>
                                    <td>${{number_format($product->price, 2)}}</td>
                                    <td class="text-center">
                                        {{ $product->discount ?? '-' }}
                                    </td>
                                    <td>
                                        @if ($product->is_in_stock == 1)
                                        <span class="label label-success">IN STOCK</span>
                                        @else
                                        <span class="label label-warning">NOT AVAILABLE</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- END RECENT PURCHASES -->
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
@parent
@endsection