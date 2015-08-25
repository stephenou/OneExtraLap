				
<?php if ($content_type == 'create' || $content_type == 'settings' || $status == 'untake') { $form_action = ($status == 'untake' && $session == FALSE) ? '/signup'.uri_string() : uri_string().'" id="'.$content_type.'form'; ?>
				<form method="post" action="<?=$form_action?>" class="right main_content">
<?php } else { ?>
				<div class="right main_content">
<?php } $term = ($content_type == 'home' || $content_type == 'user') ?  'home_user' : $content_type; ?>
					<ul class="main <?=$term?>">
<?php if ($content_type == 'home') { if ($setup[0] == FALSE) { ?>
						<li class="first">
<?php if ($setup[1] == FALSE && $setup[2] == FALSE && $setup[3] == FALSE) { ?>
							<h1 class="center">Welcome to OneExtraLap!</h1>
							<div class="small_prompt">
								-- <a href="/stephenou">Stephen</a>, the founder
							</div>
						</li>
						<li>
<?php } $s = 1; $setup_term = array('', 'Take some awesome quizzes', 'Create your first quiz!', 'Connect to your Twitter'); $setup_link = array('', 'quizzes', 'create', 'connect'); $setup_setting = get_checkbox_setting($username, 'hide_setup', TRUE); $setup_text = 'Show the Getting Started Guide'; $setup_style = 'invisible'; if ($setup_setting == FALSE || $setup[1] == FALSE && $setup[2] == FALSE && $setup[3] == FALSE) { $setup_text = 'Hide'; $setup_style = 'visible'; } ?>
							<div id="setup_guide" class="<?=$setup_style?>">
								<div class="setup_prompt">To get started & unlock your first badge "<a href="/badges/1">No Longer A Newbie</a>", follow the simple 3 steps:</div>
								<ul class="setup_ul">
<?php while ($s < 4) { $setup_status = ($setup[$s] == TRUE) ? 'done' : 'undone'; ?>
									<li class="setup <?=$setup_status?>">
										<a href="/<?=$setup_link[$s]?>"><?=$setup_term[$s]?></a>
<?php if ($s == 1) { ?>
										<div class="preview">
											<div class="left featured">Featured Quizzes:</div>
											<div class="right featured_quiz">
<?php foreach ($setup['quiz']->result() as $row) { ?>
												<h4><?=get_title($row->content)?></h4>
<?php } ?>
											</div>
											<div class="clear"></div>
										</div>
<?php } ?>
									</li>		
<?php $s++; } ?>
								</ul>
							</div>
<?php if ($setup[1] != FALSE || $setup[2] != FALSE || $setup[3] != FALSE) { ?>
							<div class="hide_setup">
								<a href="#" id="hide_setup"><?=$setup_text;?></a>
							</div>
						</li>
<?php } } if ($this->config->item('enable_create') != FALSE && $setup[1] != FALSE || $setup[2] != FALSE || $setup[3] != FALSE) { if ($setup[0] == TRUE) { ?>
						<li class="first">
<?php } else { ?>
						<li>
<?php } ?>
							<form method="post" action="/create" id="createpreform" onsubmit="createchange()">
								<div class="title">What did you learn today? Create a quiz about it!
									<span class="small_prompt"> (You get 2 points for each question you create)</span>
								</div>
								<input type="text" id="quiz_title" class="input" />
								<div class="example"><?=get_trending_terms()?></div>
								<input type="submit" value="Create" name="Create" class="button blue" />
								<div class="clear"></div>
							</form>
<?php } ?>
						</li>
<?php } else { ?>
						<li class="first">
							<h1 class="center"><?=$body_title?></h1>	
						</li>
<?php if ($content_type == 'badges' && $body_title != 'Badges') { $badge_info = get_badge($badge_id); ?>
						<li class="explanation">
							<div class="left">Way to get it:</div>
							<div class="right"><?=$badge_info['explanation']?></div>
							<div class="clear"></div>
							<div class="left">Points awarded:</div>
							<div class="right"><span class="number"><?=$badge_info['point']?></span> points</div>
							<div class="clear"></div>
							<div class="left">People unlocked:</div>
							<div class="right"><span class="number"><?=$badge_info['people']?></span> people</div>
							<div class="clear"></div>
						</li>
<?php $badge_people = $main['query']->num_rows(); if ($badge_people != 0) { ?>
						<li>Your friend<?=get_plural($badge_people)?> who had this badge:</li>
<?php } ?>
<?php } if ($content_type == 'people' && $body_title == 'Twitter Following' && $main['query'] == FALSE) { ?>
						<li class="center">
							<div class="connect_twitter">Simply sign in with Twitter account first!</div>
							<a href="/connect">
								<img src="/extras/sign-in-with-twitter.png" />
							</a>
						</li>
<?php } if ($sidebar_type == 'quiz') { $amount = get_amount_count($quizid); $people = get_people_count($quizid); ?>
						<li class="center quizmeta meta">By <?=get_creator($quizid)?> | 
							<span class="number"><?=$amount?></span> Questions | 
							Average Grade: <span class="number"><?=get_average_grade($quizid)?></span> | 
							<span class="number"><?=$people?></span> People Taken | 
							<span class="number"><?=get_created_time($quizid)?></span>
							<input type="hidden" name="amount" id="amount" value="<?=$amount?>" />
						</li>
<?php if ($status == 'take' || $status == 'took') { $score = get_individual_score($username, $quizid); ?>			
						<li>
							<ul class="score">
								<li>Score: <?=$score?> out of <?=$amount?></li>
								<li class="center">Percentage: <?=get_percentage($score, $amount)?></li>
								<li>Rank: #<?=get_rank($username, $quizid)?> in <?=$people?></li>
								<div class="clear"></div>
							</ul>
						</li>
<?php } } if ($status == 'grade') { foreach ($main['query']->result() as $row) { ?>
						<li>
							<ul class="grade_list">
								<li class="first_column"><?=get_avatar($row->user_id)?></li>
								<li class="second_column"><?=get_fullname($row->user_id)?></li>
								<li class="third_column">
									<div class="bar" style="width: <?=2*get_percentage($row->point, $row->amount, FALSE)?>px"></div>
								</li>
								<li class="fourth_column"><?=get_percentage($row->point, $row->amount)?></li>
							</ul>
							<div class="clear"></div>
						</li>
<?php } } } if ($content_type != 'create' && $content_type != 'settings' && $status != 'grade' && $status != 'edit') { if ($main['query'] != FALSE) { $i = 1; foreach ($main['query']->result() as $row) { ?>
						<li>
<?php if ($content_type == 'quiz' && $status != 'grade' && $status != 'edit') { ?>
							<h2 class="question"><?=$row->question?></h2>
							<div class="stats">Question <?=$i?> Of <?=$amount?></div>
<?php $letter = 'a'; $bigletter = 'A'; foreach ($main[$i]->result() as $row1) { ?>
							<h3 class="choice<?=$letter?>">
								<div class="choiceleft">
<?php if ($status == 'take' || $status == 'create' || $status == 'took') { ?>
									<?=$bigletter?>:
<?php } else { ?>
									<input type="radio" value="<?=$row1->id?>" name="<?=$i?>" id="<?=$i.$bigletter?>" class="radio_button"<?php if ($this->session->flashdata('question'.$i) == $row1->id) echo ' checked'; ?>>
<?php } ?>
								</div>
								<div class="choiceright">
<?php if ($status == 'untake' || $status == 'took') { ?>
									<label for="<?=$i.$bigletter?>"><?=$row1->answer?></label>
<?php } elseif (check_right_answer($row1->id, $row1->question_id) == TRUE) { ?>
									<span class="rightchoice"><?=$row1->answer?> (Right Answer)</span>
<?php } else { ?>
									<span><?=$row1->answer?></span>
<?php } ?>
								</div>
								<div class="clear"></div>
							</h3>
<?php	 $letter++; $bigletter++; } if ($status == 'took') { $his_answer = get_someone_answer($username, $row->id); ?>
							<div class="right_or_wrong">
								<span class="choicec">Your Answer: <?=get_answer($his_answer)?></span>
								<br />
<?php if (check_right_answer($his_answer, $row->id) == TRUE) { ?>
								<span class="choiceb">And it's correct!</span>
<?php } else { ?>
								<span class="choicea">Sorry! It's wrong! The correct answer should be <?=get_right_answer($row->id)?></span>
<?php } ?>
							</div>
<?php } ?>
							<div class="stats"><?=$row->correct?> Out Of <?=$people?> People Got It Right</div>
							<input type="hidden" name="<?=$i?>id" value="<?=$row->id?>">
<?php } if ($content_type == 'tags') { ?>
							<div class="left tag_term">
								<a href="/tags/<?=$row->tag?>"><?=$row->tag?></a>
							</div>
							<div class="right tag_count number"><?=$row->number?></div>
							<div class="clear"></div>
<?php } if ($content_type == 'badges') { $badge = get_badge(FALSE, $row->id); ?>
							<ul class="individual">
								<li class="first_column"><?=get_avatar($row->user_id)?></li>
								<li class="second_column"><?=get_fullname($row->user_id)?></li>
								<li class="third_column timespan">Unlocked <?=convert_timespan($row->time)?></li>
							</ul>
							<div class="clear"></div>
<?php } if ($content_type == 'home' || $content_type == 'user') { ?>
							<div class="left avatar">
								<?=get_avatar($row->user_id)?>
							</div>
							<div class="right update">
								<h2>
									<?=get_fullname($row->user_id)?> 
<?php if ($row->type == 'take') { $percent = get_percentage($row->point, $row->amount, FALSE); ?>
									got <b><?=$percent?>%</b> in 
<?php } else { ?>
									created 
<?php } ?>
									the quiz <?=get_title($row->quiz_id)?>
								</h2>
<?php $more_margin = ' more_margin'; if ($row->type == 'take') { $competition = get_challenger($row->quiz_id, $row->user_id); if ($this->config->item('enable_grade') != FALSE && $row->point == $row->amount) { ?>
								<div class="grade">A+</div>
<?php } if ($this->config->item('enable_competition') != FALSE) { $w = ''; $t = ''; $l = ''; $wn = 1; $tn = 1; $ln = 1; foreach ($competition->result() as $row1) { if ($row->point > $row1->point) { if ($wn <= 12) { $w .= get_avatar($row1->user_id, 'small', TRUE, FALSE, TRUE); } $wn++; } elseif ($row->point == $row1->point) { if ($tn <= 12) { $t .= get_avatar($row1->user_id, 'small', TRUE, FALSE, TRUE); } $tn++; } else { if ($ln <= 12) { $l .= get_avatar($row1->user_id, 'small', TRUE, FALSE, TRUE); } $ln++; } } ?>
<?php if ($w != '' || $t != '' || $l != '') { ?>
								<div class="competition">
<?php if ($w != '') { ?>
									<div class="left">Won against:</div>
									<div class="right">
										<?=$w?>
									</div>
									<div class="clear"></div>
<?php } if ($t != '') { ?>
									<div class="left">Tied with:</div>
									<div class="right">
										<?=$t?>
									</div>
									<div class="clear"></div>
<?php } if ($l != '') { ?>
									<div class="left">Lost against:</div>
									<div class="right">
										<?=$l?>
									</div>
									<div class="clear"></div>
<?php } ?>
								</div>
<?php $more_margin = ''; } } } else { if ($this->config->item('enable_preview') != FALSE) { ?>
								<div class="preview">
									<div class="left">Questions:</div>
									<div class="right">
<?php $q = 1; $preview = preview_question($row->quiz_id); $preview_number = $preview->num_rows() - 5; foreach ($preview->result() as $row1) { if ($q < 6) { ?>
									<h3><?=shorten_down($row1->question)?></h3>
<?php $q++; } } if ($preview_number > 0) { ?>
									<h6>And <?=$preview_number?> more!</h6>
<?php } ?>
									</div>
									<div class="clear"></div>
								</div>
<?php $more_margin = ''; } } ?>
								<div class="timespan <?=$more_margin?>"><?=convert_timespan($row->time)?></div>
							</div>
							<div class="clear"></div>
<?php } if ($content_type == 'people') { ?>
							<ul>
								<li class="first_column">
									<?=get_avatar($row->username)?>
<?php if ($body_title == 'Leaderboard') { ?>
									<div class="rank"><?php $rank = get_limit() * ($page - 1) + $i; echo $rank?></div>
<?php } ?>
								</li>
								<li class="second_column">
									<div class="fullname">
										<?=get_fullname($row->username)?>
									</div>
									<div class="username">@<?=$row->username?></div>
									<div class="bio"><?=get_bio($row->username, FALSE)?></div>
								</li>
								<li class="third_column">
<?php if ($body_title == 'New People') { ?>
									<span class="timespan">Signed up<br /><?=convert_timespan($row->total)?></span>
<?php } elseif ($body_title == 'Twitter Following') { ?>
									@<a href="http://twitter.com/<?=$row->total?>" target="_blank"><?=$row->total?></a>
<?php } elseif ($sidebar_type != 'user') { ?>
									<span class="number"><?=round($row->total)?></span> point<?=get_plural($row->total)?>
<?php } else { $points = get_score($row->username); ?>
									<span class="number"><?=$points?></span> point<?=get_plural($points)?>
<?php } ?>
								</li>
								<li class="fourth_column center">
									<?=get_follow($username, $row->username)?>
<?php if ($body_title == 'Leaderboard' && $username == $row->username) { ?>
									<a href="http://twitter.com/?status=I'm the <?=add_suffix($rank)?> overall in OneExtraLap!">Tweet about your rank.</a>
<?php } ?>
								</li>
							</ul>
							<div class="clear"></div>
<?php } if ($content_type == 'find') { $status = check_user_status($row->id, $username); if ($status == 'create') { ?>
							<div class="indicator purple" title="You created this quiz!"></div>
<?php } elseif ($status == 'take') { ?>
							<div class="indicator red" title="You took this quiz already!"></div>
<?php } else {} ?>
							<h2>
								<?=get_title($row->id)?>
							</h2>
							<div class="meta">Created By <?=get_creator($row->id)?> | 
								<span class="number"><?=get_amount_count($row->id)?></span> Questions | Average Grade: 
								<span class="number"><?=get_average_grade($row->id)?></span> | 
								<span class="number"><?=get_people_count($row->id)?></span> People Took It
							</div>
							<div class="preview">
								<div class="left">Questions:</div>
								<div class="right">
<?php $q = 1; $preview = preview_question($row->id); $preview_number = $preview->num_rows() - 5; foreach ($preview->result() as $row1) { if ($q < 6) { ?>
									<h3><?=shorten_down($row1->question)?></h3>
<?php $q++; } } if ($preview_number > 0) { ?>
									<h6>And <?=$preview_number?> more!</h6>
<?php } ?>
								</div>
								<div class="clear"></div>
							</div>
							<div class="timespan"><?=convert_timespan($row->time)?></div>
						</li>
<?php } $i++; } if ($content_type == 'badges') { ?>
						<li class="pagination">
<?php if ($badge_id != 1) { ?>
							<a href="/badges/<?=$badge_id - 1?>" class="left">Previous</a>
<?php } if ($total != $badge_id) { ?>
							<a href="/badges/<?=$badge_id + 1?>" class="right">Next</a>
<?php } ?>
							<div class="clear"></div>
						</li>
<?php } if ($i == 1) { if ($content_type == 'home' && $setup[0] == FALSE || $content_type == 'badges') {} else { ?>
						<li class="center">Nothing found :(</li>
<?php } } } } if ($content_type == 'settings') { $id = 0; if ($setting_type == 'profile') { $term = array('Full Name', 'Bio', 'Website', 'Avatar'); } elseif ($setting_type == 'account') { $term = array('Email', 'Old Password', 'New Password', 'Notifications'); } else { $twitter_status = get_twitter_credential($username); $term = ($twitter_status['status'] != 2) ? array('') : array('Your Account', 'Auto Sharing'); ?>
<?php } while ($id < count($term)) { ?>
						<li>
							<div class="left">
								<?php echo $term[$id]; if ($setting_type == 'account' && $id != 3) { ?> <sup class="required">*</sup><?php } ?> 
							</div>
<?php if ($id == 3 && $setting_type == 'profile') { ?>
							<div class="right avatar">
								<div class="left" id="avatar">
									<?=get_avatar($username, 'big', FALSE)?>
								</div>
								<div class="right">
									<input type="radio" name="avatar" id="avatarfield_e" value="gravatar"<?php if (get_avatar($username, '', FALSE, TRUE) == 'gravatar') { echo " checked"; } ?>>
									<label for="avatarfield_e">Get Your Gravatar</label>
									<br />
									<input type="radio" name="avatar" id="avatarfield_t" value="twavatar"<?php if (get_avatar($username, '', FALSE, TRUE) == 'twavatar') { echo " checked"; } ?>>
									<label for="avatarfield_t">Get Your Twitter Avatar</label>
								</div>
								<div class="clear"></div>
							</div>
<?php } else { ?>
							<div class="right">
<?php if ($id == 1 && $setting_type == 'profile') { $bio = get_bio($username, FALSE, FALSE); ?>
								<textarea class="input bioinput" rows="5" id="biofield" name="bio"><?=$bio?></textarea>
<?php } elseif ($id == 3 && $setting_type == 'account' || $setting_type == 'twitter') { if ($setting_type == 'twitter') { 
 if ($twitter_status['status'] != 2) { ?>
								<a href="/connect">
									<img src="/extras/sign-in-with-twitter.png" />
								</a>
<?php } else { if ($id == 0) { ?>

								<div class="twitter_username">
							 		@ <a href="http://twitter.com/<?=$twitter_status['screen_name']?>" target="_blank"><?=$twitter_status['screen_name']?></a> <small>(<a href="/disconnect">Disconnect</a>)</small>
								 </div>
<?php } else { $tid = 0; $twitter = array('share_took', 'share_onehundred', 'share_created', 'share_badge'); $word = array('took a quiz', 'got 100% in a quiz', 'created a quiz', 'unlocked a badge'); while ($tid < count($twitter)) { ?>
								<div>
									<input class="checkbox" type="checkbox" name="<?=$twitter[$tid]?>" value="1" id="<?=$twitter[$tid]?>"<?php get_checkbox_setting($username, $twitter[$tid]); ?>/>
									<label for="<?=$twitter[$tid]?>">Send a tweet whenever I <?=$word[$tid]?></label>
								</div>
<?php $tid++; } } } } else { ?>
								<input class="checkbox" type="checkbox" name="<?=handle_setting($term[$id])?>" value="1" id="<?=$term[$id]?>"<?php get_checkbox_setting($username, 'notification'); ?>/>
								<label for="<?=$term[$id]?>">Send me email when there're awesome announcements</label>
<?php } } else { $field_type = (substr($term[$id], -8, 8) == 'Password') ? 'password' : 'text'; if ($id == 3) echo '@'; ?><input class="input<?php if ($id == 3) echo ' twitterinput'; ?>" type="<?=$field_type;?>" id="<?=handle_setting($term[$id])?>field" name="<?=handle_setting($term[$id])?>" 
<?php if ($id == 0 && $setting_type == 'account') echo 'value="'.get_email($username).'"';
elseif ($id == 0 && $setting_type == 'profile') echo 'value="'.get_fullname($username, FALSE, FALSE).'"';
elseif ($id == 2 && $setting_type == 'profile') echo 'value="'.get_website($username, FALSE).'"';
?>
/>
<?php } ?>
							</div>
<?php } ?>
							<div class="clear"></div>
<?php if ($id == 3 && $setting_type == 'profile' || $id == 3 && $setting_type == 'account' || $id == 1 && $setting_type == 'account' || $setting_type == 'twitter') {} else { ?>
							<div class="left tip"></div>
							<div class="right tip" id="<?=handle_setting($term[$id])?>">&nbsp;</div>
							<div class="clear"></div>
<?php } ?>
						</li>
<?php $id++; } } if ($content_type == 'create') { if ($status == 'edit') {$quiz_title = get_title($quizid, FALSE);} ?>
						<li class="center">
							<div class="left title">
								<div class="left">Title:</div>
								<div class="right">
									<input type="text" name="title" id="quiz_title" class="title_input" value="<?=$quiz_title?>" onkeyup="createchangeagain()" />
								</div>
<?php if ($status != 'edit') { ?>
								<div class="example"><?=get_trending_terms()?></div>
<?php $amount = 3; } ?>
								<input type="hidden" id="id" name="id" value="<?=$amount+1?>">
							</div>
							<div class="right center">
								<a class="outside_link" title="Google search your title" id="g_link" href="http://www.google.com/search?q=<?=$quiz_title?>" target="_blank">
									<img src="/extras/favicon-google.png" />
								</a>
								<a class="outside_link" title="Twitter search your title" id="t_link" href="http://twitter.com/#search?q=<?=$quiz_title?>" target="_blank">
									<img src="/extras/favicon-twitter.png" />
								</a>
								<a class="outside_link" title="Look up a Wikipedia article" id="w_link" href="http://en.wikipedia.org/wiki/<?=$quiz_title?>" target="_blank">
									<img src="/extras/favicon-wikipedia.png" />
								</a>
							</div>
							<div class="clear"></div>
						</li>
<?php if ($status == 'edit') { $id = 1; foreach ($main['query']->result() as $row) { ?>
						<li>
							<div class="left">
								<div class="question" id="q<?=$id?>">
									<div id="<?=$id?>question">
										<div class="left">
											<span class="question">Question: </span>
										</div>
										<div class="right">
											<input type="text" name="question<?=$id?>" class="input question answerinput" id="inputquestion<?=$id?>" value="<?=$row->question?>">
											<input type="hidden" name="qid<?=$id?>" value="<?=$row->id?>">
										</div>
										<div class="clear"></div>
									</div>
<?php $letter = 'A'; foreach ($main[$id]->result() as $row1) { ?>
									<div id="<?=$id?><?=$letter?>">
										<div class="left">
											<span class="<?=$letter?>">Choice <?=$letter?>: </span>
										</div>
										<div class="right">
											<input type="text" name="<?=$letter?><?=$id?>" class="input answerinput" id="input<?=$letter?><?=$id?>" value="<?=$row1->answer?>">
											<input type="hidden" name="aid<?=$id?><?=$letter?>" value="<?=$row1->id?>">
										</div>
										<div class="clear"></div>
									</div>
<?php $letter++; } ?>
								</div>
								<div class="rightanswer">
									<div class="answerlabel" id="answerlabel<?=$id?>">
										<input type="hidden" id="id<?=$id?>" name="id<?=$id?>" value="<?=$letter?>">
										<div class="text">Answer:</div>
<?php $letter1 = 'A'; foreach ($main[$id]->result() as $row1) { ?>
										<span id="label<?=$letter1?><?=$id?>">
											<input type="radio" value="<?=$letter1?>" name="answer<?=$id?>" id="<?=$letter1?><?=$id?>" onclick="answerChoose('<?=$letter1?>', '<?=$id?>')"<?php if ($row->answer_id == $row1->id) { ?> checked<?php } ?>>
											<label for="<?=$letter1?><?=$id?>">
												<span class="<?=$letter1?>"><?=$letter1?></span>
											</label>
										</span>
<?php $letter1++; } ?>
									</div>
								</div>
							</div>
							<div class="right circle"><?=$id?></div>
							<div class="clear"></div>
						</li>
<?php $id++; } } else { $id = 1; $prompt = array('', 'Warm up time! Try creating the first question.', 'Let\'s keep going.', 'Let\'s get one more out there.'); while ($id < 4) { ?>
						<li>
							<div class="left">
								<div class="prompt"><?=$prompt[$id]?></div>
								<div class="question" id="q<?=$id?>">
									<div id="<?=$id?>question">
										<div class="left">
											<span class="question">Question: </span>
										</div>
										<div class="right">
											<input type="text" name="question<?=$id?>" class="input question answerinput" id="inputquestion<?=$id?>">
										</div>
										<div class="clear"></div>
									</div>
<?php $letter = 'A'; while ($letter < 'D') { ?>
									<div id="<?=$id?><?=$letter?>">
										<div class="left">
											<span class="<?=$letter?>">Choice <?=$letter?>: </span>
										</div>
										<div class="right">
											<input type="text" name="<?=$letter?><?=$id?>" class="input answerinput" value="" id="input<?=$letter?><?=$id?>">
										</div>
										<div class="clear"></div>
									</div>
<?php $letter++; } ?>
								</div>
								<div class="rightanswer">
									<div class="button_menu">
										<input type="button" class="button green" id="add<?=$id?>" value="+" onclick="addAnswer(<?=$id?>); return false">
										<input type="button" class="button red" id="delete<?=$id?>" value="-" onclick="deleteAnswer(<?=$id?>); return false">
									</div>
									<div class="answerlabel" id="answerlabel<?=$id?>">
										<input type="hidden" id="id<?=$id?>" name="id<?=$id?>" value="D">
										<div class="text">Answer:</div>
<?php $letter1 = 'A'; while ($letter1 < 'D') { ?>
										<span id="label<?=$letter1?><?=$id?>">
											<input type="radio" value="<?=$letter1?>" name="answer<?=$id?>" id="<?=$letter1?><?=$id?>" onclick="answerChoose('<?=$letter1?>', '<?=$id?>')">
											<label for="<?=$letter1?><?=$id?>">
												<span class="<?=$letter1?>"><?=$letter1?></span>
											</label>
										</span>
<?php $letter1++; } ?>
									</div>
								</div>
							</div>
							<div class="right circle"><?=$id?></div>
							<div class="clear"></div>
						</li>
<?php $id++; } } if ($status != 'edit') { ?>
						<li class="center" id="add">
							<input type="button" class="button blue" value="Add a question here!" onClick="addQuestion(); return false;" class="submit" />
						</li>
<?php } if ($this->config->item('enable_tag') != FALSE) { ?>
						<li class="tags">
							<div class="left tag_field">
								<div class="left">Tags:</div>
								<ul id="mytags" class="right tagit">
<?php if ($status == 'edit') { $tag_number = 1; foreach ($tag->result() as $row) {  ?>
									<li class="tagit-choice">
										<a href="/tags/<?=$row->tag?>" target="blank"><?=$row->tag?></a>
										<a class="close">x</a>
										<input type="hidden" name="tag<?=$tag_number?>" value="<?=$row->tag?>">
										<input type="hidden" name="tagid<?=$tag_number?>" value="<?=$row->id?>">
									</li>
<?php $tag_number++; } } ?>
								</ul>
								<input type="hidden" name="tagamount" id="tagamount" value="<?php echo ($status == 'edit') ? $tag->num_rows() + 1 : 1; ?>" />
								<div class="clear"></div>
							</div>
							<div class="right optional">
								<div class="small">(Type an comma after each tag)</div>
							</div>
							<div class="clear"></div>
						</li>
<?php } } if ($content_type == 'create' || $content_type == 'settings' || $status == 'untake') { if ($content_type == 'settings' && $setting_type == 'twitter' && $twitter_status['status'] != 2) {} else { if ($status == 'untake' && $session == FALSE) { ?>
						<li class="logout quiz_signup">
							<h3 class="center">Looks like an interesting quiz? Sign up within 10 seconds and take it!</h3>
								<div class="left red">Username: </div>
								<div class="right">
									<input type="text" name="username" id="usernamefield" value="<?=$this->session->flashdata('username')?>" />
									<div class="validation" id="username">&nbsp;</div>
								</div>
								<div class="clear"></div>
								<div class="left green">Email: </div>
								<div class="right">
									<input type="text" name="email" id="emailfield" value="<?=$this->session->flashdata('email')?>" />
									<div class="validation" id="email">&nbsp;</div>
								</div>
								<div class="clear"></div>
								<div class="left blue">Password: </div>
								<div class="right">
									<input type="password" name="password" id="newpasswordfield" value="<?=$this->session->flashdata('password')?>" />
									<div class="validation" id="newpassword">&nbsp;</div>
								</div>
								<div class="clear"></div>
								<div class="center">
									<input type="submit" class="submit" name="Submit" value="Sign Up" />
								</div>
								<div class="left_link">Not Convinced? <a href="/tour">Take a tour</a>!</div>
								<div class="right_link">Have An Account? <a href="/login<?=$pageid?>">Log In</a>.</div>
						</li>
<?php } else { ?>
						<li class="center">
<?php if ($this->config->item('enable_take') == FALSE && $content_type == 'quiz' && $status == 'untake' || $this->config->item('enable_edit') == FALSE && $content_type == 'quiz' && $status == 'edit' || $this->config->item('enable_settings') == FALSE && $content_type == 'settings') { ?>
							Sorry, the backend is having few problems, would you wait for a bit?
<?php } else { ?>
							<input type="submit" value="Submit" name="Submit" class="button blue" />
<?php if ($status == 'edit') { ?>				
							 or <a href="/<?=$quizid?>">Cancel</a>
<?php } ?>
						</li>
<?php } } } } else { if ($main['pagination'] != FALSE) { ?>
						<li class="pagination">
							<?=$main['pagination']?>
							<div class="clear"></div>
						</li>
<?php } } ?>
					</ul>
<?php if ($content_type == 'create' || $content_type == 'settings' || $status == 'untake' && $session == TRUE) { ?>
				</form>
<?php } else { ?>
				</div>
<?php } ?>