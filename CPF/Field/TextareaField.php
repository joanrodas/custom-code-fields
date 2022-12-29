<?php

namespace CPF\Field;

class TextareaField
{
    private $height;

	public function __construct(string $type, string $slug, string $name, bool $save_individual = true)
	{
		$this->type = $type;
		$this->slug = $slug;
		$this->name = $name;
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

	public function display_complex() {
		$input = '';
		if ($this->type == 'textarea') {
			ob_start(); ?>
			<p class="form-field _<?= $this->type ?>_field ">
				<label for="_<?= $this->slug ?>"><?= $this->name ?></label>
				<textarea x-cloak class="short" style="<?= $this->height ? 'height:' . $this->height . ';' : 'height: 10rem;' ?>" name="_<?= $this->slug . '[]' ?>" id="<?= $this->slug ?>" placeholder rows="4" cols="20" x-text="entries[tab]['<?= $this->slug ?>']"></textarea>
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

    public function save($product_id)
	{
		if (!$this->save_individual) return;
		
		$key = '_' . $this->slug;
		if (isset($_POST[$key])) { // phpcs:ignore
			update_post_meta($product_id, $key, $_POST[$key]); // phpcs:ignore
		}
	}
}
