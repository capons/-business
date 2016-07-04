<div class="modal fade" id="add-manager-m" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Добавить нового менеджера</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" action="{{ url('client/account/manager')}}" method="post">
                    <div style="padding: 20px" class="form-group">
                        <label>Имя менеджера:</label>
                        <input style="width: 100%" type="text" class="form-control" name="manager_name" required  placeholder="Введите имя менеджера">
                    </div>
                    <div class="form-group">
                        <div id="append_manager_error" class="alert-box success">
                            <h2 style="text-align: center"></h2>
                        </div>
                    </div>
                    <div style="padding: 20px" class="form-group">
                        <input id="f-add-m" style="background-color: rgba(11, 160, 9, 0.6);color: white;border: 1px solid gainsboro;padding: 8px"  type="button" value="ДОБАВИТЬ">
                        <button type="button" style="background-color: rgba(0, 75, 160, 0.6);color: white;float: right;border: 1px solid gainsboro;padding: 8px" data-dismiss="modal">ОТМЕНА</button>
                    </div>
                    {!! csrf_field() !!}
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->