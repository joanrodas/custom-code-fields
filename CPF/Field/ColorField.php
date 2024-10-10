<?php

namespace CCF\Field;

class ColorField extends Field
{
	use Traits\Datalist;

	public function __construct(string $type, string $slug, string $name)
    {
        parent::__construct($type, $slug, $name);
        $this->default_value = '#000000';
    }

	public function display()
	{
		ob_start(); ?>
		<p x-data="{ field_name: field_name + '_<?= $this->slug ?>' }" class="form-field _<?= $this->type ?>_field">
			<label :for="field_name"><?= $this->name ?></label>
			<input x-cloak
				type="color"
				<?php if (!empty($this->datalist)): ?>
				:list="field_name + '_datalist'"
				<?php endif; ?>
				class="short"
				:name="field_name"
				:id="field_name"
				:value="section_fields[field_name] ? section_fields[field_name] : '<?= $this->default_value ?>'"
				placeholder="">
			<?php if (!empty($this->datalist)): ?>
				<datalist :id="field_name + '_datalist'">
					<?php foreach ($this->datalist as $option): ?>
						<option value="<?= $option ?>"></option>
					<?php endforeach; ?>
				</datalist>
			<?php endif; ?>
		</p>
<?php echo ob_get_clean();
	}
}
