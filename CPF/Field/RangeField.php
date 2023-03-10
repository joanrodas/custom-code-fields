<?php

namespace CPF\Field;

class RangeField extends Field
{
	use Traits\NumericType;
	use Traits\Datalist;

	public function display($parent='')
	{
		$key = $parent . '_' . $this->slug;
		$value = get_post_meta(get_the_ID(), $key, true);
		if ($value == '') $value = $this->default_value;
		ob_start(); ?>
		<p class="form-field _<?= $this->type ?>_field ">
			<label for="<?= $key ?>"><?= $this->name ?></label>
			<input type="range"<?= $this->min ? ' min="'.$this->min.'"' : '' ?><?= $this->max ? ' max="'.$this->max.'"' : '' ?><?= $this->step ? ' step="'.$this->step.'"' : '' ?> class="short" style="" name="<?= $key ?>" id="<?= $key ?>" value="<?= $value ?>" placeholder="">
		</p>
		<?php echo ob_get_clean();
	}
	
	public function display_complex($parent='')
	{
		$key = $parent . '_' . $this->slug;
		$value = get_post_meta(get_the_ID(), $key, true);
		if ($value == '') $value = $this->default_value;
		ob_start(); ?>
		<p class="form-field _<?= $this->type ?>_field ">
			<label for="<?= $key ?>"><?= $this->name ?></label>
			<input type="range"<?= $this->min ? ' min="'.$this->min.'"' : '' ?><?= $this->max ? ' max="'.$this->max.'"' : '' ?><?= $this->step ? ' step="'.$this->step.'"' : '' ?> class="short" style="" name="<?= $key ?>" id="<?= $key ?>" value="<?= $value ?>" placeholder="">
		</p>
		<?php echo ob_get_clean();
	}

}
