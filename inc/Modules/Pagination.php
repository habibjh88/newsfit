<?php

namespace RT\Newsfit\Modules;

/**
 * Pagination Class
 */
class Pagination {

	/**
	 * Get pagination markup
	 *
	 * @param $query
	 *
	 * @return void
	 */
	public static function get_pagination( $query = null ) {
		if ( $query ) {
			$wp_query = $query;
		} else {
			global $wp_query;
		}

		$max_num_pages = $max_num_pages ?? false;

		$max = $max_num_pages ?: $wp_query->max_num_pages;
		$max = intval( $max );

		/** Stop execution if there's only 1 page */
		if ( $max <= 1 ) {
			return;
		}

		if ( get_query_var( 'paged' ) ) {
			$paged = get_query_var( 'paged' );
		} elseif ( get_query_var( 'page' ) ) {
			$paged = get_query_var( 'page' );
		} else {
			$paged = 1;
		}

		/**    Add current page to the array */
		if ( $paged >= 1 ) {
			$links[] = $paged;
		}

		/**    Add the pages around the current page to the array */
		if ( $paged >= 3 ) {
			$links[] = $paged - 1;
			$links[] = $paged - 2;
		}

		if ( ( $paged + 2 ) <= $max ) {
			$links[] = $paged + 2;
			$links[] = $paged + 1;
		}

		$previous_text = Svg::get_svg( 'arrow-right', false, '180' );
		$next_text     = Svg::get_svg( 'arrow-right', false );

		echo '<div class="newsfit-pagination"><ul class="clearfix">' . "\n";

		/**    Previous Post Link */
		$previous_posts_link = get_previous_posts_link( $previous_text );
		if ( $previous_posts_link ) {
			printf( '<li class="pagi-previous">%s</li>' . "\n", $previous_posts_link ); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}

		/**    Link to first page, plus ellipses if necessary */
		if ( ! in_array( 1, $links ) ) {
			$class = 1 == $paged ? ' class="active"' : '';

			printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' ); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

			if ( ! in_array( 2, $links ) ) {
				echo '<li><span>...</span></li>';
			}
		}

		/**    Link to current page, plus 2 pages in either direction if necessary */
		sort( $links );
		foreach ( (array) $links as $link ) {
			$class = $paged == $link ? ' class="active"' : '';
			printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link ); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}

		/**    Link to last page, plus ellipses if necessary */
		if ( ! in_array( $max, $links ) ) {
			if ( ! in_array( $max - 1, $links ) ) {
				echo '<li><span>...</span></li>' . "\n";
			}

			$class = $paged == $max ? ' class="active"' : '';
			printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max ); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}

		/**    Next Post Link */
		$next_posts_link = get_next_posts_link( $next_text, $max );
		if ( $next_posts_link ) {
			printf( '<li class="pagi-next">%s</li>' . "\n", $next_posts_link ); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}

		echo '</ul></div>' . "\n";
	}
}
