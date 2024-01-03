<?php
/**
 *
 * This theme uses PSR-4 and OOP logic instead of procedural coding
 * Every function, hook and action is properly divided and organized inside related folders and files
 * Use the file `config/custom/custom.php` to write your custom functions
 *
 * @package newsfit
 */

namespace RT\NewsFit;

use RT\NewsFit\Traits\SingletonTraits;

final class Init {

	use SingletonTraits;

	/**
	 * Class constructor
	 */
	public function __construct() {
		$this->register();
	}

	/**
	 * Instantiate all class
	 * @return void
	 */
	public function register() {
		Core\Constants::instance();
		Core\Tags::instance();
		Core\Sidebar::instance();
		Options\Opt::instance();
		Options\Layouts::instance();
		Setup\Setup::instance();
		Setup\Menus::instance();
		Setup\Enqueue::instance();
		Custom\PostTypes::instance();
		Custom\Admin::instance();
		Custom\Extras::instance();
		Custom\DynamicStyles::instance();
		Api\Customizer::instance();
		Api\Gutenberg::instance();
		Api\Widgets\TextWidget::instance();
		Plugins\ThemeJetpack::instance();
	}

}
