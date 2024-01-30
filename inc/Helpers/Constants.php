<?php

namespace RT\NewsFit\Helpers;

use RT\NewsFit\Traits\SingletonTraits;

class Constants {
	use SingletonTraits;

	const NEWSFIT_VERSION = '1.0.0';

	public function __construct() {

	}

	public static function get_version(){
		return WP_DEBUG ? time() : self::NEWSFIT_VERSION;
	}
}

