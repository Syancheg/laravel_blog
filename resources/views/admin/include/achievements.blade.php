<div class="modal fade" id="modal-achievements">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Добавить достижение</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="achievement-name" class="required">Название</label>
                    <input type="text" name="name" class="form-control" id="achievement-name">
                </div>
                <div class="form-group">
                    <label for="achievement-date">Дата</label>
                    <input type="date" class="form-control" id="achievement-date" name="date">
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Отменить</button>
                <button type="button" onclick="addAchievements()" class="btn btn-primary">Создать</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
