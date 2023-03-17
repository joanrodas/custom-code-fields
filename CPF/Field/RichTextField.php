<?php

namespace CPF\Field;

class RichTextField extends Field
{
    private $rows = 4;

    public function display($parent='')
    {
        $key = $parent . '_' . $this->slug;
        $value = get_post_meta(get_the_ID(), $key, true);
        if ($value == '') $value = $this->default_value;
        ob_start(); ?>
        <div class="form-field _<?= $this->type ?>_field " style="padding: 5px 20px 5px 162px !important; margin: 9px 0;">
            <label for="<?= $key ?>"><?= $this->name ?></label>
            <?php
            $args = array(
                'media_buttons' => true, // This setting removes the media button.
                'textarea_name' => $key, // Set custom name.
                'textarea_rows' => $this->rows, //Determine the number of rows.
                'quicktags' => false, // Remove view as HTML button.
            );
            wp_editor($value, $key, $args); ?>
        </div>
        <?php echo ob_get_clean();
    }

    public function display_complex($parent='')
    {
        $key = $parent . '_' . $this->slug;
        ob_start(); ?>
        <div class="form-field _<?= $this->type ?>_field " style="padding: 5px 20px 5px 162px !important; margin: 9px 0;">
            <label for="<?= $key ?>"><?= $this->name ?></label>
            <?php
            $args = array(
                'media_buttons' => true,
                'textarea_name' => $key . '[]',
                'textarea_rows' => $this->rows,
                'quicktags' => false,
            );
            wp_editor($value, $key, $args); // TODO: NO FUNCIONA AL COMPLEX; JA QUE NO ES POT AFEGIR ALPINE ?>
        </div>
        <?php echo ob_get_clean();
    }

    public function rows($rows)
    {
        $this->rows = sanitize_text_field($rows);
        return $this;
    }

}
