<?php $this->render('common/meta'); ?>
<link rel="stylesheet" href="/js/datatable/css/jquery.dataTables-row.min.css" type="text/css" />

<?php $this->render('common/header'); ?>

<div data-options="region:'center',title:'Detention Management'" style="padding:2px;">

    <table id="detentionTable" class="row-border compact hover" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th width="80">Action</th>
                <th>Student name</th>
                <th>Roll no</th>
                <th>Offense Id</th>
                <th>Offense</th>
                <th>Detention period</th>
                <th>Time type</th>
                <th>Calculation mode</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($data['detentions'] as $detention) { ?>
            <tr>
                <td>
                    <a href="#" class="easyui-linkbutton actionEdit" data-options="plain:true,iconCls:'icon-edit'" data-id="<?php echo $detention['id'] ;?>"></a>
                    <a href="#" class="easyui-linkbutton actionDel" data-options="plain:true,iconCls:'icon-cancel'" data-id="<?php echo $detention['id'] ;?>"></a>
                </td>
                <td><?php echo $detention['student_name'] ;?></td>
                <td><?php echo $detention['roll_no'] ;?></td>
                <td><?php echo $detention['offense_id'] ;?></td>
                <td><?php echo $detention['offense_name'] ;?></td>
                <td><?php echo $detention['detention_period'] ;?></td>
                <td><?php echo $detention['time_type'] ;?></td>
                <td><?php echo $detention['calc_mode'] ;?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<div id="dataTableTools">
    <a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-add', plain:true" id="btnAdd">Add New</a>
</div>

<div id="dlg" class="easyui-dialog" title="Add / Edit - Detention" data-options="iconCls:'icon-save',closed:true" style="width:350px;height:350px;padding:10px 10px;">
    
    <form action="" id="frm" >
        <input type="hidden" id="id" value="">
        
        <div style="margin-bottom:20px">
            <input id="student_name" name="student_name" class="easyui-textbox" value="" label="Student name:" style="width:100%;" required >
        </div>
        
        <div style="margin-bottom:20px">
            <input id="roll_no" name="roll_no" class="easyui-numberbox" precision="0" value="" label="Roll no:" style="width:100%;" required>
        </div>
        
        <div style="margin-bottom:20px">
            <select id="offense_id" name="offense_id" class="easyui-combobox" label="Offense type:" style="width:100%;" required >
                <?php foreach($data['offense_types'] as $offense_type) { ?>
                <option value="<?php echo $offense_type['id'] ;?>"><?php echo $offense_type['name'] ;?></option>
                <?php } ?>
            </select>
        </div> 
        
        <div style="margin-bottom:20px">
            <select id="calc_mode" name="calc_mode" class="easyui-combobox" label="Calc mode:" style="width:100%" required>
                <option value="Concurrent" selected>Concurrent</option>
                <option value="Consecutive">Consecutive</option>
            </select>
        </div>        
        
        <div style="text-align:center;padding:5px 0">
            <a href="javascript:void(0)" class="easyui-linkbutton" id="btnClear" style="width:80px">Clear</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" id="btnSubmit" style="width:80px">Submit</a>
        </div>
    </form>
</div>

<script type="text/javascript" src="/js/datatable/js/jquery.dataTables.min.js"></script>
<script>
$(function () {   

    $('#detentionTable').DataTable({
        dom: '<"toolbar">lfrtip',
        order: [],
        aoColumnDefs :[
            {"bVisible": false, "aTargets": [3]},
            {"bSortable": false, "aTargets": [0]},
            {"bSearchable": false, "aTargets": [0]}
        ],
        fnRowCallback: function (nRow, aData) {

            $('td:eq(0) .actionEdit', nRow).on('click', function (e) {
                e.preventDefault();
                
                var id = $(this).data('id'),
                student_name = aData[1],
                roll_no = aData[2],
                offense_id = aData[3],
                calc_mode = aData[7];
                
                $('#id').val(id);
                $('#student_name').textbox({'value': student_name});
                $('#roll_no').numberbox({'value': roll_no});
                $('#offense_id').combobox({'value': offense_id});
                $('#calc_mode').combobox({'value': calc_mode});
                
                $('#dlg').dialog('setTitle', 'Edit - Detention');
                $('#dlg').dialog('open');
            });

            $('td:eq(0) .actionDel', nRow).on('click', function (e) {
                e.preventDefault();
                
                var id = $(this).data('id');
                $.messager.confirm('Confirm', 'Are you confirm to delete?', function(r){
                    if (r){
                        $.post('/detention/delete', {id:id}, function(res){
                            if(res.type == 'success'){
                                $.messager.alert('Success', res.text);
                                setTimeout(function(){
                                    window.location.reload();
                                }, 1000);
                            } else {
                                $.messager.alert('Warning', res.text, 'warning');
                            }
                        }, 'json');
                    }
                });
            });
        }
    });
    $("div.toolbar").html($('#dataTableTools').html());
    
    $('#btnSubmit').on('click', function(e){
        e.preventDefault();
        
        var frm = $('#frm'),
            data = frm.serialize(),
            id = $('#id').val(); 
                   
        data += '&' + $.param({'id': id});
        
        $.post('/detention/save', data, function(res){
            if(res.type == 'success'){
                $.messager.alert('Success', res.text);
                setTimeout(function(){
                    window.location.reload();
                }, 1000);
            } else {
                $.messager.alert('Warning', res.text, 'warning');
            }
        }, 'json');
           
    });
    
    $('#btnClear').on('click', function(e){
        $('#frm').form('clear');
    });
    
    $('#btnAdd').on('click', function(e){
        e.preventDefault();
        
        $('#frm').form('clear');
        $('#dlg').dialog('setTitle', 'Add - Detention');
        $('#dlg').dialog('open');
    });
    
});
</script>

<?php $this->render('common/footer'); ?> 
