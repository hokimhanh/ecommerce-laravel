<script>
$(document).ready(function() {
    // get data to table
    $('#subcategoryTable').DataTable({
        serverSide: true,
        ajax: {
            url: '{{ route('admin.subcategories.index') }}',
        },
        columns: [{
                data: 'DT_RowIndex'
            },
            {
                data: 'name'
            },
            {
                data: 'category.name'
            },
            {
                data: 'created_at',
                orderable: false,
                render: function(data) {
					if (data !=null) {
						return new Date(data).toLocaleString('en-ZA');
					}
				}
            },
            {
                data: 'actions',
                orderable: false
            }
        ],
        columnDefs: [
            {
                "targets": [1,2,3,4] , 
                "className": "text-center"
            }
        ],
        initComplete: function() {
            this.api().columns([2]).every( function () {
                var column = this;
                var select = 
                    $('<select class="form-control input-group"><option value="">'+this.header().textContent+'</option></select>')
                    .appendTo($('.filter-table') )
                    .on('change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
 
                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );
 
                column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                } );
            } );
        }
    });
    //add data to select option
    getCategories();
});
</script>
<script type="text/javascript">
function onCreate() {
    $('#createEditForm').validate().resetForm();
    $('#createEditForm').trigger('reset');
    $('#categoryId').val(null).trigger('change');
    $('#modalTitle').html('Create Subcategory');
    $('#createEditForm').attr('onsubmit', 'storeData()');
    $('#createEditModal').modal('show');
}

function onEdit(event) {
    var id = $(event).data('id');
    let _url = '{{ route('admin.subcategories.show',':id')}}';
    _url = _url.replace(':id', id);
    $.ajax({
        url: _url,
        type: 'GET',
        success: function(response) {
            if (response) {
                $('#createEditForm').validate().resetForm();
                $('#modalTitle').html('Edit Subcategory');
                $('#id').val(response.id);
                $('#name').val(response.name);
                $("#categoryId").val(response.category_id).trigger('change');
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

function getCategories() {
    let _url = '{{ route('admin.categories.list') }}';
    $.ajax({
        url: _url,
        type: 'GET',
        success: function(response) {
            if (response) {
                $.each(response, function(key, value) {
                    $('#categoryId').append($('<option>', {
                        value: value.id,
                        text: value.name
                    }));
                });
            }
        }
    });
}

function storeData() {
    var name = $('#name').val();
    var category_id = $("#categoryId").val();
    let _url = '{{ route('admin.subcategories.store')}}';
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: _url,
        type: 'POST',
        data: {
            name: name,
            category_id: category_id
        },
        beforeSend: function() {
            $('#btnSave').html('Please wait...');
            $('#btnSave').attr('disabled', true);
        },
        success: function(response, textStatus, jqXHR) {
            if (jqXHR.status == 201) {

                $('#createEditModal').modal('hide');
                $('#btnSave').html('Save changes');
                $('#btnSave').attr('disabled', false);
                toastr.success(response.message, 'Success')
                $('#subcategoryTable').DataTable().ajax.reload(null, false);
            }

        },
        error: function(jqXHR) {
            if (jqXHR.status && jqXHR.status == 422) {
                var errors = $.parseJSON(jqXHR.responseText);
                var errorString = '';
                $.each(errors['errors'], function(key, value) {
                    errorString += `<p>${value}</p>`;
                });
                toastr.error(errorString, 'Error')

                $('#btnSave').html('Save changes');
                $('#btnSave').attr('disabled', false);
            } else {
                console.log(jqXHR);
            }
        }
    });

}

function updateData() {
    var id = $('#id').val();
    var name = $('#name').val();
    var category_id = $("#categoryId").val();
    let _url = '{{ route('admin.subcategories.update',':id')}}';
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
            name: name,
            category_id: category_id
        },
        beforeSend: function() {
            $('#btnSave').html('Please wait...');
            $('#btnSave').attr('disabled', true);
        },
        success: function(response, textStatus, jqXHR) {
            if (jqXHR.status == 200) {
                $('#createEditModal').modal('hide');
                $('#btnSave').html('Save changes');
                $('#btnSave').attr('disabled', false);

                toastr.success(response.message, 'Success')

                $('#subcategoryTable').DataTable().ajax.reload(null, false);
            }

        },
        error: function(jqXHR) {
            if (jqXHR.status && jqXHR.status == 422) {
                var errors = $.parseJSON(jqXHR.responseText);
                var errorString = '';
                $.each(errors['errors'], function(key, value) {
                    errorString += `<p>${value}</p>`;
                });
                toastr.error(errorString, 'Error')
                $('#btnSave').html('Save changes');
                $('#btnSave').attr('disabled', false);
            } else {
                console.log(jqXHR);
            }
        }
    });

}

function deleteData() {
    var id = $('#delId').val();
    let _url = '{{ route('admin.subcategories.destroy',':id')}}';
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
                $('#subcategoryTable').DataTable().ajax.reload(null, false);
            }
        }
    });
}
</script>
<script type="text/javascript">
$(document).ready(function() {
    // using select2
    $('#categoryId').select2({
        selectOnClose: true,
        dropdownParent: $('#createEditModal')
    });
    /*
     * When you change the value the select via select2, it triggers
     * a 'change' event, but the jquery validation plugin
     * only re-validates on 'blur'
     */
    $('#categoryId').on('change', function() {
        $(this).trigger('blur');
    });

    $('#createEditForm').submit(function(e) {
        e.preventDefault();
    });

    // validate form
    $('#createEditForm').validate({
        rules: {
            name: {
                required: true,
                maxlength: 255
            },
            categoryId: {
                required: true,
            }
        },
        errorPlacement: function(error, element) {
            if (element.is('#categoryId')) {
                error.insertAfter(element.next('.select2-container'));
            } else {
                error.insertAfter(element);
            }
        }
    });
    $('#btnSave').click(function() {
        if ($('#createEditForm').valid()) {
            $('#createEditForm').submit();
        }
    });
    // toastr options
    toastr.options = {
        'preventDuplicates': true,
        'preventOpenDuplicates': true
    };
});
</script>