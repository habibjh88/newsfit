<?php
/**
 * Template part for displaying header
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package newsfit
 */

use RT\Newsfit\Options\Opt;

if(! Opt::$has_top_bar) {
	return;
}
$header_width = 'full-width' == newsfit_option( 'rt_header_width' ) ? '-fluid' : '';
?>

<div class="newsfit-topbar">
	<div class="topbar-container rt-container<?php echo esc_attr( $header_width ) ?>">
		<div class="row ml-0 mr-0 topbar-row">
			<nav id="topbar-menu" class="newsfit-navigation pr-10" role="navigation">
				<?php
				wp_nav_menu( [
					'theme_location' => 'topbar',
					'menu_class' => 'newsfit-navbar',
					'items_wrap'     => '<ul id="%1$s" class="%2$s newsfit-topbar-menu">%3$s</ul>',
					'fallback_cb'    => 'newsfit_custom_menu_cb',
					'walker'         => has_nav_menu( 'topbar' ) ? new RT\Newsfit\Core\WalkerNav() : '',
				] );
				?>
			</nav><!-- .topbar-navigation -->

			<ul class="topbar-right d-flex gap-15 align-items-center">
				<li class="social-icon">
					<label><?php echo newsfit_option( 'rt_follow_us_label' ) ?></label>
					<?php newsfit_get_social_html( '#555' ); ?>
				</li>
			</ul>
		</div>
	</div>
</div>
