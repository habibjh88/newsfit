<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package newsfit
 */

use RT\NewsFit\Options\Opt;
$classes = newsfit_classes([
	'site-footer',
	Opt::$footer_schema
]);
?>
</div><!-- #content -->

<footer class="<?php echo esc_attr($classes); ?>" role="contentinfo">
	<?php get_template_part( 'views/footer/footer', Opt::$footer_style ); ?>
</footer><!-- #colophon -->

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
