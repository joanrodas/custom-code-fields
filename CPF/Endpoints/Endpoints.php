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
        register_rest_route('custom-code-fields/v1', '/getFields/(?P<product_id>\d+)', array(
            'methods' => 'GET',
            'callback' => [$this, 'get_section_fields'],
            'permission_callback' => '__return_true' //TODO: Permission
        ));
    }

    public function get_section_fields(\WP_REST_Request $request)
    {
        global $wpdb;
        $product_id = $request->get_param('product_id');

        $results = get_post_meta($product_id);
        $fields = array_map(function($field) {
            return is_array($field) && !empty($field) ? $field[0] : $field;
        }, $results);
        
        return [
            'fields' => $fields
        ];
    }
}
