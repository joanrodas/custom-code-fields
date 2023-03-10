<?php

namespace CPF\Field;

class AssociationField extends Field
{

	public function display($parent='')
	{
		$key = $parent . '_' . $this->slug;
		$value = get_post_meta(get_the_ID(), '_' . $this->slug, true);
		if ($value == '') $value = $this->default_value;
		ob_start(); ?>
		<p class="form-field _<?= $this->type ?>_field ">
			<label for="_<?= $this->slug ?>"><?= $this->name ?></label>
			<input type="color" class="short" style="" name="_<?= $this->slug ?>" id="_<?= $this->slug ?>" value="<?= $value ?>" placeholder="">
		</p>
		<?php echo ob_get_clean();
	}

	public function display_complex($parent='')
	{
		$key = $parent . '_' . $this->slug;
		ob_start(); ?>
		<p x-cloak class="form-field _<?= $this->type ?>_field ">
			<label for="_<?= $this->slug ?>"><?= $this->name ?></label>
			<input x-cloak type="color" class="short" style="" name="_<?= $this->slug . '[]' ?>" id="_<?= $this->slug ?>" :value="entries[tab] ? entries[tab]['<?= $this->slug ?>'] : '<?= $this->default_value ?>'" placeholder=""> 
		</p>
		<?php echo ob_get_clean();
	}

	public function save($product_id, $parent='')
	{
		$key = $parent . '_' . $this->slug;
		if (isset($_POST[$key])) { // phpcs:ignore
			update_post_meta($product_id, $key, $_POST[$key]); // phpcs:ignore
		}
	}
}
