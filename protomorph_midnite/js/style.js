/* =======================================================================
 * Protomorph Midnite: Version 1.0.0
 * @ProtoMorph (http://protomorph.cf/)
 * =======================================================================
 * Copyright 2015
 * Licensed GNU General Public License, version 2 (GPL-2.0)
 * ======================================================================= */
;(function ($, window, document, undefined) {

	// CLASS DEFINITION
	// ================

	var ProtomorphMidnite = function (element) {
		this.element	= $(element);
		this.options	= defaults;

		this._name		= 'protomorphmidnite';
		this._version	= '1.0.0-BETA';

		this.init();
	};

	// default options
	var defaults = {
		duration: 400,				// Drop down menu slide & Scroll top button fade durations in milliseconds.
		offset: 250,				// Offset from to before to top button shows.
		totoptime: 800,				// Scroll to top duration in milliseconds.
	};

	ProtomorphMidnite.prototype.init = function () {
		this.menu();
		this.scrolltop();

		hljs.configure({
			tabReplace: '	'
		});

		$('code, pre, pre code').each(function (i, block) {
			hljs.highlightBlock(block);
		});
	};

	ProtomorphMidnite.prototype.menu = function () {
		var self		= this,
			button		= this.element.find('[data-toggle="menu"]'),
			parent		= button.parents('.page-header'),
			toggle		= this.element.find('[data-toggle="dropdown"]'),
			dropdown	= toggle.parent('.dropdown'),
			ddmenu		= toggle.next('.dropdown-menu');

		function hideMenu (e) {
			parent.removeClass('in')
				.trigger(e = $.Event('hide.pr.menu'))
				.one($.transition, hiddenMenu);
		}

		function showMenu (e) {
			parent.addClass('in')
				.trigger(e = $.Event('show.pr.menu'))
				.one($.transition, showingMenu);
		}

		function hiddenMenu () {
			parent.trigger('hidden.pr.menu');
		}

		function showingMenu () {
			parent.trigger('showing.pr.menu');
		}

		function hideDropdown (e) {
			dropdown.removeClass('open')
				.trigger(e = $.Event('hide.pr.dropdown'))
				.one($.transition, hiddenDropdown);

			ddmenu.stop(true, false)
				.slideUp(self.options.duration);
		}

		function showDropdown (e) {
			dropdown.addClass('open')
				.trigger(e = $.Event('show.pr.dropdown'))
				.one($.transition, showingDropdown);

			ddmenu.stop(true, false)
				.slideDown(self.options.duration);
		}

		function hiddenDropdown () {
			dropdown.trigger('hidden.pr.dropdown');
		}

		function showingDropdown () {
			dropdown.trigger('showing.pr.dropdown');
		}

		button.on('click touchstart', function (e) {
			if (e) e.preventDefault();

			if (parent.hasClass('in')) {
				hideMenu(e);
			} else {
				showMenu(e);
			}

			if (dropdown.hasClass('open')) {
				hideDropdown(e);
			}
		});

		toggle.on('click touchstart', function (e) {
			if (e) e.preventDefault();

			if (dropdown.hasClass('open')) {
				hideDropdown(e);
			} else {
				showDropdown(e);
			}
		});

		$(document).on('click touchstart', function (e) {
			if (!$(e.target).parent('.dropdown').is('.dropdown')) {
				hideDropdown(e);
			}
		});
	};

	ProtomorphMidnite.prototype.scrolltop = function () {
		var self	= this,
			totop	= this.element.find('.scroll-top'),
			hidden	= true,
			offset	= this.options.offset;

		function scrollHide (e) {
			totop.stop(true, false)
				.fadeOut(self.options.duration)
				.trigger(e= $.Event('hidden.pr.scolling'));
		}

		function scrollShow (e) {
			totop.stop(true, false)
				.fadeIn(self.options.duration)
				.trigger(e = $.Event('showing.pr.scolling'));
		}

		$(window).on('scroll load', function (e) {
			var wintop = $(this).scrollTop();

			if (wintop > offset && hidden) {
				scrollShow(e);
				hidden = false;
			} else if (wintop <= offset && !hidden) {
				scrollHide(e);
				hidden = true;
			}
		});

		totop.on('click touchstart', function (e) {
			if (e) e.preventDefault();

			$('html, body').animate({
				scrollTop: 0
			}, self.options.totoptime);

			totop.trigger(e = $.Event('totop.pr.scrolling'));
		});
	};

	// TRANSITION END : Shoutout: http://getbootstrap.com/

	function transitionEndEvent () {
		var el = document.createElement('protomorph');

		var transitionEndNames = {
			'WebkitTransition'	: 'webkitTransitionEnd',
			'MozTransition'		: 'transitionend',
			'msTransition'		: 'MSTransitionEnd',
			'OTransition'		: 'oTransitionEnd',
			'transition'		: 'transitionend'
		};

		for (var name in transitionEndNames) {
			if (el.style[name] !== undefined) return transitionEndNames[name];
		}

		return false;
	}

	$.transition = transitionEndEvent();

	// PLUGIN DEFINITION
	// =================

	function Plugin() {
		return this.each(function () {
			var self = $(this),
				data = self.data('pr.protomorphmidnite');

			if (!data) self.data('pr.protomorphmidnite', (data = new ProtomorphMidnite(this)));
		});
	}

	var old = $.fn.protomorphmidnite;

	$.fn.protomorphmidnite				= Plugin;
	$.fn.protomorphmidnite.Constructor	= ProtomorphMidnite;

	// NO CONFLICT
	// ===========

	$.fn.protomorphmidnite.noConflict = function () {
		$.fn.protomorphmidnite = old;
		return this;
	};

	$(document).protomorphmidnite();

})(jQuery, window, document);