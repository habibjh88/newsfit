<?php

namespace RT\Newsfit\Modules;

use RT\Newsfit\Helpers\Fns;

/**
 * Comments Class
 */
class Comments {

	public static function callback( $comment, $args, $depth ) {

		// Get correct tag used for the comments
		if ( 'div' === $args['style'] ) {
			$tag       = 'div ';
			$add_below = 'comment';
		} else {
			$tag       = 'li ';
			$add_below = 'div-comment';
		}
		?>

		<<?php echo $tag; ?><?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?> id="comment-<?php comment_ID(); ?>">
		<?php
		// Switch between different comment types
		switch ( $comment->comment_type ) :
			case 'pingback':
			case 'trackback':
				?>
				<div class="pingback-entry"><span class="pingback-heading"><?php esc_html_e( 'Pingback:', 'newsfit' ); ?></span> <?php comment_author_link(); ?></div>
				<?php
				break;
			default:
				if ( 'div' != $args['style'] ) {
					?>
					<div id="div-comment-<?php comment_ID(); ?>" class="comment-body">
				<?php } ?>
				<div class="comment-author">
					<div class="vcard">
						<?php
						if ( 0 != $args['avatar_size'] ) {
							$avatar_size = ! empty( $args['avatar_size'] ) ? $args['avatar_size'] : 70; // set default avatar size.
							echo get_avatar( $comment, $avatar_size );
						}
						?>
					</div>
					<div class="author-info">
						<cite class="fn"><?php echo get_comment_author_link(); ?></cite>
						<div class="comment-meta commentmetadata">
							<a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>">
								<?php
								/* translators: 1: date, 2: time */
								printf(
									__( '%1$s at %2$s', 'newsfit' ),
									get_comment_date(),
									get_comment_time()
								);
								?>
							</a>
							<?php
							edit_comment_link( __( 'Edit', 'newsfit' ), '  ', '' );
							?>
						</div><!-- .comment-meta -->
					</div>

				</div><!-- .comment-author -->
				<div class="comment-details">

					<div class="comment-text"><?php comment_text(); ?></div><!-- .comment-text -->
					<?php
					// Display comment moderation text
					if ( $comment->comment_approved == '0' ) {
						?>
						<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'newsfit' ); ?></em><br/>
						<?php
					}
					?>

					<?php
					$icon = Svg::get_svg( 'share', false );
					// Display comment reply link
					comment_reply_link(
						array_merge(
							$args,
							[
								'add_below'  => $add_below,
								'depth'      => $depth,
								'max_depth'  => $args['max_depth'],
								'reply_text' => $icon . __( 'Reply', 'newsfit' ),
							]
						)
					);
					?>

				</div><!-- .comment-details -->
				<?php
				if ( 'div' != $args['style'] ) {
					?>
					</div>
					<?php
				}
				// IMPORTANT: Note that we do NOT close the opening tag, WordPress does this for us
				break;
		endswitch; // End comment_type check.
	}
}
