<?php
namespace CPF\Field;

class Field
{
    protected $type;
    protected $slug;
    protected $name;
    protected $default_value;

    public function __construct(string $type, string $slug, string $name)
    {
        $this->type = $type;
        $this->slug = $slug;
        $this->name = $name;
        $this->default_value = '';
    }

    public function default_value($default_value)
    {
		$this->default_value = $default_value;
		return $this;
	}

    public static function create(string $type, string $slug, string $name)
    {
        $class = __NAMESPACE__ . '\\' . str_replace(' ', '', ucwords(str_replace('_', ' ', $type))) . 'Field';
        return (new $class($type, $slug, $name));
    }

    public function save($product_id, $parent='')
	{
        $key = $parent . '_' . $this->slug;
		if (isset($_POST[$key])) { // phpcs:ignore
			update_post_meta($product_id, $key, sanitize_text_field($_POST[$key])); // phpcs:ignore
		}
	}

    public function delete($product_id, $parent='')
	{
        $key = $parent . '_' . $this->slug;
		delete_post_meta($product_id, $key); // phpcs:ignore
	}

}
