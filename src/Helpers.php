<?php

namespace vnh_namespace;

function handle($name) {
	return PLUGIN_SLUG . '-' . $name;
}

function set_cookie($name, $value, $time = DAY_IN_SECONDS, $path = '/') {
	setcookie($name, $value, time() + $time, $path);
	$_COOKIE[$name] = $value;
}

function is_plugin_settings_page() {
	return str_contains(get_current_screen()->id, PLUGIN_SLUG);
}

function get_plugin_path($dir = null) {
	if (empty($dir)) {
		return trailingslashit(PLUGIN_DIR);
	}

	return trailingslashit(PLUGIN_DIR) . $dir;
}

function get_plugin_url($dir = null) {
	if (empty($dir)) {
		return plugin_dir_url(PLUGIN_FILE);
	}

	return plugin_dir_url(PLUGIN_FILE) . $dir;
}

trait Helpers {
}
