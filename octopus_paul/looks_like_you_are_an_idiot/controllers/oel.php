<?php

class Oel extends Controller {

	function Oel() {
	
		parent::Controller();
		
	}

	function index($page) {
		
		$page = ($page == 'faq') ? strtoupper($page) : ucwords($page);
		$return = $this->global_function->initialize($page);
		$return['body_title'] = $page;
		$this->global_function->load_view($return);
		
	}

	function tour() {
		
		$return = $this->global_function->initialize('tour');
		$username = $return['username'];
		if ($username != '') redirect('/');
		$return['body_title'] = 'Tour';
		$return['page_type'] = 'tour';
		$this->global_function->load_view($return, FALSE);
		
	}

	function business() {
		
		$return = $this->global_function->initialize('business');
		$username = $return['username'];
		if ($username != '') redirect('/');
		$return['body_title'] = 'Business';
		$return['page_type'] = 'business';
		$this->global_function->load_view($return, FALSE);
		
	}

}

?>