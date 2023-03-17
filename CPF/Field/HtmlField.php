<?php

namespace CPF\Field;

class HtmlField extends Field
{

    private $html = '';

	public function display($parent='')
	{
		echo $this->html;
	}

    public function html($html)
	{
		$this->html = '<div style="padding: 5px 20px 5px 162px!important;">' . wp_kses_post( $html ) . '</div>';
		return $this;
	}

	public function display_complex($parent='')
	{
		$this->display($parent);
	}

    public function save($product_id, $parent='')
	{
		return;
	}

}
