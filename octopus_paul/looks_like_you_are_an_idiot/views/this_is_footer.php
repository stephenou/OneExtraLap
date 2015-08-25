				
				<div class="clear"></div>
			</div>
		</div>
		<div class="footer">
			<div class="inner_footer">
<?php if ($this->config->item('enable_data') == TRUE) { ?>
				<ul class="left">
					<li class="first">
						v.<b><?=$this->config->item('oneextralap_version');?></b>
					</li>
					<li>
						<b><?=get_total_user()?></b> users
					</li>
					<li>
						<b><?=get_total_quiz()?></b> quizzes
					</li>
					<!--<li>
						<b><?php $day = floor((time()-strtotime($this->config->item('launch_date')))/(60*60*24)); echo $day; ?></b> day<?=get_plural($day)?> since launch
					</li>-->
					<li>{elapsed_time}</li>
					<li>{memory_usage}</li>
				</ul>
<?php } ?>
				<ul class="right">
					<li>
						&copy; <?=date('Y');?> <a href="/">OneExtraLap</a>
					</li>
					<li>
						<a href="/about">About</a>
					</li>
					<li>
						<a href="/faq">FAQ</a>
					</li>
					<li>
						<a href="mailto:stephen@oneextralap.com">Contact</a>
					</li>
					<li>
						<a href="http://twitter.com/OneExtraLap" target="_blank">Twitter</a>
					</li>
					<li>
						<a href="http://oneextralap.tumblr.com" target="_blank">Blog</a>
					</li>
					<li class="last">
						<a href="http://stephenou.com" target="_blank">Stephen</a>
					</li>
				</ul>
				<ul class="left">
					<li class="first">
						<iframe src="http://www.facebook.com/plugins/like.php?href=<?=base_url()?>&amp;layout=button_count&amp;show_faces=true&amp;width=80&amp;action=like&amp;font=lucida+grande&amp;colorscheme=light&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:80px; height:21px;" allowTransparency="true"></iframe>
					</li>
					<li>
						<a href="http://twitter.com/share" class="twitter-share-button" data-url="http://oneextralap.com" data-text="Check out this awesome social quizzing community @OneExtraLap!" data-count="horizontal">Tweet</a>
						<script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
					</li>
				</ul>
				<div class="clear"></div>
			</div>
		</div>
		<div class="tooltips">
			<script>$("[title]").tooltip({layout: '<div><div class="arrow"></div></div>', position: 'bottom center', effect: 'fade'});</script>
		</div>
	</body>
</html>