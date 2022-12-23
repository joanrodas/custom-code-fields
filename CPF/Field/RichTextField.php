<?php

namespace CPF\Field;

class RichTextField
{
    private $rows = 4;

    public function __construct(string $type, string $slug, string $name, bool $save_individual = true)
    {
        $this->type = $type;
        $this->slug = $slug;
        $this->name = $name;
        $this->save_individual = $save_individual;
        add_action('woocommerce_process_product_meta', [$this, 'save']);
    }


    public static function create(string $type, string $slug, string $name)
    {
        return (new self($type, $slug, $name));
    }

    public function display()
    {
        $input = '';
        $value = get_post_meta(get_the_ID(), '_' . $this->slug, true);
        if ($this->type == 'rich_text') {
            ob_start(); ?>
            <div class="form-field _<?= $this->type ?>_field " style="padding: 5px 20px 5px 162px!important; margin: 9px 0;">
                <label for="_<?= $this->slug ?>"><?= $this->name ?></label>
                <?php
                $args = array(
                    'media_buttons' => true, // This setting removes the media button.
                    'textarea_name' => "_" . ($this->save_individual ? $this->slug : $this->slug . "[]"), // Set custom name.
                    'textarea_rows' => $this->rows, //Determine the number of rows.
                    'quicktags' => false, // Remove view as HTML button.
                );
                wp_editor($value, "_" . $this->slug, $args); // TODO: NO FUNCIONA AL COMPLEX; JA QUE NO ES POT AFEGIR ALPINE ?>
            </div>
            <?php $input = ob_get_clean();
        }
        echo $input;
    }

    public function rows($rows)
    {
        $this->rows = sanitize_text_field($rows);
        return $this;
    }

    public function save($product_id)
    {
        if (!$this->save_individual) return;
        
        $key = '_' . $this->slug;
        if (isset($_POST[$key])) { // phpcs:ignore
            update_post_meta($product_id, $key, $_POST[$key]); // phpcs:ignore
        }
    }
}
