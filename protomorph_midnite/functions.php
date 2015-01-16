<?php
/* =======================================================================
 * Protomorph Midnite: Version 1.0.0
 * @ProtoMorph (http://protomorph.cf/)
 * =======================================================================
 * Copyright 2015
 * Licensed under the MIT license (http://protomorph.cf/)
 * ======================================================================= */
function pr_midnite()
{
	return $obj = (object)array(
		'page_next'			=> 'Newer',		// Article/Post 'next' text.
		'page_prev'			=> 'Older',		// Article/Post 'previous' text.
		'related'			=> true,		// Show related posts. true/false.
		'related_count'		=> 4,			// Amount of related posts to show. 1-10.
		'gravatar_rating'	=> 'g',			// Gravatar rating [ g | pg | r | x ].
		'gravatar_type'		=> 'retro',		// Gravatar type [ mm | identicon | monsterid | wavatar | retro ].
		'twitter_user'		=> 'anchorcms',	// Twitter username or leave blank to disable.
	);
}

function numeral($number, $hideIfOne = false)
{
	if ($hideIfOne === true and $number == 1)
	{
		return '';
	}
	
	$test = abs($number) % 10;
	$ext = ((abs($number) % 100 < 21 and abs($number) % 100 > 4) ? 'th' : (($test < 4) ? ($test < 3) ? ($test < 2) ? ($test < 1) ? 'th' : 'st' : 'nd' : 'rd' : 'th'));

	return $number . $ext;
}

function count_words($str)
{
	return count(preg_split('/\s+/', strip_tags($str), null, PREG_SPLIT_NO_EMPTY));
}

function pluralise($amount, $str, $alt = '')
{
	return intval($amount) === 1 ? $str : $str . ($alt !== '' ? $alt : 's');
}

function relative_time($date)
{
	if (is_numeric($date)) $date = '@' . $date;

	$user_timezone = new DateTimeZone(Config::app('timezone'));
	$date = new DateTime($date, $user_timezone);

	// get current date in user timezone
	$now = new DateTime('now', $user_timezone);

	$elapsed = $now->format('U') - $date->format('U');

	if ($elapsed <= 1)
	{
		return 'Just now';
	}

	$times = array(
		31104000	=> 'year',
		2592000		=> 'month',
		604800		=> 'week',
		86400		=> 'day',
		3600		=> 'hour',
		60			=> 'minute',
		1			=> 'second'
	);

	foreach ($times as $seconds => $title) {
		$rounded = $elapsed / $seconds;

		if ($rounded > 1)
		{
			$rounded = round($rounded);
			return $rounded . ' ' . pluralise($rounded, $title) . ' ago';
		}
	}
}

function twitter_account()
{
	return site_meta('twitter', pr_midnite()->twitter_user);
}

function twitter_url()
{
	return 'https://twitter.com/' . twitter_account();
}

function next_text()
{
	return pr_midnite()->page_next . ' <i class="fa fa-angle-right"></i>';
}

function prev_text()
{
	return '<i class="fa fa-angle-left"></i> ' . pr_midnite()->page_prev;
}

/* =======================================================================
 * ARTICLE FUNCTIONS
 * ======================================================================= */
function total_articles()
{
	return Post::where(Base::table('posts.status'), '=', 'published')->count();
}

function article_pager()
{
	if (article_previous_url() || article_next_url())
	{
		if (article_previous_url())
		{
			$article_previous = '<li class="prev"><a href="' . article_previous_url() . '">' . prev_text() . '</a></li>';
		}
		else
		{
			$article_previous = false;
		}

		if (article_next_url())
		{
			$article_next_url = '<li class="next"><a href="' . article_next_url() . '">' . next_text() . '</a></li>';
		}
		else
		{
			$article_next_url = false;
		}

		return '<ul class="pagination">' . $article_previous . $article_next_url . '</ul>';
	}
	else
	{
		return false;
	}
}

function total_article_comments()
{
	return Comment::where('post', '=', article_id())->count();
}

function comment_avatar($email)
{
	$hash = hash('md5', strtolower(trim($email)));

	return 'http://www.gravatar.com/avatar/' . $hash . '?r=' . pr_midnite()->gravatar_rating . '&d=' . pr_midnite()->gravatar_type;
}

/* =======================================================================
 * RELATED POST: Shout out to - http://forums.anchorcms.com/profile/invot
 * http://forums.anchorcms.com/help/how-to-show-randomly-related-posts#post-4970
 * ======================================================================= */
function related_posts()
{
	$posts = Post::get(Base::table('posts'), '=', 'published');
	$postarr = array();

	foreach ($posts as $post)
	{
		if ($post->id != article_id())
		{
			if ($post->category == article_category_id())
			{
				$created = Date::format($post->created);
				$post->created = $created;

				array_push($postarr, $post);
			}
		}
	}

	shuffle($postarr);

	$postarr = array_slice($postarr, 0, pr_midnite()->related_count);

	return $postarr;
}

function article_category_id()
{
	if ($category = Registry::prop('article', 'category'))
	{
		$categories = Registry::get('all_categories');

		return $categories[$category]->id;
	}
}

function related_show()
{
	return pr_midnite()->related;
}

function related_count()
{
	$count = pr_midnite()->related_count;

	if ($count == 8 or $count == 10)
	{
		$total = $count / 2;
	}
	else if ($count == 6 or $count == 9)
	{
		$total = $count / 3;
	}
	else
	{
		$total = $count;
	}

	return $total;
}
