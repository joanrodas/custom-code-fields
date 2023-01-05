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
		CPF\Field\Field::create('text', 'text_field', 'Text Field'),
		CPF\Field\Field::create('textarea', 'textarea_field', 'Textarea Field'),
		CPF\Field\Field::create('switch', 'switch_field', 'Switch Field'),
		CPF\Field\Field::create('checkbox', 'checkbox_field', 'Checkbox Field'),
		CPF\Field\Field::create('number', 'number_field', 'Number Field')->min(3)->max(23.5)->step(0.1),
		CPF\Field\Field::create('color', 'color_field', 'Color Field'),
		CPF\Field\Field::create('select', 'select_field', 'Select Field')->set_options('add_select_options'),
		CPF\Field\Field::create('rich_text', 'rich_text_field', 'Rich Text Field'),
		CPF\Tabs\Tabs::create('tabs', 'tabs_element', 'add_tabs'),
		CPF\Field\RepeatableField::create('milestone-complex', 'Milestones', [
			CPF\Field\Field::create('text', 'step_name', 'Step Name'),
			CPF\Field\Field::create('textarea', 'step_description', 'Step Description'),
			CPF\Field\Field::create('checkbox', 'completed_step', 'Completed'),
			CPF\Field\Field::create('color', 'inside_color', 'Inside color')
		]),
	])
		->if_tab('general')
		// ->if_product_type(['simple', 'variable'])
		// ->if_checked('virtual')
		;
	
	// CPF\Section\Section::create('milestones_section', 'Milestones', [
	// 	CPF\Field\RepeatableField::create('milestone-complex', 'Milestones', [
	// 		CPF\Field\Field::create('text', 'step_name', 'Step Name'),
	// 		CPF\Field\Field::create('textarea', 'step_description', 'Step Description'),
	// 		CPF\Field\Field::create('checkbox', 'completed_step', 'Completed'),
	// 		CPF\Field\Field::create('color', 'inside_color', 'Inside color')
	// 	]),
	// 	CPF\Field\Field::create('color', 'milestone_color', 'Milestone Color')
		
	// ])
	// 	->if_tab('general')
	// 	->if_roles('administrator')
	// 	;
});

function add_select_options() {
	return [
		'option_1' => 'Option 1',
		'option_2' => 'Option 2',
		'option_3' => 'Option 3',
		'option_4' => 'Option 4'
	];
}

function add_tabs() {
	return [
		CPF\Tabs\Tab::create('tab_1', 'Tab 1', [
			CPF\Field\Field::create('text', 'tab_1_text_field', 'Text Field 1'),
			CPF\Field\Field::create('textarea', 'tab_1_textarea_field', 'Textarea Field 1'),
			CPF\Field\Field::create('switch', 'tab_1_switch_field', 'Switch Field 1'),
			CPF\Field\Field::create('checkbox', 'tab_1_checkbox_field', 'Checkbox Field 1'),
			CPF\Field\Field::create('number', 'tab_1_number_field', 'Number Field 1')->min(3)->max(23.5)->step(0.1),
			CPF\Field\Field::create('color', 'tab_1_color_field', 'Color Field 1'),
			CPF\Field\Field::create('select', 'tab_1_select_field', 'Select Field 1')->set_options('add_select_options'),
			CPF\Field\Field::create('rich_text', 'tab_1_rich_text_field', 'Rich Text Field 1'),
		]),
		CPF\Tabs\Tab::create('tab_2', 'Tab 2', [
			CPF\Field\Field::create('text', 'tab_2_text_field', 'Text Field 2'),
			CPF\Field\Field::create('textarea', 'tab_2_textarea_field', 'Textarea Field 2'),
			CPF\Field\Field::create('switch', 'tab_2_switch_field', 'Switch Field 2'),
			CPF\Field\Field::create('checkbox', 'tab_2_checkbox_field', 'Checkbox Field 2'),
			CPF\Field\Field::create('number', 'tab_2_number_field', 'Number Field 2')->min(3)->max(23.5)->step(0.1),
			CPF\Field\Field::create('color', 'tab_2_color_field', 'Color Field 2'),
			CPF\Field\Field::create('select', 'tab_2_select_field', 'Select Field 2')->set_options('add_select_options'),
			CPF\Field\Field::create('rich_text', 'tab_2_rich_text_field', 'Rich Text Field 2'),
		])
	];
}
