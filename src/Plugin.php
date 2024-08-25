<?php
/**
 * Plugin Name: vnh_name
 * Description: vnh_description
 * Version: vnh_version
 * Tags: vnh_tags
 * Author: vnh_author
 * Author URI: vnh_author_uri
 * License: vnh_license
 * License URI: vnh_license_uri
 * Document URI: vnh_document_uri
 * Text Domain: vnh_textdomain
 * Tested up to: WordPress vnh_tested_up_to
 * WC requires at least: vnh_wc_requires
 * WC tested up to: vnh_wc_tested_up_to
 */

namespace vnh_namespace;

use vnh\Allowed_HTML;
use vnh\contracts\Loadable;
use vnh\Plugin_Action_Links;
use vnh\Plugin_Row_Meta;
use vnh_namespace\api\Setting_API;
use vnh_namespace\tools\PHP_Checker;
use vnh_namespace\tools\WooCommerce_Checker;
use vnh_namespace\tools\WooCommerce_Required;
use vnh_namespace\tools\WordPress_Checker;
use function vnh\plugin_languages_path;

const PLUGIN_FILE = __FILE__;
const PLUGIN_DIR = __DIR__;

require_once PLUGIN_DIR . '/vendor/autoload.php';

final class Plugin implements Loadable {
	public $services;

	public function __construct() {
		$this->services = Container::instance()->services;
		$this->load();
		$this->boot();
	}

	public function load() {
		$this->services->get(Allowed_HTML::class)->boot();

		if (is_admin()) {
			$this->services->get(Plugin_Action_Links::class)->boot();
			$this->services->get(Plugin_Row_Meta::class)->boot();
			$this->services->get(Settings_Page::class)->boot();
		}
	}

	public function boot() {
		add_action('rest_api_init', [$this, 'register_api_routes']);
		add_action('plugin_loaded', [$this, 'plugin_loaded']);
		add_action('init', [$this, 'init']);
	}

	public function register_api_routes() {
		$this->services->get(Setting_API::class)->register_routes();
	}

	public function plugin_loaded() {
		load_plugin_textdomain('vnh_textdomain', false, plugin_languages_path(PLUGIN_FILE));
	}

	public function init() {
		$this->services->get(Enqueue_Frontend_Assets::class)->boot();
		$this->services->get(Enqueue_Backend_Assets::class)->boot();

		$this->services->get(PHP_Checker::class)->init();
		$this->services->get(WordPress_Checker::class)->init();
		if (defined('WC_VERSION')) {
			$this->services->get(WooCommerce_Checker::class)->init();
		} else {
			$this->services->get(WooCommerce_Required::class)->init();
		}
	}
}

new Plugin();
