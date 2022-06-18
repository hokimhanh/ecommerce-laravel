<div id="deleteModal" class="modal fade" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h3 class="modal-title" id="modalTitle">Delete</h3>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this item ?</p>
                <form id="delete-form" class="form-horizontal">
                    <input type="hidden" name="id" id="delId">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" id="btn-delete" class="btn btn-primary" onclick="deleteData()">Delete</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->