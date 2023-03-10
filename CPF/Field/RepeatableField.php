<?php

namespace CPF\Field;

class RepeatableField
{

    private $slug;
    private $name;
    private $fields;

    public function __construct(string $slug, string $name, $fields) {
        $this->slug = $slug;
        $this->name = $name;
        if (is_callable($fields)) $fields = call_user_func($fields);
        $this->fields = (array) $fields;
    }

    public static function create(string $slug, string $name, $fields) {
        return (new self($slug, $name, $fields));
    }

    public function display($parent='') {
        $values = get_post_meta(get_the_ID(), '_' . $this->slug, true);
        $entries = $values ? count($values) : 0;
        $classes = "repeatable_$this->slug";
        ob_start() ?>
            <style>.wp-editor-area { color: black !important; }</style>
            <div x-data='{ tabs: <?= $entries ?>, selected_tab: <?= $entries ? 0 : -1 ?>, entries: <?= $values ? str_replace("'", "’", json_encode($values)) : "[]" ?> }' x-cloak style="margin-right: 9px; margin-bottom: 9px">
                <p style="font-size: 16px; font-weight: bold;"><?= $this->name ?></p>
                <div style="display: flex; padding-left: 9px; padding-right: 9px; flex-wrap: wrap;">
                    <template x-for="tab in [...Array(tabs).keys()]">
                        <div :style="'padding: 10px 15px; margin: 0; font-size: 16px; font-weight: bold; border: 1px gainsboro solid; cursor: pointer;' + (selected_tab === tab ? 'border-bottom-color: white;' : 'background-color: ghostwhite;')" @click="selected_tab = tab;" x-text="tab + 1"></div>
                    </template>
                    <div :style="'padding: 10px 15px; margin: 0; font-size: 16px; font-weight: bold; border: 1px gainsboro solid; cursor: pointer;' + (tabs === 0 ? 'border-bottom-color: white;' : 'background-color: ghostwhite;')" @click="selected_tab = tabs; tabs += 1;">+</div>
                </div>
                <template x-for="tab in [...Array(tabs).keys()]">
                    <div :style="selected_tab === tab ? 'margin-left: 9px; padding: 9px; border: 1px gainsboro solid; display: flex; flex-direction: column;' : 'display: none'">
                        <?php foreach ($this->fields as $field): ?>
                            <?php $field->display_complex(); ?>
                        <?php endforeach; ?>
                        <div style="display: flex; justify-content: end;">
                            <span class="dashicons dashicons-trash" style="cursor: pointer" @click="tabs -= 1; entries.splice(selected_tab, 1); selected_tab -= 1;"></span>
                        </div>
                    </div>
                </template>
                <div x-show="tabs === 0" style="margin-left: 9px; border: 1px gainsboro solid; font-size: 16px;">
                    <p style="font-size: 16px;">There are no entries yet.</p>
                    <button type="button" style="margin: 9px; padding: 9px; cursor: pointer;" @click="selected_tab = tabs; tabs += 1;">Add Entry</button>
                </div>
            </div>
        <?php echo ob_get_clean();
    }

    public function save($product_id, $parent='')
    {
        $key = $parent . '_' . $this->slug;
        foreach ($this->fields as $field) {
            $field->save($product_id, $key);
        }
        update_post_meta($product_id, $key, count($this->fields));
    }

}