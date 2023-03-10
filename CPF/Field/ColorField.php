<?php

namespace CPF\Field;

class ColorField extends Field
{
	use Traits\Datalist;

	public function __construct(string $type, string $slug, string $name)
	{
		parent::__construct($type, $slug, $name);
		$this->default_value = "#000000";
	}

	public function display($parent='')
	{
		$key = $parent . '_' . $this->slug;
		$value = get_post_meta(get_the_ID(), '_' . $this->slug, true);
		if ($value == '') $value = $this->default_value;
		ob_start(); ?>
		<p class="form-field _<?= $this->type ?>_field ">
			<label for="_<?= $this->slug ?>"><?= $this->name ?></label>
			<input type="color" class="short" style="" name="_<?= $this->slug ?>" id="_<?= $this->slug ?>" value="<?= $value ?>" placeholder="">
		</p>
		<?php echo ob_get_clean();
	}

	public function display_complex($parent='')
	{
		$key = $parent . '_' . $this->slug;
		ob_start(); ?>
		<p x-cloak class="form-field _<?= $this->type ?>_field ">
			<label for="_<?= $this->slug ?>"><?= $this->name ?></label>
			<input x-cloak type="color" class="short" style="" name="_<?= $this->slug . '[]' ?>" id="_<?= $this->slug ?>" :value="entries[tab] ? entries[tab]['<?= $this->slug ?>'] : '<?= $this->default_value ?>'" placeholder=""> 
		</p>
		<?php echo ob_get_clean();
	}

}
