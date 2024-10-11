<?php

namespace CCF\Section;

class PostSection extends Section
{
	private $post_type;
	private $ids;

	public function __construct(string $slug, string $name, array $fields) 
	{
		parent::__construct($slug, $name, $fields);

		$this->post_type = ['post'];
		$this->ids = [];
		$this->section_type = 'post';
		
		add_action("save_post_post", [$this, 'save'], 20, 2 );
		add_action('add_meta_boxes', [$this, 'register_post_metabox']);
	}

	public function if_post_type($post_type)
	{
		remove_action("save_post_post", [$this, 'save'], 20);
		remove_action('add_meta_boxes', [$this, 'register_post_metabox']);

		$this->post_type = (array) $post_type;
		foreach ($this->post_type as $pt) {
			add_action("save_post_{$pt}", [$this, 'save'], 20, 2 );
			add_action('add_meta_boxes', [$this, 'register_post_metabox']);
		}

		add_action('admin_enqueue_scripts', function ($hook) {
			global $typenow;

			if (in_array($typenow, $this->post_type)) {
				wp_enqueue_style('custom-code-fields/app.css', plugin_dir_url(__DIR__) . '../dist/app.css', false, __NAMESPACE__ . '\VERSION');
				wp_enqueue_script('custom-code-fields/app.js', plugin_dir_url(__DIR__) . '../dist/app.js', [], __NAMESPACE__ . '\VERSION', true);

				wp_localize_script('custom-code-fields/app.js', 'CCF_PARAMS', array(
					'ajaxurl'   => admin_url('admin-ajax.php'),
					'api_url'   => get_rest_url(null, 'custom-code-fields/v1'),
					'nonce'     => wp_create_nonce('ajax-nonce'),
					'restNonce'	=> wp_create_nonce('wp_rest')
				));
			};
		}, 0);

		return $this;
	}

	public function if_id($values)
	{
		$this->ids = (array) $values;
		return $this;
	}

	public function get_classes() {
		$classes = '';
		return $classes;
	}

	public function has_permission()
	{
		if(!parent::has_permission()) return false;

		//CHECK IDS
		global $post;
		if ($this->ids) {
			if (!in_array($post->ID, $this->ids)) return false;
		}

		return true;
	}

	public function register_post_metabox()
	{
		foreach ($this->post_type as $pt) {
			$normalized_name = $this->name;
			add_meta_box( "{$normalized_name}_metabox", esc_html__($this->name), [$this, 'display'], $pt, 'advanced', 'high' );
		}
	}

}
