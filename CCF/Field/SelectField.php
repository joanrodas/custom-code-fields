<?php

namespace CCF\Field;

class SelectField extends Field
{
	private $options = [];

	public function __construct(string $type, string $slug, string $name)
	{
		parent::__construct($type, $slug, $name);
		$this->options = apply_filters('ccf_select_' . $slug . '_options', []);
		$this->default_value = 0;
	}

	public function display()
	{
		ob_start(); ?>
		<p x-data="{ field_name: field_name + '_<?= $this->slug ?>' }" class="form-field _<?= $this->type ?>_field">
			<label :for="field_name"><?= $this->name ?></label>
			<select x-cloak
				class="short"
				:name="field_name"
				:id="field_name">
				<?php foreach ($this->options as $option_key => $option_value): ?>
					<option :value="'<?= $option_key ?>'"
						:selected="section_fields[field_name] ? section_fields[field_name] === '<?= $option_key ?>' : '<?= $this->default_value ?>' === '<?= $option_key ?>'">
						<?= $option_value ?>
					</option>
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
			$options = call_user_func($options);
		}
		$this->options = array_merge($this->options, (array) $options);
		return $this;
	}
}
