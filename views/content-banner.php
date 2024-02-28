<?php
/**
 * Template part for displaying banner content
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package newsfit
 */

use RT\Newsfit\Options\Opt;
use RT\Newsfit\Helpers\Fns;
use RT\Newsfit\Modules\Breadcrumb;

if ( ! Opt::$has_banner ) {
	return;
}

$banner_image_css = '';


if ( ! empty( Opt::$banner_image ) ) {
	$image_url = wp_get_attachment_image_src( Opt::$banner_image, 'full' );

	$banner_image_css .= isset( $image_url[0] ) ? "background-image:url({$image_url[0]});" : '';

	if ( ! empty( Opt::$banner_height ) ) {
		$banner_image_css .= 'min-height:' . rtrim( Opt::$banner_height, 'px' ) . 'px;';
	}

	if ( ! empty( newsfit_option( 'rt_banner_image_attr' ) ) ) {
		$bg_attr = json_decode( newsfit_option( 'rt_banner_image_attr' ), ARRAY_A );

		if ( ! empty( $bg_attr['position'] ) ) {
			$banner_image_css .= "background-position: {$bg_attr['position']};";
		}
		if ( ! empty( $bg_attr['attachment'] ) ) {
			$banner_image_css .= "background-attachment: {$bg_attr['attachment']};";
		}
		if ( ! empty( $bg_attr['repeat'] ) ) {
			$banner_image_css .= "background-repeat: {$bg_attr['repeat']};";
		}
		if ( ! empty( $bg_attr['size'] ) ) {
			$banner_image_css .= "background-size: {$bg_attr['size']};";
		}
	}
}
$has_image = isset( $image_url[0] );
if ( in_array( Opt::$single_style, [ '3', '4' ] ) ) {
	$has_image        = false;
	$banner_image_css = '';
}

$classes = Fns::class_list(
	[
		newsfit_option( 'rt_banner_style' ),
		$has_image ? 'has-bg' : 'no-bg',
	]
);
?>

<div class="newsfit-breadcrumb-wrapper <?php echo esc_attr( $classes ); ?>" style="<?php echo esc_attr( $banner_image_css ); ?>">
	<?php if ( Opt::$has_breadcrumb ) : ?>
		<div class="container">
			<?php Breadcrumb::get_breadcrumb(); ?>
		</div>
	<?php endif; ?>
</div>
