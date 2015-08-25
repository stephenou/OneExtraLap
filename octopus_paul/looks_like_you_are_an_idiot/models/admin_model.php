<?php

class Admin_model extends Model {

	function Admin_model() {
	
		parent::Model();
		
	}
	
	function score() {
	
		$userid = $this->input->post('userid');
		$quizid = $this->input->post('quizid');
		return $this->db->query("SELECT * FROM score WHERE user_id='$userid' AND quiz_id='$quizid' LIMIT 1");
	
	}
	
	function user() {
	
		$userid = $this->input->post('userid');
		return $this->db->query("SELECT * FROM user WHERE username='$userid' LIMIT 1");
	
	}
	
	function quiz() {
	
		$quizid = $this->input->post('quizid');
		return $this->db->query("SELECT * FROM quiz WHERE id='$quizid' LIMIT 1");
	
	}
	
	function question() {
	
		$questionid = $this->input->post('questionid');
		return $this->db->query("SELECT * FROM question WHERE id='$questionid' LIMIT 1");
	
	}
	
	function answer() {
	
		$answerid = $this->input->post('answerid');
		return $this->db->query("SELECT * FROM answer WHERE id='$answerid' LIMIT 1");
	
	}
	
	function recent_signup() {
	
		$limit = $this->input->post('limit');
		return $this->db->query("SELECT username, signup_time FROM user ORDER BY signup_time DESC LIMIT $limit");
	
	}
	
	function recent_login() {
	
		$limit = $this->input->post('limit');
		return $this->db->query("SELECT username, last_login_time FROM user ORDER BY last_login_time DESC LIMIT $limit");
	
	}
	
	function forget_password() {
	
		return $this->db->query("SELECT username, forget_password, forget_password_time FROM user WHERE forget_password!=''");
	
	}
	
	function no_info() {
	
		return $this->db->query("SELECT username, password, email FROM user WHERE username='' OR password='' OR email=''");
	
	}
	
	function certain_password() {
	
		$password = md5($this->input->post('password'));
		return $this->db->query("SELECT username, password FROM user WHERE password='$password'");
	
	}
	
	function view_as() {
	
		$userid = $this->input->post('userid');
		$this->session->set_userdata('nihaoma', $userid);
		$this->session->set_userdata('cang', 'stephenou');
		redirect('/');
	
	}
	
	function preset_term() {
	
		$term = $this->input->post('term');
		if ($this->db->query("SELECT content FROM preset WHERE content='$term' AND type='username' LIMIT 1")->num_rows() == 0) {
			$data = array('content' => $term, 'type' => 'username');
			$this->db->insert('preset', $data);
			return TRUE;
		}
		return FALSE;
		
	
	}
	
	function badge() {
	
		$name = $this->input->post('name');
		$explanation = $this->input->post('explanation');
		$point = $this->input->post('point');
		if ($this->db->query("SELECT id FROM badge WHERE name='$name' LIMIT 1")->num_rows() == 0 && strlen($name) <= 40 && strlen($explanation) <= 100) {
			$data = array('user_id' => 'stephenou', 'name' => $name, 'explanation' => $explanation, 'point' => $point);
			$this->db->insert('badge', $data);
			return TRUE;
		}
		return FALSE;
	
	}
	
	function badge_user() {
	
		$userid = $this->input->post('userid');
		$badgeid = $this->input->post('badgeid');
		if ($this->db->query("SELECT id FROM badges WHERE user_id='$userid' AND badge_id='$badgeid' LIMIT 1")->num_rows() == 0 && $this->db->query("SELECT id FROM user WHERE username='$userid' LIMIT 1")->num_rows() == 1 && $this->db->query("SELECT id FROM badge WHERE id='$badgeid' LIMIT 1")->num_rows() == 1) {
			$data = array('user_id' => $userid, 'badge_id' => $badgeid, 'time' => mktime());
			$this->db->insert('badges', $data);
			return TRUE;
		}
		return FALSE;
	
	}
	
	function trending_topic() {
	
		$topic = $this->input->post('topic');
		$topic_replaced = $this->input->post('topic_replaced');
		if ($this->db->query("SELECT content FROM preset WHERE content='$topic' AND type='trending' LIMIT 1")->num_rows() == 0 && $this->db->query("SELECT content FROM preset WHERE content='$topic_replaced' AND type='trending' LIMIT 1")->num_rows() == 1) {
			$data = array('content' => $topic, 'type' => 'trending');
			$this->db->update('preset', $data, array('content' => $topic_replaced, 'type' => 'trending'));
			return TRUE;
		}
		return FALSE;
	
	}
	
	function delete_user_all() {
	
		$userid = $this->input->post('userid');
		if ($this->db->query("SELECT id FROM user WHERE username='$userid' LIMIT 1")->num_rows() == 1) {
			$this->delete_user_only();
			$this->db->delete('user', array('username' => $userid));
			return TRUE;
		}
		return FALSE;
	
	}
	
	function delete_user_only() {
	
		$userid = $this->input->post('userid');
		if ($this->db->query("SELECT id FROM user WHERE username='$userid' LIMIT 1")->num_rows() == 1) {
			$query = $this->db->query("SELECT id FROM quiz WHERE user_id='$userid'");
			$this->db->delete('activity', array('user_id' => $userid));
			$this->db->delete('badges', array('user_id' => $userid));
			$this->db->delete('follow', array('follower_user_id' => $userid));
			$this->db->delete('follow', array('following_user_id' => $userid));
			$this->db->delete('quiz', array('user_id' => $userid));
			$this->db->delete('score', array('user_id' => $userid));
			foreach ($query->result() as $row) {
				$query1 = $this->db->query("SELECT id FROM question WHERE quiz_id='$row->id'");
				$this->db->delete('question', array('quiz_id' => $row->id));
				$this->db->delete('tag', array('quiz_id' => $row->id));
				$this->db->delete('score', array('quiz_id' => $row->id));
				foreach ($query1->result() as $row1) {
					$query2 = $this->db->query("SELECT id FROM answer WHERE question_id='$row1->id'");
					$this->db->delete('answer', array('question_id' => $row1->id));
					foreach ($query2->result() as $row2) {
						$this->db->delete('activity', array('answer_id' => $row2->id));
					}
				}
			}
			return TRUE;
		}
		return FALSE;
	
	}
	
	function delete_quiz() {
	
		$quizid = $this->input->post('quizid');
		if ($this->db->query("SELECT id FROM quiz WHERE id='$quizid' LIMIT 1")->num_rows() == 1) {
			$query = $this->db->query("SELECT id FROM question WHERE quiz_id='$quizid'");
			$this->db->delete('quiz', array('id' => $quizid));
			$this->db->delete('question', array('quiz_id' => $quizid));
			$this->db->delete('tag', array('quiz_id' => $quizid));
			$this->db->delete('score', array('quiz_id' => $quizid));
			foreach ($query->result() as $row) {
				$query1 = $this->db->query("SELECT id FROM answer WHERE question_id='$row->id'");
				$this->db->delete('answer', array('question_id' => $row->id));
				foreach ($query1->result() as $row1) {
					$this->db->delete('activity', array('answer_id' => $row1->id));
				}
			}
			return TRUE;
		}
		return FALSE;
	
	}
	
	function delete_question() {
	
		$questionid = $this->input->post('questionid');
		if ($this->db->query("SELECT id FROM question WHERE id='$questionid' LIMIT 1")->num_rows() == 1) {
			$query = $this->db->query("SELECT id FROM answer WHERE question_id='$questionid'");
			$this->db->delete('question', array('id' => $questionid));
			$this->db->delete('answer', array('question_id' => $questionid));
			foreach ($query->result() as $row) {
				$this->db->delete('activity', array('answer_id' => $row->id));
			}
			return TRUE;
		}
		return FALSE;
	
	}
	
	function delete_score() {
	
		$userid = $this->input->post('userid');
		$quizid = $this->input->post('quizid');
		if ($this->db->query("SELECT id FROM score WHERE user_id='$userid' AND quiz_id='$quizid' LIMIT 1")->num_rows() == 1) {
			$this->db->delete('score', array('user_id' => $userid, 'quiz_id' => $quizid));
			return TRUE;
		}
		return FALSE;
	
	}
	
	function delete_tag() {
	
		$tag = $this->input->post('tag');
		if ($this->db->query("SELECT id FROM tag WHERE tag='$tag' LIMIT 1")->num_rows() == 1) {
			$this->db->delete('tag', array('tag' => $tag));
			return TRUE;
		}
		return FALSE;
	
	}
	
	function delete_badge_user() {
	
		$userid = $this->input->post('userid');
		$badgeid = $this->input->post('badgeid');
		if ($this->db->query("SELECT id FROM badges WHERE user_id='$userid' AND badge_id='$badgeid' LIMIT 1")->num_rows() == 1) {
			$this->db->delete('badges', array('user_id' => $userid, 'badge_id' => $badgeid));
			return TRUE;
		}
		return FALSE;
	
	}
	
	function delete_badge() {
	
		$badgeid = $this->input->post('badgeid');
		if ($this->db->query("SELECT id FROM badge WHERE id='$badgeid' LIMIT 1")->num_rows() == 1) {
			$this->db->delete('badge', array('id' => $badgeid));
			$this->db->delete('badges', array('badge_id' => $badgeid));
			return TRUE;
		}
		return FALSE;
	
	}
	
}

?>