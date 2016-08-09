<?php

class calculator extends Controller {
	
	public function __construct($controller,$action) {
		// Load core controller functions
		parent::__construct($controller, $action);
        
        $this->load_model('DetentionModel');
	}
	
	public function index() {
        if(!isAjaxRequest()) {
		    $data['students'] = $this->get_model('DetentionModel')->getStudents();
            
            $this->get_view()->set('data', $data);
            $this->get_view()->render('calc/view');
        }else{
            
            if(!empty($_POST['roll_no'])){
                $res = $this->get_model('DetentionModel')->calculate($_POST);
                $msg = ['type'=>'success', 'text'=> $res];
            }else{
                $msg = ['type'=>'error', 'text'=>'Student detention cannot be calculated.'];  
            }
            echo json_encode($msg);
        }        
	}
}
