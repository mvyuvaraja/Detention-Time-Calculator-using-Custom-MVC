<?php

class offense extends Controller {
	
	public function __construct($controller,$action) {
		// Load core controller functions
		parent::__construct($controller, $action);
        $this->load_model('OffenseModel');
	}
	
	public function index() {
        
		$data['offenses'] = $this->get_model('OffenseModel')->getAll();
        
        $this->get_view()->set('data', $data);
        $this->get_view()->render('offense/view');
        
	}
    
    public function save(){
        $id = !empty($_POST['id']) ? $_POST['id'] : 0;
        $data['name'] = htmlspecialchars(trim($_POST['name']), ENT_QUOTES);
        $data['detention_period'] = !empty($_POST['detention_period']) ? $_POST['detention_period'] : 0;
        
        if($this->get_model('OffenseModel')->checkExists($data['name'], $id)){
            $msg = ['type'=>'error', 'text'=>'Offense type exists.'];
        } else {        
        
            if($id){
                //Edit
                $res = $this->get_model('OffenseModel')->update($data, $id);
                if($res)
                    $msg = ['type'=>'success', 'text'=>'Offense type updated.'];
                else
                    $msg = ['type'=>'error', 'text'=>'Offense type not updated.'];
            }else{
                //Add
                $res = $this->get_model('OffenseModel')->insert($data);
                if($res)
                    $msg = ['type'=>'success', 'text'=>'Offense type inserted.'];
                else
                    $msg = ['type'=>'error', 'text'=>'Offense type not inserted.'];            
            }
        }
        echo json_encode($msg);
    }
	
	public function delete() {
        $id = !empty($_POST['id']) ? $_POST['id'] : 0;
        
        if($this->get_model('OffenseModel')->delete($id))
            $msg = ['type'=>'success', 'text'=>'Offense type deleted.'];
        else
            $msg = ['type'=>'error', 'text'=>'Offense type not deleted.']; 
            
        echo json_encode($msg);
	}
}
