<?php

namespace CPF\Field;

class CheckboxField
{

	public function __construct(string $type, string $slug, string $name)
	{
		$this->type = $type;
		$this->slug = $slug;
		$this->name = $name;
		add_action('woocommerce_process_product_meta', [$this, 'save']);
	}


	public static function create(string $type, string $slug, string $name)
	{
		return (new self($type, $slug, $name));
	}

	public function display()
	{
		$input = '';
		$checked = get_post_meta(get_the_ID(), '_' . $this->slug, true);
		if ($this->type == 'checkbox') {
			ob_start(); ?>
			<p class="form-field _<?= $this->type ?>_field ">
				<label for="_<?= $this->slug ?>"><?= $this->name ?></label>
				<input type="checkbox" <?= $checked ? 'checked' : '' ?> name="_<?= $this->slug ?>" id="_<?= $this->slug ?>" value="1">
			</p>
			<?php $input = ob_get_clean();
		}
		echo $input;
	}

	public function save($product_id)
	{
		$key = '_' . $this->slug;
		if (isset($_POST[$key])) { // phpcs:ignore
			update_post_meta($product_id, $key, '1'); // phpcs:ignore
		}
		else {
			update_post_meta($product_id, $key, '0'); // phpcs:ignore
		}
	}
}
