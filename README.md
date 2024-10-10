[![GitHub stars](https://img.shields.io/github/stars/joanrodas/custom-code-fields?style=for-the-badge)](https://github.com/joanrodas/custom-code-fields/stargazers)

Product fields library for WooCommerce developers.

✔️  Custom fields integrated with WooCommerce fields\
✔️  Easily extendable with hooks

<br/>

## Getting started

`composer require joanrodas/custom-code-fields`

> You can also install Custom Product Fields as a standalone WordPress plugin, simply downloading the zip and placing it in the plugins folder.

<br>

## Examples
```php
use CCF\Section\ProductSection;
use CCF\Field\Field;
use CCF\Field\RepeatableField;

add_action('ccf_register_fields', function () {
	ProductSection::create('section_slug', 'Section name', [
		Field::create('text', 'text_field', 'Text Field')
			->default_value('default')
		Field::create('textarea', 'textarea_field', 'Textarea Field'),
		Field::create('switch', 'switch_field', 'Switch Field'),
		Field::create('checkbox', 'checkbox_field', 'Checkbox Field'),
		Field::create('number', 'number_field', 'Number Field')
			->min(3)
			->max(23.5)
			->step(0.1)
			->set_datalist([1,2,5,10,15]),
		Field::create('html', 'html_inside', 'Inside html')
				->html('<b>Bold text</b>'),		
		Field::create('select', 'select_field', 'Select Field')->set_options('add_select_options'),
		Field::create('rich_text', 'rich_text_field', 'Rich Text Field'),
		RepeatableField::create('repeatable_field', 'Repeatable Field', [
			Field::create('password', 'password_inside', 'Inside password'),
			Field::create('url', 'url_inside', 'Inside url')
				->set_datalist(['https://plubo.dev']),
			Field::create('time', 'time_inside', 'Inside time')
				->set_datalist(['10:20']),
			Field::create('date', 'date_inside', 'Inside date')
				->set_datalist(['2023-02-02', '2023-02-01']),
			Field::create('color', 'color_field', 'Color Field')
				->set_datalist(['#ffdede', '#f3d4de']),
			
		]),
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
[![contributions welcome](https://img.shields.io/badge/contributions-welcome-brightgreen.svg?style=for-the-badge)](https://github.com/joanrodas/custom-code-fields/issues)
[![GitHub issues](https://img.shields.io/github/issues/joanrodas/custom-code-fields?style=for-the-badge)](https://github.com/joanrodas/custom-code-fields/issues)
[![GitHub license](https://img.shields.io/github/license/joanrodas/custom-code-fields?style=for-the-badge)](https://github.com/joanrodas/custom-code-fields/blob/main/LICENSE)


Feel free to contribute to the project, suggesting improvements, reporting bugs and coding.
