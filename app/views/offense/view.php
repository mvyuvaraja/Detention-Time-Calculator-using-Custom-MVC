<?php $this->render('common/meta'); ?>
<link rel="stylesheet" href="/js/datatable/css/jquery.dataTables-row.min.css" type="text/css" />

<?php $this->render('common/header'); ?>

<div data-options="region:'center',title:'Offense Types'" style="padding:2px;">

    <table id="offenseTable" class="row-border compact hover" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th width="80">Action</th>
                <th>Offense types</th>
                <th>Detention period</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($data['offenses'] as $offense) { ?>
            <tr>
                <td>
                    <a href="#" class="easyui-linkbutton actionEdit" data-options="plain:true,iconCls:'icon-edit'" data-id="<?php echo $offense['id'] ;?>"></a>
                    <a href="#" class="easyui-linkbutton actionDel" data-options="plain:true,iconCls:'icon-cancel'" data-id="<?php echo $offense['id'] ;?>"></a>
                </td>
                <td><?php echo $offense['name'] ;?></td>
                <td><?php echo $offense['detention_period'] ;?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<div id="dataTableTools">
    <a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-add', plain:true" id="btnAdd">Add New</a>
</div>

<div id="dlg" class="easyui-dialog" title="Add / Edit - Offense type" data-options="iconCls:'icon-save',closed:true" style="width:400px;height:300px;padding:30px 60px;">
    <form action="" id="frm" >
        <input type="hidden" id="id" value="">
        
        <div style="margin-bottom:20px">
            <input id="offense_type" name="offense_type" value="" label="Offense Type:" class="easyui-textbox" style="width:100%;" >
        </div>
            
        <div style="margin-bottom:20px">
            <input id="detention_period" name="detention_period" class="easyui-numberbox" precision="2" value="" label="Detention period:" style="width:100%;" required>
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

    var offenseTable = $('#offenseTable').DataTable({
        dom: '<"toolbar">lfrtip',
        order: [],
        aoColumnDefs :[
            {"bSortable": false, "aTargets": [0]},
            {"bSearchable": false, "aTargets": [0]}
        ],
        fnRowCallback: function (nRow, aData) {

            $('td:eq(0) .actionEdit', nRow).on('click', function (e) {
                e.preventDefault();
                
                var id = $(this).data('id'),
                offense_type = aData[1],
                detention_period = aData[2];
                
                $('#id').val(id);
                $('#offense_type').textbox({'value': offense_type});
                $('#detention_period').numberbox({'value': detention_period});
                
                $('#dlg').dialog('setTitle', 'Edit - Offense type');
                $('#dlg').dialog('open');
            });

            $('td:eq(0) .actionDel', nRow).on('click', function (e) {
                e.preventDefault();
                
                var id = $(this).data('id');
                $.messager.confirm('Confirm', 'Are you confirm to delete?', function(r){
                    if (r){
                        $.post('/offense/delete', {id:id}, function(res){
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
                
        var id = $('#id').val(),
            offense_type = $('#offense_type').val(),
            detention_period = $('#detention_period').val();
        
        $.post('/offense/save', {id:id, name: offense_type, detention_period:detention_period}, function(res){
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
        $('#dlg').dialog('setTitle', 'Add - Offense type');
        $('#dlg').dialog('open');
    });
    
});
</script>

<?php $this->render('common/footer'); ?> 
