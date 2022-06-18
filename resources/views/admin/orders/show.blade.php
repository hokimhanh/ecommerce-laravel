@extends('layouts.admin.main')

@section('title', 'Order | Details')

@section('vendor_css')
@parent
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
<div class="main-content">
    <div class="container-fluid">
        <h2 class="page-title">Orders details #{{$orderDetails->id}}</h2>
        <div class="row">
            <div class="col-md-8">
                <!-- PANEL HEADLINE -->
                <div class="panel">
                    <div class="panel-heading">
                        <h3 class="panel-title">Order information</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="name">Customer name: </label>
                                <span>{{$orderDetails->name}}</span>
                            </div>
                            <div class="col-md-6">
                                <label for="name">Phone: </label>
                                <span>{{$orderDetails->phone}}</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="name">Address: </label>
                                <span>{{$orderDetails->address}}</span>
                            </div>
                            <div class="col-md-6">
                                <label for="name">Ordered at: </label>
                                <span>{{$orderDetails->created_at}}</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="name">Note: </label>
                                <span>{{$orderDetails->note}}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END PANEL HEADLINE -->
            </div>
            <div class="col-md-4">
                <!-- PANEL NO CONTROLS -->
                <div class="panel">
                    <div class="panel-heading">
                        <h3 class="panel-title">Status order</h3>
                    </div>
                    <div class="panel-body">
                        @if ($orderDetails->status == 0)
                        Cancelled by user.
                        @else
                        <form action="{{ route('admin.orders.update', $orderDetails->id)}}" method="POST">
                            @csrf
                            <input type="hidden" name="_method" value="PUT">
                            <div class="form-group">
                                <select name="status" id="status" class="form-control" style="width: 100%">
                                    <option value="1" @if ($orderDetails->status == 1) selected @endif>
                                        Pending
                                    </option>
                                    <option value="2" @if ($orderDetails->status == 2) selected @endif>
                                        Confirmed
                                    </option>
                                    <option value="3" @if ($orderDetails->status == 3) selected @endif>
                                        Delivery
                                    </option>
                                    <option value="4" @if ($orderDetails->status == 4) selected @endif>
                                        Completed
                                    </option>
                                    <option value="5" @if ($orderDetails->status == 5) selected @endif>
                                        Cancelled by admin
                                    </option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary pull-right">Change status</button>
                        </form>
                        @endif
                    </div>
                </div>
                <!-- END PANEL NO CONTROLS -->
            </div>
        </div>
        <!-- OVERVIEW -->
        <div class="row">
            <div class="col-md-12">
                <!-- TABLE STRIPED -->
                <div class="panel">
                    <div class="panel-heading">
                        <h3 class="panel-title">Items</h3>
                    </div>
                    <div class="panel-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Options</th>
                                    <th class="text-center">Price</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-center">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orderDetails->products as $item)
                                <tr>
                                    <td>{{$item->name}}</td>
                                    <td>{{$item->pivot->options}}</td>
                                    <td class="text-center">
                                        ${{number_format($item->pivot->price, 2)}}
                                    </td>
                                    <td class="text-center">
                                        {{$item->pivot->quantity}}
                                    </td>
                                    <td class="text-center">
                                        ${{number_format($item->pivot->total, 2)}}
                                    </td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="text-right">
                                        <b>Subtotal:</b>
                                    </td>
                                    <td class="text-center">
                                        <b>${{number_format($orderDetails->subtotal, 2)}}</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="text-right">
                                        <b>Shipping fee:

                                    </td>
                                    <td class="text-center">
                                        <b>${{number_format($orderDetails->shipping_fee, 2)}}</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="text-right">
                                        <b>Total:
                                    </td>
                                    <td class="text-center">
                                        <b>${{number_format($orderDetails->total, 2)}}</b>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- END TABLE STRIPED -->
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
@parent
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    $('#status').select2();
    @if(session('status'))
    toastr.success('{{ session('status') }}', 'Success')
    @endif
});
</script>
@endsection