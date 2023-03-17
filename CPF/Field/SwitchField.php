<?php

namespace CPF\Field;

class SwitchField extends Field
{

	public function __construct(string $type, string $slug, string $name)
	{
		parent::__construct($type, $slug, $name);
		$this->default_value = false;
	}

	public function display($parent='')
	{
		$key = $parent . '_' . $this->slug;
		$checked = get_post_meta(get_the_ID(), $key, true);
		if ($checked == '') $checked = $this->default_value;
		ob_start(); ?>
		<p class="form-field _<?= $this->type ?>_field ">
			<label for="<?= $key ?>"><?= $this->name ?></label>
			<span>
				<label class="switch">
					<input type="checkbox" <?= $checked ? 'checked' : '' ?> name="<?= $key ?>" id="<?= $key ?>" value="1">
					<span class="slider round"></span>
				</label>
			</span>
		</p>
		<?php echo ob_get_clean();
	}

	public function display_complex($parent='') {
		ob_start(); ?>
		<p x-data="{field_name: '<?= $parent ?>_' + tab + '_<?= $this->slug ?>'}" class="form-field _<?= $this->type ?>_field ">
			<label :for="field_name"><?= $this->name ?></label>
			<span>
				<label class="switch">
					<input x-cloak type="checkbox" :checked="section_fields[field_name] ? (section_fields[field_name] == '1' ? true : false) : '<?= $this->default_value ? "true" : "false" ?>'" :name="field_name" :id="field_name" value="1">
					<span class="slider round"></span>
				</label>
			</span>
		</p>
		<?php echo ob_get_clean();
	}

	public function save($product_id, $parent='')
	{		
		$key = $parent . '_' . $this->slug;
		if (isset($_POST[$key])) { // phpcs:ignore
			update_post_meta($product_id, $key, '1'); // phpcs:ignore
		}
		else {
			update_post_meta($product_id, $key, '0'); // phpcs:ignore
		}
	}
}
