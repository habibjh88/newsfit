<?php

namespace RT\Newsfit\Custom;

use RT\Newsfit\Traits\SingletonTraits;
use RT\Newsfit\Options\Opt;
use RT\Newsfit\Modules\Svg;

/**
 * Extras.
 */
class Extras {
	use SingletonTraits;

	/**
	 * register default hooks and actions for WordPress
	 *
	 * @return
	 */
	public function __construct() {
		add_filter( 'body_class', [ $this, 'body_class' ] );
		add_action( 'wp_nav_menu_item_custom_fields', [ $this, 'menu_customize' ], 10, 2 );
		add_action( 'wp_update_nav_menu_item', [ $this, 'menu_update' ], 10, 2 );
		add_filter( 'wp_get_nav_menu_items', [ $this, 'menu_modify' ], 11, 3 );
		add_filter( 'get_search_form', [ $this, 'search_form' ] );
		add_action( 'after_switch_theme', [ $this, 'rewrite_flush' ] );
	}

	/*
	 * Body Class added
	 */
	public function body_class( $classes ) {

		// Adds a class of group-blog to blogs with more than 1 published author.

		$classes[] = 'newsfit-header-' . Opt::$header_style;
		$classes[] = 'newsfit-footer-' . Opt::$footer_style;

		if ( is_multi_author() ) {
			$classes[] = 'group-blog';
		}
		// Adds a class of hfeed to non-singular pages.
		if ( ! is_singular() ) {
			$classes[] = 'hfeed';
		}

		if ( Opt::$has_tr_header ) {
			$classes[] = 'has-trheader';
		} else {
			$classes[] = 'no-trheader';
		}

		if ( newsfit_option( 'rt_tr_header_shadow' ) ) {
			$classes[] = 'has-menu-shadow';
		}

		if ( Opt::$has_banner ) {
			$classes[] = 'has-banner';
		} else {
			$classes[] = 'no-banner';
		}

		if ( Opt::$layout ) {
			$classes[] = 'layout-' . Opt::$layout;
		}

		if ( newsfit_option( 'rt_sticy_header' ) ) {
			$classes[] = 'has-sticky-header';
		}

		if ( is_single() && Opt::$single_style ) {
			$classes[] = 'newsfit-single-' . Opt::$single_style;
		}

		return $classes;
	}

	/*
	 * Menu Customize
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
		$_mega_menu         = $_POST['newsfit_mega_menu'][ $menu_item_db_id ] ?? '';
		$query_string_value = $_POST['newsfit-menu-qs'][ $menu_item_db_id ] ?? '';

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

	/**
	 * Search form modify
	 *
	 * @return string
	 */
	public function search_form() {
		$output = '
		<form method="get" class="newsfit-search-form" action="' . esc_url( home_url( '/' ) ) . '">
            <div class="search-box">
				<input type="text" class="form-control" placeholder="' . esc_attr__( 'Search here...', 'newsfit' ) . '" value="' . get_search_query() . '" name="s" />
				<button class="item-btn" type="submit">
					' . Svg::get_svg( 'search', false ) . '
					<span class="btn-label">' . esc_html__( 'Search', 'newsfit' ) . '</span>
				</button>
            </div>
		</form>
		';

		return $output;
	}

	/**
	 * Flush Rewrite on CPT activation
	 *
	 * @return empty
	 */
	public function rewrite_flush() {
		// Flush the rewrite rules only on theme activation
		flush_rewrite_rules();
	}
}
