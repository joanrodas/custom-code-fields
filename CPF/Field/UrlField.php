<?php

namespace CPF\Field;

class UrlField extends Field
{
	use Traits\Datalist;

	public function display($parent='')
	{
		$key = $parent . '_' . $this->slug;
		$value = get_post_meta(get_the_ID(), $key, true);
		if ($value == '') $value = $this->default_value;
		ob_start(); ?>
		<p class="form-field _<?= $this->type ?>_field ">
			<label for="<?= $key ?>"><?= $this->name ?></label>
			<input type="url" <?= !empty($this->datalist) ? 'list="' . $key . '_datalist"' : '' ?> class="short" style="width: 50%;" name="<?= $key ?>" id="<?= $key ?>" value="<?= $value ?>" placeholder="">
			<?php if (!empty($this->datalist)): ?>
				<datalist id="<?= $key ?>_datalist">
				<?php foreach( $this->datalist as $option ): ?>
					<option value="<?= $option ?>">
				<?php endforeach; ?>
				</datalist>
			<?php endif; ?>
		</p>
		<?php echo ob_get_clean();
	}

	public function display_complex($parent='')
	{
		ob_start(); ?>
		<p x-data="{field_name: '<?= $parent ?>_' + tab + '_<?= $this->slug ?>'}" class="form-field _<?= $this->type ?>_field">
			<label :for="field_name"><?= $this->name ?></label>
			<input x-cloak type="url" <?php if( !empty($this->datalist) ): ?> :list="field_name + '_datalist'" <?php endif; ?> class="short" style="width: 50%;" :name="field_name" :id="field_name" :value="section_fields[field_name] ? section_fields[field_name] : '<?= $this->default_value ?>'" placeholder="">
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
