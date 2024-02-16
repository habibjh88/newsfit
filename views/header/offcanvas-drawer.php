<?php
/**
 * Template part for displaying header offcanvas
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package newsfit
 */
?>


<div class="newsfit-offcanvas-drawer">

	<nav id="site-navigation" class="offcanvas-navigation" role="navigation">
		<?php
		if ( has_nav_menu( 'primary' ) ) :
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'menu_id'        => 'primary-menu',
					'walker'         => new RT\Newsfit\Core\WalkerNav(),
				)
			);
		endif;
		?>
	</nav><!-- .newsfit-navigation -->

</div><!-- .container -->

<div class="newsfit-body-overlay"></div>
