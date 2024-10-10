<?php

namespace CPF\Field;

class SwitchField extends Field
{
	public function __construct(string $type, string $slug, string $name)
	{
		parent::__construct($type, $slug, $name);
		$this->default_value = '0'; // Default is off (unchecked)
	}

	public function display()
	{
		ob_start(); ?>
		<p x-data="{ 
                field_name: field_name + '_<?= $this->slug ?>', 
                field_value: section_fields[field_name] !== undefined ? section_fields[field_name] : '<?= $this->default_value ?>' 
            }"
			class="form-field _<?= $this->type ?>_field">
			<label :for="field_name"><?= $this->name ?></label>
			<input x-cloak
				type="checkbox"
				class="switch"
				:name="field_name"
				:id="field_name"
				x-model="field_value"
				:value="field_value"
				@change="field_value = $el.checked ? '1' : '0'">
		</p>
<?php echo ob_get_clean();
	}

	public function save($product_id, $parent = '')
	{
		$key = $parent . '_' . $this->slug;
		$value = isset($_POST[$key]) ? '1' : '0';
		update_post_meta($product_id, $key, $value);
	}
}
