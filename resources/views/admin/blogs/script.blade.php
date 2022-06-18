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
                    'width': '40%',
                    'style': 'display: block;margin: auto;margin-bottom: 25px'
                }).appendTo(placeToInsertImagePreview);
            }
            reader.readAsDataURL(input.files[i]);
        }
    }
};
$(document).ready(function() {
    $('input[type=file]').on('change', function() {
        $(this).trigger('blur');
    });
    // using ck editor
    var editor = CKEDITOR.replace('content');
    $('form').submit( function(e) {
            var contentLength = CKEDITOR.instances['content'].getData().replace(/<[^>]*>/gi, '').length;
            if( !contentLength ) {
               toastr.warning('Please enter content', 'Warning')
                e.preventDefault();
            }
        });
    

});
</script>