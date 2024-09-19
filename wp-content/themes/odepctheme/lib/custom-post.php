<?php
function job_post() {
  $labels = array(
    'name'                  => _x( 'Jobs', 'Post Type General Name', 'pixelflames' ),
    'singular_name'         => _x( 'Job', 'Post Type Singular Name', 'pixelflames' ),
    'menu_name'             => __( 'Jobs', 'pixelflames' ),
    'name_admin_bar'        => __( 'Jobs', 'pixelflames' ),
    'archives'              => __( 'Item Archives', 'pixelflames' ),
    'parent_item_colon'     => __( 'Parent Item:', 'pixelflames' ),
    'all_items'             => __( 'All Items', 'pixelflames' ),
    'add_new_item'          => __( 'Add New Item', 'pixelflames' ),
    'add_new'               => __( 'Add New', 'pixelflames' ),
    'new_item'              => __( 'New Item', 'pixelflames' ),
    'edit_item'             => __( 'Edit Item', 'pixelflames' ),
    'update_item'           => __( 'Update Item', 'pixelflames' ),
    'view_item'             => __( 'View Item', 'pixelflames' ),
    'search_items'          => __( 'Search Item', 'pixelflames' ),
    'not_found'             => __( 'Not found', 'pixelflames' ),
    'not_found_in_trash'    => __( 'Not found in Trash', 'pixelflames' ),
    'featured_image'        => __( 'Featured Image', 'pixelflames' ),
    'set_featured_image'    => __( 'Set featured image', 'pixelflames' ),
    'remove_featured_image' => __( 'Remove featured image', 'pixelflames' ),
    'use_featured_image'    => __( 'Use as featured image', 'pixelflames' ),
    'insert_into_item'      => __( 'Insert into item', 'pixelflames' ),
    'uploaded_to_this_item' => __( 'Uploaded to this item', 'pixelflames' ),
    'items_list'            => __( 'Items list', 'pixelflames' ),
    'items_list_navigation' => __( 'Items list navigation', 'pixelflames' ),
    'filter_items_list'     => __( 'Filter items list', 'pixelflames' ),
  );
  $args = array(
    'label'                 => __( 'Jobs', 'pixelflames' ),
    'description'           => __( 'Jobs Description', 'pixelflames' ),
    'labels'                => $labels,
    'supports'              => array( 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes', ),
    'taxonomies'            => array( 'locations','industries','types','post_tag'),
    'hierarchical'          => true,
    'public'                => true,
    'show_ui'               => true,
    'show_in_menu'          => true,
    'menu_position'         => 20,
    'menu_icon'             => 'dashicons-image-filter',
    'show_in_admin_bar'     => true,
    'show_in_nav_menus'     => true,
    'can_export'            => true,
    'has_archive'           => true,    
    'exclude_from_search'   => false,
    'publicly_queryable'    => true,
    'capability_type'       => 'page',
    // 'rewrite' => array('slug' => 'case')
  );
  register_post_type( 'jobs', $args );
}
add_action( 'init', 'job_post', 0 );


// Register Custom Taxonomy - Location
function location_tax() {
  $labels = array(
    'name'                       => _x( 'Job Locations', 'Locations General Name', 'pixelflames' ),
    'singular_name'              => _x( 'Job Location', 'Location Singular Name', 'pixelflames' ),
    'menu_name'                  => __( 'Job Locations', 'pixelflames' ),
    'all_items'                  => __( 'All Items', 'pixelflames' ),
    'parent_item'                => __( 'Parent Item', 'pixelflames' ),
    'parent_item_colon'          => __( 'Parent Item:', 'pixelflames' ),
    'new_item_name'              => __( 'New Item Name', 'pixelflames' ),
    'add_new_item'               => __( 'Add New Item', 'pixelflames' ),
    'edit_item'                  => __( 'Edit Item', 'pixelflames' ),
    'update_item'                => __( 'Update Item', 'pixelflames' ),
    'view_item'                  => __( 'View Item', 'pixelflames' ),
    'separate_items_with_commas' => __( 'Separate items with commas', 'pixelflames' ),
    'add_or_remove_items'        => __( 'Add or remove items', 'pixelflames' ),
    'choose_from_most_used'      => __( 'Choose from the most used', 'pixelflames' ),
    'popular_items'              => __( 'Popular Items', 'pixelflames' ),
    'search_items'               => __( 'Search Items', 'pixelflames' ),
    'not_found'                  => __( 'Not Found', 'pixelflames' ),
    'no_terms'                   => __( 'No items', 'pixelflames' ),
    'items_list'                 => __( 'Items list', 'pixelflames' ),
    'items_list_navigation'      => __( 'Items list navigation', 'pixelflames' ),
  );
  $args = array(
    'labels'                     => $labels,
    'hierarchical'               => true,
    'public'                     => true,
    'show_ui'                    => true,
    'show_admin_column'          => true,
    'show_in_nav_menus'          => true,
    'show_tagcloud'              => true,
  );
  register_taxonomy( 'locations', array( 'jobs' ), $args );
}
add_action( 'init', 'location_tax', 0 );


// Register Custom Taxonomy - Industries
function industries_tax() {
  $labels = array(
    'name'                       => _x( 'Job Industries', 'Industries General Name', 'pixelflames' ),
    'singular_name'              => _x( 'Job Industry', 'Industry Singular Name', 'pixelflames' ),
    'menu_name'                  => __( 'Job Industries', 'pixelflames' ),
    'all_items'                  => __( 'All Items', 'pixelflames' ),
    'parent_item'                => __( 'Parent Item', 'pixelflames' ),
    'parent_item_colon'          => __( 'Parent Item:', 'pixelflames' ),
    'new_item_name'              => __( 'New Item Name', 'pixelflames' ),
    'add_new_item'               => __( 'Add New Item', 'pixelflames' ),
    'edit_item'                  => __( 'Edit Item', 'pixelflames' ),
    'update_item'                => __( 'Update Item', 'pixelflames' ),
    'view_item'                  => __( 'View Item', 'pixelflames' ),
    'separate_items_with_commas' => __( 'Separate items with commas', 'pixelflames' ),
    'add_or_remove_items'        => __( 'Add or remove items', 'pixelflames' ),
    'choose_from_most_used'      => __( 'Choose from the most used', 'pixelflames' ),
    'popular_items'              => __( 'Popular Items', 'pixelflames' ),
    'search_items'               => __( 'Search Items', 'pixelflames' ),
    'not_found'                  => __( 'Not Found', 'pixelflames' ),
    'no_terms'                   => __( 'No items', 'pixelflames' ),
    'items_list'                 => __( 'Items list', 'pixelflames' ),
    'items_list_navigation'      => __( 'Items list navigation', 'pixelflames' ),
  );
  $args = array(
    'labels'                     => $labels,
    'hierarchical'               => true,
    'public'                     => true,
    'show_ui'                    => true,
    'show_admin_column'          => true,
    'show_in_nav_menus'          => true,
    'show_tagcloud'              => true,
  );
  register_taxonomy( 'industries', array( 'jobs' ), $args );
}
add_action( 'init', 'industries_tax', 0 );

// Register Custom Taxonomy - Types
function jobType_tax() {
  $labels = array(
    'name'                       => _x( 'Job Types', 'Types General Name', 'pixelflames' ),
    'singular_name'              => _x( 'Job Type', 'Type Singular Name', 'pixelflames' ),
    'menu_name'                  => __( 'Job Types', 'pixelflames' ),
    'all_items'                  => __( 'All Items', 'pixelflames' ),
    'parent_item'                => __( 'Parent Item', 'pixelflames' ),
    'parent_item_colon'          => __( 'Parent Item:', 'pixelflames' ),
    'new_item_name'              => __( 'New Item Name', 'pixelflames' ),
    'add_new_item'               => __( 'Add New Item', 'pixelflames' ),
    'edit_item'                  => __( 'Edit Item', 'pixelflames' ),
    'update_item'                => __( 'Update Item', 'pixelflames' ),
    'view_item'                  => __( 'View Item', 'pixelflames' ),
    'separate_items_with_commas' => __( 'Separate items with commas', 'pixelflames' ),
    'add_or_remove_items'        => __( 'Add or remove items', 'pixelflames' ),
    'choose_from_most_used'      => __( 'Choose from the most used', 'pixelflames' ),
    'popular_items'              => __( 'Popular Items', 'pixelflames' ),
    'search_items'               => __( 'Search Items', 'pixelflames' ),
    'not_found'                  => __( 'Not Found', 'pixelflames' ),
    'no_terms'                   => __( 'No items', 'pixelflames' ),
    'items_list'                 => __( 'Items list', 'pixelflames' ),
    'items_list_navigation'      => __( 'Items list navigation', 'pixelflames' ),
  );
  $args = array(
    'labels'                     => $labels,
    'hierarchical'               => true,
    'public'                     => true,
    'show_ui'                    => true,
    'show_admin_column'          => true,
    'show_in_nav_menus'          => true,
    'show_tagcloud'              => true,
  );
  register_taxonomy( 'types', array( 'jobs' ), $args );
}
add_action( 'init', 'jobType_tax', 0 );



/* ------------------------------------------------------------------News Post--------------------------------------------------------------- */

function news_post() {
  $labels = array(
    'name'                  => _x( 'News', 'Post Type General Name', 'pixelflames' ),
    'singular_name'         => _x( 'News', 'Post Type Singular Name', 'pixelflames' ),
    'menu_name'             => __( 'News', 'pixelflames' ),
    'name_admin_bar'        => __( 'News', 'pixelflames' ),
    'archives'              => __( 'Item Archives', 'pixelflames' ),
    'parent_item_colon'     => __( 'Parent Item:', 'pixelflames' ),
    'all_items'             => __( 'All Items', 'pixelflames' ),
    'add_new_item'          => __( 'Add New Item', 'pixelflames' ),
    'add_new'               => __( 'Add New', 'pixelflames' ),
    'new_item'              => __( 'New Item', 'pixelflames' ),
    'edit_item'             => __( 'Edit Item', 'pixelflames' ),
    'update_item'           => __( 'Update Item', 'pixelflames' ),
    'view_item'             => __( 'View Item', 'pixelflames' ),
    'search_items'          => __( 'Search Item', 'pixelflames' ),
    'not_found'             => __( 'Not found', 'pixelflames' ),
    'not_found_in_trash'    => __( 'Not found in Trash', 'pixelflames' ),
    'featured_image'        => __( 'Featured Image', 'pixelflames' ),
    'set_featured_image'    => __( 'Set featured image', 'pixelflames' ),
    'remove_featured_image' => __( 'Remove featured image', 'pixelflames' ),
    'use_featured_image'    => __( 'Use as featured image', 'pixelflames' ),
    'insert_into_item'      => __( 'Insert into item', 'pixelflames' ),
    'uploaded_to_this_item' => __( 'Uploaded to this item', 'pixelflames' ),
    'items_list'            => __( 'Items list', 'pixelflames' ),
    'items_list_navigation' => __( 'Items list navigation', 'pixelflames' ),
    'filter_items_list'     => __( 'Filter items list', 'pixelflames' ),
  );
  $args = array(
    'label'                 => __( 'News', 'pixelflames' ),
    'description'           => __( 'News Description', 'pixelflames' ),
    'labels'                => $labels,
    'supports'              => array( 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes', ),
    'taxonomies'            => array(),
    'hierarchical'          => true,
    'public'                => true,
    'show_ui'               => true,
    'show_in_menu'          => true,
    'menu_position'         => 20,
    'menu_icon'             => 'dashicons-text-page',
    'show_in_admin_bar'     => true,
    'show_in_nav_menus'     => true,
    'can_export'            => true,
    'has_archive'           => true,    
    'exclude_from_search'   => false,
    'publicly_queryable'    => true,
    'capability_type'       => 'page',
    // 'rewrite' => array('slug' => 'case')
  );
  register_post_type( 'news', $args );
}
add_action( 'init', 'news_post', 0 );



/* ------------------------------------------------------------------Event Post--------------------------------------------------------------- */

function event_post() {
  $labels = array(
    'name'                  => _x( 'Events', 'Post Type General Name', 'pixelflames' ),
    'singular_name'         => _x( 'Event', 'Post Type Singular Name', 'pixelflames' ),
    'menu_name'             => __( 'Events', 'pixelflames' ),
    'name_admin_bar'        => __( 'Event', 'pixelflames' ),
    'archives'              => __( 'Item Archives', 'pixelflames' ),
    'parent_item_colon'     => __( 'Parent Item:', 'pixelflames' ),
    'all_items'             => __( 'All Items', 'pixelflames' ),
    'add_new_item'          => __( 'Add New Item', 'pixelflames' ),
    'add_new'               => __( 'Add New', 'pixelflames' ),
    'new_item'              => __( 'New Item', 'pixelflames' ),
    'edit_item'             => __( 'Edit Item', 'pixelflames' ),
    'update_item'           => __( 'Update Item', 'pixelflames' ),
    'view_item'             => __( 'View Item', 'pixelflames' ),
    'search_items'          => __( 'Search Item', 'pixelflames' ),
    'not_found'             => __( 'Not found', 'pixelflames' ),
    'not_found_in_trash'    => __( 'Not found in Trash', 'pixelflames' ),
    'featured_image'        => __( 'Featured Image', 'pixelflames' ),
    'set_featured_image'    => __( 'Set featured image', 'pixelflames' ),
    'remove_featured_image' => __( 'Remove featured image', 'pixelflames' ),
    'use_featured_image'    => __( 'Use as featured image', 'pixelflames' ),
    'insert_into_item'      => __( 'Insert into item', 'pixelflames' ),
    'uploaded_to_this_item' => __( 'Uploaded to this item', 'pixelflames' ),
    'items_list'            => __( 'Items list', 'pixelflames' ),
    'items_list_navigation' => __( 'Items list navigation', 'pixelflames' ),
    'filter_items_list'     => __( 'Filter items list', 'pixelflames' ),
  );
  $args = array(
    'label'                 => __( 'Event', 'pixelflames' ),
    'description'           => __( 'Event Description', 'pixelflames' ),
    'labels'                => $labels,
    'supports'              => array( 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes', ),
    'taxonomies'            => array(),
    'hierarchical'          => true,
    'public'                => true,
    'show_ui'               => true,
    'show_in_menu'          => true,
    'menu_position'         => 20,
    'menu_icon'             => 'dashicons-text-page',
    'show_in_admin_bar'     => true,
    'show_in_nav_menus'     => true,
    'can_export'            => true,
    'has_archive'           => true,    
    'exclude_from_search'   => false,
    'publicly_queryable'    => true,
    'capability_type'       => 'page',
    // 'rewrite' => array('slug' => 'case')
  );
  register_post_type( 'events', $args );
}
add_action( 'init', 'event_post', 0 );



/* JOB APPLICANTS CPT*/
function job_applicants() {
  $labels = array(
    'name'                  => _x( 'Job Applicants', 'Post Type General Name', 'pixelflames' ),
    'singular_name'         => _x( 'Job Applicant', 'Post Type Singular Name', 'pixelflames' ),
    'menu_name'             => __( 'Applicants', 'pixelflames' ),
    'name_admin_bar'        => __( 'Applicant', 'pixelflames' ),
    'archives'              => __( 'Item Archives', 'pixelflames' ),
    'parent_item_colon'     => __( 'Parent Item:', 'pixelflames' ),
    'all_items'             => __( 'All Items', 'pixelflames' ),
    'add_new_item'          => __( 'Add New Item', 'pixelflames' ),
    'add_new'               => __( 'Add New', 'pixelflames' ),
    'new_item'              => __( 'New Item', 'pixelflames' ),
    'edit_item'             => __( 'Edit Item', 'pixelflames' ),
    'update_item'           => __( 'Update Item', 'pixelflames' ),
    'view_item'             => __( 'View Item', 'pixelflames' ),
    'search_items'          => __( 'Search Item', 'pixelflames' ),
    'not_found'             => __( 'Not found', 'pixelflames' ),
    'not_found_in_trash'    => __( 'Not found in Trash', 'pixelflames' ),
    'featured_image'        => __( 'Featured Image', 'pixelflames' ),
    'set_featured_image'    => __( 'Set featured image', 'pixelflames' ),
    'remove_featured_image' => __( 'Remove featured image', 'pixelflames' ),
    'use_featured_image'    => __( 'Use as featured image', 'pixelflames' ),
    'insert_into_item'      => __( 'Insert into item', 'pixelflames' ),
    'uploaded_to_this_item' => __( 'Uploaded to this item', 'pixelflames' ),
    'items_list'            => __( 'Items list', 'pixelflames' ),
    'items_list_navigation' => __( 'Items list navigation', 'pixelflames' ),
    'filter_items_list'     => __( 'Filter items list', 'pixelflames' ),
  );
  $args = array(
    'label'                 => __( 'Job Applicants', 'pixelflames' ),
    'description'           => __( 'Job Applicants Description', 'pixelflames' ),
    'labels'                => $labels,
    'supports'              => array( 'title', 'page-attributes', 'thumbnail' ),
    'taxonomies'            => array(),
    'hierarchical'          => true,
    'public'                => true,
    'show_ui'               => true,
    'show_in_menu'          => true,
    'menu_position'         => 20,
    'menu_icon'             => 'dashicons-groups',
    'show_in_admin_bar'     => true,
    'show_in_nav_menus'     => true,
    'can_export'            => true,
    'has_archive'           => true,    
    'exclude_from_search'   => false,
    'publicly_queryable'    => false,
    'capability_type'       => 'page',
    // 'rewrite' => array('slug' => 'case')
  );
  register_post_type( 'job_applicants', $args );
}
add_action( 'init', 'job_applicants', 0 );

