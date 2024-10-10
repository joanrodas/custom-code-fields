<?php

namespace CCF\Section;

class UserSection extends Section
{
    private $user_roles;
    private $user_ids;
    private $capabilities;

    public function __construct(string $slug, string $name, array $fields) 
    {
        parent::__construct($slug, $name, $fields);

        $this->user_roles = ['all'];
        $this->user_ids = [];
        $this->capabilities = [];
        $this->section_type = 'user';
        
        add_action('edit_user_profile_update', [$this, 'save']);
        add_action('personal_options_update', [$this, 'save']);
        add_action('show_user_profile', [$this, 'display']);
        add_action('edit_user_profile', [$this, 'display']);
    }

    public function if_user_role($roles)
    {
        $this->user_roles = (array) $roles;
        return $this;
    }

    public function if_user_id($values)
    {
        $this->user_ids = (array) $values;
        return $this;
    }

    public function if_capability($capabilities)
    {
        $this->capabilities = (array) $capabilities;
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

        // Check user roles
        if (!in_array('all', $this->user_roles)) {
            $user_roles = $current_user->roles;
            if (!array_intersect($user_roles, $this->user_roles)) {
                return false;
            }
        }

        // Check user IDs
        if (!empty($this->user_ids) && !in_array($user_id, $this->user_ids)) {
            return false;
        }

        // Check capabilities
        foreach ($this->capabilities as $capability) {
            if (!current_user_can($capability)) {
                return false;
            }
        }

        return true;
    }

}