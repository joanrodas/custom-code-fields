<?php

namespace CPF\Field;

class DateTimeField extends Field
{
	use Traits\Datalist;

	public function __construct(string $type, string $slug, string $name)
	{
		parent::__construct($type, $slug, $name);
		$this->default_value = date('Y-m-d H:i:s');
	}

	public function display($parent='')
	{
		$key = $parent . '_' . $this->slug;
		$value = get_post_meta(get_the_ID(), '_' . $this->slug, true);
		ob_start(); ?>
		<p class="form-field _<?= $this->type ?>_field ">
			<label for="_<?= $this->slug ?>"><?= $this->name ?></label>
			<input type="datetime-local" class="short" style="" name="_<?= $this->slug ?>" id="_<?= $this->slug ?>" value="<?= $value ?>" placeholder="">
		</p>
		<?php echo ob_get_clean();
	}
	
	//TODO: Complex
	public function display_complex($parent='')
	{
		$key = $parent . '_' . $this->slug;
		$value = get_post_meta(get_the_ID(), '_' . $this->slug, true);
		ob_start(); ?>
		<p class="form-field _<?= $this->type ?>_field ">
			<label for="_<?= $this->slug ?>"><?= $this->name ?></label>
			<input type="datetime-local" class="short" style="" name="_<?= $this->slug ?>" id="_<?= $this->slug ?>" value="<?= $value ?>" placeholder="">
		</p>
		<?php echo ob_get_clean();
	}

}
