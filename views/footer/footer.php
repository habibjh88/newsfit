<?php
/**
 * Template part for displaying footer
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package newsfit
 */

use RT\Newsfit\Helpers\Fns;

$footer_width = 'container' . newsfit_option( 'rt_footer_width' );
?>

<?php if ( is_active_sidebar( Fns::sidebar( 'footer' ) ) ) : ?>
	<div class="footer-widgets-wrapper">
		<div class="footer-container <?php echo esc_attr( $footer_width ) ?>">
			<div class="footer-widgets row">
				<?php dynamic_sidebar( Fns::sidebar( 'footer' ) ); ?>
			</div>
		</div>
	</div><!-- .site-info -->
<?php endif; ?>

<?php if ( has_nav_menu( 'footer' ) ) : ?>
	<div class="footer-menu-wrapper">
		<div class="footer-container <?php echo esc_attr( $footer_width ) ?>">
			<div class="row <?php echo newsfit_option( 'rt_footer_menu_alignment' ) ?>">
				<div class="row ml-0 mr-0">
					<nav id="footer-menu" class="newsfit-navigation pr-10" role="navigation">
						<?php
						wp_nav_menu( [
							'theme_location' => 'footer',
							'menu_class'     => 'newsfit-navbar',
							'items_wrap'     => '<ul id="%1$s" class="%2$s newsfit-footer-menu">%3$s</ul>',
							'fallback_cb'    => 'newsfit_custom_menu_cb',
							'walker'         => has_nav_menu( 'footer' ) ? new RT\Newsfit\Core\WalkerNav() : '',
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
			<?php echo Fns::html( str_replace( '[y]', date( 'Y' ), newsfit_option( 'rt_footer_copyright' ) ) ); ?>
		</div>
	</div>
<?php endif; ?>

<?php newsfit_scroll_top(); ?>
