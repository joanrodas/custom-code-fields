<?php

namespace CPF\Field;

class NumberField extends Field
{

	use Traits\NumericType;
	use Traits\Datalist;

	public function display($parent='')
	{
		$key = $parent . '_' . $this->slug;
		$value = get_post_meta(get_the_ID(), $key, true);
		if ($value == '') $value = $this->default_value;
		ob_start(); ?>
		<p class="form-field _<?= $this->type ?>_field ">
			<label for="<?= $key ?>"><?= $this->name ?></label>
			<input type="number"<?= $this->min ? ' min="'.$this->min.'"' : '' ?><?= $this->max ? ' max="'.$this->max.'"' : '' ?><?= $this->step ? ' step="'.$this->step.'"' : '' ?> <?= !empty($this->datalist) ? 'list="' . $key . '_datalist"' : '' ?> class="short" style="" name="<?= $key ?>" id="<?= $key ?>" value="<?= $value ?>" placeholder="">
		</p>
		<?php if (!empty($this->datalist)): ?>
			<datalist id="<?= $key ?>_datalist">
			<?php foreach( $this->datalist as $option ): ?>
				<option value="<?= $option ?>">
			<?php endforeach; ?>
			</datalist>
		<?php endif; ?>
		<?php echo ob_get_clean();
	}

	public function display_complex($parent='')
	{
		ob_start(); ?>
		<p x-data="{field_name: field_name + '_<?= $this->slug ?>'}" class="form-field _<?= $this->type ?>_field">
			<label :for="field_name"><?= $this->name ?></label>
			<input x-cloak type="number" <?= $this->min ? 'min="' . $this->min . '"' : '' ?> <?= $this->max ? 'max="' . $this->max . '"' : '' ?> <?= $this->step ? 'step="' . $this->step . '"': '' ?> <?php if( !empty($this->datalist) ): ?> :list="field_name + '_datalist'" <?php endif; ?> class="short" style="" :name="field_name" :id="field_name" :value="section_fields[field_name] ? section_fields[field_name] : '<?= $this->default_value ?>'" placeholder="">
			<?php if (!empty($this->datalist)): ?>
				<datalist :id="field_name + '_datalist'">
				<?php foreach( $this->datalist as $option ): ?>
					<option value="<?= $option ?>">
				<?php endforeach; ?>
				</datalist>
			<?php endif; ?>
		</p>
		<?php echo ob_get_clean();
	}

}
