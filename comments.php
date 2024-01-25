<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package newsfit
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */

if ( post_password_required() ) {
	return;
}

/**
 * Comment List
 */
?>

<?php if ( have_comments() ): ?>
	<?php
	$comments_number = get_comments_number();
	$comments_text   = $comments_number == 1 ? esc_html__( 'Comment', 'homlisti' ) : esc_html__( 'Comments', 'homlisti' );
	$comments_html   = number_format_i18n( $comments_number ) . ' ' . $comments_text;
	$has_avatar      = get_option( 'show_avatars' );
	$comment_class   = $has_avatar ? ' avatar-disabled' : '';
	$comment_args    = [
		'callback'    => 'radiustheme\HomListi\Helper::comments_callback',
		'reply_text'  => esc_html__( 'Reply', 'homlisti' ),
		'avatar_size' => 70,
	];
	?>

	<div class="block-content mt-30 blog-comment">
		<div class="widget-heading"><h3 class="heading-title"><?php echo esc_html( $comments_html ); ?></h3></div>
		<div class="comment-box">
			<ul class="comment-list<?php echo esc_attr( $comment_class ); ?>">
				<?php wp_list_comments( $comment_args ); ?>
			</ul>
			<?php the_comments_navigation(); ?>

			<?php if ( ! comments_open() ) : ?>
				<div class="comments-closed"><?php esc_html_e( 'Comments are closed.', 'homlisti' ); ?></div>
			<?php endif; ?>
		</div>
	</div>
<?php endif; ?>


<?php
/**
 * Comment Form
 */

$rdtheme_commenter = wp_get_current_commenter();
$rdtheme_req       = get_option( 'require_name_email' );
$rdtheme_aria_req  = ( $rdtheme_req ? " required" : '' );

$comment_form_fields = [
	'author' =>
		'<div class="row gutters-20"><div class="col-lg-6 form-group"><input type="text" id="author" name="author" value="' . esc_attr( $rdtheme_commenter['comment_author'] )
		. '" placeholder="' . esc_attr__( 'Name', 'homlisti' ) . ( $rdtheme_req ? ' *' : '' ) . '" class="form-control"' . $rdtheme_aria_req . '></div>',

	'email' =>
		'<div class="col-lg-6 form-group"><input id="email" name="email" type="email" value="' . esc_attr( $rdtheme_commenter['comment_author_email'] )
		. '" class="form-control" placeholder="' . esc_attr__( 'Email', 'homlisti' ) . ( $rdtheme_req ? ' *' : '' ) . '"' . $rdtheme_aria_req . '></div></div>',
];

$comment_form_args = [
	'class_submit'  => 'submit-btn',
	'submit_field'  => '<div class="form-group submit-button">%1$s %2$s</div>',
	'comment_field' => '<div class="form-group"><textarea id="comment" name="comment" required placeholder="' . esc_attr__( 'Comment *', 'homlisti' )
					   . '" class="form-control textarea" rows="10" cols="40"></textarea></div>',
	'fields'        => apply_filters( 'comment_form_default_fields', $comment_form_fields ),
];
?>

<?php if ( comments_open() ): ?>
	<div class="content-block-gap"></div>
	<div class="block-content blog-form">
		<div class="widget-box">
			<?php comment_form( $comment_form_args ); ?>
		</div>
	</div>
<?php endif; ?>
