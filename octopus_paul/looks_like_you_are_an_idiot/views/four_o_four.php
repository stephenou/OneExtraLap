<?php if ($error_type == 503) { ?>
				<h1 class="so_big">Will Be Right Back.</h1>
<?php } elseif ($error_type == 404) { ?>
				<h1 class="so_big">Page Not Found.</h1>
<?php } elseif ($error_type == 401) { ?>
				<h1 class="so_big">Need To Login.</h1>
<?php } ?>