<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

$previous = get_previous_post();
$next     = get_next_post();
$cols     = ( $previous && $next ) ? 'two-cols' : 'one-cols';
?>
<div class="single-post-pagination <?php echo esc_attr( $cols ) ?>">
	<?php if ( $previous ):
		$prev_image = get_the_post_thumbnail_url( $previous ); ?>

		<div class="post-navigation prev">
			<a href="<?php echo esc_url( get_permalink( $previous ) ); ?>" class="nav-title">
				<?php echo newsfit_get_svg( 'arrow-right', '180' ); ?>
				<?php esc_html_e( 'Previous Post: ', 'newsfit' ) ?>
			</a>

			<a href="<?php echo esc_url( get_permalink( $previous ) ); ?>" class="link pg-prev">
				<div class="post-thumb" style="background-image:url(<?php echo esc_url( $prev_image ) ?>)"></div>
				<p class="item-title"><?php echo get_the_title( $previous ); ?></p>
			</a>
		</div>
	<?php endif; ?>

	<?php if ( $next ):
		$prev_image = get_the_post_thumbnail_url( $next ); ?>

		<div class="post-navigation next text-right">
			<a href="<?php echo esc_url( get_permalink( $next ) ); ?>" class="nav-title">
				<?php esc_html_e( 'Next Post: ', 'newsfit' ) ?>
				<?php echo newsfit_get_svg( 'arrow-right' ); ?>
			</a>
			<a href="<?php echo esc_url( get_permalink( $next ) ); ?>" class="link pg-next">
				<p class="item-title"><?php echo get_the_title( $next ); ?></p>
				<div class="post-thumb" style="background-image:url(<?php echo esc_url( $prev_image ) ?>)"></div>
			</a>
		</div>
	<?php endif; ?>
</div>
