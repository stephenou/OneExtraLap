<?php

class Search_model extends Model {

	function Search_model() {
	
		parent::Model();
		
	}
	
	function get_quiz_result($term, $page) {
		
		$term = $this->db->escape_like_str($term);
		$text = "SELECT DISTINCT id, time FROM quiz JOIN (SELECT quiz_id FROM question WHERE question LIKE '%$term%') AS hellyeah ON quiz.id=quiz_id OR title LIKE '%$term%' OR user_id LIKE '%$term%'";
		$return['query'] = build_query($text, $page);
		$return['pagination'] = get_pagination($text, $page);
		return $return;
	
	}
	
	function get_people_result($term, $page) {
	
		$term = $this->db->escape_like_str($term);
		$text = "SELECT DISTINCT username, IFNULL((SELECT SUM(score.point) FROM score WHERE user_id=username), 0) + IFNULL((SELECT SUM(badges.point) FROM badges WHERE user_id=username), 0) AS total FROM user WHERE username LIKE '%$term%' OR fullname LIKE '%$term%' OR bio LIKE '%$term%' OR website LIKE '%$term%' OR twitter LIKE '%$term%'";
		$return['query'] = build_query($text, $page);
		$return['pagination'] = get_pagination($text, $page);
		return $return;
		
	}
	
	function get_leaderboard($page) {
	
		$text = "SELECT username, IFNULL((SELECT SUM(score.point) FROM score WHERE user_id=username), 0) + IFNULL((SELECT SUM(badges.point) FROM badges WHERE user_id=username), 0) AS total FROM user";
		$return['query'] = build_query($text, $page, "IFNULL((SELECT SUM(score.point) FROM score WHERE user_id=username), 0) + IFNULL((SELECT SUM(badges.point) FROM badges WHERE user_id=username), 0) DESC");
		$return['pagination'] = get_pagination($text, $page);
		return $return;
		
	}
	
	function get_new_people($page) {
	
		$text = "SELECT username, signup_time AS total FROM user";
		$return['query'] = build_query($text, $page);
		$return['pagination'] = get_pagination($text, $page);
		return $return;
		
	}
	
	function get_popular_quiz($page) {
	
		$text = 'SELECT id, time FROM quiz';
		$time = time();
		$return['query'] = build_query($text, $page, "(SELECT COUNT(id)/($time-time) FROM score WHERE score.quiz_id=quiz.id AND type='take') DESC");
		$return['pagination'] = get_pagination($text, $page);
		return $return;
	
	}
	
	function get_difficult_quiz($page) {
	
		$text = 'SELECT id, time FROM quiz';
		$return['query'] = build_query($text, $page, "(SELECT AVG(score.point/score.amount) FROM score WHERE score.quiz_id=quiz.id AND type='take') ASC");
		$return['pagination'] = get_pagination($text, $page);
		return $return;
	
	}
	
	function get_fresh_quiz($page) {
	
		$text = 'SELECT id, time FROM quiz';
		$return['query'] = build_query($text, $page, "time DESC");
		$return['pagination'] = get_pagination($text, $page);
		return $return;
	
	}
	
	function get_tags($page) {
	
		$text = "SELECT tag, COUNT(tag) AS number FROM tag GROUP BY tag";
		$return['query'] = build_query($text, $page, '	number DESC, id DESC');
		$return['pagination'] = get_pagination($text, $page);
		return $return;
		
	}
	
	function get_tag($tag, $page) {
	
		$term = make_it_safe($tag);
		$text = "SELECT DISTINCT id, time FROM quiz JOIN (SELECT quiz_id FROM tag WHERE tag='$term') AS hellyeah ON quiz.id=quiz_id";
		$return['query'] = build_query($text, $page);
		$return['pagination'] = get_pagination($text, $page);
		return $return;
	
	}
	
	function get_your_tags($username) {
	
		$query = $this->db->query("SELECT tag, COUNT(tag) AS number FROM tag JOIN (SELECT id AS quizid FROM quiz WHERE user_id='$username') AS hellyeah ON quizid=quiz_id GROUP BY tag ORDER BY number DESC, id DESC");
		return ($query->num_rows() == 0) ? FALSE : $query;
				
	}
	
	function get_badges_total() {
	
		return $this->db->query("SELECT COUNT(id) AS total FROM badge")->row()->total;
		
	}
	
	function get_badge($id, $userid) {
	
		$return['query'] = $this->db->query("SELECT id, user_id, badge_id, time FROM badges JOIN (SELECT follower_user_id FROM follow WHERE following_user_id='$userid' AND deleted_time='') AS hellyeah ON user_id=follower_user_id WHERE badge_id='$id' ORDER BY id DESC");
		$return['pagination'] = FALSE;
		return $return;
	
	}
	
	function get_your_badges($username) {
	
		$query = $this->db->query("SELECT id, badge_id FROM badges WHERE user_id='$username'");
		return ($query->num_rows() == 0) ? FALSE : $query;
				
	}
	
	function check_badge_existance($id) {
	
		return ($id == '' || $this->db->query("SELECT COUNT(id) AS total FROM badge WHERE id='$id'")->row()->total == 0) ? FALSE : TRUE;
		
	
	}
	
	/*function random($term, $username) {
	
		if ($term == '') {
			$query = $this->db->query("SELECT id FROM quiz WHERE id NOT IN (SELECT quiz_id FROM score WHERE user_id='$username') ORDER BY RAND() LIMIT 1");
			if ($query->num_rows() == 1) {
				$row = $query->row();
				redirect("/$row->id");
			}
			else {
				$query = $this->db->query("SELECT id FROM quiz WHERE id IN (SELECT quiz_id FROM score WHERE user_id='$username' AND type='take') ORDER BY RAND() LIMIT 1");
				if ($query->num_rows() == 1) {
					$row = $query->row();
					redirect("/$row->id");
				}
				else {
					$query = $this->db->query("SELECT id FROM quiz WHERE id IN (SELECT quiz_id FROM score WHERE user_id='$username' AND type='create') ORDER BY RAND() LIMIT 1");
					if ($query->num_rows() == 1) {
						$row = $query->row();
						redirect("/$row->id");
					}
				}
			}
		}
		else {
			$term = make_it_safe($term);
			$query = $this->db->query("SELECT id FROM quiz WHERE id IN (SELECT quiz_id FROM tag WHERE tag='$term') ORDER BY RAND() LIMIT 1");
		}
	
	}*/
	
}

?>