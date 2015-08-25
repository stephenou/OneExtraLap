<?php

class Create_model extends Model {

	function Create_model() {
	
		parent::Model();
		
	}
	
	function insert_quiz($username, $amount, $title) {
	
		$time = time();
		$insertdata = array('title' => make_it_safe($title), 'time' => $time, 'user_id' => $username);
		manipulate_database('insert', 'quiz', $insertdata);
		$quizid = $this->db->insert_id();
		$scoredata = array('type' => 'create', 'quiz_id' => $quizid, 'time' => $time, 'user_id' => $username, 'amount' => $amount, 'point' => $amount * 2);
		manipulate_database('insert', 'score', $scoredata);
		return $quizid;
	
	}
	
	function insert_questions($quizid, $question) {
	
		$data = array('quiz_id' => $quizid, 'question' => make_it_safe($question));
		manipulate_database('insert', 'question', $data);
		return $this->db->insert_id();
			
	}
	
	function insert_answers($questionid, $text, $letter, $answer) {
	
		$data = array('question_id' => $questionid, 'answer' => make_it_safe($text));
		manipulate_database('insert', 'answer', $data);
		if ($letter == $answer) {
			return $this->db->insert_id();
		}
	
	}
	
	function update_questions($questionid, $answerid) {
	
		$data = array('answer_id' => $answerid);
		manipulate_database('update', 'question', $data, array('id' => $questionid));
	
	}
	
	function insert_tags($quizid, $tag) {
	
		$data = array('quiz_id' => $quizid, 'tag' => strtolower(make_it_safe($tag)));
		manipulate_database('insert', 'tag', $data);
			
	}
	
}

?>