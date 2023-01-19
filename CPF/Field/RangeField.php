<?php

namespace CPF\Field;

class RangeField
{
	private $step;
	private $max;
	private $min;

	public function __construct(string $type, string $slug, string $name)
	{
		$this->type = $type;
		$this->slug = $slug;
		$this->name = $name;
		$this->default_value = "";
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
		if ($value == '') $value = $this->default_value;
		if ($this->type == 'range') {
			ob_start(); ?>
			<p class="form-field _<?= $this->type ?>_field ">
				<label for="_<?= $this->slug ?>"><?= $this->name ?></label>
				<input type="range"<?= $this->min ? ' min="'.$this->min.'"' : '' ?><?= $this->max ? ' max="'.$this->max.'"' : '' ?><?= $this->step ? ' step="'.$this->step.'"' : '' ?> class="short" style="" name="_<?= $this->slug ?>" id="_<?= $this->slug ?>" value="<?= $value ?>" placeholder="">
			</p>
<?php $input = ob_get_clean();
		}
		echo $input;
	}

	public function save($product_id)
	{
		$key = '_' . $this->slug;
		if (isset($_POST[$key])) { // phpcs:ignore
			update_post_meta($product_id, $key, $_POST[$key]); // phpcs:ignore
		}
	}

	public function default_value($default_value) {
		$this->default_value = $default_value;

		return $this;
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
