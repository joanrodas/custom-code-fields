<?php

namespace CPF\Field;

class NumberField
{
	private $step;
	private $max;
	private $min;

	public function __construct(string $type, string $slug, string $name, bool $save_individual = true)
	{
		$this->type = $type;
		$this->slug = $slug;
		$this->name = $name;
		$this->datalist = apply_filters( 'cpf_text_' . $slug . '_datalist', [] );
		$this->default_value = "";
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
		if ($value == '') $value = $this->default_value;
		if ($this->type == 'number') {
			ob_start(); ?>
			<p class="form-field _<?= $this->type ?>_field ">
				<label for="_<?= $this->slug ?>"><?= $this->name ?></label>
				<input type="number"<?= $this->min ? ' min="'.$this->min.'"' : '' ?><?= $this->max ? ' max="'.$this->max.'"' : '' ?><?= $this->step ? ' step="'.$this->step.'"' : '' ?> <?= !empty($this->datalist) ? 'list="_' . $this->slug . '_datalist"' : '' ?> class="short" style="" name="_<?= $this->slug ?>" id="_<?= $this->slug ?>" value="<?= $value ?>" placeholder="">
			</p>
			<?php if (!empty($this->datalist)): ?>
				<datalist id="_<?= $this->slug ?>_datalist">
				<?php foreach( $this->datalist as $option ): ?>
					<option value="<?= $option ?>">
				<?php endforeach; ?>
				</datalist>
			<?php endif; ?>
			<?php $input = ob_get_clean();
		}
		echo $input;
	}

	public function display_complex() {
		$input = '';
		if ($this->type == 'number') {
			ob_start(); ?>
			<p class="form-field _<?= $this->type ?>_field">
				<label for="_<?= $this->slug ?>"><?= $this->name ?></label>
				<input x-cloak type="number" <?= $this->min ? 'min="' . $this->min . '"' : '' ?> <?= $this->max ? 'max="' . $this->max . '"' : '' ?> <?= $this->step ? 'step="' . $this->step . '"': '' ?> <?= !empty($this->datalist) ? 'list="_' . $this->slug . '_datalist"' : '' ?> class="short" style="" name="_<?= $this->slug . '[]' ?>" id="_<?= $this->slug ?>" :value="entries[tab] ? entries[tab]['<?= $this->slug ?>'] : '<?= $this->default_value ?>'" placeholder="">
				<?php if (!empty($this->datalist)): ?>
					<datalist id="_<?= $this->slug ?>_datalist">
					<?php foreach( $this->datalist as $option ): ?>
						<option value="<?= $option ?>">
					<?php endforeach; ?>
					</datalist>
				<?php endif; ?>
			</p>
			<?php $input = ob_get_clean();
		}
		echo $input;
	}

	public function default_value($default_value) {
		$this->default_value = $default_value;

		return $this;
	}

	public function set_datalist($datalist) {
		if (is_callable($datalist)) $datalist = call_user_func($datalist);
		$this->datalist = (array) $datalist;
		return $this;
	}

	public function save($product_id)
	{
		if (!$this->save_individual) return;
		
		$key = '_' . $this->slug;
		if (isset($_POST[$key])) { // phpcs:ignore
			update_post_meta($product_id, $key, $_POST[$key]); // phpcs:ignore
		}
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
