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

	CPF\Section\Section::create('milestones_section', 'Milestones', [
		CPF\Field\RepeatableField::create('milestone-complex', 'Milestones', [
			CPF\Field\Field::create('text', 'step_name', 'Step Name'),
			CPF\Field\Field::create('textarea', 'step_description', 'Step Description'),
			CPF\Field\Field::create('checkbox', 'completed_step', 'Completed')
		]),
		CPF\Field\Field::create('color', 'milestone_color', 'Milestone Color')
		
	])
		->if_tab('milestones')
		;
});
