@extends('layouts.admin.main')

@section('title', 'Orders')

@section('vendor_css')
@parent
<link href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="main-content">
    <div class="container-fluid">
        <h2 class="page-title">Orders</h2>
        <!-- TABLE HOVER -->
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">Order Table</h3>
            </div>
            <div class="panel-body">
                <table id="orderTable" class="table table-hover">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer Name</th>
                            <th>Phone</th>
                            <th>Ordered at</th>
                            <th>Total</th>
                            <th>Status</th>
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
@endsection

@section('script')
@parent
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function() {
    $('#orderTable').DataTable({
        serverSide: true,
        ajax: {
            url: '{{ route('admin.orders.index') }}',
        },
        columns: [{
                data: 'id'
            },
            {
                data: 'name'
            },
            {
                data: 'phone',
                orderable: false,
            },
            {
                data: 'created_at',
                orderable: false,
                render: function(data) {
                    if (data != null) {
                        return new Date(data).toLocaleString('en-ZA');
                    }
                }
            },
            {
                data: 'total',
                render: function(data) {
                    return '$' + new Intl.NumberFormat('en-IN').format(data);
                }
            },
            {
                data: 'status',
                render: function(data) {
                    if (data == 0) {
                        return '<span class="label label-warning">Cancelled by user</span>';
                    }
					if (data == 1) {
                        return '<span class="label label-default">Pending</span>';
                    }
					if (data == 2) {
                        return '<span class="label label-info">Confirmed</span>';
                    }
					if (data == 3) {
                        return '<span class="label label-primary">Delivery</span>';
                    }
					if (data == 4) {
                        return '<span class="label label-success">Completed</span>';
                    }
					 else {
                        return '<span class="label label-danger">Cancelled by admin</span>';
                    }
                }
            },
            {
                data: 'actions',
                orderable: false
            }

        ],
        columnDefs: [{
            "targets": [2, 3, 4, 5, 6],
            "className": "text-center",
        }]
    });

});
</script>
@endsection