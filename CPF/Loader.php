<?php

namespace CPF;

use CPF\Endpoints\Endpoints;

class Loader
{
	public function __construct()
	{
	}

	public static function load()
	{
		if (defined(__NAMESPACE__ . '\VERSION')) return;

		if (!defined('ABSPATH'))
			throw new \Exception('Custom Product Fields cannot be booted outside of a WordPress environment.');

		if (did_action('init'))
			throw new \Exception('Custom Product Fields must be booted before the "init" WordPress action has fired.');

		if (!defined(__NAMESPACE__ . '\VERSION'))
			define(__NAMESPACE__ . '\VERSION', '0.1.0');

		new Endpoints();
		do_action('cpf_register_fields');

		add_action('post_edit_form_tag', function () {
			echo ' enctype="multipart/form-data"';
		});

		add_action('admin_enqueue_scripts', function ($hook) {
			global $typenow;
			if ($typenow === 'product' && ($hook === 'post-new.php' || $hook === 'post.php')) {
				wp_enqueue_style('custom-product-fields/app.css', plugin_dir_url(__DIR__) . 'dist/app.css', false, __NAMESPACE__ . '\VERSION');
				wp_enqueue_script('custom-product-fields/app.js', plugin_dir_url(__DIR__) . 'dist/app.js', [], __NAMESPACE__ . '\VERSION', true);
				wp_localize_script('custom-product-fields/app.js', 'CPF_PARAMS', array(
					'ajaxurl'   => admin_url('admin-ajax.php'),
					'api_url'   => get_rest_url(null, 'custom-product-fields/v1'),
					'nonce'     => wp_create_nonce('ajax-nonce'),
					'restNonce'	=> wp_create_nonce('wp_rest')
				));
			};
		}, 0);
	}
}
