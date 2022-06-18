<div id="createEditModal" class="modal fade" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h3 class="modal-title" id="modalTitle"></h3>
            </div>
            <div class="modal-body">
                <form id="createEditForm" class="form-horizontal" action="#">
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <div class="col-md-12">
                            <label for="name">Name*</label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Please enter category name">
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