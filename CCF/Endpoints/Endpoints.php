<?php

namespace CCF\Endpoints;

class Endpoints
{
    public function __construct()
    {
        add_action('rest_api_init', [$this, 'register_endpoints']);
    }

    public function register_endpoints()
    {
        register_rest_route('custom-code-fields/v1', '/getFields/(?P<section_type>[\w-]+)/(?P<object_id>\d+)', array(
            'methods' => 'GET',
            'callback' => [$this, 'get_section_fields'],
            'permission_callback' => '__return_true' // TODO: Update with appropriate permission check
        ));
    }

    public function get_section_fields(\WP_REST_Request $request)
    {
        $object_id = $request->get_param('object_id');
        $section_type = $request->get_param('section_type');

        switch ($section_type) {
            case 'user':
                $results = get_user_meta($object_id);
                break;
            case 'attachment':
                $results = wp_get_attachment_metadata($object_id);
                break;
            case 'term':
                $results = get_term_meta($object_id);
                break;
            case 'comment':
                $results = get_comment_meta($object_id);
                break;
            default:
                $results = get_post_meta($object_id);
        }

        $fields = array_map(function ($field) {
            return is_array($field) && !empty($field) ? $field[0] : $field;
        }, $results);

        return [
            'fields' => $fields
        ];
    }
}
