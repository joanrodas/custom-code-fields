<?php
namespace CPF\Field\Traits;

trait NumericType {
    private $step;
	private $max;
	private $min;

    public function min($min)
	{
		$this->min = floatval($min);
		return $this;
	}

	public function max($max)
	{
		$this->max = floatval($max);
		return $this;
	}

	public function step($step)
	{
		$this->step = floatval($step);
		return $this;
	}
}