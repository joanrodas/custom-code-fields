<?php
namespace CPF\Tabs;

class Tab
{

    private $slug;
    private $name;
    private $fields;

    public function __construct(string $slug, string $name, $fields)
    {
        $this->slug = $slug;
        $this->name = $name;
        if (is_callable($fields)) {
			$fields = call_user_func($fields);
		}
		$this->fields = (array) $fields;
    }

    public static function create(string $slug, string $name, $fields)
    {
        return (new self($slug, $name, $fields));
    }

    public function display_nav() {
        ob_start(); ?>
        <a :class="{ 'active': tab === '<?= "tab_$this->slug" ?>' }" :style="tab === '<?= "tab_$this->slug" ?>' ? 'background: #2271b1; color: white; text-decoration: none; font-size: 1rem; text-transform: uppercase; padding: 0.5rem 1.5rem;' : 'text-decoration: none; font-size: 1rem; text-transform: uppercase; padding: 0.5rem 1.5rem;'" @click.prevent="tab = '<?= "tab_$this->slug" ?>'; window.location.hash = '<?= "tab_$this->slug" ?>'" href="#"><?= $this->name ?></a>
        <?php echo ob_get_clean();
    }

    public function display()
    {
        ob_start(); ?>
        <div x-cloak x-show="tab === '<?= "tab_$this->slug" ?>'" class='<?= "tab_$this->slug" ?>'>
            <?php foreach ($this->fields as $field): ?>
                <?php $field->display(); ?>
            <?php endforeach; ?>
        </div>
        <?php echo ob_get_clean();
    }

    public function slug() {
        return $this->slug;
    }

    public function save($product_id) {
        foreach ($this->fields as $field) {
            $field->save($product_id);
        }
    }

}
