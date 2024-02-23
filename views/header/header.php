<?php
/**
 * Template part for displaying header
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package newsfit
 */

$logo_h1      = ! is_singular( [ 'post' ] );
$menu_classes = newsfit_option( 'rt_menu_alignment' );
?>

	<div class="main-header-section">
		<div class="header-container rt-container<?php echo newsfit_option( 'rt_header_width' ) ?>">

			<div class="row align-middle m-0">

				<div class="site-branding pr-15">
					<?php newsfit_site_logo( $logo_h1 ); ?>
				</div><!-- .site-branding -->

				<nav id="site-navigation" class="newsfit-navigation pl-15 pr-15 <?php echo esc_attr( $menu_classes ) ?>" role="navigation">
					<?php
					wp_nav_menu( [
						'theme_location' => 'primary',
						'menu_id'        => 'primary-menu',
						'menu_class'     => 'newsfit-navbar',
						'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
						'fallback_cb'    => 'newsfit_custom_menu_cb',
						'walker'         => has_nav_menu( 'primary' ) ? new RT\Newsfit\Core\WalkerNav() : '',
					] );
					?>
				</nav><!-- .newsfit-navigation -->

				<?php newsfit_menu_icons_group(); ?>

			</div><!-- .row -->

		</div><!-- .container -->
	</div>
<?php

