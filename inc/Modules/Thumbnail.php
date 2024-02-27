<?php

namespace RT\Newsfit\Modules;

use RT\Newsfit\Modules\Svg;
use RT\Newsfit\Helpers\Fns;

/**
 * Thumbnail Class
 */
class Thumbnail {

	/**
	 * Get Thumbnail Markup
	 *
	 * @param $size
	 * @param $single
	 *
	 * @return void
	 */
	public static function get_thumbnail( $size = 'full', $single = false ) {
		$post_format = get_post_meta( get_the_ID(), 'rt_post_format', 'true' );

		switch ( $post_format ) {
			case 'video':
			case 'audio':
				self::video_thumbnail( $size, $single, $post_format );
				break;
			case 'gallery':
				self::gallery_thumbnail( $size, $single, $post_format );
				break;
			default:
				self::default_thumbnail( $size, $single, $post_format );
		}
	}


	/**
	 * Gallery Thumbnail
	 *
	 * @param $size
	 * @param $single
	 * @param $post_format
	 *
	 * @return void
	 */
	public static function gallery_thumbnail( $size, $single, $post_format ) {

		$gallery_meta = get_post_meta( get_the_ID(), 'rt_gallery', 'true' );
		$gallery_ids  = explode( ',', $gallery_meta );
		$thumb_id     = get_post_thumbnail_id( get_the_ID() );
		if ( $thumb_id ) {
			array_unshift( $gallery_ids, $thumb_id );
		}
		$gallery_ids = array_unique( $gallery_ids );
		if ( ! $gallery_ids ) {
			self::default_thumbnail( $size, $single, $post_format );

			return;
		}

		$dataSlick = [
			'dots'           => false,
			'arrows'         => true,
			'fade'           => false,
			'speed'          => 700,
			'autoplay'       => true,
			'autoplaySpeed'  => 1500,
			'adaptiveHeight' => (bool) $single,
		];
		$classes   = Fns::class_list(
			[
				'thumbnail-' . ( $post_format ?: 'standard' ),
				'post-' . ( $single ? 'single' : 'grid' ),
			]
		)
		?>
		<div class="post-thumbnail-wrap <?php echo esc_attr( $classes ); ?> ">
			<figure class="post-thumbnail">
				<?php
				if ( ! $single ) {
					the_post_thumbnail( $size, [ 'loading' => 'lazy' ] );
				}
				?>
				<div class="rt-slick rt-carousel" data-slick="<?php echo esc_attr( htmlspecialchars( wp_json_encode( $dataSlick ) ) ); ?>">
					<?php foreach ( $gallery_ids as $id ) : ?>
						<div class="item">
							<?php if ( ! $single ) : ?>
							<a class="post-thumb-link alignwide" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
								<?php endif; ?>
								<?php echo wp_get_attachment_image( $id, $size, [ 'loading' => 'lazy' ] ); ?>
								<?php if ( ! $single ) : ?>
							</a>
						<?php endif; ?>
						</div>
					<?php endforeach; ?>
				</div>
			</figure><!-- .post-thumbnail -->
			<?php
			if ( $single ) {
				self::thumb_description();
			}
			?>
		</div>
		<?php
	}

	/**
	 * Video Thumbnail
	 *
	 * @param $size
	 * @param $single
	 * @param $post_format
	 *
	 * @return void
	 */
	public static function video_thumbnail( $size, $single, $post_format ) {

		if ( 'video' === $post_format ) {
			$media_url  = get_post_meta( get_the_ID(), 'rt_video_url', 'true' );
			$media_icon = 'play';
		} else {
			$media_url  = get_post_meta( get_the_ID(), 'rt_audio_url', 'true' );
			$media_icon = 'audio';
		}
		$classes = Fns::class_list(
			[
				'thumbnail-' . ( $post_format ?: 'standard' ),
				'post-' . ( $single ? 'single' : 'grid' ),
			]
		)
		?>
		<div class="post-thumbnail-wrap <?php echo esc_attr( $classes ); ?>">
			<figure class="post-thumbnail">

				<?php
				if ( has_post_thumbnail() ) {
					the_post_thumbnail( $size, [ 'loading' => 'lazy' ] );
					?>
					<a class="rt-popup-video" href="<?php echo esc_url( $media_url ); ?>">
						<?php Svg::get_svg( $media_icon ); ?>
					</a>
					<?php
				} else {
					echo "<div class='video-wrapper'>";
					if ( strpos( $media_url, '.mp4' ) ) {
						?>
						<video controls>
							<source src="<?php echo esc_url( $media_url ); ?>" type="video/mp4">
						</video>
						<?php
					} elseif ( strpos( $media_url, '.mp3' ) ) {
						?>
						<audio controls>
							<source src="<?php echo esc_url( $media_url ); ?>" type="audio/mpeg">
						</audio>
						<?php
					} else {
						Fns::print_html_all( wp_oembed_get( $media_url ) );
					}
					echo '</div>';
				}
				?>
				<?php if ( ! $single && ! $media_url ) : ?>
					<a class="post-thumb-link alignwide" href="<?php echo esc_url( $media_url ); ?>" aria-hidden="true" tabindex="-1"></a>
				<?php endif; ?>
				<?php edit_post_link( 'Edit' ); ?>
			</figure><!-- .post-thumbnail -->
			<?php
			if ( $single ) {
				self::thumb_description();
			}
			?>
		</div>
		<?php
	}

	/**
	 * Default thumbnail
	 *
	 * @param $size
	 * @param $single
	 * @param $post_format
	 *
	 * @return void
	 */
	public static function default_thumbnail( $size, $single, $post_format ) {
		if ( ! has_post_thumbnail() ) {
			return;
		}
		$classes = Fns::class_list(
			[
				'thumbnail-' . ( $post_format ?: 'standard' ),
				'post-' . ( $single ? 'single' : 'grid' ),
			]
		)
		?>
		<div class="post-thumbnail-wrap <?php echo esc_attr( $classes ); ?>">
			<figure class="post-thumbnail">
				<?php if ( ! $single ) : ?>
				<a class="post-thumb-link alignwide" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
					<?php endif; ?>
					<?php the_post_thumbnail( $size, [ 'loading' => 'lazy' ] ); ?>
					<?php if ( ! $single ) : ?>
				</a>
			<?php endif; ?>
				<?php edit_post_link( 'Edit' ); ?>
			</figure><!-- .post-thumbnail -->
			<?php
			if ( $single ) {
				self::thumb_description();
			}
			?>
		</div>
		<?php
	}


	/**
	 * Thumbnail Descriptions
	 *
	 * @return void
	 */
	public static function thumb_description() {
		if ( wp_get_attachment_caption( get_post_thumbnail_id() ) && is_single() ) :
			?>
			<figcaption class="wp-caption-text">
				<?php Svg::get_svg( 'camera' ); ?>
				<span><?php Fns::print_html( wp_get_attachment_caption( get_post_thumbnail_id() ) ); ?></span>
			</figcaption>
			<?php
		endif;
	}
}
