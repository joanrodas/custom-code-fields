<?php

namespace CPF\Field;

class TextareaField extends Field
{
	private $height = '10rem';

	public function display()
	{
		ob_start(); ?>
		<p x-data="{ field_name: field_name + '_<?= $this->slug ?>' }" class="form-field _<?= $this->type ?>_field">
			<label :for="field_name"><?= $this->name ?></label>
			<textarea x-cloak
				class="short"
				style="<?= $this->height ? 'height:' . $this->height . ';' : 'height: 10rem;' ?>"
				:name="field_name"
				:id="field_name"
				placeholder=""
				x-text="section_fields[field_name] ? section_fields[field_name] : '<?= $this->default_value ?>'">
            </textarea>
		</p>
<?php echo ob_get_clean();
	}

	public function height($height)
	{
		$this->height = sanitize_text_field($height);
		return $this;
	}
}
