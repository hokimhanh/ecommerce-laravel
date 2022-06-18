<script>
    $(document).ready(function () {
        $('#attributeTable').DataTable({
  			serverSide: true,
  			ajax:{
   				url: '{{ route('admin.attributes.index') }}',
  			},
			columns: [
				{
					data:'DT_RowIndex'
				},
				{
					data:'name'
				},
				{
					data:'created_at',
					orderable: false,
                	render: function(data) {
						if (data !=null) {
							return new Date(data).toLocaleString('en-ZA');
						}
					}
					
				},
				{
					data:'actions',
					orderable: false
				}
				
			],
        	columnDefs: [
        	    {
        	        "targets": [1, 2, 3] , 
        	        "className": "text-center"
        	    }
        	]
		});
    });
</script>
<script type="text/javascript">
	function onCreate() {
		$('#createEditForm').validate().resetForm();
		$('#createEditForm').trigger('reset');
		$('#modalTitle').html('Create Attribute');		
		$('#createEditForm').attr('onsubmit', 'storeData()');	
		$('#createEditModal').modal('show');
	}
	function onEdit(event) {
		var id  = $(event).data('id');
    	let _url = '{{ route('admin.attributes.show',':id')}}';
		_url = _url.replace(':id', id);
		$.ajax({
			url: _url,
			type: 'GET',
			success: function(response) {
				if(response) {
					$('#createEditForm').validate().resetForm();
					$('#modalTitle').html('Edit Attribute');
					$('#id').val(response.id);
					$('#name').val(response.name);
					$('#createEditForm').attr('onsubmit', 'updateData()');
					$('#createEditModal').modal('show');
				}
			}
    	});
	}
	function onDelete(event) {
		$('#delId').val($(event).data('id'));
		$('#deleteModal').modal('show');
	}
	function storeData() {
		var name = $('#name').val();
		let _url = '{{ route('admin.attributes.store')}}';
		$.ajaxSetup({
    		headers: {
        	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		}
		});
		$.ajax({
			url: _url,
			type: 'POST',
			data: {
				name: name
        	},
			beforeSend: function(){
				$('#btnSave').html('Please wait...');
        		$('#btnSave').attr('disabled', true);
   			},
			success: function(response,textStatus, jqXHR) {
					if(jqXHR.status == 201) {
						$('#createEditModal').modal('hide');
						$('#btnSave').html('Save changes');
        				$('#btnSave').attr('disabled', false);
						toastr.success(response.message, 'Success')
						$('#attributeTable').DataTable().ajax.reload(null, false);
					}
				
			},
			error: function(jqXHR) {  
               if(jqXHR.status&&jqXHR.status==422){
					var errors = $.parseJSON(jqXHR.responseText);
					var errorString = '';
					$.each(errors['errors'], function (key, value) {
						errorString += `<p>${value}</p>`;
        			});
					toastr.error(errorString, 'Error')
					$('#btnSave').html('Save changes');
        			$('#btnSave').attr('disabled', false); 
            	}
			   	else
			   	{
				   console.log(jqXHR.responseText);
			   	}
			}
    	});
	}
	function updateData() {
		var id  = $('#id').val();
		var name = $('#name').val();
		let _url = '{{ route('admin.attributes.update',':id')}}';
		_url = _url.replace(':id', id);
		$.ajaxSetup({
    		headers: {
        	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		}
		});
		$.ajax({
			url: _url,
			type: 'PUT',
			data: {
				name: name
        	},
			beforeSend: function(){
				$('#btnSave').html('Please wait...');
        		$('#btnSave').attr('disabled', true);
   			},	
			success: function(response,textStatus, jqXHR) {
					if(jqXHR.status == 200) {
						$('#createEditModal').modal('hide');
						$('#btnSave').html('Save changes');
        				$('#btnSave').attr('disabled', false);
						toastr.success(response.message, 'Success')
						$('#attributeTable').DataTable().ajax.reload(null, false);
					}
				
			},
			error: function(jqXHR) {  
               if(jqXHR.status&&jqXHR.status==422){
					var errors = $.parseJSON(jqXHR.responseText);
					var errorString = '';
					$.each(errors['errors'], function (key, value) {
						errorString += `<p>${value}</p>`;
        			});
					toastr.error(errorString, 'Error')
					$('#btnSave').html('Save changes');
        			$('#btnSave').attr('disabled', false); 
            	}
			}
    	});
	}
	function deleteData() {
		var id  = $('#delId').val();
		let _url = '{{ route('admin.attributes.destroy',':id')}}';
		_url = _url.replace(':id', id);
		$.ajaxSetup({
    		headers: {
        	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		}
		});
		$.ajax({
			url: _url,
			type: 'DELETE',
			success: function(response,textStatus, jqXHR) {
					if(jqXHR.status == 200) {
						$('#deleteModal').modal('hide');
						toastr.success(response.message, 'Success')
						$('#attributeTable').DataTable().ajax.reload(null, false);		
					}
			},
			error: function(jqXHR) {  
               if(jqXHR.status&&jqXHR.status==409) {
					$('#deleteModal').modal('hide');
					var errors = $.parseJSON(jqXHR.responseText);
					$.each(errors, function (key, value) {
						toastr.error(value, 'Error')
        			}); 
            	}
			}
    	});
	}
</script>
<script type="text/javascript">
	$(document).ready(function() {
		$('#createEditForm').submit(function(e){
    		e.preventDefault();
  		});
		//   validate form
		$('#createEditForm').validate({
			rules: {
				name: {
					required: true,
					maxlength: 50
				}
			}
			});
		$('#btnSave').click(function() {
 			if($('#createEditForm').valid()) {
				$('#createEditForm').submit();
			}
		});
		toastr.options = {
			'preventDuplicates': true,
			'preventOpenDuplicates': true
		};
	});
</script>