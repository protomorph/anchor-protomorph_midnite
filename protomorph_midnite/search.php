<?php theme_include('header'); ?>

<div class="inner">
<?php if(search_term() === ''): ?>
	<h1 class="solo">Search</h1>

	<form class="search" id="search" action="<?php echo search_url(); ?>" method="post" role="search">
		<input id="term" type="search" name="term" placeholder="Search">
	</form>

<?php elseif (has_search_results()): ?>
	<h1 class="solo">You searched for &ldquo;<?php echo e(search_term()); ?>&rdquo;.</h1>

	<?php while (search_results()): ?>
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
		<li class="prev"><?php echo search_prev(); ?></li>
		<li class="next"><?php echo search_next(); ?></li>
	</ul>
	<?php endif; ?>

<?php else: ?>
	<h1 class="solo">Search</h1>

	<h4>Unfortunately, there are no results for &ldquo;<?php echo e(search_term()); ?>&rdquo;</h4>

	<form class="search" id="search" action="<?php echo search_url(); ?>" method="post" role="search">
		<input id="term" type="search" name="term" placeholder="Search">
	</form>
<?php endif; ?>
</div>

<?php theme_include('footer'); ?>