<div class="modal fade" id="modal-user-new-password">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="tag-rename-input">Новый пароль</label>
                    <input type="password" name="password" class="form-control">
                    <input type="hidden" name="id">
                    <input type="hidden" name="ajax-change-password-url" value="{{ $ajax['change_password_url'] }}">
                </div>
                <div class="form-group">
                    <label for="tag-rename-input">Повторите пароль</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Отменить</button>
                <button type="button" onclick="modalNewUserPassword()" class="btn btn-primary">Создать</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
