<?php

namespace RT\Newsfit\Custom;

use RT\Newsfit\Helpers\Fns;
use RT\Newsfit\Traits\SingletonTraits;
use RT\Newsfit\Options\Opt;
use RT\Newsfit\Modules\Thumbnail;

/**
 * Extras.
 */
class Hooks {
	use SingletonTraits;

	/**
	 * register default hooks and actions for WordPress
	 */
	public function __construct() {
		add_filter( 'wp_calculate_image_srcset_meta', '__return_null' );
		add_action( 'admin_enqueue_scripts', [ __CLASS__, 'meta_css' ] );
		add_action( 'newsfit_before_single_content', [ __CLASS__, 'before_single_content' ] );
		add_action( 'wp_footer', [ __CLASS__, 'wp_footer_hook' ] );
		add_filter( 'wp_kses_allowed_html', [ __CLASS__, 'custom_wpkses_post_tags' ], 10, 2 );
		add_action( 'wp_nav_menu_item_custom_fields', [ $this, 'menu_customize' ], 10, 2 );
		add_action( 'wp_update_nav_menu_item', [ $this, 'menu_update' ], 10, 2 );
		add_filter( 'wp_get_nav_menu_items', [ $this, 'menu_modify' ], 11, 3 );
	}

	public static function wp_footer_hook() {
		?>
		<style>
			.newsfit-header-footer .site-header {
				opacity: 1;
			}
		</style>

		<?php
	}

	/**
	 * Single post meta visibility
	 *
	 * @param $screen
	 *
	 * @return void
	 */
	public static function meta_css( $screen ) {
		if ( 'post.php' !== $screen ) {
			return;
		}
		global $typenow;
		$display = 'post' === $typenow ? 'table-row' : 'none';
		?>
		<style>
			.single_post_style {
				display: <?php echo esc_attr( $display ); ?>;
			}
		</style>
		<?php
	}

	/**
	 * Before single content hook
	 *
	 * @return void
	 */
	public static function before_single_content() {
		$style = Opt::$single_style;

		if ( in_array( $style, [ '2', '3', '4' ] ) ) {
			$classes = Fns::class_list(
				[
					'content-top-area',
					( '2' == $style ) ? 'container' : 'rt-container-fluid',
				]
			);
			?>

			<div class="<?php echo esc_attr( $classes ); ?>">

				<?php Thumbnail::get_thumbnail( 'full', true ); ?>

				<?php if ( '3' == $style ) : ?>
					<div class='single-top-header <?php echo esc_attr( newsfit_post_class( null ) ); ?>'>
						<div class='container'>
							<div class="row">
								<div class="<?php echo esc_attr( Fns::content_columns() ); ?>">
									<?php newsfit_single_entry_header(); ?>
								</div>
							</div>
						</div>
					</div>
				<?php endif; ?>

			</div>
			<?php
		}
	}

	/**
	 * Add exceptions in wp_kses_post tags.
	 *
	 * @param array  $tags Allowed tags, attributes, and/or entities.
	 * @param string $context Context to judge allowed tags by. Allowed values are 'post'.
	 *
	 * @return array
	 */
	public static function custom_wpkses_post_tags( $tags, $context ) {
		if ( 'post' === $context ) {
			$tags['iframe'] = [
				'src'             => true,
				'height'          => true,
				'width'           => true,
				'frameborder'     => true,
				'allowfullscreen' => true,
			];

			$tags['svg'] = [
				'class'           => true,
				'aria-hidden'     => true,
				'aria-labelledby' => true,
				'role'            => true,
				'xmlns'           => true,
				'width'           => true,
				'height'          => true,
				'viewbox'         => true,
				'stroke'          => true,
				'fill'            => true,
			];

			$tags['g']     = [ 'fill' => true ];
			$tags['title'] = [ 'title' => true ];
			$tags['path']  = [
				'd'               => true,
				'fill'            => true,
				'stroke-width'    => true,
				'stroke-linecap'  => true,
				'stroke-linejoin' => true,
				'fill-rule'       => true,
				'clip-rule'       => true,
				'stroke'          => true,
			];
		}

		return $tags;
	}


	/**
	 * Menu Customize
	 *
	 * @param $item_id
	 * @param $item
	 *
	 * @return void
	 */
	function menu_customize( $item_id, $item ) {
		// Mega menu
		$_mega_menu = get_post_meta( $item_id, 'newsfit_mega_menu', true );
		// Query string
		$menu_query_string = get_post_meta( $item_id, 'newsfit_menu_qs', true );
		?>

		<?php if ( $item->menu_item_parent < 1 ) : ?>
			<p class="description mega-menu-wrapper widefat">
				<label for="newsfit_mega_menu-<?php echo $item_id; ?>" class="widefat">
					<?php _e( 'Make as Mega Menu', 'newsfit' ); ?><br>
					<select class="widefat" id="newsfit_mega_menu-<?php echo $item_id; ?>" name="newsfit_mega_menu[<?php echo $item_id; ?>]">
						<option value=""><?php _e( 'Choose Mega Menu', 'newsfit' ); ?></option>
						<?php
						for ( $item = 2; $item < 12; $item++ ) {
							$menu_item  = $item;
							$class_hide = null;
							$label_hide = '';
							if ( $item > 6 ) {
								$menu_item -= 5;
								$class_hide = ' hide-header';
								$label_hide = ' — Hide Col Title';
							}
							$class    = "mega-menu mega-menu-col-{$menu_item}" . $class_hide ?? '';
							$selected = ( $_mega_menu == $class ) ? ' selected="selected" ' : null;
							?>
							<option <?php echo esc_attr( $selected ); ?> value="<?php echo esc_attr( $class ); ?>">
								<?php printf( __( 'Mega menu - %1$s Col %2$s', 'newsfit' ), $menu_item, $label_hide ); ?>
							</option>
							<?php
						}
						?>
					</select>
				</label>
			</p>
		<?php endif; ?>

		<p class="description widefat">
			<label class="widefat" for="newsfit-menu-qs-<?php echo $item_id; ?>">
				<?php echo esc_html__( 'Query String', 'newsfit' ); ?><br>
				<input type="text"
					   class="widefat"
					   id="newsfit-menu-qs-<?php echo $item_id; ?>"
					   name="newsfit-menu-qs[<?php echo $item_id; ?>]"
					   value="<?php echo esc_html( $menu_query_string ); ?>"
				/>
			</label>
		</p>


		<?php
	}

	/**
	 * Menu Update
	 *
	 * @param $menu_id
	 * @param $menu_item_db_id
	 *
	 * @return void
	 */
	function menu_update( $menu_id, $menu_item_db_id ) {
		$_mega_menu         = isset( $_POST['newsfit_mega_menu'][ $menu_item_db_id ] ) ? sanitize_text_field( $_POST['newsfit_mega_menu'][ $menu_item_db_id ] ) : '';
		$query_string_value = isset( $_POST['newsfit-menu-qs'][ $menu_item_db_id ] ) ? sanitize_text_field( $_POST['newsfit-menu-qs'][ $menu_item_db_id ] ) : '';

		update_post_meta( $menu_item_db_id, 'newsfit_mega_menu', $_mega_menu );
		update_post_meta( $menu_item_db_id, 'newsfit_menu_qs', $query_string_value );
	}

	/**
	 * Modify Menu item
	 *
	 * @param $items
	 * @param $menu
	 * @param $args
	 *
	 * @return mixed
	 */
	function menu_modify( $items, $menu, $args ) {
		foreach ( $items as $item ) {
			$menu_query_string = get_post_meta( $item->ID, 'newsfit_menu_qs', true );
			if ( $menu_query_string ) {
				$item->url = add_query_arg( $menu_query_string, '', $item->url );
			}
		}

		return $items;
	}
}
