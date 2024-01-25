<?php
/**
 * Theme Customizer
 *
 * @package newsfit
 */

namespace RT\NewsFit\Api;

use RT\NewsFit\Traits\SingletonTraits;
use RTFramework\Customize;

/**
 * Customizer class
 */
class Customizer {
	use SingletonTraits;

	public static $default_value = [];

	/**
	 * register default hooks and actions for WordPress
	 * @return
	 */
	public function __construct() {
		if ( defined( 'RT_FRAMEWORK_VERSION' ) ) {
			$this->add_panels();
			add_action( 'after_setup_theme', [ $this, 'register_controls' ] );
		}
		add_action( 'after_setup_theme', [ $this, 'get_controls_default_value' ] );
	}

	/**
	 * Add customize controls
	 * @return string[]
	 */
	public static function add_controls(): array {
		$classess = [
			Customizer\General::class,
			Customizer\SiteIdentity::class,
			Customizer\Header::class,
			Customizer\HeaderTopbar::class,
			Customizer\Banner::class,
			Customizer\Blog::class,
			Customizer\BlogSingle::class,
			Customizer\Contact::class,
			Customizer\Socials::class,
			Customizer\ColorSite::class,
			Customizer\ColorTopbar::class,
			Customizer\ColorHeader::class,
			Customizer\ColorBanner::class,
			Customizer\ColorFooter::class,
			Customizer\Labels::class,
			Customizer\LayoutsBlogs::class,
			Customizer\LayoutsSingle::class,
			Customizer\LayoutsPage::class,
			Customizer\LayoutsError::class,
			Customizer\Footer::class,
			Customizer\ZControllerExample::class,
		];

		if ( class_exists( 'WooCommerce' ) ) {
			$classess[] = Customizer\LayoutsWooSingle::class;
			$classess[] = Customizer\LayoutsWooArchive::class;
		}


		return $classess;
	}

	/**
	 * Register all controls dynamically
	 *
	 * @param string $section_general
	 */
	public function register_controls(): void {
		foreach ( self::add_controls() as $class ) {
			$control = new $class();
			if ( method_exists( $control, 'register' ) ) {
				$control->register();
			}
		}
	}

	/**
	 * Get controls default value
	 * @return void
	 */
	public function get_controls_default_value() {
		foreach ( self::add_controls() as $class ) {
			$control = new $class();
			if ( method_exists( $control, 'get_controls' ) ) {
				$controls = $control->get_controls();
				foreach ( $controls as $id => $control ) {
					self::$default_value[ $id ] = $control['default'] ?? '';
				}
			}
		}

	}

	/**
	 * Add Panels
	 * @return void
	 */
	public function add_panels(): void {
		Customize::add_panel( [
			'id'          => 'rt_header_panel',
			'title'       => esc_html__( 'Header - Topbar - Menu', 'newsfit' ),
			'description' => esc_html__( 'NewsFit Header', 'newsfit' ),
			'priority'    => 22,
		] );

		Customize::add_panel( [
			'id'          => 'rt_contact_social_panel',
			'title'       => esc_html__( 'Contact & Socials', 'newsfit' ),
			'description' => esc_html__( 'NewsFit Contact & Socials', 'newsfit' ),
			'priority'    => 24,
		] );

		Customize::add_panel( [
			'id'          => 'rt_color_panel',
			'title'       => esc_html__( 'Colors', 'newsfit' ),
			'description' => esc_html__( 'NewsFit Color Settings', 'newsfit' ),
			'priority'    => 28,
		] );

		Customize::add_panel( [
			'id'          => 'rt_layouts_panel',
			'title'       => esc_html__( 'Layout Settings', 'newsfit' ),
			'description' => esc_html__( 'NewsFit Layout Settings', 'newsfit' ),
			'priority'    => 34,
		] );
	}

}
