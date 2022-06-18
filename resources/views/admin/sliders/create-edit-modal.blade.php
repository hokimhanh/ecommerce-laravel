<div id="createEditModal" class="modal fade" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h3 class="modal-title" id="modalTitle"></h3>
            </div>
            <div class="modal-body">
                <form id="createEditForm" class="form-horizontal" action="#" enctype='multipart/form-data'>
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <div class="col-md-12">
                            <label for="name">Name*</label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Please enter slider name">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <label for="productId">Product*</label>
                            <select name="product_id" id="productId" class="form-control" style="width: 100%;">
                                <option value="">Choose...</option>
                            </select>

                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <label for="prod_image">Image*</label>
                            <div class="metric">
                                <div class="slider-img-preview"></div>
                                <div class="parent-upload">
                                    <label class="btn btn-success"><i class="fa fa-upload"></i> Choose
                                        image</label>
                                    <input type="hidden" name="old_image" id="oldImage">
                                    <input type="file" id="image" name="image[]" accept=".jpg, .jpeg, .png"
                                        onchange="imagesPreview(this, 'div.slider-img-preview');">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" id="btnSave" class="btn btn-primary">Save changes</button>
                </div>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->