<?php theme_include('header'); ?>

	<div class="inner">
		<h1>Page not found</h1>

		<p>
			Unfortunately, the page <code>/<?php echo e(current_url()); ?></code> could not be found.
			Your best bet is either go to the <a href="<?php echo full_url(base_url()); ?>">homepage</a> or try <a href="<?php echo full_url('search'); ?>">searching</a>.
		</p>
	</div>

<?php theme_include('footer'); ?>