<?php

class Badge_model extends Model {

	function Badge_model() {
	
		parent::Model();
		
	}
	
	function check($username, $page) {
	
		$return = array();
		$name = array('no_longer_a_newbie', 'early_adopter', 'sneak_peaker', 'lightning_speed', 'learner', 'fast_typer', 'lucky_ducky', 'genius', 'elementary_school_graduate', 'middle_school_graduate', 'high_school_graduate', 'teacher', 'experienced_teacher', 'college_professor');
		$a = 1;
		while ($a <= count($name)) {
			if ($this->db->query("SELECT COUNT(id) AS total FROM badges WHERE user_id='$username' AND badge_id='".$a."' LIMIT 1")->row()->total == 0) $return = $this->$name[$a-1]($username, $return);
			$a++;
		}
		return $return;
	
	}
	
	//Complete the getting started guide
	function no_longer_a_newbie($userid, $array) {
	
		$query1 = $this->db->query("SELECT access_token, access_token_secret FROM user WHERE username='$userid' LIMIT 1")->row();
		$query2 = $this->db->query("SELECT fullname, bio, website, avatar FROM user WHERE username='$userid' LIMIT 1")->row();
		$query3 = $this->db->query("SELECT COUNT(id) AS total FROM follow WHERE following_user_id='$userid' LIMIT 1")->row()->total;
		$query4 = $this->db->query("SELECT COUNT(id) AS total FROM score WHERE user_id='$userid' AND type='take' LIMIT 1")->row()->total;
		$query5 = $this->db->query("SELECT COUNT(id) AS total FROM quiz WHERE user_id='$userid' LIMIT 1")->row()->total;
		$result1 = ($query1->access_token == '' && $query1->access_token_secret == '') ? FALSE : TRUE;
		$result2 = (($query2->fullname == '' && $query2->bio == '' && $query2->website == '') && ($query2->avatar == '' || $query2->avatar == 'http://www.gravatar.com/avatar')) ? FALSE : TRUE;
		$result3 = ($query3 == 0) ? FALSE : TRUE;
		$result4 = ($query4 == 0) ? FALSE : TRUE;
		$result5 = ($query5 == 0) ? FALSE : TRUE;
		$result = ($result1 == TRUE && $result2 == TRUE && $result3 == TRUE && $result4 == TRUE && $result5 == TRUE) ? TRUE : FALSE;
		return $this->show_results($userid, 1, $result, $array);
	
	}
	
	// Beta testers
	function early_adopter($userid, $array) {
	
		return $array;
	
	}
	
	// People signed up for preview
	function sneak_peaker($userid, $array) {
	
		return $array;
	
	}
	
	// 100 points in a day
	function lightning_speed($userid, $array) {
	
		$time = time() - 86400;
		$query = $this->db->query("SELECT SUM(point) AS total FROM score WHERE user_id='$userid' AND time>'$time'")->row()->total;
		$result = ($query > 100) ? TRUE : FALSE;
		return $this->show_results($userid, 4, $result, $array);
	
	}
	
	// Took 5 quizzes a day
	function learner($userid, $array) {
	
		$time = time() - 86400;
		$query = $this->db->query("SELECT COUNT(id) AS total FROM score WHERE user_id='$userid' AND type='take' AND time>'$time'")->row()->total;
		$result = ($query >= 5) ? TRUE : FALSE;
		return $this->show_results($userid, 5, $result, $array);
	
	}
	
	// Created 2 quizzes a day
	function fast_typer($userid, $array) {
	
		$time = time() - 86400;
		$query = $this->db->query("SELECT COUNT(id) AS total FROM quiz WHERE user_id='$userid' AND time>'$time'")->row()->total;
		$result = ($query >= 2) ? TRUE : FALSE;
		return $this->show_results($userid, 6, $result, $array);
	
	}
	
	// Three 100% in a row
	function lucky_ducky($userid, $array) {
	
		$query = $this->db->query("SELECT COUNT(id) AS total, point, amount FROM score WHERE user_id='$userid' AND type='take' ORDER BY id DESC LIMIT 3");
		$result = ($query->row()->total == 3) ? TRUE : FALSE;
		foreach ($query->result() as $row) {
			if ($row->point != $row->amount) $result = FALSE;
		}
		return $this->show_results($userid, 7, $result, $array);
	
	}
	
	// 100% total of 10 times
	function genius($userid, $array) {
	
		$query = $this->db->query("SELECT COUNT(id) AS total FROM score WHERE user_id='$userid' AND type='take' AND point=amount")->row()->total;
		$result = ($query >= 10) ? TRUE : FALSE;
		return $this->show_results($userid, 8, $result, $array);
	
	}
	
	// Took total of 15 quizzes
	function elementary_school_graduate($userid, $array) {
	
		$query = $this->db->query("SELECT COUNT(id) AS total FROM score WHERE user_id='$userid' AND type='take'")->row()->total;
		$result = ($query >= 15) ? TRUE : FALSE;
		return $this->show_results($userid, 9, $result, $array);
	
	}
	
	// Took total of 40 quizzes
	function middle_school_graduate($userid, $array) {
	
		$query = $this->db->query("SELECT COUNT(id) AS total FROM score WHERE user_id='$userid' AND type='take'")->row()->total;
		$result = ($query >= 40) ? TRUE : FALSE;
		return $this->show_results($userid, 10, $result, $array);
	
	}
	
	// Took total of 100 quizzes
	function high_school_graduate($userid, $array) {
	
		$query = $this->db->query("SELECT COUNT(id) AS total FROM score WHERE user_id='$userid' AND type='take'")->row()->total;
		$result = ($query >= 100) ? TRUE : FALSE;
		return $this->show_results($userid, 11, $result, $array);
	
	}
	
	// Created total of 6 quizzes
	function teacher($userid, $array) {
	
		$query = $this->db->query("SELECT COUNT(id) AS total FROM quiz WHERE user_id='$userid'")->row()->total;
		$result = ($query >= 6) ? TRUE : FALSE;
		return $this->show_results($userid, 12, $result, $array);
	
	}
	
	// Created total of 12 quizzes
	function experienced_teacher($userid, $array) {
	
		$query = $this->db->query("SELECT COUNT(id) AS total FROM quiz WHERE user_id='$userid'")->row()->total;
		$result = ($query >= 12) ? TRUE : FALSE;
		return $this->show_results($userid, 13, $result, $array);
	
	}
	
	// Created total of 20 quizzes
	function college_professor($userid, $array) {
	
		$query = $this->db->query("SELECT COUNT(id) AS total FROM quiz WHERE user_id='$userid'")->row()->total;
		$result = ($query >= 20) ? TRUE : FALSE;
		return $this->show_results($userid, 14, $result, $array);
	
	}
		
	function show_results($userid, $badgeid, $result, $array) {
	
		if ($result == TRUE) {
			$row = $this->db->query("SELECT id, point, name FROM badge WHERE id='$badgeid' LIMIT 1")->row();
			$num_rows = $this->db->query("SELECT COUNT(id) AS total FROM badges WHERE user_id='$userid' AND badge_id='$badgeid' LIMIT 1")->row()->total;
			if ($num_rows == 0) {
				$data = array('user_id' => $userid, 'badge_id' => $row->id, 'point' => $row->point, 'time' => time());
				manipulate_database('insert', 'badges', $data);
				$CI = &get_instance();
				$CI->load->model('twitter_model');
				$CI->twitter_model->auto_share($userid, FALSE, $badgeid, $row->name);
				array_push($array, 'You just unlocked the badge "<a href="/badges/'.$row->id.'">'.$row->name.'</a>"!');
			}
		}
		return $array;
	
	}
	
}

?>