<?php

class Search extends Controller {

	function Search() {
	
		parent::Controller();
		$this->load->model('search_model');
		
	}

	function index($type, $term, $page) {
		
		$return = $this->global_function->initialize('search');
		$username = $return['username'];
		$return['term'] = $term;
		if ($this->config->item('enable_search') == FALSE) $this->global_function->load_view($return, TRUE, 503);
		else {
			if ($type == 'quizzes') {
				if (empty($term)) redirect('/quizzes');
				$return['main'] = $this->search_model->get_quiz_result($term, $page);
				$return['body_title'] = 'Quiz Search';
				$return['content_type'] = 'find';
			}
			elseif ($type == 'people') {
				if (empty($term)) redirect('/people');
				$return['main'] = $this->search_model->get_people_result($term, $page);
				$return['body_title'] = 'People Search';
				$return['content_type'] = 'people';
				$return['placeholder'] = 'People';
			}
			elseif ($type == 'tags') redirect(str_replace('/search/', '', uri_string()));
			else redirect('/search/quizzes/'.$type);
			if ($term != '') $return['body_title'] .= ': '.$term;
			$this->global_function->load_view($return);
		}
		
	}
	
	function people($type, $page) {
	
		$return = $this->global_function->initialize('people');
		$return['placeholder'] = 'People';
		$username = $return['username'];
		if ($this->config->item('enable_twitter') == FALSE && $type == 'twitter') $this->global_function->load_view($return, TRUE, 503);
		elseif ($username == '' && $type == 'twitter') $this->global_function->load_view($return, TRUE, 404);
		else {
			if ($type == 'twitter') {
				$this->load->model('twitter_model');
				$return['main'] = $this->twitter_model->get_twitter_people($username);
				$return['body_title'] = 'Twitter Following';
			}
			elseif ($type == 'new') {
				$return['main'] = $this->search_model->get_new_people($page);
				$return['body_title'] = 'New People';
			}
			elseif ($type == 'leaderboard') {
				$return['main'] = $this->search_model->get_leaderboard($page);
				$return['body_title'] = 'Leaderboard';
				$return['page'] = $page;
			}
			else redirect('/people');
			$this->global_function->load_view($return);
		}
	
	}
	
	function quizzes($type, $page) {
	
		$return = $this->global_function->initialize('find');
		$username = $return['username'];
		if ($type == 'difficult') {
			$return['main'] = $this->search_model->get_difficult_quiz($page);
			$return['body_title'] = 'Difficult Quizzes';
		}
		elseif ($type == 'fresh') {
			$return['main'] = $this->search_model->get_fresh_quiz($page);
			$return['body_title'] = 'Fresh Quizzes';
		}/*
		elseif ($type == 'random') {
			$this->search_model->random($term, $username);
		}*/
		elseif ($type == 'popular') {
			$return['main'] = $this->search_model->get_popular_quiz($page);
			$return['body_title'] = 'Popular Quizzes';
		}
		else redirect('/quizzes');
		$this->global_function->load_view($return);
	
	}
	
	function tags($tag, $page) {
	
		$return = $this->global_function->initialize('tags');
		$username = $return['username'];
		$return['placeholder'] = 'Tags';
		if ($this->config->item('enable_tag') == FALSE) $this->global_function->load_view($return, TRUE, 503);
		elseif ($tag == '') {
			$return['main'] = $this->search_model->get_tags($page);
			$return['yourtags'] = $this->search_model->get_your_tags($username);
			$return['body_title'] = 'Tags';
			$this->global_function->load_view($return);
		}
		else {
			$return['main'] = $this->search_model->get_tag($tag, $page);
			$return['body_title'] = 'Tag Search: '.$tag;
			$return['content_type'] = 'find';
			$return['sidebar_type'] = 'search';
			$return['term'] = $tag;
			$this->global_function->load_view($return);
		}
		
	}
	
	function badges($id, $page) {
	
		$return = $this->global_function->initialize('badges');
		$username = $return['username'];
		$return['badge_id'] = $id;
		$return['badges'] = $this->search_model->get_your_badges($username);
		if ($this->config->item('enable_badge') == FALSE) $this->global_function->load_view($return, TRUE, 503);
		elseif ($this->search_model->check_badge_existance($id) == FALSE) $this->global_function->load_view($return, TRUE, 404);
		else {
			$name = get_badge($id);
			$return['main'] = $this->search_model->get_badge($id, $username);
			$return['total'] = $this->search_model->get_badges_total();
			$return['body_title'] = 'Badge: '.$name['name'];
			$return['content_type'] = 'badges';
			$this->global_function->load_view($return);
		}
	
	}

}

?>