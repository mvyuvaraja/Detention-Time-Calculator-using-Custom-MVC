<?php

class OffenseModel extends Model {
	
	public function __construct() {
		// Load core model functions
		parent::__construct();
	}
	
	public function getAll() {
		// Return the database query using Mysqlidb database class
		return $this->db->get('offenses');
	}
	
	public function checkExists($name, $id) {
        $this->db->where ("id", 1, '!=');
        $this->db->where ("name", $name);
		return $this->db->getOne('offenses') ? 1: 0;        
	}
	
	public function insert($data) {
		return $this->db->insert('offenses', $data);
	}
	
	public function update($data, $id) {
        $this->db->where ("id", $id);
		return $this->db->update('offenses', $data) ? 1 : 0;        
	}
	
	public function delete($id) {
        $this->db->where ("id", $id);
		return $this->db->delete('offenses') ? 1 : 0;        
	}
	
}
