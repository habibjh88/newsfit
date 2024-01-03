<?php
/**
 * Template Name: RT Icons
 *
 * @link https://developer.wordpress.org/themes/template-files-section/page-template-files/
 *
 * @package newsfit
 */

get_header(); ?>
	<div class="container">
		<div class="row pt-50 pb-50 d-flex gap-15">
			<?php
			echo newsfit_get_svg( 'search' );
			echo newsfit_get_svg( 'facebook' );
			echo newsfit_get_svg( 'twitter' );
			echo newsfit_get_svg( 'linkedin' );
			echo newsfit_get_svg( 'instagram' );
			echo newsfit_get_svg( 'pinterest' );
			echo newsfit_get_svg( 'tiktok' );
			echo newsfit_get_svg( 'youtube' );
			echo newsfit_get_svg( 'snapchat' );
			echo newsfit_get_svg( 'whatsapp' );
			echo newsfit_get_svg( 'reddit' );
			?>
		</div>
	</div>
<?php
get_footer();
