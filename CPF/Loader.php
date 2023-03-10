<?php
namespace CPF;

class Loader
{
    public function __construct()
    {

    }

    public static function load()
    {
        if( defined( __NAMESPACE__ . '\VERSION' ) ) {
            return;
        }

        if ( !defined( 'ABSPATH' ) ) {
			throw new \Exception( 'Custom Product Fields cannot be booted outside of a WordPress environment.' );
		}

		if ( did_action( 'init' ) ) {
			throw new \Exception( 'Custom Product Fields must be booted before the "init" WordPress action has fired.' );
		}

		include_once( dirname( __DIR__ ) . '/CPF/helper.php' );
        do_action( 'cpf_register_fields' );


		add_action('post_edit_form_tag', function () {
			echo ' enctype="multipart/form-data"';
		});

		// add_action( 'admin_enqueue_scripts', function ($hook) {
		// 	global $typenow;
		// 	if($typenow === 'product' && ($hook === 'post-new.php' || $hook === 'post.php')) {
		// 		$script_asset_path = plugin_dir_path(__DIR__) . 'dist/scripts.asset.php';
		// 		$script_asset      = file_exists($script_asset_path)
		// 			? require $script_asset_path
		// 			: array(
		// 				'dependencies' => array(),
		// 				'version'      => 1,
		// 			);

		// 		// wp_enqueue_style('custom-product-fields/app.css', plugin_dir_url(__DIR__) . 'dist/scripts.css', false, $script_asset['version']);
		// 		wp_enqueue_script('custom-product-fields/app.js', plugin_dir_url(__DIR__) . 'dist/scripts.js', $script_asset['dependencies'], $script_asset['version'], true);
		// 	};
		// }, 0 );

		add_action( 'admin_enqueue_scripts', function ($hook) {
			global $typenow;
			if($typenow === 'product' && ($hook === 'post-new.php' || $hook === 'post.php')) {
				wp_enqueue_style('custom-product-fields/app.css', plugin_dir_url(__DIR__) . 'dist/app.css', false, __NAMESPACE__ . '\VERSION');
				wp_enqueue_script('custom-product-fields/app.js', plugin_dir_url(__DIR__) . 'dist/app.js', [], __NAMESPACE__ . '\VERSION', true);
			};
		}, 0 );

    }

	
}
