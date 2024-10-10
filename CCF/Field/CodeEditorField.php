<?php

namespace CCF\Field;

class CodeEditorField extends Field
{
    private $language;
    private $indentUnit;
    private $useTabs;

    public function __construct(string $type, string $slug, string $name, string $language = 'javascript', int $indentUnit = 2, bool $useTabs = false)
    {
        parent::__construct($type, $slug, $name);
        $this->default_value = ''; // Default to an empty string
        $this->language = $language;
        $this->indentUnit = $indentUnit;
        $this->useTabs = $useTabs;
    }

    public function setLanguage(string $language)
    {
        $this->language = $language;
        return $this;
    }

    public function setIndentUnit(int $indentUnit)
    {
        $this->indentUnit = $indentUnit;
        return $this;
    }

    public function setUseTabs(bool $useTabs)
    {
        $this->useTabs = $useTabs;
        return $this;
    }

    public function display()
    {

        // Enqueue CodeMirror scripts and styles if not already enqueued
        if (!wp_script_is('wp-codemirror', 'enqueued')) {
            wp_enqueue_script('wp-codemirror');
            wp_enqueue_style('wp-codemirror');
        }

        // Enqueue the CodeMirror settings script
        if (!wp_script_is('code-editor', 'enqueued')) {
            wp_enqueue_script('code-editor');
        }

        // Generate a unique ID for the CodeMirror editor to avoid conflicts
        $editor_id = 'editor_' . $this->slug;

        ob_start(); ?>
        <div x-data="{ 
                field_name: field_name + '_<?= $this->slug ?>', 
                field_value: section_fields[field_name] !== undefined ? section_fields[field_name] : '<?= esc_js($this->default_value) ?>' 
            }"
            class="form-field _<?= $this->type ?>_field">
            <label :for="field_name"><?= $this->name ?></label>
            <textarea x-cloak
                :id="'<?= $editor_id ?>'"
                :name="field_name"
                class="code-editor short"
                style="width: 100%; height: 300px;"
                x-model="field_value"></textarea>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    wp.codeEditor.initialize('<?= $editor_id ?>', {
                        codemirror: {
                            mode: '<?= $this->language ?>',
                            lineNumbers: true,
                            indentUnit: <?= $this->indentUnit ?>,
                            indentWithTabs: <?= $this->useTabs ? 'true' : 'false' ?>,
                            tabSize: <?= $this->indentUnit ?>,
                        }
                    });
                });
            </script>
        </div>
<?php echo ob_get_clean();
    }

    public function save($object_id, $context = 'post', $parent = '')
    {
        $key = $parent . '_' . $this->slug;
        $value = isset($_POST[$key]) ? wp_kses_post($_POST[$key]) : '';
        update_post_meta($object_id, $key, $value);
    }
}
