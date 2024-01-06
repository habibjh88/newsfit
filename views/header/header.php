<?php
/**
 * Template part for displaying header
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package newsfit
 */
?>

<div class="main-header-section">
	<div class="header-container container<?php echo newsfit_option( 'rt_header_width' ) ?>">

		<div class="row align-middle m-0">

			<div class="site-branding pr-15">
				<h1 class="site-title">
					<?php echo newsfit_site_logo(); ?>
				</h1>
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

			<div class="menu-icon-wrapper d-flex pl-15 ml-auto">
				<ul class="d-flex gap-15 align-items-center">
					<li>
						<a class="menu-bar trigger-off-canvas" href="#">
							<span></span>
							<span></span>
							<span></span>
						</a>
					</li>
					<li>
						<a class="menu-search-bar newsfit-search-trigger" href="#">
							<?php echo newsfit_get_svg( 'search' ); ?>
						</a>
						<?php get_search_form(); ?>
					</li>
				</ul>
			</div>

		</div><!-- .row -->

	</div><!-- .container -->
</div>
