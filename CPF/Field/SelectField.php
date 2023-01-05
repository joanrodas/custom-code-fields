<?php

namespace CPF\Field;

class SelectField extends Field
{

	private $options = [];

	public function __construct(string $type, string $slug, string $name)
	{
		parent::__construct($type, $slug, $name);
		$this->options = apply_filters("cpf_select_{$slug}_options", []);
	}

	public function display()
	{
		$input = '';
		$value = get_post_meta(get_the_ID(), '_' . $this->slug, true);
		if ($this->type == 'select') {
			ob_start(); ?>
			<p class="form-field _<?= $this->type ?>_field ">
				<label for="_<?= $this->slug ?>"><?= $this->name ?></label>
				<select class="short" style="" name="_<?= $this->slug ?>" id="_<?= $this->slug ?>">
					<?php foreach ($this->options as $option_key => $option_value) : ?>
						<option value="<?= $option_key ?>" <?= $option_key == $value ? 'selected' : '' ?>><?= $option_value ?></option>
					<?php endforeach; ?>
				</select>
			</p>
			<?php $input = ob_get_clean();
		}
		echo $input;
	}

	public function display_complex(string $parent='') {
		$input = '';
		$key = $parent ? $parent . '_' . $this->slug : '_' . $this->slug;
		if ($this->type == 'select') {
			ob_start(); ?>
			<p class="form-field _<?= $this->type ?>_field ">
				<label for="_<?= $this->slug ?>"><?= $this->name ?></label>
				<select x-cloak class="short" style="" name="_<?= $this->slug . '[]' ?>" id="_<?= $this->slug ?>">
					<?php foreach ($this->options as $option_key => $option_value) : ?>
						<option value="<?= $option_key ?>" :selected="entries[tab] ? (entries[tab]['<?= $this->slug ?>'] === '<?= $option_key ?>') : ''"><?= $option_value ?></option>
					<?php endforeach; ?>
				</select>
			</p>
			<?php $input = ob_get_clean();
		}
		echo $input;
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
