<?php

namespace CPF\Field;

class PasswordField extends Field
{

	public function display($parent='')
	{
		$key = $parent . '_' . $this->slug;
		$value = get_post_meta(get_the_ID(), $key, true);
		if ($value == '') $value = $this->default_value;
		ob_start(); ?>
		<p class="form-field _<?= $this->type ?>_field ">
			<label for="<?= $key ?>"><?= $this->name ?></label>
			<input type="password" class="short" style="" name="<?= $key ?>" id="<?= $key ?>" value="<?= $value ?>" placeholder="">
		</p>
		<?php echo ob_get_clean();
	}

	public function display_complex($parent='')
	{
		ob_start(); ?>
		<p x-data="{field_name: '<?= $parent ?>_' + tab + '_<?= $this->slug ?>'}" class="form-field _<?= $this->type ?>_field">
			<label :for="field_name"><?= $this->name ?></label>
			<input x-cloak type="password" class="short" style="" :name="field_name" :id="field_name" :value="section_fields[field_name] ? section_fields[field_name] : '<?= $this->default_value ?>'" placeholder="">
		</p>
		<?php echo ob_get_clean();
	}

}
