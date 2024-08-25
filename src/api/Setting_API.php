<?php

namespace vnh_namespace\api;

use vnh_namespace\Settings;
use WP_REST_Server;
use const vnh_namespace\DS;
use const vnh_namespace\PLUGIN_SLUG;

class Setting_API extends \WP_REST_Controller {
	protected static $defaults = [
		'analyticsKey' => '123',
	];

	protected $namespace = PLUGIN_SLUG;
	protected $rest_base = 'settings';

	public function register_routes() {
		register_rest_route(
			$this->namespace,
			DS . $this->rest_base,
			[
				[
					'methods' => WP_REST_Server::READABLE,
					'callback' => [$this, 'get_items'],
				],
				[
					'methods' => WP_REST_Server::CREATABLE,
					'callback' => [$this, 'create_item'],
					'permission_callback' => [$this, 'create_item_permissions_check'],
				],
			]
		);
	}

	public function get_items($request) {
		return Settings::get_settings();
	}

	public function create_item($request) {
		$settings = $request->get_body();
		$settings = json_decode($settings, true);

		update_option(PLUGIN_SLUG, $settings);

		return new \WP_REST_Response(['success' => true], 201);
	}

	public function create_item_permissions_check($request) {
		return current_user_can('edit_posts');
	}
}
