<?php

class Global_function extends Model {

	function Global_function() {
	
		parent::Model();
		
	}
	
	function load_view($data, $page = TRUE, $error = 200) {
	
		$username = $this->get_username();
		$data['site_status'] = $this->config->item('site_status');
		if ($data['site_status'] == 1) {
			if ($username == '') {
				if ($data['page_type'] != 'Log In' && $data['page_type'] != 'tour' && $data['page_type'] != 'Register') $data['page_type'] = 'Preview';
			} 
			else $data['page_type'] = '';
		}
		if ($this->config->item('enable_site') !== FALSE || $username == $this->config->item('default_user')) {
			if ($error == 503) $data['title'] = 'Will Be Right Back';
			if ($error == 404) $data['title'] = 'Page Not Found';
			if ($error == 401) $data['title'] = 'Need To Login';
			$this->load->view('this_is_header', $data);
			if ($data['site_status'] == 1 && $username == '' || $page == FALSE && $username == '') $this->load->view('new_folks', $data);
			elseif ($error != 200) {
				$data['error_type'] = $error;
				$this->load->view('four_o_four', $data);
			}
			else {
				$this->load->view('cute_sidebar', $data);
				if ($data['oel'] == TRUE) $this->load->view('stephen_aint_bad', $data);
				else $this->load->view('lol_content', $data);
			}
			$this->load->view('this_is_footer', $data);
		}
		else {
			$this->load->view('freaking_fail_whale', $data);
		}
	
	}
	
	function initialize($page, $condition = FALSE, $id = NULL) {
	
		$username = $this->get_username();
		$this->redirect_for_capability($username);
		$this->add_pageview($username, uri_string());
		$return['username'] = $username;
		$return['fullname'] = get_fullname($username, FALSE);
		$return['pageid'] = uri_string();
		$return['placeholder'] = 'Quizzes';
		$return['fileid'] = $page;
		$return['status'] = '';
		$return['page_type'] = '';
		$return['oel'] = FALSE;
		$return['session'] = ($username == '') ? FALSE : TRUE;
		if ($page == 'About' || $page == 'FAQ' || $page == 'tour' || $page == 'business') $return['oel'] = TRUE;
		if ($page == "people" || $page == "find") {
			$return['content_type'] = $page;
			if ($page == "find") $page = "quizzes";
			$return['title'] = ucfirst($page);
		}
		elseif ($condition == FALSE) {
			$return['content_type'] = $page;
			$return['title'] = ucfirst($page);
			$return['userid'] = $username;
		}
		else {
			if (is_numeric($id)) {
				$return['content_type'] = "quiz";
				$return['title'] = get_title($id, FALSE);
				$return['quizid'] = $id;
			}
			else {
				$return['content_type'] = "user";
				$return['title'] = get_fullname($id, FALSE);
				$return['userid'] = $id;
			}
		}
		$return['sidebar_type'] = $return['content_type'];
		return $return;
	
	}
	
	function redirect_for_capability($username) {
	
		$url = rtrim(trim(uri_string(), '/'), '/');
		$redirect = ereg_replace("[^A-Za-z0-9? ~%.-:_\/]", "", $url);
		if ($redirect != $url) redirect('/'.$redirect);
		if ($url == 'newquiz') redirect('/create');
		if ($url == 'following') redirect('/'.$username.'/following');
		if ($url == 'followings') redirect('/'.$username.'/following');
		if ($url == 'follower') redirect('/'.$username.'/followers');
		if ($url == 'followers') redirect('/'.$username.'/followers');
		if ($url == 'follow') redirect('/'.$username.'/followers');
		if ($url == 'follows') redirect('/'.$username.'/followers');
		if ($url == 'leaderboard') redirect('/people/leaderboard');
		if ($url == 'new') redirect('/people/new');
		if ($url == 'twitter') redirect('/people/twitter');
		if ($url == 'popular') redirect('/quizzes/popular');
		if ($url == 'fresh') redirect('/quizzes/fresh');
		if ($url == 'difficult') redirect('/quizzes/difficult');
		if ($url == 'quiz') redirect('/quizzes/popular');
		if ($url == 'quiz/popular') redirect('/quizzes/popular');
		if ($url == 'quiz/newest') redirect('/quizzes/fresh');
		if ($url == 'quiz/hardest') redirect('/quizzes/difficult');
		if ($url == 'quizzes') redirect('/quizzes/popular');
		if ($url == 'quizzes/newest') redirect('/quizzes/fresh');
		if ($url == 'quizzes/hardest') redirect('/quizzes/difficult');
		if ($url == 'people') redirect('/people/leaderboard');
		if ($url == 'peoples') redirect('/people/leaderboard');
		if ($url == 'person') redirect('/people/leaderboard');
		if ($url == 'persons') redirect('/people/leaderboard');
		if ($url == 'user') redirect('/people/leaderboard');
		if ($url == 'users') redirect('/people/leaderboard');
		if ($url == 'setting') redirect('/settings/profile');
		if ($url == 'settings') redirect('/settings/profile');
		if ($url == 'setting/password') redirect('/settings/account');
		if ($url == 'settings/password') redirect('/settings/account');
	
	}
	
	function get_username() {
	
		$username = $this->session->userdata($this->config->item('session_cookie_name'));
		if ($username == '') $username = get_cookie($this->config->item('session_cookie_name'));
		return $username;
	
	}
	
	function add_pageview($userid, $pageid) {
	
		$data = array('user_id' => $userid, 'page' => $pageid, 'time' => time());
		//manipulate_database('insert', 'pageview', $data);
	
	}
	
	function login($username) {
	
		$username = $this->db->query("SELECT username FROM user WHERE username='$username' LIMIT 1")->row()->username;
		$this->session->set_userdata('nihaoma', $username);
		$cookie = array('name' => 'nihaoma', 'value' => $username, 'expire' => '1200000', 'domain' => '.'.str_replace('http://', '', rtrim(base_url(), '/')), 'path'   => '/', 'prefix' => 'ole_');
		set_cookie($cookie);
		$data = array('last_login_time' => time(), 'forget_password' => '');
		manipulate_database('update', 'user', $data, array('username' => $username));
	
	}
	
}

?>