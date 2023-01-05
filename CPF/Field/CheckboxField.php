<?php

namespace CPF\Field;

class CheckboxField extends Field
{

	public function display()
	{
		$input = '';
		$checked = get_post_meta(get_the_ID(), '_' . $this->slug, true);
		if ($this->type == 'checkbox') {
			ob_start(); ?>
			<p class="form-field _<?= $this->type ?>_field ">
				<label for="_<?= $this->slug ?>"><?= $this->name ?></label>
				<input type="checkbox" <?= $checked === '1' ? 'checked' : '' ?> name="_<?= $this->slug ?>" id="_<?= $this->slug ?>" value="1">
			</p>
			<?php $input = ob_get_clean();
		}
		echo $input;
	}

	public function display_complex(string $parent='') {
		$input = '';
		if ($this->type === 'checkbox') {
			ob_start(); ?>
			<p class="form-field _<?= $this->type ?>_field" x-data="{full_slug: '<?= $parent . "_" ?>' + tab + '<?= "_".$this->slug ?>'}">
				<label :for="full_slug"><?= $this->name ?></label>
				<input x-cloak type="checkbox" :checked="entries[tab] ? (entries[tab]['<?= $this->slug ?>'] == '1' ? true : false) : false" :name="full_slug" :id="full_slug" value="1">
			</p>
			<?php $input = ob_get_clean();
		}
		echo $input;
	}

	public function save($product_id, $parent='')
	{
		$key = $parent ? $parent . '_' . $this->slug : '_' . $this->slug;
		update_post_meta($product_id, $key, isset($_POST[$key]) ? '1' : '0'); // phpcs:ignore
	}
}
