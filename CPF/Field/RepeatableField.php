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

    public function display_complex(string $parent='') {
        $this->display($parent);
    }

    public function display(string $parent='') {
        $full_slug = $parent ? $parent . '_' . $this->slug : '_' . $this->slug;
        $values = get_post_meta(get_the_ID(), $full_slug, true);
        $entries = $values ? count($values) : 0; //TODO: ERROR
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
                            <?php $field->display_complex($full_slug); ?>
                        <?php endforeach; ?>
                        <div style="display: flex; justify-content: end;">
                            <span class="dashicons dashicons-trash" style="cursor: pointer" @click="tabs -= 1; entries.splice(selected_tab, 1); selected_tab -= 1;"></span>
                        </div>
                    </div>
                </template>
                <input type="hidden" name="<?= $full_slug ?>" :value="tabs">
                <div x-show="tabs === 0" style="margin-left: 9px; border: 1px gainsboro solid; font-size: 16px;">
                    <p style="font-size: 16px;">There are no entries yet.</p>
                    <button type="button" style="margin: 9px; padding: 9px; cursor: pointer;" @click="selected_tab = tabs; tabs += 1;">Add Entry</button>
                </div>
            </div>
        <?php echo ob_get_clean();
    }

    public function save($product_id, $parent='') {
        //TODO: FOR EACH ENTRY/TAB. Passar numtabs
        // $fields = array();
        $key = $parent ? $parent . '_' . $this->slug : '_' . $this->slug;
        
        if(isset($_POST[$key])) {
            $num_entries = $_POST[$key];
            update_post_meta($product_id, $key, $num_entries); //Save num entries
        }

        for($i=0; $i < $num_entries; ++$i ) {
            foreach ($this->fields as $field) {
                // $fields[$field->slug] = $_POST['_' . $field->slug] ?? array();
                $field->save($product_id, $key . '_' . $i);
            }
        }
        
        // $results = array();
        // error_log(print_r($_POST, true));
        // for ($entry = 0; $entry < max(array_map('count', $fields)); $entry++) {
        //     $results[$entry] = array();
        //     foreach($fields as $slug => $field) {
        //         $results[$entry][$slug] = $field[$entry] ?? '';
        //     }
        // }
        // $key = '_' . $this->slug;
        // if(!empty($results)) update_post_meta($product_id, $key, $results);
    }

}