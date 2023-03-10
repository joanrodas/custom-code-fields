<?php

namespace CPF\Field;

class SwitchField extends Field
{

	public function __construct(string $type, string $slug, string $name)
	{
		parent::__construct($type, $slug, $name);
		$this->default_value = false;
	}

	public function display($parent='')
	{
		$key = $parent . '_' . $this->slug;
		$checked = get_post_meta(get_the_ID(), '_' . $this->slug, true);
		if ($checked == '') $checked = $this->default_value;
		ob_start(); ?>
		<style>
			/* The switch - the box around the slider */
			.switch {
				position: relative;
				display: inline-block;
				width: 2.75rem !important;
				height: 1.5rem;
				margin: 0 !important;
			}

			/* Hide default HTML checkbox */
			.switch input {
				opacity: 0;
				width: 0;
				height: 0;
			}

			/* The slider */
			.slider {
				position: absolute;
				cursor: pointer;
				top: 0;
				left: 0;
				right: 0;
				bottom: 0;
				background-color: #ccc;
				-webkit-transition: .4s;
				transition: .4s;
			}

			.slider:before {
				position: absolute;
				content: "";
				height: 1rem;
				width: 1rem;
				left: 4px;
				bottom: 4px;
				background-color: white;
				-webkit-transition: .4s;
				transition: .4s;
			}

			input:checked + .slider {
				background-color: #2271b1;
			}

			input:focus + .slider {
				box-shadow: 0 0 1px #2271b1;
			}

			input:checked + .slider:before {
				-webkit-transform: translateX(1.25rem);
				-ms-transform: translateX(1.25rem);
				transform: translateX(1.25rem);
			}

			/* Rounded sliders */
			.slider.round {
				border-radius: 34px;
			}

			.slider.round:before {
				border-radius: 50%;
			}
		</style>
		<p class="form-field _<?= $this->type ?>_field ">
			<label for="_<?= $this->slug ?>"><?= $this->name ?></label>
			<span>
				<label class="switch">
					<input type="checkbox" <?= $checked ? 'checked' : '' ?> name="_<?= $this->slug ?>" id="_<?= $this->slug ?>" value="1">
					<span class="slider round"></span>
				</label>
			</span>
		</p>
		<?php echo ob_get_clean();
	}

	public function display_complex($parent='') {
		$key = $parent . '_' . $this->slug;
		ob_start(); ?>
		<style>
			/* The switch - the box around the slider */
			.switch {
				position: relative;
				display: inline-block;
				width: 2.75rem !important;
				height: 1.5rem;
				margin: 0 !important;
			}

			/* Hide default HTML checkbox */
			.switch input {
				opacity: 0;
				width: 0;
				height: 0;
			}

			/* The slider */
			.slider {
				position: absolute;
				cursor: pointer;
				top: 0;
				left: 0;
				right: 0;
				bottom: 0;
				background-color: #ccc;
				-webkit-transition: .4s;
				transition: .4s;
			}

			.slider:before {
				position: absolute;
				content: "";
				height: 1rem;
				width: 1rem;
				left: 4px;
				bottom: 4px;
				background-color: white;
				-webkit-transition: .4s;
				transition: .4s;
			}

			input:checked + .slider {
				background-color: #2271b1;
			}

			input:focus + .slider {
				box-shadow: 0 0 1px #2271b1;
			}

			input:checked + .slider:before {
				-webkit-transform: translateX(1.25rem);
				-ms-transform: translateX(1.25rem);
				transform: translateX(1.25rem);
			}

			/* Rounded sliders */
			.slider.round {
				border-radius: 34px;
			}

			.slider.round:before {
				border-radius: 50%;
			}
		</style>
		<p class="form-field _<?= $this->type ?>_field ">
			<label for="_<?= $this->slug ?>"><?= $this->name ?></label>
			<span>
				<label class="switch">
					<input x-cloak type="checkbox" :checked="entries[tab] ? entries[tab]['<?= $this->slug ?>'] : '<?= $this->default_value ? "true" : "false" ?>'" name="_<?= $this->slug . '[]' ?>" id="_<?= $this->slug ?>" value="1">
					<span class="slider round"></span>
				</label>
			</span>
		</p>
		<?php echo ob_get_clean();
	}

	public function save($product_id, $parent='')
	{		
		$key = $parent . '_' . $this->slug;
		if (isset($_POST[$key])) { // phpcs:ignore
			update_post_meta($product_id, $key, '1'); // phpcs:ignore
		}
		else {
			update_post_meta($product_id, $key, '0'); // phpcs:ignore
		}
	}
}
