<?php

namespace vnh_namespace;

class Settings {
	protected static $option_key = PLUGIN_SLUG;
	protected static $defaults = [
		'analyticsKey' => '123',
	];

	public static function get_settings() {
		$saved = get_option(self::$option_key, []);

		return wp_parse_args($saved, self::$defaults);
	}
}
