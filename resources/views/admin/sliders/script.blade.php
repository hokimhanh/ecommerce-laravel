<script>
$(document).ready(function() {
    // get data to table
    $('#sliderTable').DataTable({
        serverSide: true,
        ajax: {
            url: '{{ route('admin.sliders.index') }}',
        },
        columns: [{
                data: 'DT_RowIndex'
            },
            {
                data: 'name'
            },
            {
                data: 'product.name'
            },
            {
                data: 'image',
                orderable: false,
                render: function(data) {
					if (data !=null) {
                        var url = '{{ asset('files/') }}/'+data;
						return '<img src="'+url+'" width="50%" style="">';
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
                "targets": [2,3,4] , 
                "className": "text-center"
            }
        ]
    });
    //add data to select option
    getProducts();
});
</script>
<script type="text/javascript">
function imagesPreview(input, placeToInsertImagePreview) {
    if (input.files) {
        var filesAmount = input.files.length;
        $(placeToInsertImagePreview).empty();
        for (i = 0; i < filesAmount; i++) {
            var reader = new FileReader();
            reader.onload = function(event) {
                $($.parseHTML('<img>')).attr({
                    'src': event.target.result,
                    'width': '80%',
                    'style': 'display: block;margin: auto;margin-bottom: 25px;'
                }).appendTo(placeToInsertImagePreview);
            }
            reader.readAsDataURL(input.files[i]);
        }
    }
};
function onCreate() {
    $('#createEditForm').validate().resetForm();
    $('#createEditForm').trigger('reset');
    $('#productId').val(null).trigger('change');
    $('input[type=file]').attr('required','true');
    $('.slider-img-preview').empty();
    $('#modalTitle').html('Create Slider');
    $('#createEditForm').attr('onsubmit', 'storeData()');
    $('#createEditModal').modal('show');
}

function onEdit(event) {
    var id = $(event).data('id');
    let _url = '{{ route('admin.sliders.show',':id')}}';
    _url = _url.replace(':id', id);
    $.ajax({
        url: _url,
        type: 'GET',
        success: function(response) {
            if (response) {
                $('#createEditForm').validate().resetForm();
                $('input[type=file]').attr('required',false);
                $('.slider-img-preview').empty();
                $('#modalTitle').html('Edit Slider');
                $('#id').val(response.id);
                $('#name').val(response.name);
                $('#productId').val(response.product_id).trigger('change');
                $('#oldImage').val(response.image);
                var url = '{{ asset('files/') }}/'+response.image;
                $('.slider-img-preview').append('<img src="'+url+'" width="80%" style="display: block;margin:auto;margin-bottom: 25px;">')
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

function getProducts() {
    let _url = '{{ route('admin.products.list') }}';
    $.ajax({
        url: _url,
        type: 'GET',
        success: function(response) {
            if (response) {
                $.each(response, function(key, value) {
                    $('#productId').append($('<option>', {
                        value: value.id,
                        text: value.name
                    }));
                });
            }
        }
    });
}

function storeData() {
    var formData = new FormData($('#createEditForm')[0]);
    let _url = '{{ route('admin.sliders.store')}}';
    _url = _url.replace(':id', id);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: _url,
        type: 'POST',
        processData: false,
        contentType: false,
        data: formData,
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
                $('#sliderTable').DataTable().ajax.reload(null, false);
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
    var formData = new FormData($('#createEditForm')[0]);
    formData.append('_method', 'PUT');
    let _url = '{{ route('admin.sliders.update',':id')}}';
    _url = _url.replace(':id', id);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: _url,
        type: 'POST',
        processData: false,
        contentType: false,
        data: formData,
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

                $('#sliderTable').DataTable().ajax.reload(null, false);
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
    let _url = '{{ route('admin.sliders.destroy',':id')}}';
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
                $('#sliderTable').DataTable().ajax.reload(null, false);
            }
        }
    });
}
</script>
<script type="text/javascript">
$(document).ready(function() {
    // using select2
    $('#productId').select2({
        selectOnClose: true,
        dropdownParent: $('#createEditModal')
    });
    /*
     * When you change the value the select via select2, it triggers
     * a 'change' event, but the jquery validation plugin
     * only re-validates on 'blur'
     */
    $('#productId').on('change', function() {
        $(this).trigger('blur');
    });
    $('input[type=file]').on('change', function() {
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
            product_id: {
                required: true,
            }
        },
        errorPlacement: function(error, element) {
            if (element.is('#productId')) {
                error.insertAfter(element.next('.select2-container'));
            } else if (element.is('input[type=file]')) {
                error.insertAfter(element.parent());
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