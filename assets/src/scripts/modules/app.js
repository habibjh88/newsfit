class App {
	constructor($) {
		this.$ = $;
		this.offCanvas = {
			menuBar: $('.trigger-off-canvas'),
			drawer: $('.newsfit-offcanvas-drawer'),
			drawerClass: '.newsfit-offcanvas-drawer',
			menuDropdown: $('.dropdown-menu.depth_0')
		};

		$(document).ready(() => {
			this.menuDrawerOpen($);
			this.offcanvasMenuToggle($);
			this.headerSearchOpen($)
		})

		$(document).load(() => {
			// this.documentLoad();
		})
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
		$('.newsfit-search-trigger').on('click', e => {
			e.preventDefault();
			$('.newsfit-search-form').fadeToggle();
			e.stopPropagation()
		})
		$(document).on('click', e => {
			if (!$(e.target).closest('.newsfit-search-form').length) {
				$('.newsfit-search-form').fadeOut()
			}
		});
	}

}

export default App;
