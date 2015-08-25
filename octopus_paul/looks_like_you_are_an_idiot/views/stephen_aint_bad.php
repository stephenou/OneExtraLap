		
				<div class="right main_content">
					<ul class="main oel">
						<li class="first">
							<h1 class="center"><?=$body_title?></h1>	
						</li>
						<li>
<?php if ($body_title == 'About') { ?> 
							<div>
								<h2 class="top">What is OneExtraLap?</h2>
								<p>OneExtraLap is a fun but competitive community that gives you a whole new social quizzing experience. You can take content-rich, meaningful quizzes that are made by your friends, or you can share some of your wisdom by creating quizzes as well. Plus, all activities are incorporated into cool game mechanics, such as points and badges. The more you do, the more you earn! And it is addictive!</p>
								<p><center>"<b><i>Wanna get social with your friends? Start quizzing your friends!</i></b> "</center></p>
							</div>
							<div>
								<h2>The Guy Behind It</h2>
								<p>OneExtraLap is lovingly made by a young web developer <a href="http://stephenou.com" target="_blank">Stephen Ou</a> (me) who is thrilled with the power of technology.</p>
								<p>I wrote every line of code and cracked up every colorful pixel of OneExtraLap.</p>
								<p>Feel free to <a href="mailto:stephen@oneextralap.com" target="_blank">email</a> me or find me on <a href="http://twitter.com/stephenou" target="_blank">Twitter</a> if you have any feedback, questions, bug reports, etc.</p>
							</div>
							<div>
								<h2>Love Us? Spread The Word</h2>
								<p>As you know, OneExtraLap is developed, designed, and supported by one single individual, I simply don't have enough time and resources to run a million-dollar marketing campaign. If you love OneExtraLap, simply spread the word out on <a target="_blank" href="http://facebook.com/sharer.php?u=http://oneextralap.com">Facebook</a> or <a target="_blank" href="http://twitter.com/?status=I love @OneExtraLap! http://oneextralap.com">Twitter</a>! Your friends and I will both appreciate your kindness!</p>
								<p>Especially you bloggers, you've got a great site to write about. Time to go to the WP admin. :)</p>
							</div>
<?php } else { ?>
							<div>
								<h2 class="top">How are points being counted? Is there a secret formula?</h2>
								<p>You get 1 point for each question you answered correctly, 2 points for each question you <a href="/create">created</a>, and you also get points for earning badges. The point value for each badge is different, so check individual badge page (<a href="/badges/1">example</a>) for details.</p>
							</div>
							<div>
								<h2>How do I earn badges though?</h2>
								<p>You need to complete a certain task (or a combination of tasks) in order to earn a badge. Some are easy, some are hard. If you complete the hard ones, you'll get a lot of points.</p>
							</div>
							<div>
								<h2>How do I get on top of the leaderboard?</h2>
								<p>Earn points! That means use all the knowledge in your smart brain to take and create as much quizzes as you can.</p>
							</div>
							<div>
								<h2>Why are there question and answer limits when creating quizzes?</h2>
								<p>I limit question amount to 9 per quiz to prevent spam, because you obviously don't want to see someone getting 20000 points for creating 10000 questions in a quiz.</p>
								<p>And I limit answer amount to 9 per question because any number above 9 will make the question too difficult to answer, you don't want to see that as well.</p>
							</div>
							<div>
								<h2>Do I have to connect with my Twitter account?</h2>
								<p>I am not requiring you to, but it is encouraged. After the authentication, it's much easier to <a href="/people/twitter">follow friends</a> from Twitter. If you don't have a <a href="http://twitter.com" target="_blank">Twitter</a> account, obviously I'm not forcing you to make one.</p>
								<p>If you haven't connect yet, click <a href="/connect">here</a>.</p>
							</div>
							<div>
								<h2>Will there be an API? An iPhone app? An iPad app? An Android App?</h2>
								<p>I know, they're very useful. But I can't make 100% promise right now that it'll be coming. I'll accommodate based on the actual needs for our users.</p>
							</div>
							<div>
								<h2>Who made this?</h2>
								<p>15-year-old web developer <a href="http://stephenou.com" target="_blank">Stephen Ou</a>.</p>
							</div>
							<div>
								<h2>Got a question that wasn't answered here?</h2>
								<p>Just hit me up with an <a href="mailto:stephen@oneextralap.com">email</a> and I'll be happy to help you.</p>
							</div>
<?php } ?>
						</li>
<?php if ($session == FALSE) { ?>
						<li class="logout quiz_signup about_faq">
							<h3 class="center">Looks interesting? Sign up within 10 seconds!</h3>
							<form action="/signup/<?=strtolower($body_title)?>" method="post">
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
									<input type="submit" class="submit" name="Submit" value="Sign Up & Begin Quizzing" />
								</div>
								<div class="left_link">Not Convinced? <a href="/tour">Take a tour</a>!</div>
								<div class="right_link">Have An Account? <a href="/login/<?=strtolower($body_title)?>">Log In</a>.</div>
							</form>
						</li>
<?php } ?>
					</ul>
				</div>