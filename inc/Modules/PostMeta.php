<?php

namespace RT\Newsfit\Modules;

use RT\Newsfit\Helpers\Fns;

/**
 * PostMeta Class
 */
class PostMeta {

	/**
	 * Get Post Meta
	 *
	 * @param $args
	 *
	 * @return void
	 */
	public static function get_meta( $args ) {
		$default_args = [
			'with_list'     => true,
			'include'       => [],
			'class'         => '',
			'author_prefix' => newsfit_option( 'rt_author_prefix' ),
			'with_icon'     => newsfit_option( 'rt_meta_icon' ),
			'with_avatar'   => newsfit_option( 'rt_meta_user_avatar' ),
			'avatar_size'   => 30,
		];

		$args = wp_parse_args( $args, $default_args );

		$comments_number = get_comments_number();
		/* translators: used comment as singular and plular */
		$comments_text = sprintf( _n( '%s Comment', '%s Comments', $comments_number, 'newsfit' ), number_format_i18n( $comments_number ) );

		$_meta_data = [];
		$output     = '';

		$_meta_data['author']   = self::posted_by( $args['author_prefix'] );
		$_meta_data['date']     = self::posted_on();
		$_meta_data['category'] = self::posted_in();
		$_meta_data['tag']      = self::posted_in( 'tag' );
		$_meta_data['comment']  = esc_html( $comments_text );
		$_meta_data['time']     = Fns::reading_time_count( get_the_content(), true );

		$meta_list = $args['include'] ?? array_keys( $_meta_data );

		if ( $args['with_list'] ) {
			$output .= '<div class="newsfit-post-meta ' . $args['class'] . '"><ul class="entry-meta">';
		}
		foreach ( $meta_list as $key ) {
			$meta = $_meta_data[ $key ];
			if ( ! $meta ) {
				continue;
			}
			$icons = Svg::get_svg( $key, false );

			if ( $args['with_avatar'] && 'author' === $key ) {
				$icons = get_avatar( get_the_author_meta( 'ID' ), $args['avatar_size'], '', 'Avater Image' );
			}

			$output .= ( $args['with_list'] ) ? '<li class="' . $key . '">' : '';
			$output .= '<span class="meta-inner">';
			$output .= $args['with_icon'] ? $icons : null;
			$output .= $meta;
			$output .= '</span>';
			$output .= ( $args['with_list'] ) ? '</li>' : '';
		}

		if ( $args['with_list'] ) {
			$output .= '</ul></div>';
		}

		Fns::print_html_all( $output );
	}


	/**
	 * Get Post Author
	 *
	 * @param $prefix
	 *
	 * @return string
	 */
	public static function posted_by( $prefix = '' ) {

		return sprintf(
		// Translators: %1$s is the prefix, %2$s is the author's byline.
			esc_html__( '%1$s %2$s', 'newsfit' ),
			$prefix ? '<span class="prefix">' . $prefix . '</span>' : '',
			'<span class="byline"><a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" rel="author">' . esc_html( get_the_author() ) . '</a></span>'
		);
	}

	/**
	 * Prints HTML with meta information for the current post-date/time.
	 *
	 * @return string
	 */
	public static function posted_on() {
		$time_string = sprintf(
			'<time class="entry-date published updated" datetime="%1$s">%2$s</time>',
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() )
		);

		return sprintf( '<span class="posted-on">%s</span>', $time_string );
	}

	/**
	 * Get post categories and tags
	 *
	 * @param $type
	 *
	 * @return string
	 */
	public static function posted_in( $type = 'category' ) {
		$categories_list = get_the_category_list( self::list_item_separator() );
		if ( 'tag' === $type ) {
			$categories_list = get_the_tag_list( '', self::list_item_separator() );
		}
		if ( $categories_list ) {
			return sprintf(
				'<span class="%s-links">%s</span>',
				$type,
				$categories_list
			);
		}

		return '';
	}

	/**
	 * List Itesm Separator
	 *
	 * @return string
	 */
	public static function list_item_separator() {
		/* translators: Used between list items, there is a space after the comma. */
		return sprintf(
			"<span class='%s'>%s</span>",
			'sp',
			__( ', ', 'newsfit' )
		);
	}
}
