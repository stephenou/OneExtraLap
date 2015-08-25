<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2009, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter Stephen Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/helpers/stephen_helper.html
 * Sucks.
 */

// ------------------------------------------------------------------------

if (!function_exists('get_limit')) {
	function get_limit() {
	
		return 10;
		
	}
}

if (!function_exists('stupid')) {
	function stupid() {
	
		die('Please Try Again.');
	
	}
}

if (!function_exists('prevent_stupid')) {
	function prevent_stupid($id = FALSE) {
	
		$CI =& get_instance();
		if ($CI->input->post('title') == '' || $CI->input->post('id') == '') stupid();
		$number = 1;
		$amount = $CI->input->post('id') - 1;
		if ($amount > 9 || $amount < 3) stupid();
		if ($id != FALSE) {
			$query = $CI->db->query("SELECT id FROM question WHERE quiz_id='$id'");
			foreach ($query->result() as $row) {
				if ($row->id != $CI->input->post('qid'.$number)) stupid();
				if (trim($CI->input->post('id'.$number)) == '' || trim($CI->input->post('question'.$number)) == '') stupid();
				$answernumber = 'A';
				$answeramount = chr(ord($CI->input->post('id'.$number)) - 1);
				if ($answeramount > 9 || $amount < 2) stupid();
				$query1 = $CI->db->query("SELECT id FROM answer WHERE question_id='".$row->id."'");
				foreach ($query1->result() as $row1) {
					if ($row1->id != $CI->input->post('aid'.$number.$answernumber)) stupid();
					if (trim($CI->input->post($answernumber.$number)) == '' || trim($CI->input->post('answer'.$number)) == '') stupid();
					$answernumber++;
				}
				$number++;
			}
		}
		else {
			while ($number <= $amount) {
				if (trim($CI->input->post('id'.$number)) == '' || trim($CI->input->post('question'.$number)) == '') stupid();
				$answernumber = 'A';
				$answeramount = chr(ord($CI->input->post('id'.$number)) - 1);
				if ($answeramount > 9 || $amount < 2) stupid();
				while ($answernumber <= $answeramount) {
					if (trim($CI->input->post($answernumber.$number)) == '' || trim($CI->input->post('answer'.$number)) == '') stupid();
					$answernumber++;
				}
				$number++;
			}
			$tagnumber = 1;
			$tagamount = $CI->input->post('tagamount') - 1;
			if ($CI->input->post('tagamount') == '') stupid();
			while ($tagnumber <= $tagamount) {
				if (trim($CI->input->post('tag'.$tagnumber)) == '') stupid();
				$tagnumber++;
			}
		}
			
	}	
}

if (!function_exists('prevent_more_stupid')) {
	function prevent_more_stupid($page) {
	
		$CI =& get_instance();
		if ($page == 'profile') {
			if (!isset($_POST['fullname']) || !isset($_POST['bio']) || !isset($_POST['website']) || !isset($_POST['avatar'])) stupid();
		}
		if ($page == 'account') {
			if (!isset($_POST['email']) || !isset($_POST['oldpassword']) || !isset($_POST['newpassword'])) stupid();
		}
		if ($page == 'login') {
			if (!isset($_POST['username']) || !isset($_POST['password'])) stupid();
		}
		if ($page == 'signup') {
			if (!isset($_POST['username']) || !isset($_POST['email']) || !isset($_POST['password'])) stupid();
		}
		if ($page == 'reset_without_code') {
			if (!isset($_POST['email'])) stupid();
		}
		if ($page == 'reset_with_code') {
			if (!isset($_POST['password'])) stupid();
		}
			
	}	
}

if (!function_exists('get_total_user')) {
	function get_total_user() {
		
		$CI =& get_instance();
		return $CI->db->query("SELECT COUNT(id) AS total FROM user")->row()->total;
	
	}
}

if (!function_exists('get_total_quiz')) {
	function get_total_quiz() {
		
		$CI =& get_instance();
		return $CI->db->query("SELECT COUNT(id) AS total FROM quiz")->row()->total;
	
	}
}

if (!function_exists('make_it_safe')) {
	function make_it_safe($term) {
		
		return htmlspecialchars(trim($term));
	
	}
}

if (!function_exists('get_username')) {
	function get_username() {
	
		$CI =& get_instance();
		$username = $CI->session->userdata($CI->config->item('session_cookie_name'));
		if ($username == '') $username = get_cookie($CI->config->item('session_cookie_name'));
		return $username;
	
	}
}

if (!function_exists('convert_timespan')) {
	function convert_timespan($original = '') {
	
		if ($original == '') return '';
		$chunks = array(array(60 * 60 * 24 * 365 , 'year'), array(60 * 60 * 24 * 30 , 'month'), array(60 * 60 * 24 * 7, 'week'), array(60 * 60 * 24 , 'day'), array(60 * 60 , 'hour'), array(60 , 'minute'));
    		$since = time() - $original;
    		for ($i = 0, $j = count($chunks); $i < $j; $i++) {
       		 	$seconds = $chunks[$i][0];
        			$name = $chunks[$i][1];
        			if (($count = floor($since / $seconds)) != 0) break;
    		}
    		$print = ($count == 1) ? '1 '.$name : "$count {$name}s";
    		return $print.' ago';
    	
	}
}

if (!function_exists('get_trending_terms')) {
	function get_trending_terms() {
	
		$CI = &get_instance();
		if ($CI->config->item('enable_hot_topics') == FALSE) return '';
		$query = $CI->db->query("SELECT content FROM preset WHERE type='trending' ORDER BY rand() LIMIT 3");
		$return = 'Hot topics: ';
		$a = 1;
		foreach ($query->result() as $row) {
			if ($a != 1) $return .= ' / ';
			$return .= '<a href="#" onclick="addterm(\''.$row->content.'\'); return false">'.$row->content.'</a>';
			$a++;
		}
		return $return;
	
	}
}

if (!function_exists('manipulate_database')) {
	function manipulate_database($type, $table, $data = NULL, $check = NULL) {
	
		$CI = &get_instance();
		if ($CI->config->item('enable_db_write') == TRUE) {
			if ($type == 'insert') $CI->db->insert($table, $data);
			elseif ($type == 'update') $CI->db->update($table, $data, $check);
			elseif ($type == 'delete') $CI->db->delete($table, $check);
		}
	
	}
}

if (!function_exists('get_avatar')) {
	function get_avatar($userid = '', $size = 'big', $link = TRUE, $type = FALSE, $title = FALSE) {
		
		$CI = &get_instance();
		$query = $CI->db->query("SELECT avatar, email, username FROM user WHERE username='$userid' LIMIT 1");
		$row = $query->row();
		$url = $row->avatar;
		if ($url == '') $url = $CI->config->item('gravatar_url');
		$first3 = substr($url, 7, 3);
		if ($first3 == 'img') {
			if ($type == TRUE) return 'twavatar';
			if ($CI->config->item('enable_twavatar') == FALSE) $url = '/extras/unavailable_twavatar.png';
			/*
if ($size == 'small') $url .= '_m';
			else $url .= '_b';
*/
			$url = str_replace('http://img.tweetimag.es/i/', 'https://api.twitter.com/1/users/profile_image/', $url);
		} 
		else {
			if ($type == TRUE) return 'gravatar';
			if ($CI->config->item('enable_gravatar') == FALSE) $url = '/extras/unavailable_gravatar.png';
			if ($row->avatar == $CI->config->item('gravatar_url')) $url = $CI->config->item('gravatar_url').md5($row->email);
			if ($size == 'small') $url .= '?s=24';
			else $url .= '?s=48';
		}
		$url = '<img src="'.$url.'';
		$url .= '" class="profile_image_'.$size.'"';
		if ($title == TRUE) $url .= ' title="'.get_fullname($row->username, FALSE).'"';
		$url .= ' />';
		if ($link == TRUE) $url = '<a href="/'.$userid.'">'.$url.'</a>';
		return $url;
	
	}
}

if (!function_exists('get_follow')) {
	function get_follow($userid = '', $follower) {
		
		$CI = &get_instance();
		if ($CI->config->item('enable_follow') == FALSE) return '';
		$query = $CI->db->query("SELECT COUNT(id) AS total FROM follow WHERE following_user_id='$userid' AND follower_user_id='$follower' AND deleted_time=''");
		$uri = uri_string();
		$uri1 = ltrim($uri, '/');
		$count = stripos($uri1, "/");
		$uri = substr($uri, 1, $count);
		if ($uri == '') $uri = $uri1;
		if ($userid == $follower) return '';
		$return = '<button id="follow_'.$follower.'"';
		if (get_username() == '') $return .= ' title="Please log in or sign up first." class="follow disabled"';
		else $return .= ' class="follow" onclick="follow(\''.$userid.'\', \''.$follower.'\', \''.$uri.'\');return false"';
		$return .= '>';
		$return .= ($query->row()->total == 1) ? '- Unfollow' : '+ Follow';
		$return .= '</button>';
		return $return;
	
	}
}

if (!function_exists('get_score')) {
	function get_score($userid = '', $yesterday = FALSE) {
	
		$time_limit = ($yesterday == TRUE) ? ' AND time>='.mktime() - 86400 : '';
		$score = &get_instance()->db->query("SELECT username, IFNULL((SELECT SUM(score.point) FROM score WHERE user_id='$userid'$time_limit), 0) + IFNULL((SELECT SUM(badges.point) FROM badges WHERE user_id='$userid'$time_limit), 0) AS total FROM user WHERE username='$userid' LIMIT 1")->row();
		return $score->total;
		
	}
}

if (!function_exists('get_percentage')) {
	function get_percentage($correct, $amount, $sign = TRUE) {
		
		if ($correct > $amount) return $amount.'questions';
		else {
			$percent = ($amount == 0) ? 0 : round($correct / $amount * 100);
			if ($sign == TRUE) $percent .= '%';
			return $percent;
		}
	
	}
}

if (!function_exists('get_letter_grade')) {
	function get_letter_grade($percent) {
		
		if ($percent == 100) return 'A<sup class="aplus">+</sup>';
		if ($percent >= 90) return 'A';
		if ($percent >= 80) return 'B';
		if ($percent >= 70) return 'C';
		if ($percent >= 60) return 'D';
		if ($percent < 60) return 'F';
	
	}
}

if (!function_exists('check_user_status')) {
	function check_user_status($quizid, $username) {
	
		$query = &get_instance()->db->query("SELECT COUNT(id) AS total, type FROM score WHERE quiz_id='$quizid' AND user_id='$username' LIMIT 1");
		return ($query->row()->total == 1) ? $query->row()->type : '';
		
	}
}

if (!function_exists('preview_question')) {
	function preview_question($quizid) {
		
		$CI =& get_instance();
		return $CI->db->query("SELECT question FROM question WHERE quiz_id='$quizid'");
	
	}
}

if (!function_exists('get_plural')) {
	function get_plural($number, $plural = 's') {
		
		return ($number != 1) ? $plural : '';
	
	}
}

if (!function_exists('add_suffix')) {
	function add_suffix($number) {
		
		$last = substr($number, -1);
		if ($last != 1 && $last != 2 && $last != 3 && $number != 11 && $number != 12 && $number != 13) return $number.'th';
		elseif ($last == 1) return $number.'st';
		elseif ($last == 2) return $number.'nd';
		elseif ($last == 3) return $number.'rd';
	
	}
}

if (!function_exists('shorten_down')) {
	function shorten_down($text) {
		
		$CI = &get_instance();
		$CI->load->helper('text');
		return rtrim(character_limiter($text, 45), '?').'?';
	
	}
}

if (!function_exists('remember_the_options')) {
	function remember_the_options() {
		
		$CI = &get_instance();
		$quizid = str_replace('/signup/', '', uri_string());
		$amount = $CI->db->query("SELECT COUNT(id) AS total FROM question WHERE quiz_id='$quizid'")->row()->total;
		$number = 1;
		while ($number <= $amount) {
			$CI->session->set_flashdata('question'.$number, $CI->input->post($number));
			$number++;
		}
	
	}
}

if (!function_exists('get_pagination')) {
	function get_pagination($text, $page, $difference = 1) {
	
		$limit = get_limit();
		$text = (substr($text, 0, 15) == 'SELECT DISTINCT') ? $text = substr_replace($text, 'SELECT COUNT(DISTINCT id) AS total_count, ', 0, 15) : substr_replace($text, 'SELECT COUNT(id) AS total_count, ', 0, 6);
		$total = &get_instance()->db->query(str_replace(' GROUP BY tag', '', $text))->row()->total_count;
		$pageadd = $page + 1;
		$pageminus = $page - 1;
		$position = str_replace('/page/'.$page, '', uri_string());
		$position_slash = (empty($position)) ? '/' : $position;
		if ($total <= $limit) return FALSE;
		elseif ($page == 1) return '<a href="'.$position.'/page/'.$pageadd.'" class="right">Next</a>';
		elseif ($page == 2 && $total <= $limit * 2) return '<a href="'.$position_slash.'" class="left">Previous</a>';
		elseif ($page == 2) return '<a href="'.$position_slash.'" class="left">Previous</a><a href="'.$position.'/page/'.$pageadd.'" class="right">Next</a>';
		elseif ($total - $limit * $pageminus <= $limit) return '<a href="'.$position.'/page/'.$pageminus.'" class="left">Previous</a>';
		else return '<a href="'.$position.'/page/'.$pageminus.'" class="left">Previous</a><a href="'.$position.'/page/'.$pageadd.'" class="right">Next</a>';
	
	}
}
	
if (!function_exists('get_offset')) {
	function get_offset($page = 1) {
	
		$offset = ($page - 1) * get_limit();
		if ($offset < 0) $offset = 0;
		return $offset;
		
	}
}

if (!function_exists('build_query')) {
	function build_query($query, $page, $order = 'id DESC') {
	
		$CI =& get_instance();
		return $CI->db->query($query.' ORDER BY '.$order.' LIMIT '.get_offset($page).', '.get_limit());
	
	}
}

if (!function_exists('get_individual_score')) {
	function get_individual_score($userid, $quizid) {
		
		$query = &get_instance()->db->query("SELECT point FROM score WHERE user_id='$userid' AND quiz_id='$quizid' LIMIT 1");
		$row = $query->row();
		return $row->point;
	
	}
}

if (!function_exists('get_rank')) {
	function get_rank($userid, $quizid) {
		
		$point = get_individual_score($userid, $quizid);
		$query = &get_instance()->db->query("SELECT COUNT(id) AS total FROM score WHERE point>'$point' AND quiz_id= '$quizid' AND type='take'");
		return $query->row()->total + 1;
	
	}
}

if (!function_exists('check_right_answer')) {
	function check_right_answer($id, $questionid) {
		
		$query = &get_instance()->db->query("SELECT answer_id FROM question WHERE id='$questionid'");
		$row = $query->row();
		return ($id == $row->answer_id) ? TRUE : FALSE;
	
	}
}

if (!function_exists('get_someone_answer')) {
	function get_someone_answer($userid, $questionid) {
	
		$query = &get_instance()->db->query("SELECT answer_id FROM activity WHERE user_id='$userid' AND question_id='$questionid' LIMIT 1");
		return $query->row()->answer_id;
	
	}
}

if (!function_exists('get_answer')) {
	function get_answer($answerid) {
	
		$query = &get_instance()->db->query("SELECT answer FROM answer WHERE id='$answerid' LIMIT 1");
		return $query->row()->answer;
	
	}
}

if (!function_exists('get_right_answer')) {
	function get_right_answer($questionid) {
	
		$query = &get_instance()->db->query("SELECT answer_id FROM question WHERE id='$questionid' LIMIT 1");
		$row = $query->row();
		$query = &get_instance()->db->query("SELECT answer FROM answer WHERE id='$row->answer_id' LIMIT 1");
		$row = $query->row();
		return $row->answer;
	
	}
}

if (!function_exists('get_quiz_from_question')) {
	function get_quiz_from_question($questionid) {
	
		$query = &get_instance()->db->query("SELECT quiz_id FROM question WHERE id='$questionid' LIMIT 1");
		$row = $query->row();
		return $row->quiz_id;
	
	}
}

if (!function_exists('get_firstname')) {
	function get_firstname($fullname = '') {
	
		if (strlen($fullname) > 10) $fullname = substr($fullname, 0, 8).'...';
		return (strpos($fullname, ' ') == FALSE) ? $fullname : substr($fullname, 0, stripos($fullname, " "));
		
	}
}

if (!function_exists('get_fullname')) {
	function get_fullname($userid = '', $link = TRUE, $change = TRUE) {
	
		$query = &get_instance()->db->query("SELECT COUNT(id) AS total, fullname FROM user WHERE username='$userid' LIMIT 1");
		$row = $query->row();
		if ($row->total == 0) return '';
		else {
			$fullname = (trim($row->fullname) == '' && $change == TRUE) ? $userid : trim($row->fullname);
			return ($link == FALSE) ? $fullname : '<a href="/'.$userid.'">'.$fullname.'</a>';
		}
		
	}
}

if (!function_exists('get_title')) {
	function get_title($quizid = '', $link = TRUE) {

		$query = &get_instance()->db->query("SELECT COUNT(id) AS total, title FROM quiz WHERE id='$quizid' LIMIT 1");
		$row = $query->row();
		if ($row->total == 0) return '';
		else return ($link == FALSE) ? $row->title : '<a href="/'.$quizid.'">'.$row->title.'</a>';

	}
}

if (!function_exists('get_quiz_link')) {
	function get_quiz_link($quizid = '', $link = FALSE) {

		$url = base_url().$quizid;
		return ($link == FALSE) ? $url : '<a href="'.$url.'">'.$url.'</a>';

	}
}

if (!function_exists('get_badge')) {
	function get_badge($id, $class = 0) {

		if ($class == 0) {
			$CI =& get_instance();
			$query = $CI->db->query("SELECT * FROM badge WHERE id='$id' LIMIT 1");
			$row = $query->row();
			$return['name'] = $row->name;
			$return['explanation'] = $row->explanation;
			$return['point'] = $row->point;
			$return['people'] = $CI->db->query("SELECT COUNT(id) AS total FROM badges WHERE badge_id='$id'")->row()->total;
			$class = $row->id;
		}
		$return['class'] = $class % 9;
		return $return;

	}
}
	
if (!function_exists('get_email')) {	
	function get_email($userid = '', $link = FALSE) {

		$query = &get_instance()->db->query("SELECT COUNT(id) AS total, email FROM user WHERE username='$userid' LIMIT 1");
		$row = $query->row();
		if ($row->total == 0) return '';
		else return ($link == TRUE) ? '<a href="mailto:'.$row->email.'">'.$row->email.'</a>' : $row->email;

	}
}

if (!function_exists('get_website')) {
	function get_website($userid = '', $link = TRUE) {

		$query = &get_instance()->db->query("SELECT COUNT(id) AS total, website FROM user WHERE username='$userid' LIMIT 1");
		$row = $query->row();
		if ($row->total == 0 || $row->website == '') return '';
		else {
			if ($link == TRUE) {
				$url = (strlen($row->website) > 22) ? substr($row->website, 0, 22).'...' : $row->website;
				return '<a target="_blank" href="'.$row->website.'">'.$url.'</a>';
			}
			return $row->website;
		}

	}
}

if (!function_exists('get_twitter')) { 
	function get_twitter($userid = '', $link = TRUE, $sign = TRUE) {

		$query = &get_instance()->db->query("SELECT COUNT(id) AS total, twitter FROM user WHERE username='$userid' LIMIT 1");
		$row = $query->row();
		if ($row->total == 0 || $row->twitter == '') return '';
		else {
			$twitter = $row->twitter;
			if ($link == TRUE) $twitter = '<a target="_blank" href="http://twitter.com/'.$twitter.'">'.$twitter.'</a>';
			if ($sign == TRUE) $twitter = '@'.$twitter;
			return $twitter;
		}

	}
}

if (!function_exists('get_twitter_credential')) { 
	function get_twitter_credential($userid = '') {

		$row = &get_instance()->db->query("SELECT twitter, twitter_id, access_token, access_token_secret FROM user WHERE username='$userid' LIMIT 1")->row();
		$return['id'] = $row->twitter_id;
		$return['screen_name'] = $row->twitter;
		$return['access_token'] = $row->access_token;
		$return['access_token_secret'] = $row->access_token_secret;
		if ($row->access_token != '' && $row->access_token_secret != '') $return['status'] = 2;
		elseif ($row->access_token == '' && $row->access_token_secret == '') $return['status'] = 1;
		else $return['status'] = 0;
		return $return;

	}
}

if (!function_exists('get_bio')) {	
	function get_bio($userid = '', $text = TRUE, $span = TRUE) {
	
		$query = &get_instance()->db->query("SELECT COUNT(id) AS total, bio FROM user WHERE username='$userid' LIMIT 1");
		$row = $query->row();
		if ($row->total == 0 || trim($row->bio) == '') return '';
		else {
			$bio = $row->bio;
			if ($text == TRUE) $bio = 'Bio: '.$row->bio;
			if ($span == TRUE) $bio = '<span class="bio">Bio: '.$row->bio.'</span>';
			return $bio;
		}  
				
	}
}

if (!function_exists('get_checkbox_setting')) {
	function get_checkbox_setting($userid, $field, $return = FALSE) {
	
		$row = &get_instance()->db->query("SELECT $field FROM user WHERE username='$userid' LIMIT 1")->row();
		if ($return == TRUE) return ($row->$field == 1) ? ' checked' : '';
		else echo ($row->$field == 1) ? ' checked' : '';
	
	}
}

if (!function_exists('get_creator')) {
	function get_creator($quizid) {
	
		$query = &get_instance()->db->query("SELECT user_id FROM quiz WHERE id='$quizid' LIMIT 1");
		$row = $query->row();
		return get_fullname($row->user_id);
	
	}
}
	
if (!function_exists('get_average_grade')) {	
	function get_average_grade($quizid) {
	
		$row = &get_instance()->db->query("SELECT AVG(point) AS point, amount FROM score WHERE quiz_id='$quizid' AND type='take'")->row();
		return get_percentage($row->point, $row->amount); 
	
	}
}

if (!function_exists('get_amount_count')) {	
	function get_amount_count($quizid) {
	
		$query = &get_instance()->db->query("SELECT COUNT(id) AS total FROM question WHERE quiz_id='$quizid'");
		return $query->row()->total;
	
	}
}

if (!function_exists('get_people_count')) {	
	function get_people_count($quizid) {
	
		$query = &get_instance()->db->query("SELECT COUNT(id) AS total FROM score WHERE quiz_id='$quizid' AND type='take'");
		return $query->row()->total;
	
	}
}

if (!function_exists('get_created_time')) {	
	function get_created_time($quizid) {
	
		$query = &get_instance()->db->query("SELECT time FROM quiz WHERE id='$quizid' LIMIT 1");
		$row = $query->row();
		return convert_timespan($row->time);
	
	}
}

if (!function_exists('handle_setting')) {		
	function handle_setting($text) {
	
		return strtolower(str_replace(" ", "", $text));
		
	}
}

if (!function_exists('hyperlink')) {		
	function hyperlink($text) {
	
		$text = preg_replace("/((http)+(s)?:\/\/[^<>\s]+)/i", "<a href=\"\\0\" target=\"blank\">\\0</a>", $text);
		$text = preg_replace("`([-_a-z0-9]+(\.[-_a-z0-9]+)*@[-a-z0-9]+(\.[-a-z0-9]+)*\.[a-z]{2,6})`i","<a href=\"mailto:\\1\">\\1</a>", $text);
		$text = preg_replace("/[@]+([A-Za-z0-9]+)+[ ]/", "@<a href=\"/\\1\">\\1</a> ", $text);
		return $text;
		
	}
}

if (!function_exists('add_color')) {		
	function add_color($text, $type) {
	
		if ($type == 0) return '<span style="color: #999999">'.$text.'</span>';
		if ($type == 1) return '<span style="color: #990000">'.$text.'</span>';
		if ($type == 2) return '<span style="color: #009900">'.$text.'</span>';
		
	}
}
	
if (!function_exists('get_challenger')) {
	function get_challenger($quizid, $userid = '') {
	
		$CI = &get_instance();
		$username = get_username();
		return $CI->db->query("SELECT user_id, point FROM score JOIN (SELECT follower_user_id FROM follow WHERE following_user_id='$userid' AND deleted_time='') AS hellyeah ON user_id=follower_user_id WHERE quiz_id='$quizid' AND type='take'");
		
	}
}

if (!function_exists('get_twitterid')) {
	function get_twitterid($userid = '') {
	
		$CI =& get_instance();
		$CI->load->library('twitter');
		if ($userid == '') {
			return '';
		}
		else {
			$call = &get_instance()->twitter->call('users/show', array('screen_name' => $userid));
			return $call->id;
		}
	
	}
}

/* End of file stephen_helper.php */
/* Location: ./system/helpers/stephen_helper.php */