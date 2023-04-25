
		<footer class="footer">
			<div class="inner">
				&copy; <?php echo date('Y'); ?> <?php echo site_name(); ?>. All rights reserved.
				Powered by <a href="http://anchorcms.com/">AnchorCMS</a>.

				<ul role="navigation">
					<li><a href="<?php echo rss_url(); ?>">RSS</a></li>

					<?php if(twitter_account()): ?>
					<li><a href="<?php echo twitter_url(); ?>">@<?php echo twitter_account(); ?></a></li>
					<?php endif; ?>

					<li><a href="<?php echo base_url('admin'); ?>">Admin</a></li>

					<li><a href="/">Home</a></li>
				</ul>
			</div>
		</footer>

		<div class="scroll-top">
			<i class="fa fa-chevron-up"></i>
		</div>

		<script src="//ajax.googleapis.com/ajax/libs/jquery/3.5.0/jquery.min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/8.3/highlight.min.js"></script>
		<script src="<?php echo theme_url('/js/style.js'); ?>"></script>
		<?php if(customised()): ?>
		<!--  Custom Javascript -->
		<script><?php echo article_js(); ?></script>
		<?php endif; ?>
    </body>
</html>
