<?php

namespace CPF\Field;

class DateField extends Field
{
	use Traits\Datalist;

	public function __construct(string $type, string $slug, string $name)
	{
		parent::__construct($type, $slug, $name);
		$this->default_value = date('Y-m-d');
	}

	public function display($parent='')
	{
		$key = $parent . '_' . $this->slug;
		$value = get_post_meta(get_the_ID(), $key, true);
		if ($value == '') $value = $this->default_value;
		ob_start(); ?>
		<p class="form-field _<?= $this->type ?>_field ">
			<label for="<?= $key ?>"><?= $this->name ?></label>
			<input type="date" class="short" style="" name="<?= $key ?>" id="<?= $key ?>" value="<?= $value ?>" placeholder="">
		</p>
		<?php echo ob_get_clean();
	}
	
	//TODO: COMPLEX
	public function display_complex($parent='')
	{
		$key = $parent . '_' . $this->slug;
		$value = get_post_meta(get_the_ID(), $key, true);
		if ($value == '') $value = $this->default_value;
		ob_start(); ?>
		<p class="form-field _<?= $this->type ?>_field ">
			<label for="<?= $key ?>"><?= $this->name ?></label>
			<input type="date" class="short" style="" name="<?= $key ?>" id="<?= $key ?>" value="<?= $value ?>" placeholder="">
		</p>
		<?php echo ob_get_clean();
	}

}
