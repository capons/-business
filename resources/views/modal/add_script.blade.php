<div class="modal fade" id="add-script-m" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Добавить нового менеджера</h4>
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
                        <select name="parent_id" class="form-control">
                            <option></option>
                            @if (count($block_category) > 0)
                                @foreach($block_category as $row)
                                    <option value="<?php echo $row['id'] ?>"><?php if(strlen($row['name']) > 20){echo mb_substr($row['name'], 0, 20).'...';} else { echo $row['name'];} ?></option>
                                @endforeach
                            @endif
                        </select>
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