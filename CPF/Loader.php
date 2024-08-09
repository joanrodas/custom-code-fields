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
	}
}
