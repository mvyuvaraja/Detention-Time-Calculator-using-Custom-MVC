<?php

class home extends Controller {
	
	public function __construct($controller,$action) {
		// Load core controller functions
		parent::__construct($controller, $action);
		
	}
	
	public function index() {
        
		$this->get_view()->render('common/meta');
		$this->get_view()->render('common/header');
		$this->get_view()->render('common/footer');
	}
}
