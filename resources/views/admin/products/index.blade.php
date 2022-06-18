@extends('layouts.admin.main')

@section('title', 'Products')

@section('vendor_css')
@parent
<link href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="main-content">
	<div class="container-fluid">
		<h2 class="page-title">Products</h2>
		<div class="form-group">
			<a href="{{ route('admin.products.create')}}" class="btn btn-primary">Create new</a>
		</div>
		<!-- TABLE HOVER -->
		<div class="panel">
			<div class="panel-heading">
				<h3 class="panel-title">Product Table</h3>
			</div>
			<div class="panel-body">
				<table id="productTable" class="table table-hover">
					<thead>
						<tr>
							<th>#</th>
							<th class="text-center">Name</th>
							<th>Category</th>
							<th>Price</th>
							<th>Discount</th>
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
@include('admin.products.show-modal')
@include('layouts.admin.elements.delete-modal')
@endsection

@section('script')
@parent
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function() {
	$('#productTable').DataTable({
		serverSide: true,
		ajax: {
			url: '{{ route('admin.products.index') }}',
		},
		columns: [{
				data: 'DT_RowIndex'
			},
			{
				data: 'name'
			},
			{
				data: 'subcategory.name'
			},
			{
				data: 'price',
				render: function(data) {
					return '$'+new Intl.NumberFormat('en-IN').format(data);
				}
			},
			{
				data: 'discount',
				render: function(data) {
					if (data ==null) {
						return '-';
					} else {
						return data+ '%';
					}
				}
			},
			{
				data: 'is_in_stock',
				render: function(data) {
					if (data == 1) {
						return '<span class="label label-success">In stock</span>';
					} else {
						return '<span class="label label-warning">Not available</span>';
					}
				}
			},
			{
				data: 'actions',
				orderable: false
			}

		],
		columnDefs: [{
			"targets": [2, 3, 4, 5,6],
			"className": "text-center",
		}]
	});

});
</script>
<script type="text/javascript">

@if(session('status'))
	toastr.success('{{ session('status') }}', 'Success')
@endif

function onShow(event) {
	var id = $(event).data('id');
	let _url = '{{ route('admin.products.show',':id')}}';
	_url = _url.replace(':id', id);
	$.ajax({
		url: _url,
		type: 'GET',
		success: function(response) {
			if (response) {
				$('.product-images').empty();
				$('#fDescription').empty();
				$('#fDescription').hide();

				$('#fName').text(response.name);
				$('#fSlug').text(response.slug);
				$('#fCategory').text(response.subcategory.name);
				$('#fPrice').text(new Intl.NumberFormat('en-IN').format(response.price));
				$('#fDiscount').text(response.discount);
				$('#fDescription').append(response.description);
				$('#fCreatedAt').text(new Date(response.created_at).toLocaleString('en-ZA'));
				$('#fUpdatedAt').text(new Date(response.updated_at).toLocaleString('en-ZA'));

				if (response.is_in_stock === 1) {
					$('#fStatus').text('In stock');
				} else {
					$('#fStatus').text('Not available');
				}
			   
				var images = JSON.parse(response.image_list);
				$.each(images, function(key, value) {
					var url = '{{ asset('files/') }}/'+value;
					var htmls= '';
					htmls += '<img src="'+url+'" width="120px" style="margin:20px">';
					$('.product-images').append(htmls);
				});

				$('#showModal').modal('show');
			}
		}
	});
	
}
function onDelete(event) {
	$('#delId').val($(event).data('id'));
	$('#deleteModal').modal('show');
}

function deleteData() {
	var id = $('#delId').val();
	let _url = '{{ route('admin.products.destroy',':id')}}';
	_url = _url.replace(':id', id);
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	$.ajax({
		url: _url,
		type: 'DELETE',
		success: function(response, textStatus, jqXHR) {
			if (jqXHR.status == 200) {
				$('#deleteModal').modal('hide');
				toastr.success(response.message, 'Success')
				$('#productTable').DataTable().ajax.reload(null, false);
			}
		},
		error: function(jqXHR) {
			if (jqXHR.status && jqXHR.status == 409) {
				$('#deleteModal').modal('hide');
				var errors = $.parseJSON(jqXHR.responseText);
				$.each(errors, function(key, value) {
					toastr.error(value, 'Error')
				});
			}
		}
	});
}
$('#hideShowText').click(function(){
	$('#fDescription').toggle();
  });
</script>
@endsection