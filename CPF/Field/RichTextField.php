<?php

namespace CPF\Field;

class RichTextField extends Field
{
    private $rows = 4;

    public function display()
    {
        $input = '';
        $value = get_post_meta(get_the_ID(), '_' . $this->slug, true);
        if ($this->type == 'rich_text') {
            ob_start(); ?>
            <div class="form-field _<?= $this->type ?>_field " style="padding: 5px 20px 5px 162px !important; margin: 9px 0;">
                <label for="_<?= $this->slug ?>"><?= $this->name ?></label>
                <?php
                $args = array(
                    'media_buttons' => true, // This setting removes the media button.
                    'textarea_name' => "_" . $this->slug, // Set custom name.
                    'textarea_rows' => $this->rows, //Determine the number of rows.
                    'quicktags' => false, // Remove view as HTML button.
                );
                wp_editor($value, "_" . $this->slug, $args); ?>
            </div>
            <?php $input = ob_get_clean();
        }
        echo $input;
    }

    public function display_complex(string $parent='') {
        $input = '';
        if ($this->type == 'rich_text') {
            ob_start(); ?>
            <div class="form-field _<?= $this->type ?>_field " style="padding: 5px 20px 5px 162px !important; margin: 9px 0;" x-data="{full_slug: '<?= $parent . "_" ?>' + tab + '<?= "_".$this->slug ?>'}">
                <label :for="full_slug"><?= $this->name ?></label>
                <?php
                $args = array(
                    'media_buttons' => true,
                    'textarea_name' => "_" . $this->slug . '[]',
                    'textarea_rows' => $this->rows,
                    'quicktags' => false,
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

}
