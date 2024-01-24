<?php
/**
 * Template part for displaying header
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package newsfit
 */

use RT\NewsFit\Helpers\Fns;

$logo_h1 = ! is_singular( [ 'post' ] );
?>

<div class="main-header-section">
	<div class="header-container rt-container<?php echo newsfit_option( 'rt_header_width' ) ?>">

		<div class="row align-middle m-0">

			<div class="site-branding pr-15">
				<?php echo newsfit_site_logo( $logo_h1 ); ?>
			</div><!-- .site-branding -->

			<nav id="site-navigation" class="newsfit-navigation pl-15 pr-15" role="navigation">
				<?php
				$menu_classes = newsfit_option( 'rt_menu_alignment' );
				wp_nav_menu( [
					'theme_location' => 'primary',
					'menu_id'        => 'primary-menu',
					'menu_class'     => 'newsfit-navbar',
					'items_wrap'     => '<ul id="%1$s" class="%2$s ' . $menu_classes . '">%3$s</ul>',
					'fallback_cb'    => 'newsfit_custom_menu_cb',
					'walker'         => has_nav_menu( 'primary' ) ? new RT\NewsFit\Core\WalkerNav() : '',
				] );
				?>
			</nav><!-- .newsfit-navigation -->

			<div class="menu-icon-wrapper d-flex pl-15 ml-auto align-items-center gap-15">
				<?php newsfit_menu_icons_group(); ?>

				<?php if ( ! empty( newsfit_option( 'rt_get_started_label' ) ) && newsfit_option( 'rt_get_started_button' ) ) : ?>
					<div class="newsfit-get-started-btn">
						<a class="btn btn-primary" href="#">
							<?php echo esc_html( newsfit_option( 'rt_get_started_label' ) ); ?>
						</a>
					</div>
				<?php endif; ?>
			</div>

		</div><!-- .row -->

	</div><!-- .container -->
</div>
