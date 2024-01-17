<?php
/**
 * Helpers methods
 * List all your static functions you wish to use globally on your theme
 *
 * @package newsfit
 */

use RT\NewsFit\Options\Opt;
use RT\NewsFit\Core\Constants;
use RT\NewsFit\Helpers\Fns;


if ( ! function_exists( 'starts_with' ) ) {
	/**
	 * Determine if a given string starts with a given substring.
	 *
	 * @param string $haystack
	 * @param string|array $needles
	 *
	 * @return bool
	 */
	function starts_with( $haystack, $needles ) {
		foreach ( (array) $needles as $needle ) {
			if ( $needle != '' && substr( $haystack, 0, strlen( $needle ) ) === (string) $needle ) {
				return true;
			}
		}

		return false;
	}
}

if ( ! function_exists( 'mix' ) ) {
	/**
	 * Get the path to a versioned Mix file.
	 *
	 * @param string $path
	 * @param string $manifestDirectory
	 *
	 * @return string
	 *
	 * @throws \Exception
	 */
	function mix( $path, $manifestDirectory = '' ): string {
		if ( ! $manifestDirectory ) {
			//Setup path for standard AWPS-Folder-Structure
			$manifestDirectory = "assets/dist/";
		}
		static $manifest;
		if ( ! starts_with( $path, '/' ) ) {
			$path = "/{$path}";
		}
		if ( $manifestDirectory && ! starts_with( $manifestDirectory, '/' ) ) {
			$manifestDirectory = "/{$manifestDirectory}";
		}
		$rootDir = dirname( __FILE__, 2 );
		if ( file_exists( $rootDir . '/' . $manifestDirectory . '/hot' ) ) {
			return getenv( 'WP_SITEURL' ) . ":8080" . $path;
		}
		if ( ! $manifest ) {
			$manifestPath = $rootDir . $manifestDirectory . 'mix-manifest.json';
			if ( ! file_exists( $manifestPath ) ) {
				throw new Exception( 'The Mix manifest does not exist.' );
			}
			$manifest = json_decode( file_get_contents( $manifestPath ), true );
		}

		if ( starts_with( $manifest[ $path ], '/' ) ) {
			$manifest[ $path ] = ltrim( $manifest[ $path ], '/' );
		}

		$path = $manifestDirectory . $manifest[ $path ];

		return get_template_directory_uri() . $path;
	}
}

function newsfit_html( $html, $checked = true ) {
	$allowed_html = [
		'a'      => [
			'href'   => [],
			'title'  => [],
			'class'  => [],
			'target' => [],
		],
		'br'     => [],
		'span'   => [
			'class' => [],
			'id'    => [],
		],
		'em'     => [],
		'strong' => [],
		'i'      => [
			'class' => []
		],
		'iframe' => [
			'class'                 => [],
			'id'                    => [],
			'name'                  => [],
			'src'                   => [],
			'title'                 => [],
			'frameBorder'           => [],
			'width'                 => [],
			'height'                => [],
			'scrolling'             => [],
			'allowvr'               => [],
			'allow'                 => [],
			'allowFullScreen'       => [],
			'webkitallowfullscreen' => [],
			'mozallowfullscreen'    => [],
			'loading'               => [],
		],
	];

	if ( $checked ) {
		return wp_kses( $html, $allowed_html );
	} else {
		return $html;
	}
}

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
		$menu_text     = sprintf( __( "Add %s Menu", "newsfit" ), $theme_location );
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
		if ( ! empty ( $container ) ) {
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
	 * @return void
	 */
	function newsfit_menu_icons_group() {
		$menu_classes = '';
		if ( newsfit_option( 'rt_header_separator' ) ) {
			$menu_classes = 'has-separator';
		}
		?>
		<ul class="d-flex gap-15 align-items-center <?php echo esc_attr( $menu_classes ) ?>">
			<?php if ( newsfit_option( 'rt_header_bar' ) ) : ?>
				<li>
					<a class="menu-bar trigger-off-canvas" href="#">
						<span></span>
						<span></span>
						<span></span>
					</a>
				</li>
			<?php endif; ?>

			<?php if ( newsfit_option( 'rt_header_search' ) ) : ?>
				<li class="newsfit-search-popup">
					<a class="menu-search-bar newsfit-search-trigger" href="#">
						<?php echo newsfit_get_svg( 'search' ); ?>
					</a>
					<?php get_search_form(); ?>
				</li>
			<?php endif; ?>

			<?php if ( newsfit_option( 'rt_header_login_link' ) ) : ?>
				<li class="newsfit-user-login">
					<a href="<?php echo esc_url( wp_login_url() ) ?>">
						<?php echo newsfit_get_svg( 'user' ); ?>
					</a>
				</li>
			<?php endif; ?>
		</ul>
		<?php
	}
}

if ( ! function_exists( 'newsfit_require' ) ) {
	/**
	 * Require any file. If the file will available in the child theme, the file will load from the child theme
	 *
	 * @param $filename
	 * @param string $dir
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

if ( ! function_exists( 'newsfit_get_svg' ) ) {
	/**
	 * Get svg icon
	 *
	 * @param $name
	 *
	 * @return string|void
	 */
	function newsfit_get_svg( $name ) {
		return Fns::get_svg( $name );
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
	function newsfit_get_file( $path ): string {
		$file = get_stylesheet_directory_uri() . $path;
		if ( ! file_exists( $file ) ) {
			$file = get_template_directory_uri() . $path;
		}

		return $file;
	}
}

if ( ! function_exists( 'newsfit_get_img' ) ) {
	/**
	 * Get Image Path
	 *
	 * @param $filename
	 *
	 * @return string
	 */
	function newsfit_get_img( $filename ): string {
		$path = '/assets/dist/images/' . $filename;

		return newsfit_get_file( $path );
	}
}

if ( ! function_exists( 'newsfit_get_css' ) ) {
	/**
	 * Get CSS Path
	 *
	 * @param $filename
	 *
	 * @return string
	 */
	function newsfit_get_css( $filename ) {
		$path = '/assets/dist/css/' . $filename . '.css';

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
		$path = '/assets/dist/js/' . $filename . '.js';

		return newsfit_get_file( $path );
	}
}

if ( ! function_exists( 'newsfit_maybe_rtl' ) ) {
	/**
	 * Get css path conditionally by RTL
	 *
	 * @param $filename
	 *
	 * @return string
	 */
	function newsfit_maybe_rtl( $filename ) {
		if ( is_rtl() ) {
			$path = '/assets/dist/css-rtl/' . $filename . '.css';

			return newsfit_get_file( $path );
		} else {
			return newsfit_get_file( $filename );
		}
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
	function newsfit_option( $key, $echo = false, $return_type = false ): mixed {
		if ( isset( Opt::$options[ $key ] ) ) {
			if ( $echo ) {
				echo newsfit_html( Opt::$options[ $key ] );
			} else {
				$opt_val = Opt::$options[ $key ];
				if ( $return_type && $opt_val ) {
					$opt_val = explode( ',', trim( $opt_val, ', ' ) );
				}

				return $opt_val;
			}
		}

		return false;
	}
}

if ( ! function_exists( 'newsfit_get_social_html' ) ) {
	/**
	 * Get Social markup
	 *
	 * @param $color
	 *
	 * @return void
	 */

	function newsfit_get_social_html( $color = '' ): void {
		ob_start();
		$icon_style = newsfit_option( 'rt_social_icon_style' ) ?? '';
		foreach ( Fns::get_socials() as $id => $item ) {
			if ( empty( $item['url'] ) ) {
				continue;
			}
			?>
			<a target="_blank" href="<?php echo esc_url( $item['url'] ) ?>">
				<?php echo newsfit_get_svg( $id . $icon_style ); ?>
			</a>
			<?php
		}

		echo ob_get_clean();
	}
}

if ( ! function_exists( 'newsfit_site_logo' ) ) {
	/**
	 * Newfit Site Logo
	 *
	 */
	function newsfit_site_logo() {
		$main_logo       = newsfit_option( 'rt_logo' );
		$logo_light      = newsfit_option( 'rt_logo_light' );
		$logo_mobile     = newsfit_option( 'rt_logo_mobile' );
		$site_logo       = Opt::$has_tr_header ? $logo_light : $main_logo;
		$mobile_logo     = $logo_mobile ?? $site_logo;
		$has_mobile_logo = ! empty( $logo_mobile ) ? 'has-mobile-logo' : '';
		ob_start();
		?>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="<?php echo esc_attr( $has_mobile_logo ) ?>">
			<?php
			if ( ! empty( $site_logo ) ) {
				echo wp_get_attachment_image( $site_logo, 'full', null, [ 'id' => 'rt-site-logo' ] );
				if ( ! empty( $mobile_logo ) ) {
					echo wp_get_attachment_image( $mobile_logo, 'full', null, [ 'id' => 'rt-mobile-logo' ] );
				}
			} else {
				bloginfo( 'name' );
			}
			?>
		</a>
		<?php
		return ob_get_clean();
	}
}

if ( ! function_exists( 'newsfit_footer_logo' ) ) {
	/**
	 * Newfit Site Logo
	 *
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

if ( ! function_exists( 'newsfit_classes' ) ) {
	/**
	 * Merge all classes
	 *
	 * @param $clsses
	 *
	 * @return string
	 */
	function newsfit_classes( $clsses ): string {
		return implode( ' ', $clsses );
	}
}

if ( ! function_exists( 'newsfit_scroll_top' ) ) {
	/**
	 * Back-to-top button
	 * @return void
	 */
	function newsfit_scroll_top( $class = '', $icon = 'scroll-top' ): void {
		if ( newsfit_option( 'rt_back_to_top' ) ) {
			?>
			<a href="#" class="scrollToTop <?php echo esc_attr( $class ) ?>">
				<?php echo newsfit_get_svg( $icon ); ?>
			</a>
			<?php
		}
	}
}


if ( ! function_exists( 'newsfit_post_meta' ) ) {
	/**
	 * Get post meta
	 *
	 * @return string
	 */
	function newsfit_post_meta( $args ) {
		$default_args = [
			'with_list'     => true,
			'include'       => [],
			'edit_link'     => false,
			'class'         => '',
			'author_prefix' => __( 'By', 'newsfit' )
		];

		$args = wp_parse_args( $args, $default_args );

		$comments_number = get_comments_number();
		$comments_text   = sprintf( _n( '%s Comment', '%s Comments', $comments_number, 'newsfit' ), number_format_i18n( $comments_number ) );

		$_meta_data = [];
		$output     = '';

		$_meta_data['author']   = Fns::posted_by( $args['author_prefix'] );
		$_meta_data['date']     = Fns::posted_on();
		$_meta_data['category'] = Fns::posted_in();
		$_meta_data['tag']      = Fns::posted_in( 'tag' );
		$_meta_data['comment']  = esc_html( $comments_text );

		$meta_list = $args['include'] ?? array_keys( $_meta_data );

		ob_start();
		edit_post_link( 'Edit' );
		$edit_markup = ob_get_clean();

		if ( $args['with_list'] ) {
			$output .= '<div class="newsfit-post-meta ' . $args['class'] . '"><ul class="entry-meta">';
		}
		foreach ( $meta_list as $key ) {
			$meta = $_meta_data[ $key ];
			if ( ! $meta ) {
				continue;
			}
			$output .= ( $args['with_list'] ) ? '<li class="' . $key . '">' : '';
			$output .= $meta;
			$output .= ( $args['with_list'] ) ? '</li>' : '';
		}

		if ( $args['edit_link'] && is_user_logged_in() && $edit_markup ) {
			$output .= '<li class="edit-link">' . $edit_markup . '</li>';
		}

		if ( $args['with_list'] ) {
			$output .= '</ul></div>';
		}

		return $output;
	}
}

if ( ! function_exists( 'newsfit_blog_column' ) ) {
	function newsfit_blog_column( $blog_col = 'col-lg-6' ) {
		$colum_from_customize = newsfit_option( 'newsfit_blog_column' );

		if ( 'default' == $colum_from_customize && 'full-width' === Opt::$layout ) {
			$blog_col = 'col-lg-4';
		} elseif ( 'default' !== $colum_from_customize ) {
			$blog_col = $colum_from_customize;
		}

		return $blog_col;
	}
}


if ( ! function_exists( 'newsfit_post_thumbnail' ) ) {
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 *
	 * @return html
	 */
	function newsfit_post_thumbnail() {
		if ( ! Fns::can_show_post_thumbnail() ) {
			return;
		}
		?>

		<?php if ( is_singular() ) : ?>

			<figure class="post-thumbnail">
				<?php
				// Lazy-loading attributes should be skipped for thumbnails since they are immediately in the viewport.
				the_post_thumbnail( 'post-thumbnail', [ 'loading' => false ] );
				?>
				<?php if ( wp_get_attachment_caption( get_post_thumbnail_id() ) ) : ?>
					<figcaption class="wp-caption-text"><?php echo wp_kses_post( wp_get_attachment_caption( get_post_thumbnail_id() ) ); ?></figcaption>
				<?php endif; ?>
			</figure><!-- .post-thumbnail -->

		<?php else : ?>

			<figure class="post-thumbnail">
				<a class="post-thumbnail-inner alignwide" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
					<?php the_post_thumbnail( 'post-thumbnail' ); ?>
				</a>
				<?php if ( wp_get_attachment_caption( get_post_thumbnail_id() ) ) : ?>
					<figcaption class="wp-caption-text"><?php echo wp_kses_post( wp_get_attachment_caption( get_post_thumbnail_id() ) ); ?></figcaption>
				<?php endif; ?>
			</figure><!-- .post-thumbnail -->

		<?php endif; ?>
		<?php
	}
}

if ( ! function_exists( 'newsfit_entry_footer' ) ) {
	/**
	 * NewsFit Entry Footer
	 *
	 * @return void
	 *
	 */
	function newsfit_entry_footer() {
		if ( ! is_single() ) {
			echo '<a class="read-more" href="' . esc_url( get_permalink() ) . '">' . Fns::continue_reading_text() . '</a>'; // phpcs:ignore WordPress.Security.EscapeOutput
		} else {
			if ( 'post' !== get_post_type() && has_tag() ) {
				echo '<div class="post-tags">';
				echo Fns::posted_in( 'tag' );
				echo '</div>';
			}
		}
	}
}

if ( ! function_exists( 'newsfit_entry_content' ) ) {
	/**
	 * Entry Content
	 * @return void
	 */
	function newsfit_entry_content() {
		if ( ! is_single() ) {
			$length = newsfit_option( 'newsfit_excerpt_limit' );
			echo wp_trim_words( get_the_excerpt(), $length );
		} else {
			the_content();
		}
	}
}


function newsfit_layout() {
	return Opt::$layout;
}

function newsfit_content_columns() {

	$columns = "col-md-8";

	if ( is_singular() ) {
		if ( is_active_sidebar( 'rt-single-sidebar' ) ) {
			$columns = "col-md-8";
		} else {
			$columns = "col-md-10 col-md-offset-1";
		}
	} else {
		if ( ! is_active_sidebar( 'rt-sidebar' ) ) {
			$columns = "col-md-12";
		}
	}

	if ( Opt::$layout === 'full-width' ) {
		$columns = is_singular() ? "col-md-10 col-md-offset-1" : "col-md-12";
	}

	return $columns;
}

if ( ! function_exists( 'newsfit_sidebar_columns' ) ) {
	/**
	 * Get sidebar column conditionally
	 * @return string
	 */
	function newsfit_sidebar_columns() {
		$columns = "col-md-4";

		return $columns;
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

		if ( Opt::$layout == 'full-width' ) {
			return false;
		}

		$sidebar_cols = newsfit_sidebar_columns();
		?>
		<aside id="sidebar" class="newsfit-widget-area <?php echo esc_attr( $sidebar_cols ) ?>" role="complementary">
			<?php dynamic_sidebar( $sidebar_id ); ?>
		</aside><!-- #sidebar -->
		<?php
	}
}
