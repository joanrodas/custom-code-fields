[![GitHub stars](https://img.shields.io/github/stars/joanrodas/custom-product-fields?style=for-the-badge)](https://github.com/joanrodas/custom-product-fields/stargazers)

Product fields library for WooCommerce developers.

✔️  Custom fields integrated with WooCommerce fields\
✔️  Easily extendable with hooks

<br/>

## Getting started

`composer require joanrodas/custom-product-fields`

> You can also install Custom Product Fields as a standalone WordPress plugin, simply downloading the zip and placing it in the plugins folder.

<br>

## Examples
```php
add_action('cpf_register_fields', function () {
	CPF\Section\Section::create('section_slug', 'Section name', [
		CPF\Field\Field::create('text', 'text_field', 'Text Field'),
		CPF\Field\Field::create('textarea', 'textarea_field', 'Textarea Field'),
		CPF\Field\Field::create('switch', 'switch_field', 'Switch Field'),
		CPF\Field\Field::create('checkbox', 'checkbox_field', 'Checkbox Field'),
		CPF\Field\Field::create('number', 'number_field', 'Number Field')->min(3)->max(23.5)->step(0.1),
		CPF\Field\Field::create('color', 'color_field', 'Color Field'),
		CPF\Field\Field::create('select', 'select_field', 'Select Field')->set_options('add_select_options'),
		CPF\Field\Field::create('rich_text', 'rich_text_field', 'Rich Text Field'),
	])
		->if_tab('general')
		// ->if_product_type(['simple', 'variable'])
		// ->if_checked('virtual')
		;
});

function add_select_options() {
	return [
		'option_1' => 'Option 1',
		'option_2' => 'Option 2',
		'option_3' => 'Option 3',
		'option_4' => 'Option 4'
	];
}
```

<br>

## Contributions
[![contributions welcome](https://img.shields.io/badge/contributions-welcome-brightgreen.svg?style=for-the-badge)](https://github.com/joanrodas/custom-product-fields/issues)
[![GitHub issues](https://img.shields.io/github/issues/joanrodas/custom-product-fields?style=for-the-badge)](https://github.com/joanrodas/custom-product-fields/issues)
[![GitHub license](https://img.shields.io/github/license/joanrodas/custom-product-fields?style=for-the-badge)](https://github.com/joanrodas/custom-product-fields/blob/main/LICENSE)


Feel free to contribute to the project, suggesting improvements, reporting bugs and coding.
