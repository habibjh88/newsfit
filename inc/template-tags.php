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
	function newsfit_get_svg( $name, $rotate = '' ) {
		return Fns::get_svg( $name, $rotate );
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
	function newsfit_option( $key, $echo = false, $return_array = false ): mixed {
		if ( isset( Opt::$options[ $key ] ) ) {
			if ( $echo ) {
				echo newsfit_html( Opt::$options[ $key ] );
			} else {
				$opt_val = Opt::$options[ $key ];
				if ( $return_array && $opt_val ) {
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
	function newsfit_site_logo( $with_h1 = false ) {
		$main_logo       = newsfit_option( 'rt_logo' );
		$logo_light      = newsfit_option( 'rt_logo_light' );
		$logo_mobile     = newsfit_option( 'rt_logo_mobile' );
		$site_logo       = Opt::$has_tr_header ? $logo_light : $main_logo;
		$mobile_logo     = $logo_mobile ?? $site_logo;
		$has_mobile_logo = ! empty( $logo_mobile ) ? 'has-mobile-logo' : '';
		ob_start();

		if ( $with_h1 ) {
			echo '<h1 class="site-title">';
		}
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
		if ( $with_h1 ) {
			echo '</h1>';
		}

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

		if ( $args['with_list'] ) {
			$output .= '</ul></div>';
		}

		return $output;
	}
}


if ( ! function_exists( 'newsfit_post_thumbnail' ) ) {
	/**
	 * Displays post thumbnail.
	 * @return void
	 */
	function newsfit_post_thumbnail() {
		if ( ! Fns::can_show_post_thumbnail() ) {
			return;
		}
		?>
		<div class="post-thumbnail-wrap">
			<figure class="post-thumbnail">
				<a class="post-thumb-link alignwide" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
					<?php the_post_thumbnail( 'newsfit-500-500', [ 'loading' => 'lazy' ] ); ?>
				</a>
				<?php edit_post_link( 'Edit' ); ?>
			</figure><!-- .post-thumbnail -->
		</div>
		<?php
	}
}

if ( ! function_exists( 'newsfit_post_single_thumbnail' ) ) {
	/**
	 * Display post details thumbnail
	 * @return void
	 */
	function newsfit_post_single_thumbnail() {
		if ( ! Fns::can_show_post_thumbnail() ) {
			return;
		}
		?>
		<div class="post-thumbnail-wrap">
			<figure class="post-thumbnail">
				<?php the_post_thumbnail( 'full', [ 'loading' => true ] ); ?>
				<?php edit_post_link( 'Edit' ); ?>
			</figure><!-- .post-thumbnail -->
			<?php if ( wp_get_attachment_caption( get_post_thumbnail_id() ) ) : ?>
				<figcaption class="wp-caption-text">
					<span><?php echo wp_kses_post( wp_get_attachment_caption( get_post_thumbnail_id() ) ); ?></span>
				</figcaption>
			<?php endif; ?>
		</div>
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
			if ( newsfit_option( 'rt_blog_footer_visibility' ) ) { ?>
				<footer class="entry-footer">
				<a class="read-more" href="<?php echo esc_url( get_permalink() ) ?>"><?php echo Fns::continue_reading_text() ?></a>
				</footer><?php
			}
		} else {
			if ( 'post' === get_post_type() && has_tag() ) { ?>
				<footer class="entry-footer">
					<div class="post-tags">
						<?php if ( $tags_label = newsfit_option( 'rt_tags' ) ) {
							printf( "<span>%s</span>", esc_html( $tags_label ) );
						} ?>
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

		if ( Opt::$layout == 'full-width' || Opt::$single_style == '4' ) {
			return false;
		}

		$sidebar_cols = Fns::sidebar_columns();
		?>
		<aside id="sidebar" class="newsfit-widget-area <?php echo esc_attr( $sidebar_cols ) ?>" role="complementary">
			<?php dynamic_sidebar( $sidebar_id ); ?>
		</aside><!-- #sidebar -->
		<?php
	}
}

if ( ! function_exists( 'newsfit_post_class' ) ) {
	/**
	 * Get dynamic article classes
	 * @return string
	 */
	function newsfit_post_class( $default_class = 'newsfit-post-card' ) {
		$above_meta_style = 'above-' . newsfit_option( 'rt_single_above_meta_style' );

		if ( is_single() ) {
			$meta_style   = newsfit_option( 'rt_single_meta_style' );
			$post_classes = newsfit_classes( [ $meta_style, $above_meta_style ] );
		} else {
			$meta_style   = newsfit_option( 'rt_blog_meta_style' );
			$post_classes = newsfit_classes( [ $meta_style, $above_meta_style, Fns::blog_column() ] );
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
	 * @return string
	 */
	function newsfit_separate_meta( $class = '', $includes = [ 'category' ] ) {
		if ( ( ! is_single() && newsfit_option( 'rt_blog_above_cat_visibility' ) ) || ( is_single() && newsfit_option( 'rt_single_above_cat_visibility' ) ) ) : ?>
		<div class="separate-meta <?php echo esc_attr( $class ) ?>">
			<?php echo newsfit_post_meta( [
				'with_list' => false,
				'include'   => $includes,
			] ); ?>
			</div><?php
		endif;
	}
}

if ( ! function_exists( 'newsfit_single_entry_header' ) ) {
	/**
	 * Get above title meta
	 * @return string
	 */
	function newsfit_single_entry_header() {
		?>
		<header class="entry-header">
			<?php
			newsfit_separate_meta( 'title-above-meta' );

			the_title( '<h1 class="entry-title default-max-width">', '</h1>' );

			if ( ! empty( Fns::single_meta_lists() ) && newsfit_option( 'rt_single_meta_visibility' ) ) {
				echo newsfit_post_meta( [
					'with_list'     => true,
					'include'       => Fns::single_meta_lists(),
					'author_prefix' => newsfit_option( 'rt_author_prefix' ),
				] );
			}
			?>
		</header>
		<?php
	}
}

if ( ! function_exists( 'newsfit_breadcrumb' ) ) {
	/**
	 * Newsfit breadcrumb
	 * @return void
	 */
	function newsfit_breadcrumb() {
		?>
		<nav aria-label="breadcrumb">
			<ul class="breadcrumb">
				<li class="breadcrumb-item">
					<?php echo newsfit_get_svg( 'home' ); ?>
					<a href="<?php echo esc_url( site_url() ); ?>"><?php esc_html_e( 'Home', 'newsfit' ) ?></a>
					<span class="raquo">/</span>
				</li>
				<li class="breadcrumb-item active" aria-current="page">
					<?php
					if ( is_tag() ) {
						esc_html_e( 'Posts Tagged ', 'newsfit' );
						?><span class="raquo">/</span>
						<span class="title"><?php single_tag_title(); ?></span>
						<?php

					} elseif ( is_day() || is_month() || is_year() ) {
						echo '<span class="title">';
						esc_html_e( 'Posts made in', 'newsfit' );
						echo esc_html( get_the_time( is_year() ? 'Y' : ( is_month() ? 'F, Y' : 'F jS, Y' ) ) );
						echo '</span>';
					} elseif ( is_search() ) {
						echo '<span class="title">';
						esc_html_e( 'Search results for', 'newsfit' );
						the_search_query();
						echo '</span>';
					} elseif ( is_404() ) {
						echo '<span class="title">';
						esc_html_e( '404', 'newsfit' );
						echo '</span>';
					} elseif ( is_single() ) {
						$category = get_the_category();
						if ( $category ) {
							$catlink = get_category_link( $category[0]->cat_ID );
							echo '<a href="' . esc_url( $catlink ) . '">' . esc_html( $category[0]->cat_name ) . '</a> <span class="raquo"> /</span> ';
						}
						echo '<span class="title">';
						echo get_the_title();
						echo '</span>';
					} elseif ( is_category() ) {
						echo '<span class="title">';
						single_cat_title();
						echo '</span>';
					} elseif ( is_tax() ) {
						$tt_taxonomy_links = [];
						$tt_term           = get_queried_object();
						$tt_term_parent_id = $tt_term->parent;
						$tt_term_taxonomy  = $tt_term->taxonomy;

						while ( $tt_term_parent_id ) {
							$tt_current_term     = get_term( $tt_term_parent_id, $tt_term_taxonomy );
							$tt_taxonomy_links[] = '<a href="' . esc_url( get_term_link( $tt_current_term, $tt_term_taxonomy ) ) . '" title="' . esc_attr( $tt_current_term->name ) . '">' . esc_html( $tt_current_term->name ) . '</a>';
							$tt_term_parent_id   = $tt_current_term->parent;
						}

						if ( ! empty( $tt_taxonomy_links ) ) {
							echo implode( ' <span class="raquo">/</span> ', array_reverse( $tt_taxonomy_links ) ) . ' <span class="raquo">/</span> ';
						}

						echo '<span class="title">';
						echo esc_html( $tt_term->name );
						echo '</span>';
					} elseif ( is_author() ) {
						global $wp_query;
						$current_author = $wp_query->get_queried_object();

						echo '<span class="title">';
						esc_html_e( 'Posts by: ', 'newsfit' );
						echo ' ', esc_html( $current_author->nickname );
						echo '</span>';
					} elseif ( is_page() ) {
						echo '<span class="title">';
						echo get_the_title();
						echo '</span>';
					} elseif ( is_home() ) {
						echo '<span class="title">';
						esc_html_e( 'Blog', 'newsfit' );
						echo '</span>';
					} elseif ( class_exists( 'WooCommerce' ) and is_shop() ) {
						echo '<span class="title">';
						esc_html_e( 'Shop', 'newsfit' );
						echo '</span>';
					}
					?>
				</li>
			</ul>
		</nav>
		<?php
	}
}

if ( ! function_exists( 'newsfit_get_avatar_url' ) ) :
	function newsfit_get_avatar_url( $get_avatar ) {
		preg_match( "/src='(.*?)'/i", $get_avatar, $matches );

		return $matches[1];
	}
endif;


function newsfit_comments_cbf( $comment, $args, $depth ) {

	// Get correct tag used for the comments
	if ( 'div' === $args['style'] ) {
		$tag       = 'div ';
		$add_below = 'comment';
	} else {
		$tag       = 'li ';
		$add_below = 'div-comment';
	} ?>

	<<?php echo $tag; ?><?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?> id="comment-<?php comment_ID() ?>">

	<?php
	// Switch between different comment types
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' : ?>
			<div class="pingback-entry"><span class="pingback-heading"><?php esc_html_e( 'Pingback:', 'newsfit' ); ?></span> <?php comment_author_link(); ?></div>
			<?php
			break;
		default :

			if ( 'div' != $args['style'] ) { ?>
				<div id="div-comment-<?php comment_ID() ?>" class="comment-body">
			<?php } ?>
			<div class="comment-author">
				<div class="vcard">
					<?php
					// Display avatar unless size is set to 0
					if ( $args['avatar_size'] != 0 ) {
						$avatar_size = ! empty( $args['avatar_size'] ) ? $args['avatar_size'] : 70; // set default avatar size
						echo get_avatar( $comment, $avatar_size );
					} ?>
				</div>
				<div class="author-info">
					<?php
					// Display author name
					printf( __( '<cite class="fn">%s</cite>', 'newsfit' ), get_comment_author_link() ); ?>

					<div class="comment-meta commentmetadata">
						<a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>"><?php
							/* translators: 1: date, 2: time */
							printf(
								__( '%1$s at %2$s', 'newsfit' ),
								get_comment_date(),
								get_comment_time()
							); ?>
						</a><?php
						edit_comment_link( __( 'Edit', 'newsfit' ), '  ', '' ); ?>
					</div><!-- .comment-meta -->
				</div>

			</div><!-- .comment-author -->
			<div class="comment-details">

				<div class="comment-text"><?php comment_text(); ?></div><!-- .comment-text -->
				<?php
				// Display comment moderation text
				if ( $comment->comment_approved == '0' ) { ?>
					<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'newsfit' ); ?></em><br/><?php
				} ?>

				<?php
				$icon = newsfit_get_svg( 'share' );
				// Display comment reply link
				comment_reply_link( array_merge( $args, [
					'add_below'  => $add_below,
					'depth'      => $depth,
					'max_depth'  => $args['max_depth'],
					'reply_text' => $icon . __( 'Reply', 'newsfit' )
				] ) ); ?>

			</div><!-- .comment-details -->
			<?php
			if ( 'div' != $args['style'] ) { ?>
				</div>
			<?php }
			// IMPORTANT: Note that we do NOT close the opening tag, WordPress does this for us
			break;
	endswitch; // End comment_type check.
}
