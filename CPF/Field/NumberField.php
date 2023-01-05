<?php

namespace CPF\Field;

class NumberField extends Field
{
	private $step;
	private $max;
	private $min;

	public function display()
	{
		$input = '';
		$value = get_post_meta(get_the_ID(), '_' . $this->slug, true);
		if ($this->type == 'number') {
			ob_start(); ?>
			<p class="form-field _<?= $this->type ?>_field ">
				<label for="_<?= $this->slug ?>"><?= $this->name ?></label>
				<input type="number"<?= $this->min ? ' min="'.$this->min.'"' : '' ?><?= $this->max ? ' max="'.$this->max.'"' : '' ?><?= $this->step ? ' step="'.$this->step.'"' : '' ?> class="short" style="" name="_<?= $this->slug ?>" id="_<?= $this->slug ?>" value="<?= $value ?>" placeholder="">
			</p>
			<?php $input = ob_get_clean();
		}
		echo $input;
	}

	public function display_complex(string $parent='') {
		$input = '';
		if ($this->type == 'number') {
			ob_start(); ?>
			<p class="form-field _<?= $this->type ?>_field" x-data="{full_slug: '<?= $parent . "_" ?>' + tab + '<?= "_".$this->slug ?>'}">
				<label :for="full_slug"><?= $this->name ?></label>
				<input x-cloak type="number" <?= $this->min ? 'min="' . $this->min . '"' : '' ?> <?= $this->max ? 'max="' . $this->max . '"' : '' ?> <?= $this->step ? 'step="' . $this->step . '"': '' ?> class="short" style="" :name="full_slug" :id="full_slug" :value="entries[tab] ? entries[tab]['<?= $this->slug ?>'] : ''" placeholder="">
			</p>
			<?php $input = ob_get_clean();
		}
		echo $input;
	}

	public function min($min)
	{
		$this->min = floatval($min);
		return $this;
	}

	public function max($max)
	{
		$this->max = floatval($max);
		return $this;
	}

	public function step($step)
	{
		$this->step = floatval($step);
		return $this;
	}
}
