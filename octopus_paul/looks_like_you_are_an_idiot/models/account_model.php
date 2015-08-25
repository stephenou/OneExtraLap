<?php

class Account_model extends Model {

	function Account_model() {
	
		parent::Model();
		$this->load->library('form_validation');
		
	}
	
	function add_business_user() {
	
		$data = array('email' => $this->input->post('email'), 'time' => time());
		manipulate_database('insert', 'preview', $data);
		$this->session->set_flashdata('message', array('Awesome! We will contact you specifically very soon!'));
		redirect('/business');
	
	}
	
	function validate($type, $username = FALSE, $password = FALSE, $email = FALSE, $fullname = FALSE, $bio = FALSE, $website = FALSE) {
	
		$message = array();
		if ($type == 'signup') {
			if ($this->form_validation->max_length($username, 20) == FALSE || $this->form_validation->alpha_numeric($username) == FALSE || is_numeric($username)) array_push($message, 'Please enter a valid username.');
			if ($this->if_username_used($username) == FALSE) array_push($message, 'The username is not available.');
			if ($this->form_validation->min_length($password, 6) == FALSE) array_push($message, 'Password has to be 6 or more characters.');
		}
		if ($type !== 'profile') {
			if ($this->form_validation->valid_email($email) == FALSE) array_push($message, 'Please enter a valid email.');
			if ($this->if_email_used($username, $email) == FALSE) array_push($message, 'The email already had an account.');
		}
		if ($type == 'profile') {
			if ($this->form_validation->max_length($fullname, 255) == FALSE) array_push($message, 'Fullname has to be under 256 characters.');
			if ($this->form_validation->max_length($bio, 255) == FALSE) array_push($message, 'Bio has to be under 256 characters.');
			if ($this->form_validation->max_length($website, 255) == FALSE) array_push($message, 'Website has to be under 256 characters.');
			if ($this->form_validation->valid_url($website) == FALSE && !empty($website) && $website !== 'http://') array_push($message, 'Please enter a valid URL.');
		}
		return $message;
	
	}
	
	function avatar($avatar, $twitter, $email) {
	
		if ($avatar == 'twavatar') {
			if ($twitter == '') $twitter = 'twitter';
			return $this->config->item('twavatar_url').strtolower($twitter);
		}
		elseif ($avatar == 'gravatar') return $this->config->item('gravatar_url').md5(strtolower($email));
		else return $this->config->item('gravatar_url');
	
	}
	
	function submit_profile_settings($username) {
	
		$fullname = $this->input->post('fullname');
		$bio = $this->input->post('bio');
		$website = $this->input->post('website');
		$avatar = $this->input->post('avatar');
		$message = $this->validate('profile', $username, '', '', $fullname, $bio, $website);
		if (!empty($message)) $this->session->set_flashdata('message', $message);
		else {
			if ($avatar !== '') {
				$avatardata = array('avatar' => $this->avatar($avatar, get_twitter($username, FALSE, FALSE), get_email($username)));
				manipulate_database('update', 'user', $avatardata, array('username' => $username));
			}
			if ($website == 'http://') $website = '';
			$data = array('fullname' => make_it_safe($fullname), 'bio' => make_it_safe($bio), 'website' => $website);
			manipulate_database('update', 'user', $data, array('username' => $username));
			$this->session->set_flashdata('message', array('Awesome! Your profile settings had been saved.'));
		}
	
	}
	
	function submit_account_settings($username) {
		
		$email = $this->input->post('email');
		$oldpassword = $this->input->post('oldpassword');
		$password = $this->input->post('newpassword');
		$notifications = $this->input->post('notifications');
		$message = $this->validate('account', $username, $password, $email);
		$data = array('email' => $email, 'notification' => $notifications);
		manipulate_database('update', 'user', $data, array('username' => $username));
		if ($oldpassword !== '' || $password !== '') {
			if ($this->check_old_password($username, $oldpassword) == FALSE) array_push($message, 'Your old password didn\'t match.');
			if ($this->form_validation->min_length($password, 6) == FALSE) array_push($message, 'Password has to be 6 or more characters.'); 
		}
		if (!empty($message)) $this->session->set_flashdata('message', $message);
		else {
			if ($oldpassword !== '' && $password !== '') $data['password'] = md5($password);
			manipulate_database('update', 'user', $data, array('username' => $username));
			$this->session->set_flashdata('message', array('Awesome! Your account settings had been saved.'));
		}
	
	}
	
	function submit_twitter_settings($username) {
	
		$share_took = $this->input->post('share_took');
		$share_onehundred = $this->input->post('share_onehundred');
		$share_created = $this->input->post('share_created');
		$share_badge = $this->input->post('share_badge');
		$data = array('share_took' => $share_took, 'share_onehundred' => $share_onehundred, 'share_created' => $share_created, 'share_badge' => $share_badge);
		manipulate_database('update', 'user', $data, array('username' => $username));
		$this->session->set_flashdata('message', array('Awesome! Your Twitter settings had been saved.'));
	
	}
	
	function submit_signup_form($refer) {
	
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$email = $this->input->post('email');
		$message = $this->validate('signup', $username, $password, $email);
		if (!empty($message)) {
			$this->session->set_flashdata('username', $username);
			$this->session->set_flashdata('password', $password);
			$this->session->set_flashdata("email", $email);
			$this->session->set_flashdata('message', $message);
		}
		else {
			$time = time();
			$data = array('username' => $username, 'password' => md5($password), 'email' => $email, 'signup_time' => $time, 'last_login_time' => $time, 'avatar' => $this->config->item('gravatar_url'), 'notification' => 1, 'invite' => $refer);
			manipulate_database('insert', 'user', $data);
			return TRUE;
		}
	
	}
	
	function submit_login_form() {

		$username = $this->db->escape_str($this->input->post('username'));
		$password = md5($this->input->post('password'));
		if (substr($this->input->post('username'), -2, 2) == '\'#') stupid();
		$query = $this->db->query("SELECT COUNT(id) AS total FROM user WHERE username='$username' AND password='$password'");
		if ($query->row()->total == 1) {
			$this->session->set_flashdata('message', array('Welcome back!'));
			return TRUE;
		}
		else {
			$this->session->set_flashdata('message', array('Uh Oh, wrong combination. Please try again.'));
			$this->session->set_flashdata('username', $this->input->post('username'));
			$this->session->set_flashdata('password', $this->input->post('password'));
		}

	}
	
	function forget_password() {
	
		$email = $this->db->escape_str($this->input->post('email'));
		$query = $this->db->query("SELECT fullname, email, COUNT(id) AS total FROM user WHERE email='$email'");
		$row = $query->row();
		if ($row->total == 1) {
			$random = rand(1000000000, 9999999999);
			$data = array('forget_password' => $random, 'forget_password_time' => time());
			manipulate_database('update', 'user', $data, array('email' => $row->email));
			$this->load->library('email');
			$this->email->from('iwantmypasswordback@oneextralap.com', 'OneExtraLap');
			$this->email->to($row->email);
			$this->email->reply_to('stephen@oneextralap.com', 'Stephen Ou');
			$this->email->subject('Your OneExtraLap Password Recovery');
			$this->email->message('Hello, '.$row->fullname.'. Click the following link to reset your password: http://oneextralap.com/reset/'.$random);
			$this->email->send();
			$this->session->set_flashdata('message', array('Check your email please. We\'ve sent you a recovery link.'));
		}
		else {
			$this->session->set_flashdata('message', array('Email not found...'));
		}
		redirect(uri_string());
	
	}
	
	function reset_password($code) {
	
		$password = $this->input->post('password');
		$status = $this->check_code($code);
		if ($status == TRUE) {
			if ($this->form_validation->required($password) == FALSE) {
				$this->session->set_flashdata('message', array('Please enter your new password.'));
				redirect('/reset/'.$code);
			}
			elseif ($this->form_validation->min_length($password, 6) == FALSE) {
				$this->session->set_flashdata('message', array('Password should be 6 characters or more.'));
				redirect('/reset/'.$code);
			}
			else {
				$query = $this->db->query("SELECT username FROM user WHERE forget_password='$code' LIMIT 1");
				$data = array('password' => md5($password), 'forget_password' => '');
				manipulate_database('update', 'user', $data, array('forget_password' => $code));
				$this->session->set_flashdata('message', array('All set!'));
				return $query->row()->username;
			}
		}
		else redirect('/reset');
	
	}
	
	function logout() {
	
		$this->session->sess_destroy();
		delete_cookie('nihaoma');
	
	}
	
	function check_old_password($username, $oldpassword) {
	
		$oldpassword = md5($oldpassword);
		$query = $this->db->query("SELECT COUNT(id) AS total FROM user WHERE username='$username' AND password='$oldpassword'");
		return ($query->row()->total == 1) ? TRUE : FALSE;
		
	}
	
	function if_email_used($username, $email) {
	
		$query = $this->db->query("SELECT username, COUNT(id) AS total FROM user WHERE email='$email'");
		$row = $query->row();
		return ($row->total == 0 || $username == $row->username) ? TRUE : FALSE;
		
	}
	
	function get_email($code) {
	
		$query = $this->db->query("SELECT email FROM preview WHERE code=$code LIMIT 1");
		return $query->row()->email;
		
	}
	
	function if_username_used($username) {
	
		$query1 = $this->db->query("SELECT COUNT(id) AS total FROM user WHERE username='$username'");
		$query2 = $this->db->query("SELECT COUNT(content) AS total FROM preset WHERE content='$username' AND type='username'");
		return ($query1->row()->total == 0 && $query2->row()->total == 0) ? TRUE : FALSE;
		
	}
	
	function check_code($code) {
	
		if ($code == '') return TRUE;
		$time = time() - 86400;
		$query = $this->db->query("SELECT COUNT(id) AS total FROM user WHERE forget_password='$code' AND forget_password_time>='$time'");
		return ($query->row()->total == 1) ? TRUE : FALSE;
	
	}
	
}

?>