<?php

class Quiz extends Controller {

	function Quiz() {
	
		parent::Controller();
		$this->load->model('quiz_model');
		
	}

	function index($quizid, $action) {
		
		$return = $this->global_function->initialize('quiz', TRUE, $quizid);
		$username = $return['username'];
		$return['body_title'] = get_title($quizid, FALSE);
		$existance = $this->quiz_model->check_quiz_existance($quizid);
		$status = $this->quiz_model->check_user_status($quizid, $username, $action);
		if ($this->config->item('enable_edit') == FALSE && $status == 'edit') $this->global_function->load_view($return, TRUE, 503);
		elseif ($existance == TRUE) {
			if ($this->session->flashdata('took') == 'yes') $status = 'took';
			if ($this->input->post('Submit')) {
				if ($username == '') stupid();
				if ($status == 'edit') {
					prevent_stupid($quizid);
					$number = 1;
					$amount = $this->input->post('id') - 1;
					$tagnumber = 1;
					$tagamount = $this->input->post('tagamount') - 1;
					$change = '';
					while ($number <= $amount) {
						$answernumber = 'A';
						$answeramount = chr(ord($this->input->post('id'.$number)) - 1);
						$answerid = '';
						$questionid = $this->input->post('qid'.$number);
						while ($answernumber <= $answeramount) {
							if ($this->quiz_model->if_answer_changed($this->input->post($answernumber.$number), $this->input->post('aid'.$number.$answernumber)) == TRUE) $change = TRUE;
								$answerid .= $this->quiz_model->update_answers($questionid, $this->input->post($answernumber.$number), $this->input->post('aid'.$number.$answernumber), $answernumber, $this->input->post('answer'.$number));
							$answernumber++;
						}
						if ($this->quiz_model->if_question_changed($questionid, $answerid, $this->input->post('question'.$number)) == TRUE) $change = TRUE;
						$this->quiz_model->update_questions($questionid, $answerid, $this->input->post('question'.$number));
						$number++;
					}
					$this->quiz_model->delete_tags($quizid);
					while ($tagnumber <= $tagamount) {
						$questionid = $this->quiz_model->insert_tags($quizid, $this->input->post('tag'.$tagnumber), $this->input->post('tagid'.$tagnumber));
						$tagnumber++;
					}
					$this->quiz_model->edit_form_submit($quizid, $this->input->post('title'), $change);
					$badge = $this->badge_model->check($username, 'edit');
					$this->session->set_flashdata('badge', $badge);
					$this->session->set_flashdata('message', array('Awesome! Your edit had been saved!'));
				}
				elseif ($status == 'untake') {
					$main = '';
					$correct = 0;
					$number = 1;
					$amount = $this->input->post('amount');
					while ($number <= $amount) {
						$answernumber = 'answer'.$number;
						$idnumber = 'id'.$number;
						$$answernumber = $this->input->post($number);
						$$idnumber = $this->input->post($number.'id');
						$answer = $$answernumber;
						$id = $$idnumber;
						$result = $this->quiz_model->submit_individual_question($answer, $id, $number, $amount, $username);
						if ($result == TRUE) $correct++;
						$number++;
					}
					$this->quiz_model->submit_score($quizid, $username, $correct, $amount);
					$this->load->model('twitter_model');
					$this->twitter_model->auto_share($username, $quizid);
					$badge = $this->badge_model->check($username, 'take');
					$this->session->set_flashdata('badge', $badge);
					$this->session->set_flashdata('message', array('Awesome! You just earned '.$correct.' points!'));
					$this->session->set_flashdata('took', 'yes');
				}
				redirect('/'.$quizid);
			}
			if ($status == 'edit') {
				if (get_fullname($username) !== get_creator($quizid)) redirect('/'.$quizid);
				$return['content_type'] = 'create';
				$return['body_title'] .= ' - Edit';
			}
			$return['tag'] = $this->quiz_model->get_tag($quizid);
			if ($status == 'take' || $status == 'create' || $status == 'untake' || $status == 'edit' || $status == 'took') $return['main'] = $this->quiz_model->get_questions($quizid);
			elseif ($status == 'grade') $return['main'] = $this->quiz_model->get_quiz_grade($quizid, $username);
			else redirect('/'.$quizid);
			$return['onehundred'] = $this->quiz_model->get_onehundred($quizid);
			$return['status'] = $status;
			$this->global_function->load_view($return);
		}
		else {
			$this->global_function->load_view($return, TRUE, 404);
		}
		
	}

}

?>