<?php

namespace RT\NewsFit\Custom;

use RT\NewsFit\Traits\SingletonTraits;
use RT\NewsFit\Options\Opt;

/**
 * Extras.
 */
class Fns {
	use SingletonTraits;

	/**
	 * register default hooks and actions for WordPress
	 * @return
	 */
	public function __construct() {
//		add_action( 'newsfit_breadcrumb', [ __CLASS__, 'breadcrumb' ] );
	}


	/**
	 * Get Menu Icon group
	 * @return void
	 */
	static function get_menu_icons_group() {
		$menu_classes = '';
		if ( newsfit_option( 'rt_header_separator' ) ) {
			$menu_classes = 'has-separator';
		}
		?>
		<ul class="d-flex gap-15 align-items-center <?php echo esc_attr( $menu_classes ) ?>">
			<?php if ( newsfit_option( 'rt_header_bar' ) ) : ?>
				<li>
					<a class="menu-bar trigger-off-canvas" href="#">
						<span></span>
						<span></span>
						<span></span>
					</a>
				</li>
			<?php endif; ?>

			<?php if ( newsfit_option( 'rt_header_search' ) ) : ?>
				<li class="newsfit-search-popup">
					<a class="menu-search-bar newsfit-search-trigger" href="#">
						<?php echo newsfit_get_svg( 'search' ); ?>
					</a>
					<?php get_search_form(); ?>
				</li>
			<?php endif; ?>

			<?php if ( newsfit_option( 'rt_header_login_link' ) ) : ?>
				<li class="newsfit-user-login">
					<a href="<?php echo esc_url( wp_login_url() ) ?>">
						<?php echo newsfit_get_svg( 'user' ); ?>
					</a>
				</li>
			<?php endif; ?>
		</ul>
		<?php
	}
}
