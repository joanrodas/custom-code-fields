<?php

namespace CPF\Endpoints;

class Endpoints
{
    public function __construct()
    {
        add_action('rest_api_init', [$this, 'register_endpoints']);
    }

    public function register_endpoints()
    {
        register_rest_route('custom-product-fields/v1', '/getFields/(?P<product_id>\d+)', array(
            'methods' => 'GET',
            'callback' => [$this, 'get_section_fields'],
            'permission_callback' => '__return_true' //TODO: Permission
        ));
    }

    public function get_section_fields(\WP_REST_Request $request)
    {
        global $wpdb;
        //$slug = $request->get_param('slug');
        $product_id = $request->get_param('product_id');
        // $results = $wpdb->get_results(
        //     $wpdb->prepare("SELECT meta_key, meta_value FROM {$wpdb->prefix}postmeta WHERE meta_key LIKE %s AND post_id = %d", [$slug . '%', $product_id]),
        //     OBJECT_K
        // );
        $results = get_post_meta($product_id);
        return [
            'fields' => $results
        ];
    }
}
