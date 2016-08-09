<?php 
	$this->render('common/meta'); 
	$this->render('common/header');
?>

<div data-options="region:'center',title:'Detention Calculator'" style="padding:2px;">
    <fieldset><legend>Calculate Detention for a student</legend>
        
        <form action="" id="frm" >
            <div style="margin-bottom:20px">
                <select id="roll_no" name="roll_no" class="easyui-combobox" label="Student *" style="width:200px;" required>
                    <option value="">Select</option>
                    <?php foreach($data['students'] as $student) { ?>
                    <option value="<?php echo $student['roll_no'] ;?>"><?php echo $student['student_name'] ;?></option>
                    <?php } ?>
                </select>
            
                <select id="time_type" name="time_type" class="easyui-combobox" label="Time type:" style="width:200px;" >
                    <option value="" selected>All</option>
                    <option value="Good">Good Time</option>
                    <option value="Bad">Bad Time</option>
                </select>
            
                <select id="calc_mode" name="calc_mode" class="easyui-combobox" label="Calc mode:" style="width:200px" >
                    <option value="" selected>All</option>
                    <option value="Concurrent" >Concurrent</option>
                    <option value="Consecutive">Consecutive</option>
                </select>
                
                <a href="javascript:void(0)" class="easyui-linkbutton" id="btnSubmit" style="width:80px">Calculate</a>
            </div> 
        </form> 
        
    </fieldset>
    
    <div id="calcResult"></div>
</div>

<script>
$(function () {   
    $('#btnSubmit').on('click', function(e){
        e.preventDefault();
        
        var roll_no = $('#roll_no').combobox('getValue');
        console.log(roll_no);
        if(!roll_no) {
            $.messager.alert('Warning', 'Select Student', 'warning');
            return;
        }
        
        $.post('/calculator/index', $('#frm').serialize(), function(res){
            if(res.type == 'success'){
                var tot = 0;
                var tbl = '<h3>Calculated Detention Period</h3>';
                tbl += '<table  class="report-table">';
                tbl += '<thead><tr><th>Sno</th><th>Offense Type</th><th>Time</th><th>Calc Mode</th><th>Actual Detention</th><th>Gross Detention (in Hours)</th></tr> </thead><tbody>';
                $.each(res.text, function(i,v){
                    var detention;
                    switch(v.time_type){
                        case 'Good':
                            detention = Math.round(v.detention_period * 0.9 * 10) / 10;
                            break; 
                        case 'Bad':
                            detention = Math.round(v.detention_period * 1.1 * 10) / 10;
                            break;
                        default:
                            detention = v.detention_period;
                            break;
                    }
                    tbl += '<tr><td>'+(i+1)+'</td><td>'+v.offense_name+'</td><td>'+v.time_type+'</td><td>'+v.calc_mode+'</td><td style="text-align:center;">'+v.detention_period+'</td><td style="text-align:center;">'+detention+'</td></tr>';
                    tot += detention;
                });
                tbl += '</tbody>';
                tbl += '</tfoot><tr><th colspan="5" style="text-align:right;">Total Detention Period</th><th style="text-align:center;">'+tot+'</th></tr></tfoot>';
                tbl += '</table>';
                
                if(tot > 8){
                   tbl += '<p style="color: red;">Note: This student has been detained for more than a school day (8 hours). Please call his/her parents.</p>' 
                }
                $('#calcResult').html(tbl);
            } else {
                $.messager.alert('Warning', res.text, 'warning');
            }
        }, 'json');
        
    });
});
</script>
<?php
	$this->render('common/footer');
?> 
