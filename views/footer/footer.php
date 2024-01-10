<?php
/**
 * Template part for displaying footer
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package newsfit
 */

$footer_width = 'container'.newsfit_option('rt_footer_width');
?>

<?php if ( is_active_sidebar( 'rt-footer-sidebar' ) ) : ?>
	<div class="footer-widgets-wrapper">
		<div class="footer-container <?php echo esc_attr($footer_width) ?>">
			<div class="footer-widgets row">
				<?php dynamic_sidebar( 'rt-footer-sidebar' ); ?>
			</div>
		</div>
	</div><!-- .site-info -->
<?php endif; ?>

<?php if ( has_nav_menu( 'footer' ) ) : ?>
	<div class="footer-menu-wrapper">
		<div class="footer-container <?php echo esc_attr($footer_width) ?>">
			<div class="row justify-content-end">
				<div class="row ml-0 mr-0">
					<nav id="footer-menu" class="newsfit-navigation pr-10" role="navigation">
						<?php
						wp_nav_menu( [
							'theme_location' => 'footer',
							'menu_class'     => 'newsfit-navbar',
							'items_wrap'     => '<ul id="%1$s" class="%2$s newsfit-footer-menu">%3$s</ul>',
							'fallback_cb'    => 'newsfit_custom_menu_cb',
							'walker'         => has_nav_menu( 'footer' ) ? new RT\NewsFit\Core\WalkerNav() : '',
						] );
						?>
					</nav><!-- .footer-navigation -->
				</div>
			</div>
		</div>
	</div><!-- .footer-fop -->
<?php endif; ?>

<?php if ( ! empty( newsfit_option( 'rt_footer_copyright' ) ) ) : ?>
	<div class="footer-copyright-wrapper text-center">
		<div class="copyright-text">
			<?php echo newsfit_html( str_replace( '[y]', date( 'Y' ), newsfit_option( 'rt_footer_copyright' ) ) ); ?>
		</div>
	</div>
<?php endif; ?>
