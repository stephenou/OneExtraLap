<?php

class Quiz_model extends Model {

	function Quiz_model() {
	
		parent::Model();
		
	}
	
	function check_quiz_existance($quizid) {
		
		$query = $this->db->query("SELECT COUNT(id) AS total FROM quiz WHERE id='$quizid' LIMIT 1");
		return ($query->row()->total == 1) ? TRUE : FALSE;
		
	}
	
	function check_user_status($quizid, $username, $action) {
	
		if ($action != '') return $action;
		$query = $this->db->query("SELECT COUNT(id) AS total, type FROM score WHERE quiz_id='$quizid' AND user_id='$username' LIMIT 1");
		$row = $query->row();
		return ($row->total == 1) ? $row->type : 'untake';
	
	}
	
	function get_onehundred($quizid) {
	
		$query = $this->db->query("SELECT user_id, time FROM score WHERE quiz_id='$quizid' AND type='take' AND point=amount ORDER BY id DESC");
		return ($query->num_rows() == 0) ? FALSE : $query;
	
	}
	
	function get_tag($quizid) {
	
		$query = $this->db->query("SELECT id, tag FROM tag WHERE quiz_id='$quizid'");
		return ($query->num_rows() == 0) ? FALSE : $query;
	
	}
	
	/*function get_similar_quiz($quizid, $userid) {
	
		$CI = & get_instance();
		$CI->load->model('global_function');
		$return = "";
		$query1 = $this->db->query("SELECT tag, COUNT(tag) AS number FROM tag WHERE quiz_id='$quizid' GROUP BY tag ORDER BY number DESC");
		if ($query1->num_rows() != 0) {
			foreach ($query1->result() as $row1) {
				$query2 = $this->db->query("SELECT quiz_id FROM tag WHERE tag='$row1->tag' AND quiz_id!='$quizid' AND quiz_id NOT IN (SELECT quiz_id FROM score WHERE user_id='$userid') ORDER BY RAND() LIMIT 1");
				$row2 = $query2->row();
				if ($return == "") {
					$return = $row2->quiz_id;
				}
			}
		}
		else {
			$query3 = $this->db->query("SELECT id FROM quiz WHERE user_id IN (SELECT user_id FROM quiz WHERE id='$quizid') AND id!='$quizid' AND id NOT IN (SELECT quiz_id FROM score WHERE user_id='$userid') ORDER BY RAND() LIMIT 1");
			if ($query3->num_rows() != 0) {
				$row3 = $query3->row();
				$return = $row3->id;
			}
			else {
				$query4 = $this->db->query("SELECT id FROM quiz WHERE id IN (SELECT id FROM score WHERE user_id IN (SELECT user_id FROM quiz WHERE id='$quizid')) AND id!='$quizid' AND id NOT IN (SELECT quiz_id FROM score WHERE user_id='$userid') ORDER BY RAND() LIMIT 1");
				if ($query4->num_rows() != 0) {
					$row4 = $query4->row();
					$return = $row4->id;
				}
				else {
					$query5 = $this->db->query("SELECT id FROM quiz WHERE id IN (SELECT id FROM score WHERE user_id IN (SELECT follower_user_id FROM follow WHERE following_user_id='$userid')) AND id!='$quizid' AND id NOT IN (SELECT quiz_id FROM score WHERE user_id='$userid') ORDER BY RAND() LIMIT 1");
					if ($query5->num_rows() != 0) {
						$row5 = $query5->row();
						$return = $row5->id;
					}
					else {
						$query6 = $this->db->query("SELECT id FROM quiz WHERE id IN (SELECT id FROM score WHERE user_id IN (SELECT following_user_id FROM follow WHERE follower_user_id='$userid')) AND id!='$quizid' AND id NOT IN (SELECT quiz_id FROM score WHERE user_id='$userid') ORDER BY RAND() LIMIT 1");
						if ($query6->num_rows() != 0) {
							$row6 = $query6->row();
							$return = $row6->id;
						}
						else {
							$query7 = $this->db->query("SELECT id FROM quiz WHERE id!='$quizid' AND id NOT IN (SELECT quiz_id FROM score WHERE user_id='$userid') ORDER BY RAND() LIMIT 1");
							$row7 = $query7->row();
							$return = $row7->id;
						}
					}
				}
			}
		}
		return $CI->global_function->get_title($return);
	
	}*/
	
	function submit_individual_question($answer, $id, $number, $amount, $username) {
	
		$row = $this->db->query("SELECT * FROM question WHERE id='$id' LIMIT 1")->row();
		$correct = $row->correct;
		if ($answer == $row->answer_id) $correct++;
		$data = array('correct' => $correct);
		manipulate_database('update', 'question', $data, array('id' => $id));
		$data = array('user_id' => $username, 'answer_id' => $answer, 'question_id' => $id);
		manipulate_database('insert', 'activity', $data);
		return ($answer == $row->answer_id) ? TRUE : FALSE;
		
	}
	
	function submit_score($quizid, $username, $correct, $amount) {
	
		$date = time();
		$scoredata = array('user_id' => $username, 'type' => 'take', 'quiz_id' => $quizid, 'time' => $date, 'point' => $correct, 'amount' => $amount);
		manipulate_database('insert', 'score', $scoredata);
		
	}
	
	function get_quiz_grade($quizid, $username) {
	
		$return['query'] = $this->db->query("SELECT DISTINCT id, type, user_id, quiz_id, point, amount, time FROM score WHERE quiz_id='$quizid' AND type='take' ORDER BY point DESC");
		$return['pagination'] = FALSE;
		return $return;
	
	}
	
	function get_questions($quizid) {
		
		$return['query'] = $this->db->query("SELECT * FROM question WHERE quiz_id='$quizid' ORDER BY id ASC");
		$a = 1;
		foreach ($return['query']->result() as $row) {
			$return[$a] = $this->db->query("SELECT * FROM answer WHERE question_id='$row->id' ORDER BY id ASC");
			$a++;
		}
		$return['pagination'] = FALSE;
		return $return;
		
	}
	
	function if_answer_changed($text, $answerid) {
	
		$row = $this->db->query("SELECT answer FROM answer WHERE id='$answerid' LIMIT 1")->row();
		return ($row->answer == $text) ? FALSE : TRUE;
	
	}
	
	function if_question_changed($questionid, $answerid, $question) {
	
		$row = $this->db->query("SELECT question, answer_id FROM question WHERE id='$questionid' LIMIT 1")->row();
		return ($row->question == $question && $row->answer_id == $answerid) ? FALSE : TRUE;
	
	}
	
	function update_answers($questionid, $text, $answerid, $letter, $answer) {
	
		$text = make_it_safe($text);
		$data = array('question_id' => $questionid, 'answer' => $text);
		manipulate_database('update', 'answer', $data, array('id' => $answerid));
		if ($letter == $answer) {
			$text = mysql_real_escape_string($text);
			$row = $this->db->query("SELECT id FROM answer WHERE question_id='$questionid' AND answer='$text' LIMIT 1")->row();
			return $row->id;
		}
	
	}
	
	function update_questions($questionid, $answerid, $question) {
	
		$data = array('answer_id' => $answerid, 'question' => make_it_safe($question));
		manipulate_database('update', 'question', $data, array('id' => $questionid));
	
	}
	
	function delete_tags($quizid) {
	
		$query = $this->db->query("SELECT id FROM tag WHERE quiz_id='$quizid' ORDER BY id ASC");
		$number = 1;
		foreach ($query->result() as $row) {
			if ($this->input->post('tagid'.$number) != $row->id) manipulate_database('delete', 'tag', NULL, array('id' => $row->id));
			$number++;
		}
			
	}
	
	function insert_tags($quizid, $tag, $tagid) {
	
		if ($tagid == 'new') {
			$data = array('quiz_id' => $quizid, 'tag' => strtolower(make_it_safe($tag)));
			manipulate_database('insert', 'tag', $data);
		}
			
	}

	function edit_form_submit($quizid, $title, $change) {
		
		$row = $this->db->query("SELECT title FROM quiz WHERE id='$quizid' LIMIT 1")->row();
		$data = array('title' => make_it_safe($title));
		manipulate_database('update', 'quiz', $data, array('id' => $quizid));
		if ($row->title != $title) $change = TRUE;
		if ($change == TRUE) {
			$data = array('last_edit_time' => time());
			manipulate_database('update', 'quiz', $data, array('id' => $quizid));
		}
		
	}
	
}

?>