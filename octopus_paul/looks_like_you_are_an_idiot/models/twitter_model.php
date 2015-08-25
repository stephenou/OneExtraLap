<?php

class Twitter_model extends Model {

	function Twitter_model() {
	
		parent::Model();
		$this->load->library('twitter');
		
	}
	
	function auth($username = FALSE) {
	
		$tokens['access_token'] = NULL;
		$tokens['access_token_secret'] = NULL;
		$row = $this->db->query("SELECT access_token, access_token_secret FROM user WHERE username='$username' LIMIT 1")->row();
		if ($row->access_token != '' && $row->access_token_secret != '' && $username != FALSE) {
			$tokens['access_token'] = $row->access_token;
			$tokens['access_token_secret'] = $row->access_token_secret;
		}
		$oauth_tokens = $this->session->userdata('twitter_oauth_tokens');
		if ($oauth_tokens !== FALSE) {
			$tokens = $oauth_tokens;
		}
		return $this->twitter->oauth($tokens['access_token'], $tokens['access_token_secret']);
	
	}
	
	function oauth($username) {
	
		$this->session->unset_userdata('twitter_oauth_tokens');
		$auth = $this->auth();
		if (isset($auth['access_token']) && isset($auth['access_token_secret'])) {
			$this->session->set_userdata('twitter_oauth_tokens', $auth);
			$return = $this->get_user_info();
			$access_token = $auth['access_token'];
			$access_token_secret = $auth['access_token_secret'];
			$row = $this->db->query("SELECT COUNT(id) AS total, username FROM user WHERE access_token='$access_token' AND access_token_secret='$access_token_secret'")->row();
			if ($row->total == 0 && $username == '') {
				$this->session->set_flashdata('message', array('Your Twitter credential didn\'t match with any of our accounts.'));
				$this->logout();
				redirect('/login');
			}
			elseif ($row->total == 1 && $username == '') {
				$this->session->set_flashdata('message', array('Welcome Back!'));
				$CI =& get_instance();
				$CI->global_function->login($row->username);
				redirect('/');
			}
			elseif ($username != '') {
				$data = array('access_token' => $access_token, 'access_token_secret' => $access_token_secret, 'fullname' => $return->name, 'bio' => $return->description, 'website' => $return->url, 'avatar' => $this->config->item('twavatar_url').strtolower($return->screen_name), 'twitter' => $return->screen_name, 'twitter_id' => $return->id, 'share_created' => 1, 'share_badge' => 1);
				manipulate_database('update', 'user', $data, array('username' => $username));
				$this->session->set_flashdata('message', array('Success! Follow some of your friends from Twitter!'));
				redirect('/people/twitter');
			}
			else {
				$this->session->set_flashdata('message', array('Uh oh, an error just occured. Please try again. Sorry. :('));
				redirect('/');
			}
		}
		else {
			die('no');
		}
	
	}
	
	function get_user_info() {
	
		$auth = $this->auth();
		return $this->twitter->call('account/verify_credentials');
	
	}
	
	function auto_follow($screen_name) {
	
		$auth = $this->auth();
		$this->twitter->call('friendships/create', array('screen_name' => $this->config->item('twitter_screen_name')));
	
	}
	
	function get_twitter_people($username) {
	
		$row = $this->db->query("SELECT twitter, access_token, access_token_secret FROM user WHERE username='$username' LIMIT 1")->row();
		if ($row->access_token == '' || $row->access_token_secret == '') return FALSE;
		else {
			$followers = $this->twitter->call('friends/ids', array('screen_name' => $row->twitter));
			if (!empty($followers)) $this->db->select('username, twitter AS total')->where_in('twitter_id', $followers);
			else $this->db->limit(0);
			$return['query'] = $this->db->get('user');
			$return['pagination'] = FALSE;
			return $return;
		}
	
	}
	
	function logout() {
	
		$this->session->unset_userdata('twitter_oauth_tokens');
	
	}
	
	function disconnect_twitter($username, $type = TRUE) {
	
		$data = array('access_token' => '', 'access_token_secret' => '', 'twitter' => '', 'twitter_id' => '');
		manipulate_database('update', 'user', $data, array('username' => $username));
		$this->session->set_flashdata('message', array('Success! You can reconnect by clicking the image below.'));
		redirect('/settings/twitter');
	
	}
	
	function auto_share($userid, $quizid, $badge = FALSE, $badge_name = FALSE) {
	
		$auth = $this->auth($userid);
		$row1 = $this->db->query("SELECT point, amount FROM score WHERE user_id='$userid' AND quiz_id='$quizid' LIMIT 1")->row();
		$row2 = $this->db->query("SELECT share_created, share_took, share_onehundred, share_badge FROM user WHERE username='$userid' LIMIT 1")->row();
		$send = FALSE;
		if ($badge == FALSE) {
			if ($row1->point > $row1->amount && $row2->share_created == 1) {
				$tweet = 'I just created the quiz \''.get_title($quizid, FALSE).'\' on @OneExtraLap! Come & take it! '.get_quiz_link($quizid);
				$send = TRUE;
			}
			if ($row1->point == $row1->amount && $row2->share_onehundred == 1) {
				$tweet = 'I just got 100% in the quiz \''.get_title($quizid, FALSE).'\' on @OneExtraLap! You can do it too! '.get_quiz_link($quizid);
				$send = TRUE;
			}
			elseif ($row1->point <= $row1->amount && $row2->share_took == 1) {
				$tweet = 'I just got '.get_percentage($row1->point, $row1->amount).' in the quiz \''.get_title($quizid, FALSE).'\' on @OneExtraLap! Can you beat me? '.get_quiz_link($quizid);
				$send = TRUE;
			}
		}
		else {
			if ($row2->share_badge == 1) {
				$badge_info = get_badge($badge);
				$tweet = 'I just unlocked the badge \''.$badge_name.'\' on @OneExtraLap! http://oneextralap.com/badges/'.$badge;
				$send = TRUE;
			}
		}
		if ($send == TRUE) {
			$this->twitter->call('statuses/update', array('status' => trim($tweet)));
			return TRUE;
		}
		return FALSE;
	
	}
	
}

?>