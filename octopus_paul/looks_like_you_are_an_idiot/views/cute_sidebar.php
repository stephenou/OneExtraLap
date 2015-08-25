				<div class="left main_sidebar">
					<div class="sidebar">
						<div class="top"></div>
<?php if ($sidebar_type == 'quiz') { ?>
						<div class="info quiz_info first">
							<div class="left">Share</div>
							<div class="right">
								<a href="http://twitter.com/?status=Awesome quiz on @OneExtraLap: '<?=$title?>' <?=get_quiz_link($quizid)?>" target="_blank">Twitter</a> | 
								<a href="http://www.facebook.com/sharer.php?u=<?=get_quiz_link($quizid)?>" target="_blank">Facebook</a> | 
								<a href="mailto:?subject=Check out this awesome quiz on OneExtraLap: <?=$title?>&body=Go ahead and take the quiz if you can! <?=get_quiz_link($quizid)?> (PS: OneExtraLap is a social quizzing website, and it is pretty addictive!)">Email</a>
							</div>
							<div class="clear"></div>
							<div class="left">Link</div>
							<div class="right">
								<input type="text" value="<?=get_quiz_link($quizid)?>" class="quizlink" onclick="this.select()" />
							</div>
							<div class="clear"></div>
<?php if ($this->config->item('enable_tag') !== FALSE && $tag != FALSE) { ?>
							<div class="left">Tags</div>
							<div class="right">
<?php $tag_number = 1; foreach ($tag->result() as $row) { if ($tag_number != 1) { echo ','; } ?>
								<a href="/tags/<?=$row->tag?>"><?=$row->tag?></a><?php $tag_number++; } ?>
							</div>
							<div class="clear"></div>
<?php } ?>
							<div class="left">Grade</div>
							<div class="right">
<?php if ($status == 'grade') { ?>
								<a href="/<?=$quizid?>">Go Back To Quiz</a>
<?php } else { ?>
								<a href="/<?=$quizid?>/grade">View Individual Grade</a>
<?php } ?>
							</div>
							<div class="clear"></div>
<?php if (get_fullname($username) == get_creator($quizid) && $this->config->item('enable_edit') !== FALSE) { ?>
							<div class="left">Edit</div>
							<div class="right">
<?php if ($status == 'edit') { ?>
								<a href="/<?=$quizid?>">Cancel Editing</a>
<?php } else { ?>
								<a href="/<?=$quizid?>/edit">Edit Your Quiz</a>
<?php } ?>
							</div>
							<div class="clear"></div>
<?php } ?>
						</div>
<?php if ($this->config->item('enable_aplus') !== FALSE) { ?>
						<div class="bottom"></div>
					</div>
					<div class="sidebar">
						<div class="top"></div>
						<div class="title first"><b title="People who got 100%">A+ People</b></div>
						<div class="aplus">
							<ul>
<?php if ($onehundred !== FALSE) { $o = 1; $more = $onehundred->num_rows() - 8; foreach ($onehundred->result() as $row) { if ($o < 9) { ?>
								<li>
									<div class="left"><?=get_avatar($row->user_id, 'small')?></div>
									<div class="right"><?=get_fullname($row->user_id)?>
										<div class="timespan"><?=convert_timespan($row->time)?></div>
									</div>
									<div class="clear"></div>
								</li>
<?php } $o++; } if ($more > 0) { ?>
								<li class="center">And <?=$more?> more!</li>
<?php } } else { ?>
								<li class="center">Nobody yet. :(</li>
<?php } ?>
							</ul>
						</div>
<?php } } if ($sidebar_type == 'home' && $session == TRUE || $sidebar_type == 'user' || $sidebar_type == 'badges') { if ($sidebar_type !== 'badges') { ?>
						<div class="name">
							<div class="left">
								<?=get_avatar($userid, 'big')?>
							</div>
							<div class="right">
								<h1><?=get_fullname($userid, FALSE)?></h1>
								<h2>@<?=$userid?></h2>
								<?=get_follow($username, $userid)?>
							</div>
							<div class="clear"></div>
						</div>
<?php if ($this->config->item('enable_follow') !== FALSE) { ?>
						<div class="stats">
							<ul>
								<li>
									<a href="/<?=$userid?>">
										<b><?=$sidebar_stats["score"]?></b><br /> point<?=get_plural($sidebar_stats["score"])?>
									</a>
								</li>
								<li>
									<a href="/<?=$userid?>/following">
										<b id="following"><?=$sidebar_stats["following"]?></b><br /> following
									</a>
								</li>
								<li>
									<a href="/<?=$userid?>/followers">
										<b id="follower"><?=$sidebar_stats["follower"]?></b><br /> follower<span id="sss"><?=get_plural($sidebar_stats["follower"])?></span>
									</a>
								</li>
							</ul>
							<div class="clear"></div>
						</div>
<?php } ?>
						<div class="info user_info">
<?php if (get_website($userid, FALSE) != "") { ?>
							<div class="left">URL</div>
							<div class="right">
								<?=get_website($userid)?>
							</div>
							<div class="clear"></div>
<?php } if (get_twitter($userid, FALSE) != "") { ?>
							<div class="left">Twitter</div>
							<div class="right">
								<?=get_twitter($userid)?>
							</div>
							<div class="clear"></div>
<?php } if (get_bio($userid, FALSE) != "") { ?>
							<div class="left">Bio</div>
							<div class="right bio">
								<?=get_bio($userid, FALSE, FALSE)?>
							</div>
							<div class="clear"></div>
<?php } ?>
						</div>
						<div class="bottom"></div>
					</div>
					<div class="sidebar">
						<div class="top"></div>
							<div class="title first" title="Earn 'Promotion Ambassador' badge if 3 friends sign up!">Invite friends</div>
							<div class="share_panel">
								<a href="http://twitter.com/?status=I think @OneExtraLap is a really fun and addictive social quzzing community. Sign up now! <?=base_url().'refer/'.$username?>" target="_blank">Twitter</a> | 
								<a href="http://www.facebook.com/sharer.php?u=<?=base_url().'refer/'.$username?>" target="_blank">Facebook</a> | 
								<a href="mailto:?subject=Invitation to OneExtraLap&body=OneExtraLap is an addictive social quzzing community that allows you to take and create quizzes while earning points and badges. I'd love to invite you to sign up and compete with me! <?=base_url().'refer/'.$username?>%0D%0A%0D%0AYour friend,%0D%0A<?=$fullname?>">Email</a>
							</div>
							<!-<input onclick="this.select()" class="quizlink" value="<?=base_url().'refer/'.$username?>" />
<?php } if ($this->config->item('enable_badge') !== FALSE) { if ($badges == FALSE && $sidebar_type == 'badges') { ?>
						<div class="title first">What are badges?</div>
						<div class="what_are_tags">
							<p>Badges are cool awards you receive for accomplishing a certain task (or a combination of tasks).</p>
						</div>
<?php } else { if ($badges !== FALSE) { if ($sidebar_type !== 'badges') { ?>
						<div class="bottom"></div>
					</div>
					<div class="sidebar">
						<div class="top"></div>
						<div class="title first">Badges</div>
<?php } else { ?>
						<div class="title first">Your Badges</div>
<?php } ?>
						<div class="badge">
							<ul>
<?php foreach ($badges->result() as $row) { $badge = get_badge($row->badge_id); ?>
								<li>
									<a class="badge badge<?=$badge['class']?>" href="/badges/<?=$row->badge_id;?>" title="<?=$badge['explanation']?>, <?=$badge['point']?> points"><?=$badge['name']?></a>
								</li>
<?php } if ($sidebar_type == 'badges') { ?>
								<li class="idea">Have badges idea? <a href="mailto:stephen@oneextralap.com?subject=Badges Idea">Let me know</a>.</li>
<?php } ?>
							</ul>
						</div>
						
<?php } } } } if ($sidebar_type == 'create') { ?>
						<div class="title first">Our Few Rules</div>
						<div class="tips">
							<ul>
								<li>Be <i>scientific</i>, make questions with <i>objective</i> answers. "Why am I so smart?" isn't a good one.
								<li><i>Don't spam</i>. Your friends won't like questions such as "Choose A if you are a genius".</li>
							</ul>
						</div>
						<div class="bottom"></div>
					</div>
					<div class="sidebar">
						<div class="top"></div>
						<div class="title first">Other Tips</div>
						<div class="tips">
							<ul>
								<li>If you ran out of ideas, click one of 3 icons on the right.</li>
								<li>You get <span class="number">2</span> points per question.</li>
								<li><span class="number">3</span> questions minimum, <span class="number">9</span> questions maximum per quiz.</li>
								<li><span class="number">2</span> answers minimum, <span class="number">9</span> answers maximum per question.</li>
							</ul>
						</div>
<?php } if ($sidebar_type == 'people') { ?>
						<div class="nav">
							<ul>
								<li class="first">
									<a href="/people/leaderboard">
										<b>Leaderboard</b>
										<i>Sort by points</i>
									</a>
								</li>
								<li>
									<a href="/people/new">
										<b>New People</b>
										<i>Sort by signup time</i>
									</a>
								</li>
<?php if ($session == TRUE) { ?>
								<li>
									<a href="/people/twitter">
										<b>Twitter Following</b>
										<i>Find friends in your Twitterverse</i>
									</a>
								</li>
<?php } ?>
							</ul>
						</div>
<?php } if ($sidebar_type == 'find') { ?>
						<div class="nav">
							<ul>
								<li class="first">
									<a href="/quizzes/popular">
										<b>Popular Quizzes</b>
										<i>Sort by number of people taken</i>
									</a>
								</li>
								<li>
									<a href="/quizzes/fresh">
										<b>Fresh Quizzes</b>
										<i>Sort by creation time</i>
									</a>
								</li>
								<li>
									<a href="/quizzes/difficult">
										<b>Difficult Quizzes</b>
										<i>Sort by average grade</i>
									</a>
								</li>
							</ul>
						</div>
<?php } if ($sidebar_type == 'search') { ?>
						<div class="nav">
							<ul>
								<li class="first">
									<a href="/search/quizzes/<?=$term?>">
										<b>Quizzes</b>
										<i>Search "<?=$term?>" from all quizzes</i>
									</a>
								</li>
								<li>
									<a href="/search/people/<?=$term?>">
										<b>People</b>
										<i>Search "<?=$term?>" from all people</i>
									</a>
								</li>
								<li>
									<a href="/tags/<?=$term?>">
										<b>Tags</b>
										<i>Search "<?=$term?>" from all tags</i>
									</a>
								</li>
							</ul>
						</div>
<?php } if ($sidebar_type == 'settings') { ?>
						<div class="nav">
							<ul>
								<li class="first">
									<a href="/settings/profile">
										<b>Profile</b>
										<i>Name, Bio, Website & Avatar</i>
									</a>
								</li>
								<li>
									<a href="/settings/account">
										<b>Account</b>
										<i>Email, Password & Notifications</i>
									</a>
								</li>
								<li>
									<a href="/settings/twitter">
										<b>Twitter</b>
										<i>Link to Twitter + Auto-share options</i>
									</a>
								</li>
							</ul>
						</div>
<?php } if ($sidebar_type == 'tags') { if ($yourtags == FALSE) { ?>
						<div class="title first">What are tags?</div>
						<div class="what_are_tags">
							<p>Tags are labels that identify quizzes from each other, they make finding quizzes much easier.</p>
						</div>
<?php } else {?>
						<div class="title first">Your Tags</div>
						<ul class="yourtags">
<?php if ($yourtags == FALSE) { ?>
							<li class="center">Nothing yet :(</li>
<?php } else { $t = 1; foreach ($yourtags->result() as $row) { if ($t <= 18) { ?>
							<li>
								<div class="left">
									<a href="/tags/<?=$row->tag?>"><?=$row->tag?></a>
								</div>
								<div class="right number"><?=$row->number?></div>
								<div class="clear"></div>
							</li>
<?php $t++; } else { ?>
							<li class="center">And <?=$yourtags->num_rows() - 18;?> more!</li>	
<?php break; } } } ?>
						</ul>
<?php } } if ($oel == TRUE) { ?>
						<div class="nav">
							<ul>
								<li class="first">
									<a href="/about">
										<b>About</b>
										<i>Curious on behind-the-scene stuff?</i>
									</a>
								</li>
								<li>
									<a href="/faq">
										<b>FAQ</b>
										<i>Got some questions flowing in head?</i>
									</a>
								</li>
								<li>
									<a href="mailto:stephen@oneextralap.com">
										<b>Contact</b>
										<i>Have feedback? Saw a bug? Need help?</i>
									</a>
								</li>
								<li>
									<a href="http://twitter.com/OneExtraLap" target="_blank">
										<b>Twitter</b>
										<i>Wanna see updates (in short-form)?</i>
									</a>
								</li>
								<li>
									<a href="http://oneextralap.tumblr.com" target="_blank">
										<b>Blog</b>
										<i>Wanna see updates (in long-form)?</i>
									</a>
								</li>
							</ul>
						</div>

<?php } ?>						
						<div class="bottom"></div>
					</div>
				</div>