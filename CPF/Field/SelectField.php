<?php

namespace CPF\Field;

class SelectField extends Field
{

	private $options = [];

	public function __construct(string $type, string $slug, string $name)
	{
		parent::__construct($type, $slug, $name);
		$this->options = apply_filters('cpf_select_' . $slug . '_options', []);
		$this->default_value = 0;
	}

	public function display($parent='')
	{
		$key = $parent . '_' . $this->slug;
		$value = get_post_meta(get_the_ID(), $key, true);
		if ($value == '') $value = $this->default_value;
		ob_start(); ?>
		<p class="form-field _<?= $this->type ?>_field ">
			<label for="<?= $key ?>"><?= $this->name ?></label>
			<select class="short" style="" name="<?= $key ?>" id="<?= $key ?>">
				<?php foreach ($this->options as $option_key => $option_value) : ?>
					<option value="<?= $option_key ?>" <?= $option_key == $value ? 'selected' : '' ?>><?= $option_value ?></option>
				<?php endforeach; ?>
			</select>
		</p>
		<?php echo ob_get_clean();
	}

	public function display_complex($parent='') {
		$key = $parent . '_' . $this->slug;
		ob_start(); ?>
		<p class="form-field _<?= $this->type ?>_field ">
			<label for="<?= $key ?>"><?= $this->name ?></label>
			<select x-cloak class="short" style="" name="_<?= $key . '[]' ?>" id="<?= $key ?>">
				<?php foreach ($this->options as $option_key => $option_value) : ?>
					<option value="<?= $option_key ?>" :selected="entries[tab] ? (entries[tab]['<?= $key ?>'] === '<?= $option_key ?>') : '<?= $this->default_value ?>' === '<?= $option_key ?>'"><?= $option_value ?></option>
				<?php endforeach; ?>
			</select>
		</p>
		<?php echo ob_get_clean();
	}

	public function set_options($options)
	{
		if (is_callable($options)) {
			$options = call_user_func($options);
		}
		$this->options = (array) $options;
		return $this;
	}

	public function add_options($options)
	{
		if (is_callable($options)) {
			$options = (array) call_user_func($options);
		}
		$this->options = array_merge($this->options, $options);
		return $this;
	}

}
