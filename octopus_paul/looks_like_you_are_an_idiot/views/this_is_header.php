<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>OneExtraLap - <?php echo $title; ?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="description" content="Social Quizzing!">
		<meta name="keywords" content="social quizzing, OneExtraLap, One Extra Lap, quiz, quizzes, <?=$fullname?>">
		<link rel="shortcut icon" href="/extras/favicon.gif" />
		<link type="text/css" rel="stylesheet" href="/extras/style.css" />
		<script type="text/javascript" src="/extras/jqueryfull.js"></script>
		<script type="text/javascript" src="/extras/jquerytag.js"></script>
		<script type="text/javascript" src="/extras/main.js"></script>
		<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-11556483-4']);
  _gaq.push(['_setDomainName', '.oneextralap.com']);
  _gaq.push(['_setCustomVar', 1, <?=$username?>, true, 3]);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

		</script>
	</head>
<?php $message = $this->session->flashdata('message'); $badge = $this->session->flashdata('badge'); $count1 = (empty($message)) ? 0 : count($message); $count2 = (empty($badge)) ? 0 : count($badge); $initialize = ($oel == TRUE && $count1 == 0 || $status == 'untake' && $count1 == 0) ? 0 : 1; ?>
	<body class="<?php echo strtolower(str_replace(' ', '_', $this->agent->platform().$this->agent->mobile()).' '.str_replace(' ', '_', $this->agent->browser()).' version'.floor($this->agent->version())); if ($this->agent->is_robot() == FALSE) { echo ' not_a_robot'; } ?>" onload="initialize(<?=$count1 + $count2?>, <?=$initialize?>)">
		<div class="this_is_a_secret_place_that_you_could_get_arrested_if_you_do_anything_stupid invisible">
			<img src="/extras/follow-hover.png" />
			<img src="/extras/bg-favicon.gif" />
<?php if ($username == '') { ?>
			<img src="/extras/learn-more-hover.png" />
<?php } else { ?>
			<input type="hidden" value="<?=$username?>" id="hiddenusername"/>
			<input type="hidden" value="<?=$fullname?>" id="hiddenfullname"/>
<?php } if ($content_type == 'settings') { ?>
			<input type="hidden" value="<?=get_email($username)?>" id="hiddenemail"/>
			<input type="hidden" value="<?=get_twitter($username, FALSE, FALSE)?>" id="hiddentwitter"/>
<?php } if (isset($userid)) { ?>
			<input type="hidden" value="<?=$userid?>" id="hiddenuserid"/>
<?php } if (isset($quizid)) { ?>
			<input type="hidden" value="<?=$quizid?>" id="hiddenquizid"/>
<?php } ?>
		</div>
		<div class="header">
			<div class="inner_header">
				<ul class="left">
					<li class="nav_logo">
						<a href="/">
							<img src="/extras/logo.png" alt="OneExtraLap" />
						</a>
					</li>
				</ul>
				<ul class="right">
					<li class="nav_main left">
<?php if ($session == TRUE && $this->config->item('enable_create') !== FALSE) { ?>
						<a href="/create">Create</a>
<?php } ?>
						<a href="/quizzes/popular">Quizzes</a>
						<a href="/people/leaderboard">People</a>
						<a href="/tags">Tags</a>
					</li>
					<li class="nav_sub">
<?php if ($session == TRUE) { ?>
						Hi, <a href="/<?=$username?>"><?=get_firstname($fullname)?></a> | <a href="/settings/profile">Settings</a> | <a href="/logout<?=$pageid?>">Logout</a>
<?php } else { ?>
						<a href="/">Sign Up</a> | <a href="/login<?=$pageid?>">Log In</a> | <a href="/tour">Take a tour</a>
<?php } ?>
					</li>
<?php if ($this->config->item('enable_search') !== FALSE) { $value = 'Search '.$placeholder; $disabled = ''; } else { $value = 'Unavailable'; $disabled = ' disabled'; } ?>
					<li class="nav_search right">
						<form action="/search" method="post" name="searchform" onsubmit="<?=strtolower($placeholder)?>change()">
							<input type="text" id="search" name="q" value="<?=$value?>" onfocus="formfocus('Search <?=$placeholder?>')" onblur="formblur('Search <?=$placeholder?>')" <?=$disabled?>/>
						</form>
					</li>
					<div class="clear"></div>
				</ul>
				<div class="clear"></div>
			</div>
		</div>
		<div class="content">
			<div class="inner_content">
<?php if (!empty($message) || !empty($badge)) { ?>
				<div class="message_container">
<?php if (!empty($message)) { foreach ($message as $hong) { ?>
					<div class="message"><?=$hong?></div>
<?php } } if (!empty($badge)) { foreach ($badge as $lv) { ?>
					<div class="message"><?=$lv?></div>
<?php } } ?>
				</div>
<?php } ?>