<?php

namespace CCF\Section;

class Section
{
	protected $slug;
	protected $name;
	protected $fields;
	protected $roles;
	protected $capabilities;
	protected $callable_conditional;
	protected $section_type = 'product';

	public function __construct(string $slug, string $name, array $fields)
	{
		$this->slug = $slug;
		$this->name = $name;
		$this->fields = $fields;
		$this->roles = [];
		$this->capabilities = [];
		$this->callable_conditional = false;
	}

	public static function create(string $slug, string $name, array $fields)
	{
		return (new static($slug, $name, $fields));
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

	public function if($callable_conditional)
	{
		$this->callable_conditional = $callable_conditional;
		return $this;
	}

	public function has_permission()
	{
		//CHECK ROLES
		if ($this->roles) {
			$user = wp_get_current_user();
			$roles = (array) $user->roles;
			if (!array_intersect($roles, $this->roles)) return false;
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
			if (!$has_cap) return false;
		}

		//CHECK CUSTOM CONDITION
		if ($this->callable_conditional && is_callable($this->callable_conditional)) {
			if (!call_user_func($this->callable_conditional)) return false;
		}

		return true;
	}

	public function get_classes()
	{
		return '';
	}

	public function save($object_id)
	{
		foreach ($this->fields as $field) {
			$field->save($object_id, $this->section_type);
		}
	}

	public function display()
	{
		if(!$this->has_permission()) return;

		$classes = $this->get_classes(); ?>

		<div class="options_group<?=$classes?>" x-data="initSection(<?= get_the_ID() ?>, '<?= $this->section_type ?>')">
		<?php
		foreach ($this->fields as $field) {
			$field->display();
		}
		echo '</div>';
	}
}
