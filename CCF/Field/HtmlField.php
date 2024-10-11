<?php

namespace CCF\Field;

class HtmlField extends Field
{

	private $html = '';

	public function display($parent = '')
	{
		echo wp_kses_post($this->html);
	}

	public function html($html)
	{
		$this->html = '<div style="padding: 5px 20px 5px 162px!important;">' . $html . '</div>';
		return $this;
	}

	public function save($object_id, $context = 'product', $parent = '')
	{
		return;
	}
}
