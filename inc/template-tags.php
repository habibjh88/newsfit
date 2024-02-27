<?php
/**
 * Helpers methods
 * List all your static functions you wish to use globally on your theme
 *
 * @package newsfit
 */

use RT\Newsfit\Options\Opt;
use RT\Newsfit\Helpers\Fns;
use RT\Newsfit\Modules\Svg;
use RT\Newsfit\Modules\PostMeta;

if ( ! function_exists( 'newsfit_custom_menu_cb' ) ) {
	/**
	 * Callback function for the main menu
	 *
	 * @param $args
	 *
	 * @return string|void
	 */
	function newsfit_custom_menu_cb( $args ) {
		extract( $args );
		$add_menu_link = admin_url( 'nav-menus.php' );
		$menu_text     = sprintf( __( 'Add %s Menu', 'newsfit' ), $theme_location );
		__( 'Add a menu', 'newsfit' );
		if ( ! current_user_can( 'manage_options' ) ) {
			$add_menu_link = home_url();
			$menu_text     = __( 'Home', 'newsfit' );
		}

		// see wp-includes/nav-menu-template.php for available arguments

		$link = $link_before . '<a href="' . $add_menu_link . '">' . $before . $menu_text . $after . '</a>' . $link_after;

		// We have a list
		if ( false !== stripos( $items_wrap, '<ul' ) || false !== stripos( $items_wrap, '<ol' ) ) {
			$link = "<li>$link</li>";
		}

		$output = sprintf( $items_wrap, $menu_id, $menu_class, $link );
		if ( ! empty( $container ) ) {
			$output = "<$container class='$container_class' id='$container_id'>$output</$container>";
		}

		if ( $echo ) {
			echo $output;
		}

		return $output;
	}
}

if ( ! function_exists( 'newsfit_menu_icons_group' ) ) {
	/**
	 * Get menu icon group
	 *
	 * @return void
	 */
	function newsfit_menu_icons_group( $args = [] ) {
		$default_args = [
			'hamburg'       => newsfit_option( 'rt_header_bar' ),
			'search'        => newsfit_option( 'rt_header_search' ),
			'login'         => newsfit_option( 'rt_header_login_link' ),
			'button'        => newsfit_option( 'rt_get_started_button' ),
			'button_label'  => newsfit_option( 'rt_get_started_label' ),
			'button_link'   => newsfit_option( 'rt_get_started_button_url' ),
			'has_separator' => newsfit_option( 'rt_header_separator' ),
		];
		$args         = wp_parse_args( $args, $default_args );
		$has_button   = $args['button'] && $args['button_label'];
		$menu_classes = '';

		if ( $args['has_separator'] ) {
			$menu_classes .= 'has-separator ';
		}

		if ( $has_button ) {
			$menu_classes .= 'has-button ';
		}
		?>
		<div class="menu-icon-wrapper d-flex pl-15 ml-auto align-items-center gap-15">
			<ul class="d-flex gap-15 align-items-center <?php echo esc_attr( $menu_classes ); ?>">
				<?php if ( $args['hamburg'] ) : ?>
					<li>
						<a class="menu-bar trigger-off-canvas" href="#">
							<svg class="ham_burger" viewBox="0 0 100 100" width="180">
								<path class="line top" d="m 30,33 h 40 c 3.722839,0 7.5,3.126468 7.5,8.578427 0,5.451959 -2.727029,8.421573 -7.5,8.421573 h -20"/>
								<path class="line middle" d="m 30,50 h 40"/>
								<path class="line bottom" d="m 70,67 h -40 c 0,0 -7.5,-0.802118 -7.5,-8.365747 0,-7.563629 7.5,-8.634253 7.5,-8.634253 h 20"/>
							</svg>
						</a>
					</li>
				<?php endif; ?>

				<?php if ( $args['search'] ) : ?>
					<li class="newsfit-search-popup">
						<a class="menu-search-bar newsfit-search-trigger" href="#">
							<?php Svg::get_svg( 'search' ); ?>
						</a>
						<?php get_search_form(); ?>
					</li>
				<?php endif; ?>

				<?php if ( $args['login'] ) : ?>
					<li class="newsfit-user-login">
						<a href="<?php echo esc_url( wp_login_url() ); ?>">
							<?php Svg::get_svg( 'user' ); ?>
						</a>
					</li>
				<?php endif; ?>

				<?php if ( $has_button ) : ?>
					<li class="newsfit-get-started-btn">
						<a class="btn btn-primary" href="<?php echo esc_url( $args['button_link'] ); ?>">
							<?php echo esc_html( $args['button_label'] ); ?>
						</a>
					</li>
				<?php endif; ?>
			</ul>
		</div>
		<?php
		if ( $args['hamburg'] ) {
			get_template_part( 'views/header/offcanvas', 'drawer' );
		}
	}
}

if ( ! function_exists( 'newsfit_require' ) ) {
	/**
	 * Require any file. If the file will available in the child theme, the file will load from the child theme
	 *
	 * @param $filename
	 * @param string   $dir
	 *
	 * @return false|void
	 */
	function newsfit_require( $filename, string $dir = 'inc' ) {

		$dir        = trailingslashit( $dir );
		$child_file = get_stylesheet_directory() . DIRECTORY_SEPARATOR . $dir . $filename;

		if ( file_exists( $child_file ) ) {
			$file = $child_file;
		} else {
			$file = get_template_directory() . DIRECTORY_SEPARATOR . $dir . $filename;
		}

		if ( file_exists( $file ) ) {
			require_once $file;
		} else {
			return false;
		}
	}
}

if ( ! function_exists( 'newsfit_readmore_text' ) ) {
	/**
	 * Creates continue reading text.
	 *
	 * @return string
	 */
	function newsfit_readmore_text() {
		return sprintf(
			esc_html__( 'Continue reading %s', 'newsfit' ),
			the_title( '<span class="screen-reader-text">', '</span>', false )
		);
	}
}


if ( ! function_exists( 'newsfit_get_file' ) ) {
	/**
	 * Get File Path
	 *
	 * @param $path
	 *
	 * @return string
	 */
	function newsfit_get_file( $path, $return_path = false ): string {
		$file = ( $return_path ? get_stylesheet_directory() : get_stylesheet_directory_uri() ) . $path;
		if ( ! file_exists( $file ) ) {
			$file = ( $return_path ? get_template_directory() : get_template_directory_uri() ) . $path;
		}

		return $file;
	}
}

if ( ! function_exists( 'newsfit_get_img' ) ) {
	/**
	 * Get Image Path
	 *
	 * @param $filename
	 * @param $echo
	 * @param $image_meta
	 *
	 * @return string|void
	 */
	function newsfit_get_img( $filename, $echo = false, $image_meta = '' ) {
		$path      = '/assets/images/' . $filename;
		$image_url = newsfit_get_file( $path );

		if ( $echo ) {
			if ( ! strpos( $filename, '.svg' ) ) {
				$getimagesize = wp_getimagesize( newsfit_get_file( $path, true ) );
				$image_meta   = $getimagesize[3] ?? $image_meta;
			}
			echo '<img ' . $image_meta . ' src="' . esc_url( $image_url ) . '"/>';
		} else {
			return $image_url;
		}
	}
}

if ( ! function_exists( 'newsfit_get_css' ) ) {
	/**
	 * Get CSS Path
	 *
	 * @param $filename
	 * @param bool     $check_rtl
	 *
	 * @return string
	 */
	function newsfit_get_css( $filename, $check_rtl = false ) {
		$min    = WP_DEBUG ? '.css' : '.min.css';
		$is_rtl = $check_rtl && is_rtl() ? 'css-rtl' : 'css';
		$path   = "/assets/$is_rtl/" . $filename . $min;

		return newsfit_get_file( $path );
	}
}

if ( ! function_exists( 'newsfit_get_js' ) ) {
	/**
	 * Get JS Path
	 *
	 * @param $filename
	 *
	 * @return string
	 */
	function newsfit_get_js( $filename ) {
		$min  = WP_DEBUG ? '.js' : '.min.js';
		$path = '/assets/js/' . $filename . $min;

		return newsfit_get_file( $path );
	}
}


if ( ! function_exists( 'newsfit_option' ) ) {
	/**
	 * Get Customize Options value by key
	 *
	 * @param $key
	 *
	 * @return mixed
	 */
	function newsfit_option( $key, $default = '', $return_array = false ) {
		if ( ! empty( Opt::$options[ $key ] ) ) {
			$opt_val = Opt::$options[ $key ];
			if ( $return_array && $opt_val ) {
				$opt_val = explode( ',', trim( $opt_val, ', ' ) );
			}

			return $opt_val;
		}

		if ( $default ) {
			return $default;
		}

		return false;
	}
}

if ( ! function_exists( 'newsfit_get_social_html' ) ) {
	/**
	 * Get Social markup
	 *
	 * @return void
	 */
	function newsfit_get_social_html() {
		ob_start();
		$icon_style = newsfit_option( 'rt_social_icon_style' );
		foreach ( Fns::get_socials() as $id => $item ) {
			if ( empty( $item['url'] ) ) {
				continue;
			}
			?>
			<a target="_blank" href="<?php echo esc_url( $item['url'] ); ?>">
				<?php Svg::get_svg( $id . $icon_style ); ?>
			</a>
			<?php
		}

		$html = ob_get_clean();
		Fns::print_html_all( $html );
	}
}

if ( ! function_exists( 'newsfit_site_logo' ) ) {
	/**
	 * Newfit Site Logo
	 */
	function newsfit_site_logo( $with_h1 = false, $custom_title = '' ) {
		$main_logo       = newsfit_option( 'rt_logo' );
		$logo_light      = newsfit_option( 'rt_logo_light' );
		$logo_mobile     = newsfit_option( 'rt_logo_mobile' );
		$site_logo       = Opt::$has_tr_header ? $logo_light : $main_logo;
		$mobile_logo     = $logo_mobile ?? $site_logo;
		$has_mobile_logo = ! empty( $logo_mobile ) ? 'has-mobile-logo' : '';
		$site_title      = $custom_title ?: get_bloginfo( 'name', 'display' );

		?>
		<?php if ( $with_h1 ) : ?>
			<h1 class="site-title">
		<?php endif; ?>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="<?php echo esc_attr( $has_mobile_logo ); ?>">
			<?php
			if ( ! empty( $site_logo ) ) {
				echo wp_get_attachment_image( $site_logo, 'full', null, [ 'id' => 'rt-site-logo' ] );
				if ( ! empty( $mobile_logo ) ) {
					echo wp_get_attachment_image( $mobile_logo, 'full', null, [ 'id' => 'rt-mobile-logo' ] );
				}
			} else {
				echo esc_html( $site_title );
			}
			?>
		</a>
		<?php if ( $with_h1 ) : ?>
			</h1>
			<?php
		endif;
	}
}

if ( ! function_exists( 'newsfit_footer_logo' ) ) {
	/**
	 * Newfit Site Logo
	 */
	function newsfit_footer_logo() {
		$main_logo  = newsfit_option( 'rt_logo' );
		$logo_light = newsfit_option( 'rt_logo_light' );
		$site_logo  = $main_logo;

		if ( 'footer-dark' === Opt::$footer_schema ) {
			$site_logo = $logo_light;
		}

		if ( '2' == Opt::$footer_style && 'schema-default' === Opt::$footer_schema ) {
			$site_logo = $logo_light;
		}

		ob_start();
		?>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
			<?php
			if ( ! empty( $site_logo ) ) {
				echo wp_get_attachment_image( $site_logo, 'full', null, [ 'class' => 'footer-logo' ] );
			} else {
				bloginfo( 'name' );
			}
			?>
		</a>
		<?php
		return ob_get_clean();
	}
}

if ( ! function_exists( 'newsfit_scroll_top' ) ) {
	/**
	 * Back-to-top button
	 *
	 * @return void
	 */
	function newsfit_scroll_top( $class = '', $icon = 'scroll-top' ) {
		if ( newsfit_option( 'rt_back_to_top' ) ) {
			?>
			<a href="#" class="scrollToTop <?php echo esc_attr( $class ); ?>">
				<?php Svg::get_svg( $icon ); ?>
			</a>
			<?php
		}
	}
}


if ( ! function_exists( 'newsfit_entry_footer' ) ) {
	/**
	 * Newsfit Entry Footer
	 *
	 * @return void
	 */
	function newsfit_entry_footer() {

		if ( ! is_single() ) {
			if ( newsfit_option( 'rt_blog_footer' ) ) {
				?>
				<footer class="entry-footer">
					<a class="read-more" href="<?php echo esc_url( get_permalink() ); ?>"><?php echo newsfit_readmore_text(); ?></a>
				</footer>
				<?php
			}
		} else {
			if ( 'post' === get_post_type() && has_tag() ) {
				?>
				<footer class="entry-footer">
					<div class="post-tags">
						<?php
						if ( $tags_label = newsfit_option( 'rt_tags' ) ) {
							printf( '<span>%s</span>', esc_html( $tags_label ) );
						}
						?>
						<?php newsfit_separate_meta( 'content-below-meta', [ 'tag' ] ); ?>
					</div>
				</footer>
				<?php
			}
		}
	}
}

if ( ! function_exists( 'newsfit_entry_content' ) ) {
	/**
	 * Entry Content
	 *
	 * @return void
	 */
	function newsfit_entry_content() {
		if ( ! is_single() ) {
			$length = newsfit_option( 'rt_excerpt_limit' );
			echo wp_trim_words( get_the_excerpt(), $length );
		} else {
			the_content();
		}
	}
}

if ( ! function_exists( 'newsfit_sidebar' ) ) {
	/**
	 * Get Sidebar conditionally
	 *
	 * @param $sidebar_id
	 *
	 * @return false|void
	 */
	function newsfit_sidebar( $sidebar_id ) {
		$sidebar_from_layout = Opt::$sidebar;

		if ( 'default' !== $sidebar_from_layout && is_active_sidebar( $sidebar_from_layout ) ) {
			$sidebar_id = $sidebar_from_layout;
		}
		if ( ! is_active_sidebar( $sidebar_id ) ) {
			return false;
		}

		if ( 'full-width' == Opt::$layout || '4' == Opt::$single_style ) {
			return false;
		}

		$sidebar_cols = Fns::sidebar_columns();
		?>
		<aside id="sidebar" class="newsfit-widget-area <?php echo esc_attr( $sidebar_cols ); ?>" role="complementary">
			<?php dynamic_sidebar( $sidebar_id ); ?>
		</aside><!-- #sidebar -->
		<?php
	}
}


if ( ! function_exists( 'newsfit_post_class' ) ) {
	/**
	 * Get dynamic article classes
	 *
	 * @return string
	 */
	function newsfit_post_class( $default_class = 'newsfit-post-card' ) {
		$above_meta_style = 'above-' . newsfit_option( 'rt_single_above_meta_style' );
		$post_format      = get_post_meta( get_the_ID(), 'rt_post_format', true );
		$common_class     = $post_format ? 'format-' . $post_format : '';

		if ( is_single() ) {
			$meta_style   = newsfit_option( 'rt_single_meta_style' );
			$post_classes = Fns::class_list( [ $common_class, $meta_style, $above_meta_style ] );
		} else {
			$meta_style   = newsfit_option( 'rt_blog_meta_style' );
			$post_classes = Fns::class_list( [ $common_class, $meta_style, $above_meta_style, Fns::blog_column() ] );
		}

		if ( $default_class ) {
			return $post_classes . ' ' . $default_class;
		}

		return $post_classes;
	}
}

if ( ! function_exists( 'newsfit_separate_meta' ) ) {
	/**
	 * Get above title meta
	 *
	 * @return string
	 */
	function newsfit_separate_meta( $class = '', $includes = [ 'category' ] ) {
		if ( ( ! is_single() && newsfit_option( 'rt_blog_above_meta' ) ) || ( is_single() && newsfit_option( 'rt_single_above_meta' ) ) ) :
			?>
			<div class="separate-meta <?php echo esc_attr( $class ); ?>">
				<?php
				PostMeta::get_meta(
					[
						'with_list' => false,
						'include'   => $includes,
						'with_icon' => false,
					]
				);
				?>
			</div>
			<?php
		endif;
	}
}

if ( ! function_exists( 'newsfit_single_entry_header' ) ) {
	/**
	 * Get above title meta
	 *
	 * @return string
	 */
	function newsfit_single_entry_header() {
		?>
		<header class="entry-header">
			<?php
			newsfit_separate_meta( 'title-above-meta' );

			the_title( '<h1 class="entry-title default-max-width">', '</h1>' );

			if ( ! empty( Fns::single_meta_lists() ) && newsfit_option( 'rt_single_meta' ) ) {
				PostMeta::get_meta(
					[
						'with_list'     => true,
						'include'       => Fns::single_meta_lists(),
						'author_prefix' => newsfit_option( 'rt_author_prefix' ),
						'with_icon'     => newsfit_option( 'rt_single_meta_icon' ),
						'with_avatar'   => newsfit_option( 'rt_single_meta_user_avatar' ),
					]
				);
			}
			?>
		</header>
		<?php
	}
}

if ( ! function_exists( 'newsfit_get_avatar_url' ) ) :
	function newsfit_get_avatar_url( $get_avatar ) {
		preg_match( "/src='(.*?)'/i", $get_avatar, $matches );

		return $matches[1];
	}
endif;


