<div class="modal fade" id="modal-filemanager">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-header-control">
                    <h4 class="modal-title">Менеджер файлов</h4>
                    <div class="modal-header-btn-block">
                        <button type="button" onclick="filemanagerBack()" class="btn bg-gradient-warning">
                            <i class="fa fa-reply"></i>
                        </button>
                        <button type="button" onclick="filemanagerRefresh()" class="btn bg-gradient-success">
                            <i class="fa fa-refresh"></i>
                        </button>

                        <div class="filemanager-input-file">
                            <form id="filemanager-form">
                                <input type="file" name="files" id="filemanager-modal-file-input" multiple="true" />
                                <label for="filemanager-modal-file-input" onclick="filemanagerUpload()" class="btn bg-gradient-info">
                                    <i class="fa fa-cloud-arrow-down"></i>
                                </label>
                            </form>
                        </div>

                        <button type="button" onclick="openDirnameInput()" class="btn bg-gradient-primary">
                            <i class="fa fa-folder-plus"></i>
                        </button>
                        <button type="button" onclick="filemanagerDelete()" class="btn bg-gradient-danger">
                            <i class="fa fa-trash-alt"></i>
                        </button>
                    </div>
                    <div class="modal-header-url-block" id="dir-name-block">
                        <span id="modal-header-url"></span>
                        <input type="hidden" id="current-url">
                        <input type="hidden" id="upload-url">
                        <input type="hidden" id="delete-url">
                        <input type="hidden" id="new-folder-url">
                        <input type="hidden" id="current-page">
                        <input type="hidden" id="all-pages">
                        <input type="hidden" id="count-image">
                        <input type="hidden" id="image-id">
                        <input type="hidden" id="image-type">
                    </div>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body filemanager-modal-body" id="filemanager-modal-content">

            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" id="filemanager-modal-close" data-dismiss="modal">Close</button>
                <button type="button" onclick="filemanagerChangeItem()" class="btn btn-primary">Выбрать</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
