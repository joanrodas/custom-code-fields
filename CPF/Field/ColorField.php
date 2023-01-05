<?php

namespace CPF\Field;

class ColorField extends Field
{

	public function display()
	{
		$input = '';
		$value = get_post_meta(get_the_ID(), '_' . $this->slug, true);
		if ($this->type == 'color') {
			ob_start(); ?>
			<p class="form-field _<?= $this->type ?>_field ">
				<label for="_<?= $this->slug ?>"><?= $this->name ?></label>
				<input type="color" class="short" style="" name="_<?= $this->slug ?>" id="_<?= $this->slug ?>" value="<?= $value ?>" placeholder="">
			</p>
			<?php $input = ob_get_clean();
		}
		echo $input;
	}

	public function display_complex(string $parent='') {
		$input = '';
		$key = $parent ? $parent . '_' . $this->slug : '_' . $this->slug;
		if ($this->type == 'color') {
			ob_start(); ?>
			<p x-cloak class="form-field _<?= $this->type ?>_field ">
				<label for="_<?= $this->slug ?>"><?= $this->name ?></label>
				<input x-cloak type="color" class="short" style="" name="_<?= $this->slug . '[]' ?>" id="_<?= $this->slug ?>" :value="entries[tab] ? entries[tab]['<?= $this->slug ?>'] : ''" placeholder=""> 
			</p>
			<?php $input = ob_get_clean();
		}		
		echo $input;
	}

}
