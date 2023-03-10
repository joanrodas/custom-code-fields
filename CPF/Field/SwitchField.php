<?php

namespace CPF\Field;

class SwitchField extends Field
{

	public function __construct(string $type, string $slug, string $name)
	{
		parent::__construct($type, $slug, $name);
		$this->default_value = false;
	}

	public function display($parent='')
	{
		$key = $parent . '_' . $this->slug;
		$checked = get_post_meta(get_the_ID(), $key, true);
		if ($checked == '') $checked = $this->default_value;
		ob_start(); ?>
		<p class="form-field _<?= $this->type ?>_field ">
			<label for="<?= $key ?>"><?= $this->name ?></label>
			<span>
				<label class="switch">
					<input type="checkbox" <?= $checked ? 'checked' : '' ?> name="<?= $key ?>" id="<?= $key ?>" value="1">
					<span class="slider round"></span>
				</label>
			</span>
		</p>
		<?php echo ob_get_clean();
	}

	public function display_complex($parent='') {
		$key = $parent . '_' . $this->slug;
		ob_start(); ?>
		<p class="form-field _<?= $this->type ?>_field ">
			<label for="<?= $key ?>"><?= $this->name ?></label>
			<span>
				<label class="switch">
					<input x-cloak type="checkbox" :checked="entries[tab] ? entries[tab]['<?= $key ?>'] : '<?= $this->default_value ? "true" : "false" ?>'" name="<?= $key . '[]' ?>" id="<?= $key ?>" value="1">
					<span class="slider round"></span>
				</label>
			</span>
		</p>
		<?php echo ob_get_clean();
	}

	public function save($product_id, $parent='')
	{		
		$key = $parent . '_' . $this->slug;
		if (isset($_POST[$key])) { // phpcs:ignore
			update_post_meta($product_id, $key, '1'); // phpcs:ignore
		}
		else {
			update_post_meta($product_id, $key, '0'); // phpcs:ignore
		}
	}
}
