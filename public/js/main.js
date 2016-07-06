var main = (function () {
    doConstruct = function () {
        this.init_callbacks = [];
    };
    doConstruct.prototype = {
        add_init_callback : function (func) {
            if (typeof(func) == 'function') {
                this.init_callbacks.push(func);
                return true;
            }
            else {
                return false;
            }
        }
    };
    return new doConstruct;
})();
$(document).ready(function () {
    $.each(main.init_callbacks, function (index, func) {
        func();
    });
});
var client = (function () {                    //Client controller group
    var doConstruct = function () {
        main.add_init_callback(this.show_add_manager_box); //show modal to add new manager
        main.add_init_callback(this.ajax_add_manager); //show modal to add new manager
        main.add_init_callback(this.meneger_delete); //delete manager
        main.add_init_callback(this.display_box_add_scipt); //add client script
        main.add_init_callback(this.ajax_add_script); //add client script

    };
    doConstruct.prototype = {
        show_add_manager_box: function () { //show modal to add new manager
            $('#add-manager-b').click(function(){
                $('#add-manager-m').modal('show');
            });
        },
        ajax_add_manager: function () { //show modal to add new manager
            $('#f-add-m').click(function() {
                $("#f-add-m").attr('disabled', 'disabled');
                $.ajax({
                    url: './manager',
                    type: "post",
                    data: {'name':$('input[name=manager_name]').val(), '_token': $('input[name=_token]').val()},
                    success: function(data){
                        switch (data.success){       //needed array cell
                            case true:            //if basket goods quontity response false
                                //console.log(data.message);
                                $('#append_manager_error > h2').html(data.message);
                                setTimeout(function(){
                                    $('#add-manager-m').modal('hide');
                                    $('#append_manager_error > h2').html('');
                                    $('#f-add-m').removeAttr('disabled');
                                    window.location.href = "./manager";
                                },2000);
                                break;
                            case false:        //if basket goods quantity response true go to next step
                                $('#append_manager_error > h2').html(data.message.name);
                                $('#f-add-m').removeAttr('disabled');
                                setTimeout(function(){
                                    $('#append_manager_error > h2').html('');
                                },2000);
                                break;
                        }
                    },
                    error: function(data){
                        var errors = data.responseJSON;
                        console.log(errors);
                        // Render the errors with js ...
                    }
                });
            });
        },
        meneger_delete: function(){ //delete manager confirm
            $('.b_get_m_id').click(function(){
                var manager_id = $(this).data("manager_id");
                $('#m_delete_'+manager_id).on('click', function(){
                    var r = confirm("Удалить?");
                    if (r == true) {
                        this.submit();
                    }
                });
            });

        },
        display_box_add_scipt: function(){
            $('#add-script-b').click(function(){
                $('#add-script-m').modal('show');
            });
        },
        ajax_add_script: function () { //show modal to add new manager
            $('#f-add-script').click(function() {
                $("#f-add-script").attr('disabled', 'disabled');
                $.ajax({
                    url: './script',
                    type: "post",
                    data: {'name':$('input[name=block_name]').val(),'desc':$('textarea[name=block_desc]').val(),'parent_id':$('input[name=parent_id]').val(), '_token': $('input[name=_token]').val()},
                    success: function(data){
                        switch (data.success){       //needed array cell
                            case true:            //if basket goods quontity response false
                                //console.log(data.message);
                                $('#append_manager_error > h2').html(data.message);
                                setTimeout(function(){
                                    $('#add-manager-m').modal('hide');
                                    $('#append_manager_error > h2').html('');
                                    $('#f-add-script').removeAttr('disabled');
                                    window.location.href = "./script";
                                },2000);
                                break;
                            case false:        //if basket goods quantity response true go to next step
                                //console.log(data.message);
                                $('#append_manager_error > h2').html(data.message.name);
                                $('#f-add-script').removeAttr('disabled');
                                setTimeout(function(){
                                    $('#append_manager_error > h2').html('');
                                },2000);
                                break;
                        }
                    },
                    error: function(data){
                        var errors = data.responseJSON;
                        console.log(errors);
                        // Render the errors with js ...
                    }
                });
            });
        },

    };
    return new doConstruct;
})();
function show_script(id){
    //console.log($('#'+id+">.child"));
    var selector = $('#'+id+">.child");
    if(selector.css('display') == 'block'){
        selector.css('display','none');
    } else {
        selector.css('display','block');
    }
}
function add_script (id){
   /// console.log('test');
    //$('#add-script-b').click(function(){
    $('input[name=parent_id]').val(id);
    $('#add-script-m').modal('show');
   // });
}
function edit_script(id){
    $('input[name=edit_parent_id]').val(id);
    $('input[name=edit_block_name]').val($('.b_edit-'+id).attr("data-name"));
    $('textarea[name=edit_block_desc]').val($('.b_edit-'+id).attr("data-desc"));
    $('#edit-script-m').modal('show');
}


