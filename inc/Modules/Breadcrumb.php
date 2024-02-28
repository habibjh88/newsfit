<?php

namespace RT\Newsfit\Modules;

use RT\Newsfit\Helpers\Fns;

/**
 * PostMeta Class
 */
class Breadcrumb {
	/**
	 * Newsfit breadcrumb
	 *
	 * @return void
	 */
	public static function get_breadcrumb( ) {

		global $wp_query;
		$found_posts = $wp_query->found_posts;

		?>
		<nav aria-label="breadcrumb">
			<ul class="breadcrumb">
				<li class="home-link breadcrumb-item">
					<?php Svg::get_svg( 'home' ); ?>
					<a href="<?php echo esc_url( site_url() ); ?>"><?php esc_html_e( 'Home', 'newsfit' ); ?></a>
					<span class="raquo">/</span>
				</li>
				<li class="breadcrumb-item active" aria-current="page">
					<?php
					if ( is_tag() ) {
						esc_html_e( 'Posts Tagged ', 'newsfit' );
						?>
						<span class="raquo">/</span>
						<span class="title"><?php single_tag_title(); ?></span>
						<?php
					} elseif ( is_day() || is_month() || is_year() ) {
						echo '<span class="title">';
						esc_html_e( 'Posts made in', 'newsfit' );
						echo esc_html( get_the_time( is_year() ? 'Y' : ( is_month() ? 'F, Y' : 'F jS, Y' ) ) );
						echo '</span>';
					} elseif ( is_search() ) {
						echo '<p class="title">';
						esc_html_e( 'Search Results for: ', 'newsfit' );
						the_search_query();
						echo '<span class="description">';
						printf(
							/* translators: 1: Total post count. */
							esc_html( _n( 'Showing %d result for your search', 'Showing %d results for your search', $found_posts, 'newsfit' ) ),
							absint( $found_posts )
						);
						echo '</span>';
						echo '</p>';
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
						the_title();
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
							echo implode( ' <span class="raquo">/</span> ', array_reverse( $tt_taxonomy_links ) ) . ' <span class="raquo">/</span> '; //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
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
						the_title();
						echo '</span>';
					} elseif ( is_home() ) {
						echo '<span class="title">';
						esc_html_e( 'Blog', 'newsfit' );
						echo '</span>';
					} elseif ( class_exists( 'WooCommerce' ) && is_shop() ) {
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
