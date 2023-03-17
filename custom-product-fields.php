<?php

/**
 * The plugin bootstrap file
 *
 * @wordpress-plugin
 * Plugin Name:       Custom Product Fields
 * Plugin URI:        https://sirvelia.com/
 * Description:       WooCommerce fields made simple.
 * Version:           1.0.0
 * Author:            Joan Rodas - Sirvelia
 * Author URI:        https://sirvelia.com/
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:       cpf
 * Domain Path:       /languages
 */

require_once plugin_dir_path(__FILE__) . 'vendor/autoload.php';


add_action('after_setup_theme', function () {
	CPF\Loader::load();
});

add_action('cpf_register_fields', function () {
	CPF\Section\Section::create('section_slug', 'SECTION name', [
		//CPF\Field\Field::create('textarea', 'textarea_field', 'Textarea Field'),
		// CPF\Field\Field::create('switch', 'switch_field', 'Switch Field'),
		// CPF\Field\Field::create('file', 'file_field', 'File Field'),
		// CPF\Field\Field::create('image', 'image_field', 'Image Field'),
		CPF\Field\RepeatableField::create('repeatable_field', 'Repeatable Field', [
			CPF\Field\Field::create('text', 'text_inside', 'Inside text'),
			CPF\Field\Field::create('checkbox', 'checkbox_inside', 'Inside checkbox'),
			CPF\Field\Field::create('switch', 'switch_inside', 'Inside switch'),
			CPF\Field\Field::create('password', 'password_inside', 'Inside password'),
			CPF\Field\Field::create('url', 'url_inside', 'Inside url')
				->set_datalist(['https://plubo.dev']),
			CPF\Field\Field::create('time', 'time_inside', 'Inside time')
				->set_datalist(['10:20']),
			CPF\Field\Field::create('date', 'date_inside', 'Inside date')
				->set_datalist(['2023-02-02']),
			CPF\Field\Field::create('color', 'color_inside', 'Inside color')
				->set_datalist(['#ffdede', '#f3d4de']),
			//CPF\Field\Field::create('date_time', 'datetime_inside', 'Inside datetime'),
			CPF\Field\Field::create('html', 'html_inside', 'Inside html')
				->html('<b>BOLD</b>'),
			CPF\Field\Field::create('number', 'number_field', 'Number Field')
				->min(3)
				->max(23.5)
				->step(0.1)
				//->default_value(5)
				->set_datalist([3]),
		]),
	])
		->if_tab('general')
		// ->if_product_type(['simple', 'variable'])
		// ->if_checked('virtual')
		;
});