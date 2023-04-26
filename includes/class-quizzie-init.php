<?php
/**
 * Generic init functionality of the plugin.
 * Could be registering post types, taxonomies etc. that is not
 * directly related to admin or public and not warrant of
 * it's own folder directory.
 *
 * @since 1.0
 */

class Quizzie_Init {

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since   1.0
	 */
	public function __construct() {

		// Example action hook usage. Uncomment or delete.
		add_action( 'init', array( $this, 'init' ) );
	}
	


	/**
	 * Init.
	 * This could contain registration of post types etc.
	 *
	 * @since   1.0
	 */
	public function init() {
		$labels = array(
			'name'                  => _x( 'Quizzes', 'Post Type General Name', 'text_domain' ),
			'singular_name'         => _x( 'Quiz', 'Post Type Singular Name', 'text_domain' ),
			'menu_name'             => __( 'Quiz', 'text_domain' ),
			'name_admin_bar'        => __( 'Quiz', 'text_domain' ),
			'archives'              => __( 'Item Archives', 'text_domain' ),
			'attributes'            => __( 'Item Attributes', 'text_domain' ),
			'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
			'all_items'             => __( 'All Items', 'text_domain' ),
			'add_new_item'          => __( 'Add New Item', 'text_domain' ),
			'add_new'               => __( 'Add New', 'text_domain' ),
			'new_item'              => __( 'New Item', 'text_domain' ),
			'edit_item'             => __( 'Edit Item', 'text_domain' ),
			'update_item'           => __( 'Update Item', 'text_domain' ),
			'view_item'             => __( 'View Item', 'text_domain' ),
			'view_items'            => __( 'View Items', 'text_domain' ),
			'search_items'          => __( 'Search Item', 'text_domain' ),
			'not_found'             => __( 'Not found', 'text_domain' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
			'featured_image'        => __( 'Featured Image', 'text_domain' ),
			'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
			'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
			'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
			'insert_into_item'      => __( 'Insert into item', 'text_domain' ),
			'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
			'items_list'            => __( 'Items list', 'text_domain' ),
			'items_list_navigation' => __( 'Items list navigation', 'text_domain' ),
			'filter_items_list'     => __( 'Filter items list', 'text_domain' ),
		);
		$args = array(
			'label'                 => __( 'Quiz', 'text_domain' ),
			'description'           => __( 'Questions and answers for quiz', 'text_domain' ),
			'labels'                => $labels,
			'supports'              => array( 'title', 'editor' ),
			'taxonomies'            => array( 'category' ),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 5,
			'menu_icon'             => 'dashicons-buddicons-groups',
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => false,
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'capability_type'       => 'page',
		);
		$result = register_post_type( 'quiz', $args );
			if ( is_wp_error( $result ) ) {
				$error_string = $result->get_error_message();
				echo '<div class="error">' . $error_string . '</div>';
		}
		$this->create_result_page();
	}

	public function create_result_page() {

		// Check if the page already exists
		$args = array(
			'post_type' => 'page',
			'post_status' => 'publish',
			'name' => 'result-page'
		);
		$existing_page = new WP_Query($args);
	
		// Create a new page only if it doesn't exist
		if (!$existing_page->have_posts()) {
			// Create the new page here
			$result_page = array(
				'post_title'    => 'Result Page',
				'post_name'     => 'result-page',
				'post_content'  => '',
				'post_status'   => 'publish',
				'post_type'     => 'page'
			);
			$result_page_id = wp_insert_post($result_page, true);
		}
		else {
			// If the page already exists, get the ID of the existing page
			$result_page_id = $existing_page->posts[0]->ID;
		}
	
		function my_custom_template($template) {
			if ( is_page('result-page') ) {
			  $template = plugin_dir_path( __FILE__ ) . '/public/templates/result-page.php';
			}
			return $template;
		  }
		  add_filter( 'template_include', 'my_custom_template' );
		  
	}
	
	
	
}
new Quizzie_Init();
