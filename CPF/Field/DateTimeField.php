<?php

namespace CPF\Field;

class DateTimeField extends Field
{

	public function display()
	{
		$input = '';
		$value = get_post_meta(get_the_ID(), '_' . $this->slug, true);
		if ($this->type == 'datetime') {
			ob_start(); ?>
			<p class="form-field _<?= $this->type ?>_field ">
				<label for="_<?= $this->slug ?>"><?= $this->name ?></label>
				<input type="datetime-local" class="short" style="" name="_<?= $this->slug ?>" id="_<?= $this->slug ?>" value="<?= $value ?>" placeholder="">
			</p>
			<?php $input = ob_get_clean();
		}
		echo $input;
	}

}
