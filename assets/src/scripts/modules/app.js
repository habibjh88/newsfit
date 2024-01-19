class App {
	constructor($) {
		this.$ = $;
		this.offCanvas = {
			menuBar: $('.trigger-off-canvas'),
			drawer: $('.newsfit-offcanvas-drawer'),
			drawerClass: '.newsfit-offcanvas-drawer',
			menuDropdown: $('.dropdown-menu.depth_0'),
		};
		this.searchTrigger = $('.newsfit-search-trigger');
		this.isSticky = true;

		$(document).ready(() => {
			this.menuDrawerOpen($);
			this.offcanvasMenuToggle($);
			this.headerSearchOpen($);
			this.backToTop($);
			this.menuOffset($);
		})

		$(document).on('load',() => {
			this.menuOffset($);
		})

		$(window).on('scroll', (event) => {
			this.headerSticky($, event);
			this.backTopTopScroll($, event);
		});

		$(window).on('resize', () => {
			this.menuOffset($);
		});
	}

	menuOffset($) {
		$(".dropdown-menu > li").each(function () {
			var $this = $(this),
				$win = $(window);

			if ($this.offset().left + ($this.width()+30) > $win.width() + $win.scrollLeft() - $this.width()) {
				$this.addClass("dropdown-inverse");
			} else if ($this.offset().left < ($this.width()+30)) {
				$this.addClass("dropdown-inverse-left");
			} else {
				$this.removeClass("dropdown-inverse");
			}
		});
	}


	headerSticky($, event) {

		if ($('body').hasClass('has-sticky-header')) {

			if (this.isSticky) {
				$('.site-header').prepend('<div id="rt-sticky-placeholder"></div>')
			}
			this.isSticky = false;
			var stickyPlaceHolder = $("#rt-sticky-placeholder");
			var mainMenu = $(".main-header-section");
			var menuHeight = mainMenu.outerHeight() || 0;
			var headerTopbar = $('.newsfit-topbar').outerHeight() || 0;
			var targrtScroll = headerTopbar + menuHeight;

			// Main Menu
			if ($(window).scrollTop() > targrtScroll) {
				mainMenu.addClass('rt-sticky');
				stickyPlaceHolder.height(menuHeight);
			} else {
				mainMenu.removeClass('rt-sticky');
				stickyPlaceHolder.height(0);
			}

			//Mobile Menu
			var mobileMenu = $("#meanmenu");
			var mobileTopHeight = $('#mobile-menu-sticky-placeholder');

			if ($(window).scrollTop() > mobileMenu.outerHeight() + headerTopbar) {
				mobileMenu.addClass('rt-sticky');
				mobileTopHeight.height(mobileMenu.outerHeight());
			} else {
				mobileMenu.removeClass('rt-sticky');
				mobileTopHeight.height(0);
			}
		}
	}

	menuDrawerOpen($) {
		this.offCanvas.menuBar.on('click', e => {
			e.preventDefault();
			this.offCanvas.menuBar.toggleClass('is-open')
			this.offCanvas.drawer.toggleClass('is-open');
			e.stopPropagation()
		});

		$(document).on('click', e => {
			if (!$(e.target).closest(this.offCanvas.drawerClass).length) {
				this.offCanvas.drawer.removeClass('is-open');
				this.offCanvas.menuBar.removeClass('is-open')
			}
		});
	}

	offcanvasMenuToggle($) {
		this.offCanvas.drawer.each(function () {
			const caret = $(this).find('.caret');
			caret.on('click', function (e) {
				e.preventDefault();
				$(this).closest('li').toggleClass('is-open');
				$(this).parent().next().slideToggle(300);
			})
		})
	}

	headerSearchOpen($) {
		$('.newsfit-search-trigger').on('click', function (e) {
			e.preventDefault();
			$(this).parent().toggleClass('show');
			e.stopPropagation()
		})
		$(document).on('click', function (e) {
			if (!$(e.target).closest('.newsfit-search-form').length) {
				$('.newsfit-search-popup.show').removeClass('show')
			}
		});
	}

	backToTop($) {
		/* Scroll to top */
		$('.scrollToTop').on('click', function () {
			$('html, body').animate({scrollTop: 0}, 800);
			return false;
		});
	}

	backTopTopScroll($, event) {
		if ($(window).scrollTop() > 100) {
			$('.scrollToTop').addClass('show');
		} else {
			$('.scrollToTop').removeClass('show');
		}
	}

}

export default App;
