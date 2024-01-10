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
			$classes = 'widget col-lg-3 col-md-6 ';
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
		$instance = wp_parse_args( (array) $instance, [ 'title' => '', 'text' => '', 'widget_cols' => 'none' ] );
		if ( ! isset( $instance['widget_cols'] ) ) {
			$instance['widget_cols'] = null;
		}
		?>
		<p>
			<label for="<?php echo $t->get_field_id( 'widget_cols' ); ?>"><?php echo esc_html__( 'Column:', 'newsfit' ) ?></label>
			<select id="<?php echo $t->get_field_id( 'widget_cols' ); ?>" name="<?php echo $t->get_field_name( 'widget_cols' ); ?>">
				<option value=""><?php echo esc_html__( '--Select--', 'newsfit' ); ?></option>
				<option <?php selected( $instance['widget_cols'], 'col-xl-6' ); ?> value="col-xl-6"><?php echo esc_html__( '2 Cols', 'newsfit' ); ?></option>
				<option <?php selected( $instance['widget_cols'], 'col-xl-4' ); ?> value="col-xl-4"><?php echo esc_html__( '3 Cols', 'newsfit' ); ?></option>
				<option <?php selected( $instance['widget_cols'], 'col-xl-3' ); ?> value="col-xl-3"><?php echo esc_html__( '4 Cols', 'newsfit' ); ?></option>
				<option <?php selected( $instance['widget_cols'], 'col-xl-2' ); ?> value="col-xl-2"><?php echo esc_html__( '6 Cols', 'newsfit' ); ?></option>
			</select>
			<small><?php echo esc_html__( 'The specified column options are optimized for larger displays. When applying this class to a singular widget, it is imperative to extend its usage consistently across other widgets.', 'newsfit' ); ?></small>
		</p>
		<?php
		$retrun = null;

		return [ $t, $return, $instance ];
	}

	function newsfit_in_widget_form_update( $instance, $new_instance, $old_instance ) {
		$instance['widget_cols'] = $new_instance['widget_cols'];

		return $instance;
	}

	function newsfit_dynamic_sidebar_params( $params ) {
		global $wp_registered_widgets;
		$widget_id  = $params[0]['widget_id'];
		$widget_obj = $wp_registered_widgets[ $widget_id ];
		$widget_opt = get_option( $widget_obj['callback'][0]->option_name );
		$widget_num = $widget_obj['params'][0]['number'];

		if ( isset( $widget_opt[ $widget_num ]['widget_cols'] ) ) {
			$widget_cols = $widget_opt[ $widget_num ]['widget_cols'];
		} else {
			$widget_cols = '';
		}
		$params[0]['before_widget'] = preg_replace( '/class="/', 'class="' . $widget_cols . ' half ', $params[0]['before_widget'], 1 );


		return $params;
	}
}
