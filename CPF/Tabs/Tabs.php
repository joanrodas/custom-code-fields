<?php
namespace CPF\Tabs;

class Tabs
{

    private $slug;
    private $name;
    private $tabs;

    public function __construct(string $slug, string $name, $tabs)
    {
        $this->slug = $slug;
        $this->name = $name;
        if (is_callable($tabs)) {
			$tabs = call_user_func($tabs);
		}
		$this->tabs = (array) $tabs;
    }

    public static function create(string $slug, string $name, $tabs)
    {
        return (new self($slug, $name, $tabs));
    }

    public function display()
    {
        $classes = "tabs_$this->slug";
        $child_slug = $this->tabs ? $this->tabs[0]->slug() : '';
        ob_start() ?>
        <div x-data="{ tab: window.location.hash ? window.location.hash.substring(1) : 'tab_<?= $child_slug ?>' }" class='<?= $classes ?>' style="border: 2px solid #2271b1; margin: 5px 20px 5px 162px!important; background: #f6f7f7;">
			<nav style="border-bottom: 2px solid #2271b1; display: flex; gap: 1rem; align-items: center;">
				<?php foreach ($this->tabs as $tab): ?>
					<?php $tab->display_nav(); ?>
				<?php endforeach; ?>
			</nav>
			<div>
				<?php foreach ($this->tabs as $tab): ?>
					<?php $tab->display(); ?>
				<?php endforeach; ?>
			</div>
		</div>
		<?php echo ob_get_clean();
    }

}