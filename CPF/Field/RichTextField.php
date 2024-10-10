<?php

namespace CCF\Field;

class RichTextField extends Field
{
    private $rows = 4;

    public function display()
    {
        // Generate a unique ID for the editor to avoid conflicts
        $editor_id = 'editor_' . $this->slug;

        ob_start(); ?>
        <div x-data="{ 
                field_name: field_name + '_<?= $this->slug ?>', 
                field_value: section_fields[field_name] !== undefined ? section_fields[field_name] : '<?= esc_js($this->default_value) ?>' 
            }"
            class="form-field _<?= $this->type ?>_field">
            <label :for="field_name"><?= $this->name ?></label>
            <div :id="'<?= $editor_id ?>'" x-init="
                wp.editor.initialize('<?= $editor_id ?>', {
                    tinymce: {
                        wpautop: true,
                        plugins: 'lists,link,wordpress,wpautoresize,wpeditimage',
                        toolbar1: 'formatselect,bold,italic,underline,bullist,numlist,link,unlink,wp_adv',
                        toolbar2: 'alignleft,aligncenter,alignright,alignjustify,forecolor,wp_help'
                    },
                    quicktags: true,
                    mediaButtons: true
                });
            ">
                <?php
                wp_editor(
                    $this->default_value,
                    $editor_id,
                    [
                        'textarea_name' => $this->slug,
                        'textarea_rows' => $this->rows,
                        'teeny' => false,
                        'media_buttons' => true,
                    ]
                );
                ?>
            </div>
        </div>
<?php echo ob_get_clean();
    }

    public function rows($rows)
    {
        $this->rows = sanitize_text_field($rows);
        return $this;
    }

    public function save($object_id, $context = 'post', $parent = '')
    {
        $key = $parent . '_' . $this->slug;
        $value = isset($_POST[$key]) ? wp_kses_post($_POST[$key]) : '';
        update_post_meta($object_id, $key, $value);
    }
}
