<?php

class Account extends Controller {

	function Account() {
	
		parent::Controller();
		$this->load->model('account_model');
		
	}

	function settings($page) {
		
		$return = $this->global_function->initialize('settings');
		$username = $return['username'];
		if ($username == '') $this->global_function->load_view($return, TRUE, 401);
		elseif ($this->config->item('enable_settings') == FALSE) $this->global_function->load_view($return, TRUE, 503);
		elseif ($this->input->post('Submit')) {
			prevent_more_stupid($page);
			if ($page == 'profile') $this->account_model->submit_profile_settings($username);
			elseif ($page == 'account') $this->account_model->submit_account_settings($username);
			elseif ($page == 'twitter') $this->account_model->submit_twitter_settings($username);
			$badge = $this->badge_model->check($username, 'settings');
			$this->session->set_flashdata('badge', $badge);
			redirect(uri_string());
		}
		else {
			$return['body_title'] = 'Settings - '.ucfirst($page);
			$return['setting_type'] = $page;
			$this->global_function->load_view($return);
		}
				
	}
	
	function signup($one, $two, $three, $four, $five) {
		
		$return = $this->global_function->initialize('signup');
		$redirect = str_replace('/signup', '', uri_string());
		$username = $return['username'];
		if ($one == 'preview' && $username != '') redirect('/');
		if ($one == 'refer' && $username != '') redirect('/');
		elseif ($one == 'business') $this->account_model->add_business_user();
		elseif ($username != '') redirect($redirect);
		else {
			$refer = ($one == 'refer') ? $two : '' ;
			if ($this->input->post('Submit')) {
				prevent_more_stupid('signup');
				if ($this->account_model->submit_signup_form($refer) == TRUE) { 
					$this->global_function->login($this->input->post('username'));
					if (is_numeric(str_replace('/', '', $redirect)) == TRUE) {
						$this->session->set_flashdata('message', array('Welcome to OneExtraLap! When you are finished, just submit your answers!'));
					}
				}
				remember_the_options();
				redirect($redirect);
			}
			else {
				$return['page_type'] = 'Sign Up';
				$this->global_function->load_view($return, FALSE);
			}
		}
		
	}
	
	function login($one, $two, $three, $four, $five) {
		
		$return = $this->global_function->initialize('login');
		$username = $return['username'];
		$redirect = str_replace('/login', '', uri_string());
		if ($username != '') redirect($redirect);
		if ($this->input->post('Submit')) {
			prevent_more_stupid('login');
			if ($this->account_model->submit_login_form() == FALSE) redirect('/login'.$redirect);
			else {
				$this->global_function->login($this->input->post('username'));
				redirect($redirect);
			}
		}
		else {
			$return['page_type'] = 'Log In';
			$this->global_function->load_view($return, FALSE);
		} 
		
	}
	
	function reset_password($code) {
	
		$return = $this->global_function->initialize('reset');
		$username = $return['username'];
		if ($username != '') redirect('/');
		if ($this->input->post('Submit')) {
			if ($code == '') {
				prevent_more_stupid('reset_without_code');
				$this->account_model->forget_password();
			}
			else {
				prevent_more_stupid('reset_with_code');
				$status = $this->account_model->reset_password($code);
				if ($status !== FALSE) {
					$this->global_function->login($status);
					redirect('/');
				}
			}
		}
		else {
			if ($this->account_model->check_code($code) == FALSE) redirect('/reset');
			$return['code'] = $code;
			$return['page_type'] = ($code == '') ? 'Reset' : 'Submit';
			$this->global_function->load_view($return, FALSE);
		}
	
	}
	
	function logout($one, $two, $three, $four, $five) {
		
		$return = $this->global_function->initialize('logout');
		$username = $return['username'];
		$redirect = str_replace('/logout', '', uri_string());
		$return['redirect'] = $redirect;
		if ($username == '') redirect($redirect);
		$this->account_model->logout();
		redirect($redirect);
		
	}

	function twitter($status) {
		
		$return = $this->global_function->initialize('twitter');
		$this->load->model('twitter_model');
		$username = $return['username'];
		if ($status == 'connect') {
			if ($this->config->item('enable_twitter') == FALSE) $this->global_function->load_view($return, TRUE, 503);
			else {
				$this->twitter_model->oauth($username);
			}
		}
		elseif ($status == 'notwitter' || $username != '') $this->twitter_model->disconnect_twitter($username, FALSE);
		elseif ($status == 'disconnect' || $username != '') $this->twitter_model->disconnect_twitter($username, TRUE);
		else $this->global_function->load_view($return, TRUE, 404);
		
	}

}

?>