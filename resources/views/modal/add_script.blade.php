<div class="modal fade" id="add-script-mm" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Добавить новый блок</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" action="{{url('client/account/script')}}" method="post">
                    <div style="padding: 20px" class="form-group">
                        <label>Название блока:</label>
                        <input style="width: 100%" type="text" class="form-control" name="block_name" required placeholder="Введите название">
                    </div>
                    <div style="padding: 20px" class="form-group">
                        <label>Описание блока:</label>
                        <textarea class="form-control" name="block_desc" required placeholder="Описание" rows="3"></textarea>
                    </div>
                    <div style="padding: 20px" class="form-group">
                        <input type="hidden" name="parent_id" value="">
                    </div>
                    <div class="form-group">
                        <div id="append_manager_error" class="alert-box success">
                            <h2 style="text-align: center"></h2>
                        </div>
                    </div>
                    <div style="padding: 20px" class="form-group">
                        <input id="f-add-script" style="background-color: rgba(11, 160, 9, 0.6);color: white;border: 1px solid gainsboro;padding: 8px"  type="button" value="ДОБАВИТЬ">
                        <button type="button" style="background-color: rgba(0, 75, 160, 0.6);color: white;float: right;border: 1px solid gainsboro;padding: 8px" data-dismiss="modal">ОТМЕНА</button>
                    </div>
                    {!! csrf_field() !!}
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!--Edit script modal -->

<div class="modal fade" id="edit-script-m" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Редактировать блок</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" action="{{url('client/account/script/edit')}}" method="post">
                    <div style="padding: 20px" class="form-group">
                        <label>Новое название:</label>
                        <input style="width: 100%" type="text" class="form-control" name="edit_block_name" required >
                    </div>
                    <div style="padding: 20px" class="form-group">
                        <label>Новое описание:</label>
                        <textarea class="form-control" name="edit_block_desc" required rows="3"></textarea>
                    </div>
                    <div style="padding: 20px" class="form-group">
                        <input type="hidden" name="edit_parent_id" value="">
                    </div>
                    <div class="form-group">
                        <div id="append_manager_edit_error" class="alert-box success">
                            <h2 style="text-align: center"></h2>
                        </div>
                    </div>
                    <div style="padding: 20px" class="form-group">
                        <input id="f-edit-script" style="background-color: rgba(11, 160, 9, 0.6);color: white;border: 1px solid gainsboro;padding: 8px"  type="button" value="ДОБАВИТЬ">
                        <button type="button" style="background-color: rgba(0, 75, 160, 0.6);color: white;float: right;border: 1px solid gainsboro;padding: 8px" data-dismiss="modal">ОТМЕНА</button>
                    </div>
                    {!! csrf_field() !!}
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
