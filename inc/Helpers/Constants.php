<?php

namespace RT\NewsFit\Helpers;

class Constants {

	const NEWSFIT_VERSION = '1.0.0';

	public static function get_version() {
		return WP_DEBUG ? time() : self::NEWSFIT_VERSION;
	}
}

