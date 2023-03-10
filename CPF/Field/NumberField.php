<?php

namespace CPF\Field;

class NumberField extends Field
{

	use Traits\NumericType;
	use Traits\Datalist;

	public function display($parent='')
	{
		$key = $parent . '_' . $this->slug;
		$value = get_post_meta(get_the_ID(), '_' . $this->slug, true);
		if ($value == '') $value = $this->default_value;
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
		<?php echo ob_get_clean();
	}

	public function display_complex($parent='') {
		$key = $parent . '_' . $this->slug;
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
		<?php echo ob_get_clean();
	}

}
