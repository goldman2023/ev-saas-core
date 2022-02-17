<!-- delete Modal -->
<div id="delete-modal" class="modal fade">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title h6">{{translate('Delete Confirmation')}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body text-center">
                <p class="mt-1">{{translate('Are you sure to delete this?')}}</p>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link mt-2" data-dismiss="modal" data-test="deleteModalCancel">{{translate('Cancel')}}</button>
                <button type="button" class="btn btn-primary mt-2" data-test="deleteModalSubmit">{{translate('Delete')}}</button>
              </div>
        </div>
    </div>
</div><!-- /.modal -->
