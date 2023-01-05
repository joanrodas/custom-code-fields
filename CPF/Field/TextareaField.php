<?php

namespace CPF\Field;

class TextareaField extends Field
{
    private $height;

	public function display()
	{
		$input = '';
        $value = get_post_meta(get_the_ID(), '_' . $this->slug, true);
		if ($this->type == 'textarea') {
			ob_start(); ?>
            <p class="form-field _<?= $this->type ?>_field ">
		        <label for="_<?= $this->slug ?>"><?= $this->name ?></label>
                <textarea class="short" style="<?= $this->height ? 'height:'.$this->height.';' : 'height:10rem;' ?>" name="_<?= $this->slug ?>" id="_<?= $this->slug ?>" placeholder="" rows="4" cols="20"><?= $value ?></textarea>
            </p>
			<?php $input = ob_get_clean();
		}
		echo $input;
	}

	public function display_complex(string $parent='') {
		$input = '';
		if ($this->type == 'textarea') {
			ob_start(); ?>
			<p class="form-field _<?= $this->type ?>_field " x-data="{full_slug: '<?= $parent . "_" ?>' + tab + '<?= "_".$this->slug ?>'}">
				<label :for="full_slug"><?= $this->name ?></label>
				<textarea x-cloak class="short" style="<?= $this->height ? 'height:' . $this->height . ';' : 'height: 10rem;' ?>" :name="full_slug" :id="full_slug" placeholder rows="4" cols="20" x-text="entries[tab] ? entries[tab]['<?= $this->slug ?>'] : ''"></textarea>
			</p>
			<?php $input = ob_get_clean();
		}
		echo $input;
	}

    public function height($height)
	{
		$this->height = sanitize_text_field($height);
		return $this;
	}

}
