<?php
namespace CPF\Field\Traits;

trait Datalist {
    private $datalist = [];

    public function set_datalist($datalist)
	{
		if (is_callable($datalist)) $datalist = call_user_func($datalist);
		$this->datalist = (array) $datalist;
		return $this;
	}

	public function display($parent='')
	{
		$key = $parent . '_' . $this->slug;
		$this->datalist = apply_filters( $key . '_datalist', $this->datalist );
		parent::display($parent);
	}
}