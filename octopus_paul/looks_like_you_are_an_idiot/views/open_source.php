<html>
	<head>
		<title>What's up, boy?</title>
		<script type="text/javascript">
			function confirmSubmit()
			{
				var agree=confirm("Are you sure?");
				if (agree) {
					return true;
				}
				else {
					return false;
				}
			}
		</script>
		<style>
			span {
				font-size: 10pt;
				font-family: Georgia;
				margin: 5px;
			}
			
			div {
				margin: 10px 0px;
				padding: 5px 25px;
				font-family: Georgia;
			}
			
			input[type='text'] {
				border: #CCC 1px solid;
				outline: none;
				padding: 3px;
			}
			
			.left {
				float: left;
				width: 60%;
				border-right: 1px dotted #999;
			}
			
			.right {
				float: right;
				width: 30%;
				line-height: 18pt;
			}
			
			a {
				color: #009900;
				text-decoration: none;
			}
			
			a:hover {
				color: #990000;
			}
			
			a:active {
				position: relative;
				top: 1px;
			}
		</style>
	</head>
	<body>
<?php if ($authorized == TRUE) { ?>
		<div class="right">
			{elapsed_time}<br /><br />
<?php if ($main !== FALSE && $main !== TRUE) { foreach ($main->result() as $row) { if ($type == 'score') { ?>
			ID: <?=$row->id?><br />
			Username: <?=$row->user_id?><br />
			Fullname: <?=get_fullname($row->user_id)?><br />
			Quiz ID: <?=$row->id?><br />
			Quiz Title: <?=get_title($row->id)?><br />
			Correct: <?=$row->point?><br />
			Amount: <?=$row->amount?><br />
<?php } elseif ($type == 'user') { ?>
			ID: <?=$row->id?><br />
			Username: <a target="_blank" href="/<?=$row->username?>"><?=$row->username?></a><br />
			Fullname: <?=$row->fullname?><br />
			Score: <?=get_score($row->username)?><br />
			Email: <a href="mailto:<?=$row->email?>"><?=$row->email?></a><br />
			Bio: <?=$row->bio?><br />
			Website: <a target="_blank" href="<?=$row->website?>"><?=$row->website?></a><br />
			Twitter: <a target="_blank" href="http://twitter.com/<?=$row->twitter?>"><?=$row->twitter?></a><br />
			Signup Time: <?=convert_timespan($row->signup_time)?><br />
			Last Login Time: <?=convert_timespan($row->last_login_time)?><br />
			Access Token: <?=$row->access_token?><br />
			Access Token Secret: <?=$row->access_token_secret?><br />
			Share after took a quiz: <?=$row->share_took?><br />
			Share after got 100% in a quiz: <?=$row->share_onehundred?><br />
			Share after created a quiz: <?=$row->share_created?><br />
			Share after unlocked a badge: <?=$row->share_badge?><br />
			Receive notification email: <?=$row->notification?><br />
			Getting Started guide: <?=$row->hide_setup?><br />
<?php } elseif ($type == 'quiz') { ?>
			ID: <?=$row->id?><br />
			Title: <a target="_blank" href="/<?=$row->id?>"><?=$row->title?></a><br />
			Username: <?=$row->user_id?><br />
			Fullname: <?=get_fullname($row->user_id)?><br />
			Time: <?=convert_timespan($row->time)?><br />
			Last Edited Time: <?=convert_timespan($row->last_edit_time)?><br />
<?php } elseif ($type == 'question') { ?>
			ID: <?=$row->id?><br />
			Quiz ID: <?=$row->quiz_id?><br />
			Title: <?=get_title($row->quiz_id)?><br />
			Question: <?=$row->question?><br />
			Answer ID: <?=$row->answer_id?><br />
			Answer: <?=get_answer($row->answer_id)?><br />
			Correct: <?=$row->correct?><br />
<?php } elseif ($type == 'answer') { ?>
			ID: <?=$row->id?><br />
			Question ID: <?=$row->question_id?><br />
			Quiz Title: <?=get_title(get_quiz_from_question($row->question_id))?><br />
			Answer: <?=$row->answer?><br />
			Correct Answer: <?=get_right_answer($row->question_id)?><br />
<?php } elseif ($type == 'recent_signup') { ?>
			Username: <a target="_blank" href="/<?=$row->username?>"><?=$row->username?></a><br />
			Signup Time: <?=convert_timespan($row->signup_time)?><br />
<?php } elseif ($type == 'recent_login') { ?>
			Username: <a target="_blank" href="/<?=$row->username?>"><?=$row->username?></a><br />
			Last Login Time: <?=convert_timespan($row->last_login_time)?><br />
<?php } elseif ($type == 'forget_password') { ?>
			Username: <a target="_blank" href="/<?=$row->username?>"><?=$row->username?></a><br />
			Code: <?=$row->forget_password?><br />
			Time: <?=convert_timespan($row->forget_password_time)?><br />
<?php } elseif ($type == 'no_info') { ?>
			Username: <a target="_blank" href="/<?=$row->username?>"><?=$row->username?></a><br />
			Password: <?=$row->password?><br />
			Email: <a target="_blank" href="mailto:<?=$row->email?>"><?=$row->email?></a><br />
<?php } elseif ($type == 'certain_password') { ?>
			Username: <a target="_blank" href="/<?=$row->username?>"><?=$row->username?></a><br />
			Password: <?=$row->password?><br />
<?php } ?>
			<br />
<?php } } elseif ($main == FALSE) { ?>
			ERROR...
<?php } elseif ($main == TRUE) { ?>
			SUCCESS...
<?php } ?>
		</div>
		<div class="left">
			<form action="/admin" method="post">
				<input type="submit" name="logout" value="Logout" />
			</form>
			<br />
			<form action="/admin" method="post">
				<span>1. View Score:</span>
				<input type="text" name="userid" value="userid" />
				<input type="text" name="quizid" value="quizid" />
				<input type="submit" name="view_score" value="Submit" />
			</form>
			<form action="/admin" method="post">
				<span>2. View User:</span>
				<input type="text" name="userid" value="userid" />
				<input type="submit" name="view_user" value="Submit" />
			</form>
			<form action="/admin" method="post">
				<span>3. View Quiz:</span>
				<input type="text" name="quizid" value="quizid" />
				<input type="submit" name="view_quiz" value="Submit" />
			</form>
			<form action="/admin" method="post">
				<span>4. View Question:</span>
				<input type="text" name="questionid" value="questionid" />
				<input type="submit" name="view_question" value="Submit" />
			</form>
			<form action="/admin" method="post">
				<span>5. View Answer:</span>
				<input type="text" name="answerid" value="answerid" />
				<input type="submit" name="view_answer" value="Submit" />
			</form>
			<form action="/admin" method="post">
				<span>6. View Recent Signup:</span>
				<input type="text" name="limit" value="limit" />
				<input type="submit" name="view_recent_signup" value="Submit" />
			</form>
			<form action="/admin" method="post">
				<span>7. View Recent Login:</span>
				<input type="text" name="limit" value="limit" />
				<input type="submit" name="view_recent_login" value="Submit" />
			</form>
			<form action="/admin" method="post">
				<span>8. View Forget Password:</span>
				<input type="submit" name="view_forget_password" value="Submit" />
			</form>
			<form action="/admin" method="post">
				<span>9. View No Info User:</span>
				<input type="submit" name="view_no_info" value="Submit" />
			</form>
			<form action="/admin" method="post">
				<span>10. View Users with Certain Password:</span>
				<input type="text" name="password" value="password" />
				<input type="submit" name="view_certain_password" value="Submit" />
			</form>
			<form action="/admin" method="post">
				<span>11: View As</span>
				<input type="text" name="userid" value="userid" />
				<input type="submit" name="view_as" value="Submit" />
			</form>
			<br />
			<form action="/admin" method="post">
				<span>1. Add Preset Term:</span>
				<input type="text" name="term" value="term" />
				<input type="submit" name="add_preset_term" value="Submit" onclick="return confirmSubmit()" />
			</form>
			<form action="/admin" method="post">
				<span>2. Add Badge:</span>
				<input type="text" name="name" value="name" />
				<input type="text" name="explanation" value="explanation" />
				<input type="text" name="point" value="point" />
				<input type="submit" name="add_badge" value="Submit" onclick="return confirmSubmit()" />
			</form>
			<form action="/admin" method="post">
				<span>3. Add Badge to a user:</span>
				<input type="text" name="userid" value="userid" />
				<input type="text" name="badgeid" value="badgeid" />
				<input type="submit" name="add_badge_user" value="Submit" onclick="return confirmSubmit()" />
			</form>
			<form action="/admin" method="post">
				<span>4. Add Trending Topic:</span>
				<input type="text" name="topic" value="topic" />
				<input type="text" name="topic_replaced" value="topic replaced" />
				<input type="submit" name="add_trending_topic" value="Submit" onclick="return confirmSubmit()" />
			</form>
			<br />
			<form action="/admin" method="post">
				<span>1. Delete user and user's data:</span>
				<input type="text" name="userid" value="userid" />
				<input type="submit" name="delete_user_all" value="Submit" onclick="return confirmSubmit()" />
			</form>
			<form action="/admin" method="post">
				<span>2. Delete only user's data:</span>
				<input type="text" name="userid" value="userid" />
				<input type="submit" name="delete_user_only" value="Submit" onclick="return confirmSubmit()" />
			</form>
			<form action="/admin" method="post">
				<span>3. Delete quiz:</span>
				<input type="text" name="quizid" value="quizid" />
				<input type="submit" name="delete_quiz" value="Submit" onclick="return confirmSubmit()" />
			</form>
			<form action="/admin" method="post">
				<span>4. Delete question:</span>
				<input type="text" name="questionid" value="questionid" />
				<input type="submit" name="delete_question" value="Submit" onclick="return confirmSubmit()" />
			</form>
			<form action="/admin" method="post">
				<span>5. Delete score:</span>
				<input type="text" name="userid" value="userid" />
				<input type="text" name="quizid" value="quizid" />
				<input type="submit" name="delete_score" value="Submit" onclick="return confirmSubmit()" />
			</form>
			<form action="/admin" method="post">
				<span>6. Delete tag:</span>
				<input type="text" name="tag" value="tag" />
				<input type="submit" name="delete_tag" value="Submit" onclick="return confirmSubmit()" />
			</form>
			<form action="/admin" method="post">
				<span>7. Delete badge for a user:</span>
				<input type="text" name="userid" value="userid" />
				<input type="text" name="badgeid" value="badgeid" />
				<input type="submit" name="delete_badge_user" value="Submit" onclick="return confirmSubmit()" />
			</form>
			<form action="/admin" method="post">
				<span>8. Delete badge:</span>
				<input type="text" name="badgeid" value="badgeid" />
				<input type="submit" name="delete_badge" value="Submit" onclick="return confirmSubmit()" />
			</form>
		</div>
<?php } else { ?>
		<form action="/admin" method="post">
			<input type="password" name="password" />
			<input type="submit" name="Submit" value="Submit" onclick="return confirmSubmit()" />
		</form>
<?php } ?>
	</body>
</html>