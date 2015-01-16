<?php theme_include('header'); ?>

	<div class="inner">
		<article class="article" id="article-<?php echo article_id(); ?>">
			<h1 class="article-title"><?php echo article_title(); ?></h1>

			<p class="description"><?php echo article_description(); ?></p>

			<?php echo article_markdown(); ?>

			<footer>
				Posted <time datetime="<?php echo date(DATE_W3C, article_time()); ?>"><?php echo date('jS F Y', article_time()); ?></time>
				by <?php echo article_author('real_name'); ?>.
				<a href="<?php echo article_category_url(); ?>"><?php echo article_category(); ?></a>.
			<?php if(comments_open()): ?>
				<?php echo total_comments() . pluralise(total_comments(), ' comment'); ?>.
			<?php endif; ?>
				<?php echo article_custom_field('attribution'); ?>
			</footer>
		</article>

		<?php echo article_pager(); ?>

	<?php if (related_show()): ?>
		<h3>Related Posts</h3>

		<div class="row">
		<?php foreach (related_posts() as $post) : ?>
			<div class="col-<?php echo related_count(); ?>">
				<article class="related">
					<h5 class="article-title">
						<a href="<?php echo $post->slug; ?>">
							<?php echo $post->title; ?>
						</a>
					</h5>

					<small>Posted <?php echo $post->created; ?></small>
				</article>
			</div>
		<?php endforeach; ?>
		</div>
	<?php endif; ?>
	</div>

<?php if (comments_open()): ?>
	<div class="inner">
	<?php if(has_comments()): ?>
		<h3>Comments</h3>

		<?php $i = 0; while (comments()): $i++; ?>
		<div class="comment clearfix" id="comment-<?php echo $i; ?>">
			<span class="avatar">
				<img src="<?php echo comment_avatar(comment_email()); ?>" >
			</span>

			<p><?php echo comment_text(); ?></p>

			<footer class="clearfix">
				By <span><?php echo comment_name(); ?></span> on
				<time datetime="<?php echo date(DATE_W3C, comment_time()); ?>">
					<?php echo date('jS F Y H:i', comment_time()); ?>
				</time>

				- <a class="comment-id" href="#comment-<?php echo $i; ?>">#<?php echo $i; ?></a>
			</footer>
		</div>
		<?php endwhile; ?>
	<?php endif; ?>

		<form id="comment" class="commentform" method="post" action="<?php echo comment_form_url(); ?>#comment">
			<?php echo comment_form_notifications(); ?>

			<div class="form-row">
				<div class="col-2">
					<?php echo comment_form_input_name('placeholder="Your name"'); ?>
				</div>

				<div class="col-2">
					<?php echo comment_form_input_email('placeholder="Your email (won’t be published)"'); ?>
				</div>
			</div>

			<div class="form-row">
				<div class="col-1">
					<?php echo comment_form_input_text('placeholder="Your comment" rows="10"'); ?>
				</div>
			</div>

			<div class="submit">
				<?php echo comment_form_button(); ?>
			</div>
		</form>
	</div>
<?php endif; ?>

<?php theme_include('footer'); ?>