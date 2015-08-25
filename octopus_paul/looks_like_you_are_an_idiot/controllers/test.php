<?php

class Test extends Controller {

	function Test() {
	
		parent::Controller();
		
	}

	function index() {
		
		$this->load->model('twitter_model');
		if (get_username() == $this->config->item('default_user')) {
			/*
			$this->load->library('postmark');
			$query = $this->db->query("SELECT username, email FROM user");
			foreach ($query->result() as $row) {
				$this->postmark->clear();
				$this->postmark->from('stephen@oneextralap.com', 'Stephen Ou');
				$this->postmark->to($row->email);
				$this->postmark->subject('Some updates from OneExtraLap HQ');
				$this->postmark->message_html('Hello, there,<br /><br />Sorry to bug you, but I have some great things to tell you. :)<br /><br />First, I released some really cool features earlier this week, including view grades, edit tags, and more. Also our landing page has a featured user list. If you want to be stood out, participate as much as possible! More info: http://oneextralap.tumblr.com/post/965814476<br /><br />Second, I want to give you the privilege to invite friends to the site, your invite link is http://oneextralap.com/refer/'.$row->username.'. There are awards for it too, 3 new users = Promotion Ambassador badge!<br /><br />Lastly, I made a handy survey.io feedback form for your guys, because I want to know your opinions about OneExtraLap and help us grow together! http://survey.io/survey/99b06<br /><br />Stephen,<br />Founder of OneExtraLap<br />http://oneextralap.com');
				$this->postmark->send();
				echo $row->email.' '.$row->code.'<br />';
			}
			$query = $this->db->query("SELECT answer_id FROM activity");
			foreach ($query->result() as $row) {
				$row1 = $this->db->query("SELECT question_id FROM answer WHERE id='$row->answer_id'")->row();
				
				$this->db->update('activity', array('question_id' => $row1->question_id), array('answer_id' => $row->answer_id));
			}
			$query = $this->db->query("SELECT username FROM user");
			foreach ($query->result() as $row) {
				$this->db->update('user', array('notification' => 1), array('username' => $username));
			}
			$query = $this->db->query("SELECT username FROM user WHERE avatar='http://www.gravatar.com/avatar'");
			foreach ($query->result() as $row) {
				$this->db->update('user', array('avatar' => 'http://www.gravatar.com/avatar/'), array('username' => $username));
			}
			$query = $this->db->query("SELECT username FROM user WHERE twitter!=''");
			foreach ($query->result() as $row) {
				$this->db->update('user', array('share_created' => 1, 'share_badge' => 1), array('username' => $username));
			}
$quiz = array('netspencer', 'stephenou', 'danielbru', 'hiten', 'crystalcy', 'imkevinxu', 'zacharycollins', 'markbao', 'powdahound', 'jp', 'andmurphoto', 'jakemates', 'mike3k');
			$a = 0;
			while ($a < count($quiz)) {
				$this->db->insert('preset', array('content' => $quiz[$a], 'type' => 'people'));
				$a++;
			}
		
			
			$query = $this->db->query("SELECT username, twitter, twitter_id FROM user WHERE twitter!='' AND twitter_id=0");
			foreach ($query->result() as $row) {
				$call = $this->twitter->call('users/show', array('screen_name' => $row->twitter));
				$this->db->update('user', array('twitter_id' => $call->id), array('username' => $username));
			}
			
			$query = $this->db->query("SELECT username FROM user");
			foreach ($query->result() as $row) {
				$this->badge_model->check($row->username, 'test');
			}
*/
			/*
			
*/
		}
		else stupid();
		
	}
	
	function email() {
	
		/*$this->load->database();
		$this->load->library('email');
		$query = $this->db->select('email, fullname')->get('user');
		foreach ($query->result() as $row) {
			$count = stripos($row->fullname, " ");
			$firstname = substr($row->fullname, 0, $count);
			$this->email->clear();
			$this->email->from('stephen@oneextralap.com', 'Stephen Ou');
			$this->email->to($row->email);
			$this->email->reply_to('stephen@oneextralap.com', 'Stephen Ou');
			$this->email->subject('Email Test');
			$this->email->message('Testing the email class.');
			$this->email->send();
		}*/
	
	}
	
	function preserved() {
	
		/*echo $_POST;
		$a = '';
		if (isset($a)) echo 'yay';
		echo $_SERVER['REQUEST_URI'];
		echo 5 % 2;
		$field = 'notification';
		$query = $this->db->query("SELECT $field FROM user WHERE username='stephenou' LIMIT 1");
		$row = $query->row();
		echo $row->$field;
		echo substr('http://gravatar.com/avatar', -7, 7);
		$a[1] = FALSE;
		$a[2] = FALSE;
		if ($a[] == FALSE) echo 'hi';
		$a = array('a');
		if (empty($a)) echo 'no';
		echo mktime();
		$text = "Full Name";
		echo strtolower(trim($text));
		$this->load->view('this_is_header');
		$this->load->view('this_is_footer');
		$this->session->unset_userdata('twitter_oauth_tokens');
		$uri = uri_string();
		$uri = ltrim($uri, '/');
		echo $uri;
		$a = "a";
		$b = "b";
		echo chr(ord($b) - 1);*/
	
	}

}

?>