<?php

namespace CPF\Field;

class TimeField extends Field
{
	use Traits\Datalist;
	
	public function display($parent='')
	{
		$key = $parent . '_' . $this->slug;
		$value = get_post_meta(get_the_ID(), '_' . $this->slug, true);
		if ($value == '') $value = $this->default_value;
		ob_start(); ?>
		<p class="form-field _<?= $this->type ?>_field ">
			<label for="_<?= $this->slug ?>"><?= $this->name ?></label>
			<input type="time" class="short" style="" name="_<?= $this->slug ?>" id="_<?= $this->slug ?>" value="<?= $value ?>" placeholder="">
		</p>
		<?php echo ob_get_clean();
	}
}
