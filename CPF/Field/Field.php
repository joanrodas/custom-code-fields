<?php
namespace CPF\Field;

class Field
{

    protected $type;
    protected $slug;
    protected $name;

    public function __construct(string $type, string $slug, string $name)
    {
        $this->type = $type;
        $this->slug = $slug;
        $this->name = $name;
    }

    public static function create(string $type, string $slug, string $name)
    {
        $class = __NAMESPACE__ . '\\' . str_replace(' ', '', ucwords(str_replace('_', ' ', $type))) . 'Field';
        return (new $class($type, $slug, $name));
    }

    public function save($product_id, $parent='')
	{
        error_log(print_r($_POST, true));
		$key = $parent ? $parent . '_' . $this->slug : '_' . $this->slug;	
		if (isset($_POST[$key])) { // phpcs:ignore
			update_post_meta($product_id, $key, $_POST[$key]); // phpcs:ignore
		}
	}

}
