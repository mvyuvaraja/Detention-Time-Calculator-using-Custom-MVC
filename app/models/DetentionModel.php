<?php

class DetentionModel extends Model {
	
	public function __construct() {
		// Load core model functions
		parent::__construct();
	}
	
	public function getAll() {
        $cols = Array ("d.*", "o.name AS offense_name", "o.detention_period");
		$this->db->join("offenses o", "d.offense_id=o.id", "LEFT");
		return $this->db->get('detentions d', null, $cols);
	}
	
	public function insert($data) {
		return $this->db->insert('detentions', $data);
	}
	
	public function update($data, $id) {
        $this->db->where("id", $id);
		return $this->db->update('detentions', $data) ? 1 : 0;        
	}
	
	public function delete($id) {
        $this->db->where("id", $id);
		return $this->db->delete('detentions') ? 1 : 0;        
	}
	
	public function checkExists($roll_no) {
        $this->db->where("roll_no", $roll_no);
		return $this->db->getOne('detentions') ? 1: 0;        
	}
	
	public function getStudents() {
        $cols = Array("roll_no", "student_name");
        $this->db->groupBy("roll_no");
		return $this->db->get('detentions', null, $cols);
	}
	
	public function calculate($param) {
        
        $this->db->where("roll_no", $param['roll_no']);
        
        if(array_key_exists('time_type', $param) && !empty($param['time_type']))
            $this->db->where("time_type", $param['time_type']);
                        
        if(array_key_exists('calc_mode', $param) && !empty($param['calc_mode']))
            $this->db->where("calc_mode", $param['calc_mode']);
        
        $cols = Array("d.*", "o.name AS offense_name", "o.detention_period");
        
		$this->db->join("offenses o", "d.offense_id=o.id", "LEFT");
		return $this->db->get('detentions d', null, $cols);
	}
	
}
