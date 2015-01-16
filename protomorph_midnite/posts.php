<?php theme_include('header'); ?>

	<div class="inner">
	<?php if (has_posts()): ?>

		<?php posts(); ?>
		<article class="article">
			<h1 class="article-title">
				<a href="<?php echo article_url(); ?>">
					<?php echo article_title(); ?>
				</a>
			</h1>

			<p class="description"><?php echo article_description(); ?></p>

			<footer>
				Posted <time datetime="<?php echo date(DATE_W3C, article_time()); ?>"><?php echo date('jS F Y', article_time()); ?></time>
				by <?php echo article_author('real_name'); ?>.
				<a href="<?php echo article_category_url(); ?>"><?php echo article_category(); ?></a>.
			<?php if(comments_open()): ?>
				<?php echo total_article_comments() . pluralise(total_article_comments(), ' comment'); ?>.
			<?php endif; ?>
			</footer>
		</article>

		<?php while (posts()): ?>
		<article class="article">
			<h2 class="article-title">
				<a href="<?php echo article_url(); ?>">
					<?php echo article_title(); ?>
				</a>
			</h2>

			<p class="description"><?php echo article_description(); ?></p>

			<footer>
				Posted <time datetime="<?php echo date(DATE_W3C, article_time()); ?>"><?php echo date('jS F Y', article_time()); ?></time>
				by <?php echo article_author('real_name'); ?>.
				<a href="<?php echo article_category_url(); ?>"><?php echo article_category(); ?></a>.
			<?php if(comments_open()): ?>
				<?php echo total_article_comments() . pluralise(total_article_comments(), ' comment'); ?>.
			<?php endif; ?>
			</footer>
		</article>
		<?php endwhile; ?>

		<?php if (has_pagination()): ?>
		<ul class="pagination">
			<li class="prev"><?php echo posts_prev(prev_text()); ?></li>
			<li class="next"><?php echo posts_next(next_text()); ?></li>
		</ul>
		<?php endif; ?>

	<?php else: ?>
		<article class="article">
			<h1>No posts yet!</h1>

			<div class="description">Looks like you have some writing to do!</div>
		</article>
	<?php endif; ?>
	</div>

<?php theme_include('footer'); ?>