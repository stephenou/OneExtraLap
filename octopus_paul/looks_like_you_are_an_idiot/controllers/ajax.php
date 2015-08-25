<?php

class Ajax extends Controller {

	function Ajax() {
	
		parent::Controller();
		$this->load->library('form_validation');
		
	}

	function index() {
	
		stupid();
		
	}
	
	function username() {
	
		if ($this->input->post('hell_yeah') != 52012) stupid();
		$username = $this->input->post('username');
		$query1 = $this->db->query("SELECT username FROM user WHERE username='$username'");
		$query2 = $this->db->query("SELECT content FROM preset WHERE content='$username' AND type='username'");
		if (empty($username)) $return = add_color('&nbsp;', 0);
		elseif (is_numeric($username)) $return = add_color('Please include a letter.', 1);
		elseif ($this->form_validation->alpha_numeric($username) == FALSE) $return = add_color('Please only use numbers and letters.', 1);
		elseif ($this->form_validation->max_length($username, 20) == FALSE) $return = add_color('Sorry! The max length is 20 characters.', 1);
		elseif ($query1->num_rows() == 1 || $query2->num_rows() == 1) $return = add_color('Sorry! <b>'.$username.'</b> is already used.', 1);
		else $return = '<span style="color: #999999">URL: oneextralap.com/</span><span style="color: #009900; font-weight: bold">'.$username.'</span>';
		$data = array('result' => $return);
		echo json_encode($data);
			
	}
	
	function fullname() {
	
		if ($this->input->post('hell_yeah') != 52012) stupid();
		$fullname = $this->input->post('fullname');
		if (empty($fullname)) $return = add_color('&nbsp;', 0);
		elseif ($this->form_validation->max_length($fullname, 255) == FALSE) $return = add_color('Sorry! The max length is 255 characters.', 1);
		else $return = add_color('Good to go!', 2);
		$data = array('result' => $return);
		echo json_encode($data);
			
	}
	
	function password() {
	
		if ($this->input->post('hell_yeah') != 52012) stupid();
		$password = $this->input->post('password');
		if (empty($password)) $return = add_color('&nbsp;', 0);
		elseif ($this->form_validation->min_length($password, 6) == FALSE) $return = add_color('6 characters or more.', 1);
		else $return = add_color('Good to go!', 2);
		$data = array('result' => $return);
		echo json_encode($data);
			
	}
	
	function email() {
		
		if ($this->input->post('hell_yeah') != 52012) stupid();
		$email = $this->input->post('email');
		$username = get_username();
		$query = $this->db->query("SELECT email, username FROM user WHERE email='$email' LIMIT 1");
		$row = $query->row();
		if (empty($email)) $return = add_color('&nbsp;', 0);
		elseif ($this->form_validation->valid_email($email) == FALSE) $return = add_color('Not a valid email.', 1);
		elseif ($query->num_rows() == 1 && $username !== $row->username) $return = add_color('The email already had an account.', 1);
		else $return = add_color('Good to go!', 2);
		$data = array('result' => $return);
		echo json_encode($data);
			
	}
	
	function bio() {
	
		if ($this->input->post('hell_yeah') != 52012) stupid();
		$this->load->library('form_validation');
		$bio = $this->input->post('bio');
		$return = (empty($bio)) ? add_color('&nbsp;', 0) : add_color('Good to go!', 2);
		$data = array('result' => $return);
		echo json_encode($data);
			
	}
		
	function website() {
	
		if ($this->input->post('hell_yeah') != 52012) stupid();
		$website = $this->input->post('website');
		if (empty($website) || $website == "http://") $return = add_color('&nbsp;', 0);
		elseif ($this->form_validation->max_length($website, 255) == FALSE) $return = add_color('Sorry! The max length is 255 characters.', 1);
		elseif ($this->form_validation->valid_url($website) == FALSE) $return = add_color('Not a valid website URL.', 1);
		else $return = add_color('Good to go!', 2);
		$data = array('result' => $return);
		echo json_encode($data);
			
	}
	
	function avatar() {
	
		if ($this->input->post('hell_yeah') != 52012) stupid();
		$avatar = $this->input->post('avatar');
		$email = $this->input->post('email');
		$twitter = $this->input->post('twitter');
		if ($avatar == "twavatar") {
			if ($twitter == '') $twitter = "twitter";
			$avatarurl = $this->config->item('twavatar_url').strtolower($twitter);
			if ($this->config->item('enable_twavatar') == FALSE) $avatarurl = '/extras/unavailable_twavatar.png';
		}
		else {
			$avatarurl = $this->config->item('gravatar_url').md5(strtolower($email));
			if ($this->config->item('enable_gravatar') == FALSE) $avatarurl = '/extras/unavailable_gravatar.png';
		}
		$return = '<img src="'.$avatarurl.'" class="profile_image_big"/>';
		$data = array('result' => $return);
		echo json_encode($data);
			
	}
	
	function hidesetup() {
			
		if ($this->input->post('hell_yeah') != 52012) stupid();
		$username = get_username();
		$row = $this->db->query("SELECT hide_setup FROM user WHERE username='$username' LIMIT 1")->row();
		$number = ($row->hide_setup == 1) ? 0 : 1;
		$return = ($row->hide_setup == 1) ? 'Hide' : 'Show the Getting Started Guide';
		$data = array('hide_setup' => $number);
		manipulate_database('update', 'user', $data, array('username' => $username));
		$data = array('result' => $return);
		echo json_encode($data);
	
	}
	
	function follow() {
	
		$following = get_username();
		$follower = $this->input->post('follower');
		if ($follower == '' || $this->input->post('hell_yeah') != 52012) stupid();
		$page = $this->input->post('page');
		$query = $this->db->query("SELECT id FROM follow WHERE following_user_id='$following' AND follower_user_id='$follower' AND deleted_time='' LIMIT 1");
		if ($query->num_rows() == 1) {
			$data = array('deleted_time' => mktime());
			manipulate_database('update', 'follow', $data, array('following_user_id' => $following, 'follower_user_id' => $follower, 'deleted_time' => ''));
			$return = '+ Follow';
		}
		else {
			$data = array('following_user_id' => $following, 'follower_user_id' => $follower, 'time' => mktime());
			manipulate_database('insert', 'follow', $data);
			$return = '- Unfollow';
		}
		if ($page == $following) {
			$followingquery = $this->db->query("SELECT COUNT(id) AS total FROM follow WHERE following_user_id='$following' AND deleted_time=''");
			$followerquery = $this->db->query("SELECT COUNT(id) AS total FROM follow WHERE follower_user_id='$following' AND deleted_time=''");
		}
		else {
			$followerquery = $this->db->query("SELECT COUNT(id) AS total FROM follow WHERE follower_user_id='$follower' AND deleted_time=''");
			$followingquery = $this->db->query("SELECT COUNT(id) AS total FROM follow WHERE following_user_id='$follower' AND deleted_time=''");
		}
		if ($page == $following || $page == $follower) {
			$followernumber = $followerquery->row()->total;
			$followingnumber = $followingquery->row()->total;
			$type = 1;
		}
		else {
			$followernumber = 0;
			$followingnumber = 0;
			$type = 0;
		}
		$badge = $this->badge_model->check($following, 'follow');
		$data = array('result' => $return, 'type' => $type, 'followernumber' => $followernumber, 'followingnumber' => $followingnumber);
		echo json_encode($data);
			
	}

}

?>