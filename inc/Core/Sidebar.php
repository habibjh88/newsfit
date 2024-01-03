<?php

namespace RT\NewsFit\Core;

use RT\NewsFit\Traits\SingletonTraits;

/**
 * Sidebar.
 */
class Sidebar {
	use SingletonTraits;

	/**
	 * register default hooks and actions for WordPress
	 * @return
	 */
	public function __construct() {
		add_action( 'widgets_init', [ $this, 'widgets_init' ] );

		//Add input fields(priority 5, 3 parameters)
		add_action( 'in_widget_form', [ $this, 'newsfit_in_widget_form' ], 5, 3 );
		//Callback function for options update (priorität 5, 3 parameters)
		add_filter( 'widget_update_callback', [ $this, 'newsfit_in_widget_form_update' ], 5, 3 );
		//add class names (default priority, one parameter)
		add_filter( 'dynamic_sidebar_params', [ $this, 'newsfit_dynamic_sidebar_params' ] );
	}

	/*
		Define the sidebar
	*/
	public function widgets_init() {

		foreach ( Constants::$sidebar as $id => $sidebar ) {
			$description = sprintf( esc_html_x( '%s to add all your widgets.', 'Widget Description', 'newsfit' ), $sidebar['name'] );
			if ( ! empty( $sidebar['description'] ) ) {
				$description = sprintf( esc_html_x( '%s', 'Widget Description', 'newsfit' ), $sidebar['description'] );
			}
			$classes = 'widget ';
			if ( ! empty( $sidebar['class'] ) ) {
				$classes .= $sidebar['class'];
			}
			register_sidebar( [
				'id'            => $id,
				'name'          => sprintf( esc_html_x( '%s', 'Widget Name', 'newsfit' ), $sidebar['name'] ),
				'description'   => $description,
				'before_widget' => '<section id="%1$s" class="' . $classes . ' %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			] );

		}
	}

	function newsfit_in_widget_form( $t, $return, $instance ) {
		$instance = wp_parse_args( (array) $instance, [ 'title' => '', 'text' => '', 'float' => 'none' ] );
		if ( ! isset( $instance['float'] ) ) {
			$instance['float'] = null;
		}
		if ( ! isset( $instance['texttest'] ) ) {
			$instance['texttest'] = null;
		}
		?>
		<p>
			<input id="<?php echo $t->get_field_id( 'width' ); ?>" name="<?php echo $t->get_field_name( 'width' ); ?>" type="checkbox" <?php checked( isset( $instance['width'] ) ? $instance['width'] : 0 ); ?> />
			<label for="<?php echo $t->get_field_id( 'width' ); ?>"><?php echo esc_html__( 'halbe Breite', 'newsfit' ); ?></label>
		</p>
		<p>
			<label for="<?php echo $t->get_field_id( 'float' ); ?>">Float:</label>
			<select id="<?php echo $t->get_field_id( 'float' ); ?>" name="<?php echo $t->get_field_name( 'float' ); ?>">
				<option <?php selected( $instance['float'], 'auto' ); ?> value="auto">none</option>
				<option <?php selected( $instance['float'], 'left' ); ?>value="left">left</option>
				<option <?php selected( $instance['float'], 'right' ); ?> value="right">right</option>
			</select>
		</p>
		<input type="text" name="<?php echo $t->get_field_name( 'texttest' ); ?>" id="<?php echo $t->get_field_id( 'texttest' ); ?>" value="<?php echo $instance['texttest']; ?>"/>
		<?php
		$retrun = null;

		return [ $t, $return, $instance ];
	}

	function newsfit_in_widget_form_update( $instance, $new_instance, $old_instance ) {
		$instance['width']    = isset( $new_instance['width'] );
		$instance['float']    = $new_instance['float'];
		$instance['texttest'] = strip_tags( $new_instance['texttest'] );

		return $instance;
	}

	function newsfit_dynamic_sidebar_params( $params ) {
		global $wp_registered_widgets;
		$widget_id  = $params[0]['widget_id'];
		$widget_obj = $wp_registered_widgets[ $widget_id ];
		$widget_opt = get_option( $widget_obj['callback'][0]->option_name );
		$widget_num = $widget_obj['params'][0]['number'];
		if ( isset( $widget_opt[ $widget_num ]['width'] ) ) {
			if ( isset( $widget_opt[ $widget_num ]['float'] ) ) {
				$float = $widget_opt[ $widget_num ]['float'];
			} else {
				$float = '';
			}
			$params[0]['before_widget'] = preg_replace( '/class="/', 'class="' . $float . ' half ', $params[0]['before_widget'], 1 );
		}

		return $params;
	}
}
