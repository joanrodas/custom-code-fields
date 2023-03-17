<?php

namespace CPF\Section;

class Section
{
	private $slug;
	private $name;
	private $fields;
	private $tab;
	private $product_type;
	private $checked;
	private $not_checked;
	private $roles;
	private $ids;
	private $capabilities;
	private $callable_conditional;

	public function __construct(string $slug, string $name, array $fields)
	{
		$this->slug = $slug;
		$this->name = $name;
		$this->fields = $fields;
		$this->tab = 'general';
		$this->product_type = [];
		$this->checked = [];
		$this->not_checked = [];
		$this->roles = [];
		$this->ids = [];
		$this->capabilities = [];
		$this->callable_conditional = false;
		add_action('woocommerce_product_options_general_product_data', [$this, 'display_default']);
		add_action('woocommerce_process_product_meta', [$this, 'save']);
	}

	public function if_tab(string $tab)
	{
		$this->tab = $tab;
		remove_action('woocommerce_product_options_general_product_data', array($this, 'display_default'));
		if (!in_array($tab, ['general', 'inventory', 'related', 'attributes', 'advanced'])) {
			add_action('woocommerce_product_data_panels', function () {
				echo "<div id='$this->tab' class='panel woocommerce_options_panel hidden'>";
				$this->display();
				echo '</div>';
			});
		} else {
			add_action("woocommerce_product_options_{$tab}_product_data", array($this, 'display'));
		}
		return $this;
	}

	public function if_product_type($product_type)
	{
		$this->product_type = (array) $product_type;
		return $this;
	}

	public function if_checked($values)
	{
		$this->checked = (array) $values;
		return $this;
	}

	public function if_not_checked($values)
	{
		$this->not_checked = (array) $values;
		return $this;
	}

	public function if_roles($values)
	{
		$this->roles = (array) $values;
		return $this;
	}

	public function if_capabilities($values)
	{
		$this->capabilities = (array) $values;
		return $this;
	}

	public function if_id($values)
	{
		$this->ids = (array) $values;
		return $this;
	}

	public function if($callable_conditional)
	{
		$this->callable_conditional = $callable_conditional;
		return $this;
	}

	public static function create(string $slug, string $name, array $fields)
	{
		return (new self($slug, $name, $fields));
	}

	public function display()
	{
		global $post;
		//CHECK ROLES
		if ($this->roles) {
			$user = wp_get_current_user();
			$roles = (array) $user->roles;
			if (!array_intersect($roles, $this->roles)) return;
		}

		//CHECK CAPABILITIES
		if ($this->capabilities) {
			$has_cap = false;
			foreach ($this->capabilities as $cap) {
				if (current_user_can($cap)) {
					$has_cap = true;
					break;
				}
			}
			if (!$has_cap) return;
		}

		//CHECK IDS
		if ($this->ids) {
			if (!in_array($post->ID, $this->ids)) return;
		}

		//CHECK CUSTOM CONDITION
		if ($this->callable_conditional && is_callable($this->callable_conditional)) {
			if (!call_user_func($this->callable_conditional)) return;
		}

		$classes = '';
		foreach ($this->product_type as $product_type) {
			$classes .= " show_if_$product_type";
		}
		foreach ($this->checked as $checked) {
			$classes .= " show_if_$checked hidden";
		}
		?>
		<div class="options_group<?=$classes?>" x-data="initSection(<?= get_the_ID() ?>)">
		<?php
		foreach ($this->fields as $field) {
			$field->display();
		}
		echo '</div>';
	}

	public function display_default()
	{
		if ($this->tab === 'general') {
			$this->display();
		}
	}

	public function save($post_id)
	{
		foreach ($this->fields as $field) {
			$field->save($post_id);
		}
	}
}
