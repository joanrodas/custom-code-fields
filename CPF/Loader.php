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

        // INIT: do_action( 'carbon_fields_register_fields' );
        // INIT: do_action( 'carbon_fields_fields_registered' );

		// add_action( 'after_setup_theme', array( $this, 'load_textdomain' ), 9999 );
		// add_action( 'init', array( $this, 'trigger_fields_register' ), 0 );
		// add_action( 'rest_api_init', array( $this, 'initialize_widgets' ) );
		// add_action( 'carbon_fields_fields_registered', array( $this, 'initialize_containers' ) );
		add_action( 'admin_enqueue_scripts', function ($hook) {
			global $typenow;
			if($typenow === 'product' && ($hook === 'post-new.php' || $hook === 'post.php')) {
				wp_enqueue_style('custom-product-fields/app.css', plugin_dir_url(__DIR__) . 'dist/app.css', false, __NAMESPACE__ . '\VERSION');
				wp_enqueue_script('custom-product-fields/app.js', plugin_dir_url(__DIR__) . 'dist/app.js', [], __NAMESPACE__ . '\VERSION', true);
			};
		}, 0 );
		// add_action( 'admin_print_footer_scripts', array( $this, 'enqueue_assets' ), 9 );
		// add_action( 'admin_print_footer_scripts', array( $this, 'initialize_ui' ), 9999 );
		// add_action( 'edit_form_after_title', array( $this, 'add_carbon_fields_meta_box_contexts' ) );
    }

	
}
