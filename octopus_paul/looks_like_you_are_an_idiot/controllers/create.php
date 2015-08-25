<?php

class Create extends Controller {

	function Create() {
	
		parent::Controller();
		$this->load->model('create_model');
		
	}

	function index($input) {
		
		$return = $this->global_function->initialize('create');
		$username = $return['username'];
		if ($username == '') $this->global_function->load_view($return, TRUE, 401);
		elseif ($this->config->item('enable_create') == FALSE) $this->global_function->load_view($return, TRUE, 503);
		elseif ($this->input->post('Submit')) {
			prevent_stupid();
			$number = 1;
			$amount = $this->input->post('id') - 1;
			$tagnumber = 1;
			$tagamount = $this->input->post('tagamount') - 1;
			$quizid = $this->create_model->insert_quiz($username, $amount, $this->input->post('title'));
			while ($number <= $amount) {
				$answernumber = 'A';
				$answeramount = chr(ord($this->input->post('id'.$number)) - 1);
				$answerid = '';
				$questionid = $this->create_model->insert_questions($quizid, $this->input->post('question'.$number));
				while ($answernumber <= $answeramount) {
					$answerid .= $this->create_model->insert_answers($questionid, $this->input->post($answernumber.$number), $answernumber, $this->input->post('answer'.$number));
					$answernumber++;
				}
				$number++;
				$this->create_model->update_questions($questionid, $answerid);
			}
			while ($tagnumber <= $tagamount) {
				$questionid = $this->create_model->insert_tags($quizid, $this->input->post('tag'.$tagnumber));
				$tagnumber++;
			}
			$this->load->model('twitter_model');
			$this->twitter_model->auto_share($username, $quizid);
			$badge = $this->badge_model->check($username, 'create');
			$this->session->set_flashdata('badge', $badge);
			$this->session->set_flashdata('message', array('Awesome! Feel free to share the quiz with your friends!'));
			redirect('/'.$quizid);
		}
		else {
			$return['quiz_title'] = $input;
			$return['body_title'] = 'Create A New Quiz';
			$this->global_function->load_view($return);
		}
		
	}

}

?>