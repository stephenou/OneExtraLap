<?php

class Home_model extends Model {

	function Home_model() {
	
		parent::Model();
		
	}
	
	function check_user_existance($userid) {
		
		$userid = str_replace('\'', '', $userid);
		$query = $this->db->query("SELECT COUNT(id) AS total, username FROM user WHERE username='$userid' LIMIT 1")->row();
		return ($query->total == 1) ? $query->username : FALSE;
		
	}
	
	function get_setup_status($userid) {
	
		$query0 = $this->db->query("SELECT COUNT(id) AS total FROM badges WHERE badge_id='1' AND user_id='$userid' LIMIT 1")->row()->total;
		$query1 = $this->db->query("SELECT COUNT(id) AS total FROM score WHERE user_id='$userid' AND type='take' LIMIT 1")->row()->total;
		$query2 = $this->db->query("SELECT COUNT(id) AS total FROM quiz WHERE user_id='$userid' LIMIT 1")->row()->total;
		$query3 = $this->db->query("SELECT access_token, access_token_secret FROM user WHERE username='$userid' LIMIT 1")->row();
		$return['quiz'] = $this->db->query("SELECT content FROM preset WHERE type='quiz' ORDER BY rand() LIMIT 5");
		$return[3] = ($query3->access_token == '' && $query3->access_token_secret == '') ? FALSE : TRUE;
		$return[1] = ($query1 == 0) ? FALSE : TRUE;
		$return[2] = ($query2 == 0) ? FALSE : TRUE;
		$return[0] = ($query0 == 1 || $return[1] == TRUE && $return[2] == TRUE && $return[3] == TRUE) ? TRUE : FALSE;
		return $return;
	
	}

	function get_sidebar_stats($userid) {
		
		$time = time() - 86400;
		$return['score'] = get_score($userid);
		$return['score_yesterday'] = get_score($userid, TRUE);
		$return['following'] = $this->db->query("SELECT COUNT(id) AS total FROM follow WHERE following_user_id='$userid' AND deleted_time=''")->row()->total;
		$return['follower'] = $this->db->query("SELECT COUNT(id) AS total FROM follow WHERE follower_user_id='$userid' AND deleted_time=''")->row()->total;
		$return['following_yesterday'] = $this->db->query("SELECT COUNT(id) AS total FROM follow WHERE following_user_id='$userid' AND time<=$time AND deleted_time>=$time")->row()->total;
		$return['follower_yesterday'] = $this->db->query("SELECT COUNT(id) AS total FROM follow WHERE follower_user_id='$userid' AND time<=$time AND deleted_time>=$time")->row()->total;
		return $return;
		
	}
	
	function get_badges($userid) {
	
		$query = $this->db->query("SELECT id, badge_id FROM badges WHERE user_id='$userid'");
		return ($query->num_rows() == 0) ? FALSE : $query;
	
	}

	function get_home_timeline($userid, $page) {
		
		$text = "SELECT DISTINCT id, type, user_id, quiz_id, point, amount, time FROM score JOIN (SELECT follower_user_id FROM follow WHERE following_user_id='$userid' AND deleted_time='') AS hellyeah ON user_id=follower_user_id OR user_id='$userid'";
		$return['query'] = build_query($text, $page);
		$return['pagination'] = get_pagination($text, $page);
		return $return;
	
	}
		
	function get_user_timeline($userid, $page) {
		
		$text = "SELECT DISTINCT id, type, user_id, quiz_id, point, amount, time FROM score WHERE user_id='$userid'";
		$return['query'] = build_query($text, $page);
		$return['pagination'] = get_pagination($text, $page);
		return $return;
	
	}	
	
	function get_user_following($userid, $page, $username) {
		
		$text = "SELECT id, follower_user_id AS username FROM follow WHERE following_user_id='$userid' AND deleted_time=''";
		$return['query'] = build_query($text, $page);
		$return['pagination'] = get_pagination($text, $page);
		return $return;
	
	}
	
	function get_user_followers($userid, $page, $username) {
		
		$text = "SELECT id, following_user_id AS username FROM follow WHERE follower_user_id='$userid' AND deleted_time=''";
		$return['query'] = build_query($text, $page);
		$return['pagination'] = get_pagination($text, $page);
		return $return;
	
	}
	
}

?>