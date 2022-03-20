<div class="modal fade" id="modal-tag-rename">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Переименовать тег "<span class="add-header"></span>"</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="tag-rename-input">Новое имя</label>
                    <input type="text" name="name" class="form-control" id="tag-rename-input">
                    <input type="hidden" name="id">
                    <input type="hidden" name="ajax-rename-url" value="{{ $ajax['rename_tag'] }}">
                    <input type="hidden" name="ajax-delete-url" value="{{ $ajax['delete_tag'] }}">
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Отменить</button>
                <button type="button" onclick="modalRenameTag()" class="btn btn-primary">Переименовать</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
