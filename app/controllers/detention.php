<?php

class detention extends Controller {
	
	public function __construct($controller,$action) {
		// Load core controller functions
		parent::__construct($controller, $action);
        $this->load_model('DetentionModel');
        $this->load_model('OffenseModel');
	}
	
	public function index() {
        
		$data['detentions'] = $this->get_model('DetentionModel')->getAll();
		$data['offense_types'] = $this->get_model('OffenseModel')->getAll();
        
        $this->get_view()->set('data', $data);
        $this->get_view()->render('detention/view');
        
	}
    
    public function save(){
        $id = !empty($_POST['id']) ? $_POST['id'] : 0;
        $data['student_name'] = htmlspecialchars(trim($_POST['student_name']), ENT_QUOTES);
        $data['roll_no'] = !empty($_POST['roll_no']) ? $_POST['roll_no'] : 0;
        $data['offense_id'] = !empty($_POST['offense_id']) ? $_POST['offense_id'] : 0;
        $data['time_type'] = !empty($_POST['time_type']) ? $_POST['time_type'] : 'Default';
        $data['calc_mode'] = !empty($_POST['calc_mode']) ? $_POST['calc_mode'] : 'Concurrent';
                    
        if($id){
            //Edit
            $res = $this->get_model('DetentionModel')->update($data, $id);
            if($res)
                $msg = ['type'=>'success', 'text'=>'Student detention updated.'];
            else
                $msg = ['type'=>'error', 'text'=>'Student detention not updated.'];
        }else{
            //Add
            $res = $this->get_model('DetentionModel')->insert($data);
            if($res)
                $msg = ['type'=>'success', 'text'=>'Student detention inserted.'];
            else
                $msg = ['type'=>'error', 'text'=>'Student detention not inserted.'];            
        }
            
        echo json_encode($msg);
    }
	
	public function delete() {
        $id = !empty($_POST['id']) ? $_POST['id'] : 0;
        
        if($this->get_model('DetentionModel')->delete($id))
            $msg = ['type'=>'success', 'text'=>'Student detention deleted.'];
        else
            $msg = ['type'=>'error', 'text'=>'Student detention not deleted.']; 
            
        echo json_encode($msg);
	}
}
