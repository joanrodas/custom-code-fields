<?php

namespace CPF\Field;

class ColorField
{

	public function __construct(string $type, string $slug, string $name, bool $save_individual = true)
	{
		$this->type = $type;
		$this->slug = $slug;
		$this->name = $name;
		$this->save_individual = $save_individual;
		add_action('woocommerce_process_product_meta', [$this, 'save']);
	}


	public static function create(string $type, string $slug, string $name)
	{
		return (new self($type, $slug, $name));
	}

	public function display()
	{
		$input = '';
		$value = get_post_meta(get_the_ID(), '_' . $this->slug, true);
		if ($this->type == 'color') {
			ob_start(); ?>
			<p x-cloak class="form-field _<?= $this->type ?>_field ">
				<label for="_<?= $this->slug ?>"><?= $this->name ?></label>
				<input type="color" class="short" style="" name="_<?= $this->save_individual ? $this->slug : $this->slug . '[]' ?>" id="_<?= $this->slug ?>" :value="(typeof entries !== 'undefined' && tab < entries.length) ? entries[tab]['<?= $this->slug ?>'] : '<?= $value ?>'" placeholder="">
			</p>
			<?php $input = ob_get_clean();
		}
		echo $input;
	}

	public function save($product_id)
	{
		if (!$this->save_individual) return;

		$key = '_' . $this->slug;
		if (isset($_POST[$key])) { // phpcs:ignore
			update_post_meta($product_id, $key, $_POST[$key]); // phpcs:ignore
		}
	}
}
