<?php

namespace CCF\Section;

class TermSection extends Section
{
    private $taxonomies;
    private $term_ids;

    public function __construct(string $slug, string $name, array $fields)
    {
        parent::__construct($slug, $name, $fields);

        $this->taxonomies = ['category', 'post_tag'];
        $this->term_ids = [];
        $this->section_type = 'term';

        add_action('created_term', [$this, 'save_term'], 10, 3);
        add_action('edited_term', [$this, 'save_term'], 10, 3);
        add_action("{$this->taxonomies[0]}_add_form_fields", [$this, 'display']);
        add_action("{$this->taxonomies[0]}_edit_form_fields", [$this, 'display']);
    }

    public function for_taxonomies($taxonomies)
    {
        $this->taxonomies = (array) $taxonomies;

        // Remove default actions
        remove_action("{$this->taxonomies[0]}_add_form_fields", [$this, 'display']);
        remove_action("{$this->taxonomies[0]}_edit_form_fields", [$this, 'display']);

        // Add actions for each taxonomy
        foreach ($this->taxonomies as $taxonomy) {
            add_action("{$taxonomy}_add_form_fields", [$this, 'display']);
            add_action("{$taxonomy}_edit_form_fields", [$this, 'display']);
        }

        return $this;
    }

    public function for_term_ids($term_ids)
    {
        $this->term_ids = (array) $term_ids;
        return $this;
    }

    public function get_classes()
    {
        $classes = parent::get_classes();
        // Add any additional classes specific to TermSection if needed
        return $classes;
    }

    public function has_permission()
    {
        if (!parent::has_permission()) return false;

        // If term_ids are set, check if current term is in the list
        if (!empty($this->term_ids)) {
            $current_term_id = isset($_GET['tag_ID']) ? intval($_GET['tag_ID']) : 0;
            if (!in_array($current_term_id, $this->term_ids)) {
                return false;
            }
        }

        return true;
    }

    public function save_term($term_id, $tt_id, $taxonomy)
    {
        if (!$this->has_permission()) return;

        if (!in_array($taxonomy, $this->taxonomies)) {
            return;
        }

        $this->save($term_id);
    }
}
