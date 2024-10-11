<?php

namespace CCF\Section;

class UserSection extends Section
{
    private $user_ids;

    public function __construct(string $slug, string $name, array $fields)
    {
        parent::__construct($slug, $name, $fields);

        $this->user_ids = [];
        $this->section_type = 'user';

        add_action('edit_user_profile_update', [$this, 'save']);
        add_action('personal_options_update', [$this, 'save']);
        add_action('show_user_profile', [$this, 'display']);
        add_action('edit_user_profile', [$this, 'display']);

        add_action('admin_enqueue_scripts', function ($hook) {
            if ($hook === 'profile.php' || $hook === 'user-edit.php') {
                wp_enqueue_style('custom-code-fields/app.css', plugin_dir_url(__DIR__) . '../dist/app.css', false, __NAMESPACE__ . '\VERSION');
                wp_enqueue_script('custom-code-fields/app.js', plugin_dir_url(__DIR__) . '../dist/app.js', [], __NAMESPACE__ . '\VERSION', true);

                wp_localize_script('custom-code-fields/app.js', 'CCF_PARAMS', array(
                    'ajaxurl'   => admin_url('admin-ajax.php'),
                    'api_url'   => get_rest_url(null, 'custom-code-fields/v1'),
                    'nonce'     => wp_create_nonce('ajax-nonce'),
                    'restNonce'    => wp_create_nonce('wp_rest')
                ));
            };
        }, 0);
    }

    public function if_user_id($values)
    {
        $this->user_ids = (array) $values;
        return $this;
    }

    public function get_classes()
    {
        $classes = '';
        return $classes;
    }

    public function has_permission()
    {
        if (!parent::has_permission()) return false;

        $current_user = wp_get_current_user();
        $user_id = $current_user->ID;

        // Check user IDs
        if (!empty($this->user_ids) && !in_array($user_id, $this->user_ids)) {
            return false;
        }

        return true;
    }

    public function display()
    {
        if (!$this->has_permission()) return;

        $classes = $this->get_classes(); ?>

        <div class="options_group<?= $classes ?>" x-data="initSection(<?= isset($_GET['user_id']) ? intval($_GET['user_id']) : get_current_user_id() ?>, '<?= $this->section_type ?>')">
    <?php
        foreach ($this->fields as $field) {
            $field->display();
        }
        echo '</div>';
    }
}
