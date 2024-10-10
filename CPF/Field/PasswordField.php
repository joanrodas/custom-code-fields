<?php

namespace CPF\Field;

class PasswordField extends Field
{
	public function display()
	{
		ob_start(); ?>
		<p x-data="{ field_name: field_name + '_<?= $this->slug ?>' }" class="form-field _<?= $this->type ?>_field">
			<label :for="field_name"><?= $this->name ?></label>
			<input x-cloak
				type="password"
				class="short"
				:name="field_name"
				:id="field_name"
				:value="section_fields[field_name] ? section_fields[field_name] : '<?= $this->default_value ?>'"
				placeholder="">
		</p>
<?php echo ob_get_clean();
	}
}
