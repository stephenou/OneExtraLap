<?php

class Home extends Controller {

	function Home() {
	
		parent::Controller();
		$this->load->model('home_model');
		
	}

	function main($type, $page) {
		
		$return = $this->global_function->initialize('home');
		$username = $return['username'];
		if ($username == '') {
			$return['page_type'] = 'Sign Up';
			$return['title'] = 'Social Quizzing';
			$this->global_function->load_view($return, FALSE);
		}
		else {
			$return['sidebar_stats'] = $this->home_model->get_sidebar_stats($username);
			$return['badges'] = $this->home_model->get_badges($username);
			$return['setup'] = $this->home_model->get_setup_status($username);
			$return['main'] = $this->home_model->get_home_timeline($username, $page);
			$this->global_function->load_view($return);
		}
		
		
	}
	
	function user($userid, $action, $page) {
		
		$userid = $this->home_model->check_user_existance($userid);
		$return = $this->global_function->initialize('user', TRUE, $userid);
		$username = $return['username'];
		if ($userid != FALSE) {
			$return['sidebar_stats'] = $this->home_model->get_sidebar_stats($userid);
			$return['badges'] = $this->home_model->get_badges($userid);
			if ($action == 'following') {
				$return['main'] = $this->home_model->get_user_following($userid, $page, $username);
				$return['content_type'] = 'people';
				$return['body_title'] = get_fullname($userid, FALSE).'\'s Following';
			}
			elseif ($action == 'followers') {
				$return['main'] = $this->home_model->get_user_followers($userid, $page, $username);
				$return['content_type'] = 'people';
				$return['body_title'] = get_fullname($userid, FALSE).'\'s Followers';
			}
			elseif ($action == '') {
				$return['main'] = $this->home_model->get_user_timeline($userid, $page);
				$return['body_title'] = get_fullname($userid, FALSE).'\'s Activities';
			}
			elseif ($action == 'followings') redirect('/'.$userid.'/following');
			elseif ($action == 'follower') redirect('/'.$userid.'/followers');
			else redirect('/'.$userid);
			$this->global_function->load_view($return);
		}
		else {
			$this->global_function->load_view($return, TRUE, 404);
		}

	}

}

?>