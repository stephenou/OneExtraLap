<?php $page = strtolower(str_replace(' ', '', $page_type)); if ($page == 'signup') { $h = 'We re-define social quizzing'; } elseif ($page == 'reset') { $h = 'No worries.'; } elseif ($page_type == 'Log In') { $h = 'Nice to see you again!'; } elseif ($page == 'submit') { $h = 'Almost Done!'; } elseif ($page == 'business') { $h = 'Coming Soon: OneExtraLap For Business'; } $url = ($page_type == 'Sign Up' || $page == 'tour' || $page == 'business') ? '/signup'.uri_string() : uri_string(); if ($page != 'tour' && $page != 'business') { ?>
				<h1 class="so_big"><?=$h?></h1>
<?php if ($page == 'signup') { ?>
				<div class="learnmore"><a href="/tour">Take a tour: What can I do in OneExtraLap?</a></div>
<?php } } else { ?>
				<div class="logout less_margin"></div>
<?php } ?>
				<div class="signup_form logout">
<?php if ($page == 'business') { ?>
					<ul class="tour">
						<li class="no_border">
							<h4 class="center">Coming Soon: OneExtraLap For Business</h4>
						</li>
						<li>
							<h5>Want to engage with your customers? You've come to the right place!</h5>
							<p>If you are selling cool stuff, you can create a compelling quiz on things related to your product/service, and <b>offer exclusive discount</b> to people who got 100%!</p>
							<p>If you are beta-testing an app, simply make a mysterious quiz about your upcoming app, and <b>give away exclusive invites</b> to people who got 100%!</p>
							<p>It'll be a <b>triple-win</b>. Your customers will have fun, challenge themselves and receive exclusive privileges. You can build up engagements and sales/signups. And we'll get more happy snappy users! Isn't it amazing? :)</p>
						</li>
						<li>
							<h5>Features Including:</h5>
								<p>Quizzes with unlimited questions and unlimited answers</p>
								<p>Ability to include images in quizzes</p>
								<p>Intuitive, embeddable quizzes</p>
								<p>Advanced statistics specifically on who chose what answers</p>
								<p>Send out emails to winners directly from our site</p>
						</li>
					</ul>
<?php } if ($page == 'tour') { ?>
					<ul class="tour">
						<li class="no_border">
							<h4 class="center">The Big Question: What can I do in OneExtraLap???</h4>
						</li>
						<li>OneExtraLap allows users to <b>take and create compelling, content-rich quizzes while competing with friends by earning points & receiving badges</b>. People can flawlessly learn real-world knowledge without sacrificing the fun and addictiveness!</li>
						<li>
							<div class="left less red">
								<h2>1. Take Quizzes</h2>
								<!--<p>Time to say goodbye to annoying Facebook quizzes, because OneExtraLap offers content-rich, meaningful quizzes that are carefully made by your friends.</p>-->
							</div>
							<div class="right more">
								<img src="/extras/tour-1.png" />
							</div>
							<div class="clear"></div>
						</li>
						<li>
							<div class="right more">
								<img src="/extras/tour-2.png" />
							</div>
							<div class="left less green">
								<h2>2. Create Quizzes</h2>
								<!--<p>With flexible structure, colorful interface, we have a perfect place for you to create high-quality quizzes out of some amazing ideas.</p>-->
							</div>
							<div class="clear"></div>
						</li>
						<li>
							<div class="left less blue">
								<h2>3. Earn Badges</h2>
								<!--<p>Your life is a journey of completing different tasks. Now we've offered you some awards, all you need is to take actions and earn them!</p>-->
							</div>
							<div class="right more">
								<img src="/extras/tour-3.png" />
							</div>
							<div class="clear"></div>
						</li>
						<li>
							<div class="right more">
								<img src="/extras/tour-4.png" />
							</div>
							<div class="left less red">
								<h2>4. Get Points</h2>
								<!--<p>You earned what you pay for. If you put in hard work, you earn points!</p>-->
							</div>
							<div class="clear"></div>
						</li>
						<li>
							<div class="left less green">
								<h2>5. Earn A+ (100%)</h2>
								<!--<p>You will be totally proud of yourself once you get ultimate accuracy.</p>-->
							</div>
							<div class="right more">
								<img src="/extras/tour-5.png" />
							</div>
							<div class="clear"></div>
						</li>
						<li>
							<div class="right more">
								<img src="/extras/tour-6.png" />
							</div>
							<div class="left less blue">
								<h2>6. Follow Friends</h2>
								<!--<p>We make following friends effortless for you, just connect to Twitter or check through our leaderboard.</p>-->
							</div>
							<div class="clear"></div>
						</li>
						<li>
							<div class="left less red">
								<h2>7. Compete with Others</h2>
								<!--<p>Competition is the momentum to push people forward. If you win against your friend, you will be honored.</p>-->
							</div>
							<div class="right more">
								<img src="/extras/tour-7.png" />
							</div>
							<div class="clear"></div>
						</li>
						<li>
							<div class="right more">
								<img src="/extras/tour-8.png" />
							</div>
							<div class="left less green">
								<h2>8. Share Scores</h2>
								<!--<p>If you've got a good grade, why not letting all your friends and the whole world know about it?</p>-->
							</div>
							<div class="clear"></div>
						</li>
					</ul>
<?php } ?>
					<form action="/<?=substr($url, 1)?>" method="post" class="no_border">
<?php if ($page == 'tour') { $page_type = 'Sign Up'; $page = 'signup'; ?>
						<h3 class="center">Looks interesting? Sign up within 10 seconds!</h3>
<?php } if ($page == 'business') { $page_type = 'Keep me updated!'; ?>
						<h3 class="center">Interested? Enter your email and stay informed!</h3>
<?php } if ($page == 'login' || $page == 'signup') { ?>
						<div class="left red">Username: </div>
						<div class="right">
							<input type="text" name="username" id="usernamefield" value="<?=$this->session->flashdata('username')?>" />
<?php if ($page == 'signup') { ?>
							<div class="validation" id="username">&nbsp;</div>
<?php } ?>
						</div>
						<div class="clear"></div>
<?php } if ($page == 'signup' || $page == 'reset' || $page == 'business') { ?>
						<div class="left green">Email: </div>
						<div class="right">
							<input type="text" name="email" id="emailfield" value="<?=$this->session->flashdata('email')?>" />
<?php if ($page == 'signup') { ?>
							<div class="validation" id="email">&nbsp;</div>
<?php } ?>
						</div>
						<div class="clear"></div>
<?php } if ($page == 'submit' || $page == 'signup' || $page == 'login') { ?>
						<div class="left blue">Password: </div>
						<div class="right">
							<input type="password" name="password" id="newpasswordfield" value="<?=$this->session->flashdata('password')?>" />
<?php if ($page == 'signup') { ?>
							<div class="validation" id="newpassword">&nbsp;</div>
<?php } if ($page == 'login') { ?>
							<div class="small"><a href="/reset">Forget Password?</a></div>
<?php } ?>
						</div>
						<div class="clear"></div>
<?php } ?>
						<div class="center">
							<input type="submit" class="submit" name="Submit" value="<?php echo $page_type; if ($page != 'business') echo ' & Begin Quizzing'; ?>" />
						</div>
<?php if ($page == 'reset') { ?>
						<div class="left_link">Nevermind? <a href="/login">Log in now</a>.</div>
						<div class="right_link">Don't have an account? <a href="/">Sign Up</a>.</div>
<?php } elseif ($page != 'login') { if ($page != 'business') { ?>
						<div class="left_link">Follow us on <a href="http://twitter.com/OneExtraLap" target="_blank">Twitter</a>.</div>
<?php } else { ?>
						<div class="left_link">Don't have an account? <a href="/">Sign Up</a>.</div>
<?php } ?>
						<div class="right_link">Have an account? <a href="/login">Log In</a>.</div>
<?php } elseif ($page == 'signup') { if (isset($h)) { ?>
						<div class="left_link">Not convinced? <a href="/tour">Take a tour</a>!</div>
<?php } ?>
						<div class="right_link">Have an account? <a href="/login">Log In</a>.</div>
<?php } elseif ($page == 'login') { ?>
						<div class="left_link"><a href="/connect"><img src="/extras/sign-in-with-twitter.png" /></a></div>
						<div class="right_link">Don't have an account? <a href="/">Sign Up</a>.</div>
<?php } ?>
					</form>
				</div>
<?php if ($page == 'signup') { ?>
				<div class="featured_new">
					<div>
						<div class="featured_header">Featured Users</div>
						<ul class="featured_user">
							<li>
								<?=get_avatar('ryancarson', 'big', TRUE, FALSE, TRUE)?>
							</li>
							<li>
								<?=get_avatar('kyle', 'big', TRUE, FALSE, TRUE)?>
							</li>
							<li>
								<?=get_avatar('rebecca', 'big', TRUE, FALSE, TRUE)?>
							</li>
							<li>
								<?=get_avatar('rjamestaylor', 'big', TRUE, FALSE, TRUE)?>
							</li>
							<li>
								<?=get_avatar('stephenou', 'big', TRUE, FALSE, TRUE)?>
							</li>
							<li>
								<?=get_avatar('danielbru', 'big', TRUE, FALSE, TRUE)?>
							</li>
							<li>
								<?=get_avatar('crystalcy', 'big', TRUE, FALSE, TRUE)?>
							</li>
							<li>
								<?=get_avatar('jp', 'big', TRUE, FALSE, TRUE)?>
							</li>
							<li>
								<?=get_avatar('markbao', 'big', TRUE, FALSE, TRUE)?>
							</li>
							<li>
								<?=get_avatar('christian', 'big', TRUE, FALSE, TRUE)?>
							</li>
							<li>
								<?=get_avatar('robin', 'big', TRUE, FALSE, TRUE)?>
							</li>
							<li class="last">
								<?=get_avatar('netspencer', 'big', TRUE, FALSE, TRUE)?>
							</li>
						</ul>
						<div class="clear"></div>
					</div>
					<div>
						<div class="featured_header">Featured Quizzes</div>
						<ul class="featured_quiz">
							<li>
								<?=get_title(173)?>
							</li>
							<li>
								<?=get_title(172)?>
							</li>
							<li>
								<?=get_title(167)?>
							</li>
							<li>
								<?=get_title(164)?>
							</li>
							<li>
								<?=get_title(157)?>
							</li>
							<li>
								<?=get_title(143)?>
							</li>
							<li>
								<?=get_title(129)?>
							</li>
							<li>
								<?=get_title(120)?>
							</li>
							<li>
								<?=get_title(114)?>
							</li>
							<li>
								<?=get_title(113)?>
							</li>
							<li>
								<?=get_title(95)?>
							</li>
						</ul>
						<div class="clear"></div>
					</div>
					<div class="clear"></div>
				</div>
<?php } ?>