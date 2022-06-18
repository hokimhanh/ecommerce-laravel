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
                    'width': '120px',
                    'style': 'margin: 20px'
                }).appendTo(placeToInsertImagePreview);
            }
            reader.readAsDataURL(input.files[i]);
        }
    }
};
$(document).ready(function() {
    // using ck editor
    var editor = CKEDITOR.replace('description');
    // using select2
    $('#subcategoryId').select2({
        selectOnClose: true,
    });
    $('#isInStock').select2({
        selectOnClose: true,
    });
    /*
     * When you change the value the select via select2, it triggers
     * a 'change' event, but the jquery validation plugin
     * only re-validates on 'blur'
     */
    $('#subcategoryId').on('change', function() {
        $(this).trigger('blur');
    });
    $('input[type=file]').on('change', function() {
        $(this).trigger('blur');
    });

    // add attribute option 
    $('#attributeOption').on('change', function() {
        var id = this.value;
        var attributeName = `input[name="attributes[${id}]"]`;
        var nameLabel = $(this).find('option:selected').text();
        var html = '';
        html += '<tr><td>' + nameLabel + '</td>';
        html += '<td><input type="text" name="attributes[' + id +
            ']" class="form-control"></td>';
        html +=
            '<td><button type="button" name="remove" class="btn btn-danger btn-sm remove"><span class="glyphicon glyphicon-minus"></span></button></td></tr>';
        if (id > 0 && $(attributeName).length == 0) {
            $('#attributeTable').append(html);
            $(attributeName).tagsinput({
                maxTags: 10,
                maxChars: 15,
                trimValue: true,
            });
            // $(attributeName).val('');
        }
        $('#attributeOption').val('');

    });
    $(document).on('click', '.remove', function() {
        $(this).closest('tr').remove();
    });
    // toastr options
    toastr.options = {
        'preventDuplicates': true,
        'preventOpenDuplicates': true
    };
});
</script>