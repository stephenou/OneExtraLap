<?php

class Admin extends Controller {

	function Admin() {
	
		parent::Controller();
		
	}

	function index() {
		
		$this->load->model('admin_model');
		$return = $this->global_function->initialize('admin');
		$username = $return['username'];
		$cang = $this->session->userdata('cang');
		$changsha = $this->session->userdata('changsha');
		
		if ($username == $this->config->item('default_user') || $cang == $this->config->item('default_user')) {
			if ($changsha == 'changsha') {
				if ($this->input->post('view_score')) {
					$return['main'] = $this->admin_model->score();
					$return['type'] = 'score';
				}
				elseif ($this->input->post('view_user')) {
					$return['main'] = $this->admin_model->user();
					$return['type'] = 'user';
				}
				elseif ($this->input->post('view_quiz')) {
					$return['main'] = $this->admin_model->quiz();
					$return['type'] = 'quiz';
				}
				elseif ($this->input->post('view_question')) {
					$return['main'] = $this->admin_model->question();
					$return['type'] = 'question';
				}
				elseif ($this->input->post('view_answer')) {
					$return['main'] = $this->admin_model->answer();
					$return['type'] = 'answer';
				}
				elseif ($this->input->post('view_recent_signup')) {
					$return['main'] = $this->admin_model->recent_signup();
					$return['type'] = 'recent_signup';
				}
				elseif ($this->input->post('view_recent_login')) {
					$return['main'] = $this->admin_model->recent_login();
					$return['type'] = 'recent_login';
				}
				elseif ($this->input->post('view_forget_password')) {
					$return['main'] = $this->admin_model->forget_password();
					$return['type'] = 'forget_password';
				}
				elseif ($this->input->post('view_no_info')) {
					$return['main'] = $this->admin_model->no_info();
					$return['type'] = 'no_info';
				}
				elseif ($this->input->post('view_certain_password')) {
					$return['main'] = $this->admin_model->certain_password();
					$return['type'] = 'certain_password';
				}
				elseif ($this->input->post('view_as')) {
					$return['main'] = $this->admin_model->view_as();
				}
				elseif ($this->input->post('add_preset_term')) {
					$return['main'] = $this->admin_model->preset_term();
				}
				elseif ($this->input->post('add_badge')) {
					$return['main'] = $this->admin_model->badge();
				}
				elseif ($this->input->post('add_badge_user')) {
					$return['main'] = $this->admin_model->badge_user();
				}
				elseif ($this->input->post('add_trending_topic')) {
					$return['main'] = $this->admin_model->trending_topic();
				}
				elseif ($this->input->post('delete_user_all')) {
					$return['main'] = $this->admin_model->delete_user_all();
				}
				elseif ($this->input->post('delete_user_only')) {
					$return['main'] = $this->admin_model->delete_user_only();
				}
				elseif ($this->input->post('delete_quiz')) {
					$return['main'] = $this->admin_model->delete_quiz();
				}
				elseif ($this->input->post('delete_question')) {
					$return['main'] = $this->admin_model->delete_question();
				}
				elseif ($this->input->post('delete_score')) {
					$return['main'] = $this->admin_model->delete_score();
				}
				elseif ($this->input->post('delete_tag')) {
					$return['main'] = $this->admin_model->delete_tag();
				}
				elseif ($this->input->post('delete_badge_user')) {
					$return['main'] = $this->admin_model->delete_badge_user();
				}
				elseif ($this->input->post('delete_badge')) {
					$return['main'] = $this->admin_model->delete_badge();
				}
				elseif ($this->input->post('logout'))  {
					$this->session->unset_userdata('changsha');
					redirect('/');
				}
				else $return['main'] = FALSE;
				$return['authorized'] = TRUE;
			}
			else {
				if ($this->input->post('Submit')) {
					if ($this->input->post('password') == 'chang%sha') $this->session->set_userdata('changsha', 'changsha');
					redirect(uri_string());
				}
				else $return['authorized'] = FALSE;
			}
			$this->load->view('open_source', $return);
		}
		else {
			$this->global_function->load_view($return, TRUE, 404);
		}
				
	}

}

?>