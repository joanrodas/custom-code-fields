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


    public static function create(string $type, string $slug, string $name, bool $save_individual = true)
    {
        $class = __NAMESPACE__ . '\\' . str_replace(' ', '', ucwords(str_replace('_', ' ', $type))) . 'Field';
        return (new $class($type, $slug, $name, $save_individual));
    }

}
