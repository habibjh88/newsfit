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
			newsfit_get_svg( 'search' );
			newsfit_get_svg( 'facebook' );
			newsfit_get_svg( 'twitter' );
			newsfit_get_svg( 'linkedin' );
			newsfit_get_svg( 'instagram' );
			newsfit_get_svg( 'pinterest' );
			newsfit_get_svg( 'tiktok' );
			newsfit_get_svg( 'youtube' );
			newsfit_get_svg( 'snapchat' );
			newsfit_get_svg( 'whatsapp' );
			newsfit_get_svg( 'reddit' );
			?>
		</div>
	</div>
<?php
get_footer();
