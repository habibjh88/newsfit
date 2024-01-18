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

	//Section's ID
	protected string $section_general = 'newsfit_general_section';
	protected string $section_topbar = 'newsfit_topbar_section';
	protected string $section_header = 'newsfit_header_section';
	protected string $section_footer = 'newsfit_footer_section';
	protected string $section_breadcrumb = 'newsfit_breadcrumb_section';
	protected string $section_contact = 'newsfit_contact_section';
	protected string $section_socials = 'newsfit_socials_section';
	protected string $section_labels = 'newsfit_labels_section';
	protected string $section_site_color = 'newsfit_site_color_section';
	protected string $section_banner_color = 'newsfit_banner_color_section';
	protected string $section_footer_color = 'newsfit_footer_color_section';
	protected string $section_header_color = 'newsfit_header_color_section';
	protected string $section_topbar_color = 'newsfit_topbar_color_section';
	protected string $section_blog_layout = 'newsfit_blog_layout_section';
	protected string $section_single_layout = 'newsfit_single_layout_section';
	protected string $section_page_layout = 'newsfit_page_layout_section';
	protected string $section_error_layout = 'newsfit_error_layout_section';
	protected string $section_woocommerce_archive_layout = 'newsfit_woocommerce_archive_layout_section';
	protected string $section_woocommerce_single_layout = 'newsfit_woocommerce_single_layout_section';

	protected string $section_blog = 'newsfit_blog_section';
	protected string $section_blog_single = 'newsfit_blog_single_section';

	protected string $section_test = 'newsfit_test_section';

	/**
	 * register default hooks and actions for WordPress
	 * @return
	 */
	public function __construct() {
		if ( defined( 'RT_FRAMEWORK_VERSION' ) ) {
			$this->add_panels();
			$this->add_sections();
			add_action( 'after_setup_theme', [ $this, 'register_controls' ] );
		}
		add_action( 'after_setup_theme', [ $this, 'get_controls_default_value' ] );
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

	/**
	 * Add Sections
	 * @return void
	 */
	public function add_sections(): void {
		Customize::add_section( [
			'id'          => $this->section_general,
			'title'       => __( 'General', 'newsfit' ),
			'description' => __( 'NewsFit General Section', 'newsfit' ),
			'priority'    => 20
		] );

		Customize::add_section( [
			'id'          => $this->section_topbar,
			'panel'       => 'rt_header_panel',
			'title'       => __( 'Header Topbar', 'newsfit' ),
			'description' => __( 'NewsFit Topbar Section', 'newsfit' ),
			'priority'    => 1
		] );

		Customize::add_section( [
			'id'          => $this->section_header,
			'panel'       => 'rt_header_panel',
			'title'       => __( 'Header Menu', 'newsfit' ),
			'description' => __( 'NewsFit Header Section', 'newsfit' ),
			'priority'    => 2
		] );


		Customize::add_section( [
			'id'          => $this->section_contact,
			'panel'       => 'rt_contact_social_panel',
			'title'       => __( 'Contact Information', 'newsfit' ),
			'description' => __( 'NewsFit Contact Address Section', 'newsfit' ),
			'priority'    => 1
		] );

		Customize::add_section( [
			'id'          => $this->section_socials,
			'panel'       => 'rt_contact_social_panel',
			'title'       => __( 'Socials Information', 'newsfit' ),
			'description' => __( 'NewsFit Socials Section', 'newsfit' ),
			'priority'    => 2
		] );

		Customize::add_section( [
			'id'          => $this->section_site_color,
			'panel'       => 'rt_color_panel',
			'title'       => __( 'Site Colors', 'newsfit' ),
			'description' => __( 'NewsFit Site Color Section', 'newsfit' ),
			'priority'    => 2
		] );

		Customize::add_section( [
			'id'          => $this->section_topbar_color,
			'panel'       => 'rt_color_panel',
			'title'       => __( 'Topbar Colors', 'newsfit' ),
			'description' => __( 'NewsFit Topbar Color Section', 'newsfit' ),
			'priority'    => 3
		] );

		Customize::add_section( [
			'id'          => $this->section_header_color,
			'panel'       => 'rt_color_panel',
			'title'       => __( 'Header Colors', 'newsfit' ),
			'description' => __( 'NewsFit Header Color Section', 'newsfit' ),
			'priority'    => 4
		] );

		Customize::add_section( [
			'id'          => $this->section_banner_color,
			'panel'       => 'rt_color_panel',
			'title'       => __( 'Banner / Breadcrumb Colors', 'newsfit' ),
			'description' => __( 'NewsFit Banner Color Section', 'newsfit' ),
			'priority'    => 6
		] );

		Customize::add_section( [
			'id'          => $this->section_footer_color,
			'panel'       => 'rt_color_panel',
			'title'       => __( 'Footer Colors', 'newsfit' ),
			'description' => __( 'NewsFit Footer Color Section', 'newsfit' ),
			'priority'    => 8
		] );

		Customize::add_section( [
			'id'          => $this->section_breadcrumb,
			'title'       => __( 'Banner - Breadcrumb', 'newsfit' ),
			'description' => __( 'NewsFit Banner Section', 'newsfit' ),
			'priority'    => 23
		] );

		Customize::add_section( [
			'id'          => $this->section_blog,
			'title'       => __( 'Blog Settings', 'newsfit' ),
			'description' => __( 'NewsFit Blog Section', 'newsfit' ),
			'priority'    => 25
		] );
		Customize::add_section( [
			'id'          => $this->section_blog_single,
			'title'       => __( 'Blog Single', 'newsfit' ),
			'description' => __( 'NewsFit Blog Single Section', 'newsfit' ),
			'priority'    => 26
		] );

		Customize::add_section( [
			'id'          => $this->section_footer,
			'title'       => __( 'Footer', 'newsfit' ),
			'description' => __( 'NewsFit Footer Section', 'newsfit' ),
			'priority'    => 38
		] );

		self::get_layouts();

		Customize::add_section( [
			'id'          => $this->section_labels,
			'title'       => __( 'Modify Static Text', 'newsfit' ),
			'description' => __( 'You can change all static text of the theme.', 'newsfit' ),
			'priority'    => 999
		] );

		//TODO: Test section
		Customize::add_section( [
			'id'          => $this->section_test,
			'title'       => __( 'Test Controls', 'newsfit' ),
			'description' => __( 'Customize the Test', 'newsfit' ),
			'priority'    => 9999
		] );

	}

	public function get_layouts() {

		Customize::add_section( [
			'id'    => $this->section_blog_layout,
			'title' => __( 'Blog Layout', 'newsfit' ),
			'panel' => 'rt_layouts_panel',
		] );

		Customize::add_section( [
			'id'    => $this->section_single_layout,
			'title' => __( 'Single Layout', 'newsfit' ),
			'panel' => 'rt_layouts_panel',
		] );

		Customize::add_section( [
			'id'    => $this->section_page_layout,
			'title' => __( 'Page Layout', 'newsfit' ),
			'panel' => 'rt_layouts_panel',
		] );

		Customize::add_section( [
			'id'    => $this->section_error_layout,
			'title' => __( 'Error Layout', 'newsfit' ),
			'panel' => 'rt_layouts_panel',
		] );

		Customize::add_section( [
			'id'    => $this->section_woocommerce_archive_layout,
			'title' => __( 'Woocommerce Archive', 'newsfit' ),
			'panel' => 'rt_layouts_panel',
		] );

		Customize::add_section( [
			'id'    => $this->section_woocommerce_single_layout,
			'title' => __( 'Woocommerce Single', 'newsfit' ),
			'panel' => 'rt_layouts_panel',
		] );


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

}
