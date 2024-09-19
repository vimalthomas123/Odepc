<?php

if ( function_exists('register_sidebar') ){
  register_sidebar(array(
      'name' => 'Left Sidebar',
      'id'   => 'sidebar-1',
      'before_widget' => '<section id="%1$s" class="widget %2$s">',
      'after_widget' => '</section>',
      'before_title' => '<h2 class="widget-title">',
      'after_title' => '</h2>',
  ));
}

add_theme_support('post-thumbnails');
set_post_thumbnail_size('my_thumb',190,140,true);
add_image_size( 'img_488x550',488, 550, true );
add_image_size( 'hire_job',568, 372, true );
add_image_size( 'bg_800x560',800, 560, true );
add_image_size( 'news_thumb',367,208,true);
add_image_size( 'img_360x360',360,360,true);
add_image_size( 'video_poster',969,459,true);
add_image_size( 'business_logos',168,63,true);
add_image_size( 'img_1149x680',1149,680,true);
 //prtfolio header banner
// to call this thumbnail, put this in template:-> the_post_thumbnail('my_thumb'); 

//Remove P wrapped on img from both ACF content & the_content
function filter_ptags_on_images($content) {
  $content = preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
  return preg_replace('/<p>\s*(<iframe .*>*.<\/iframe>)\s*<\/p>/iU', '\1', $content);
}
add_filter('acf_the_content', 'filter_ptags_on_images', 9999);
add_filter('the_content', 'filter_ptags_on_images', 9999);

// This theme uses wp_nav_menu() in one location.  
register_nav_menus( array(
  'primary' => __( 'Primary Navigation', 'px theme' ),
  'footer' => __('Footer Navigation', 'px theme'),
	'forcandidate' => __('Candidate Navigation', 'px theme'),
	'partnership' => __('Partnership Navigation', 'px theme'),
	'travel' => __('Travel Navigation', 'px theme'),
	'footerend' => __('Footerend Navigation', 'px theme'),
));


/**
 * Register Custom Navigation Walker
 */
function register_navwalker(){
	require_once get_template_directory() . '/class-wp-bootstrap-navwalker.php';
}
add_action( 'after_setup_theme', 'register_navwalker' );


// -----------------------------------------------------Enqueue scripts and stylesheets----------------------------------------------------------
function add_theme_scripts() {
	// style
	wp_enqueue_style('main', get_template_directory_uri() . '/assets/styles/styles.min.css');
	wp_enqueue_style('custom', get_template_directory_uri() . '/assets/styles/custom.css');
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	// script


	// wp_register_script('jquery', get_template_directory_uri() . '/assets/scripts/jquery.min.js', false, null, true);
	wp_register_script('plugin', get_template_directory_uri() . '/assets/scripts/plugins.min.js', false, null, true);
  wp_register_script('app', get_template_directory_uri() . '/assets/scripts/app.min.js', false, null, true);
  wp_register_script('custom', get_template_directory_uri() . '/assets/scripts/custom.js', false, null, true);
	wp_enqueue_script('plugin');
  wp_enqueue_script('app');
  wp_enqueue_script('custom');
}
add_action( 'wp_enqueue_scripts', 'add_theme_scripts' );


// ---------------------------------------------------  acf theme options  -----------------------------------------------------------------------------------------
if( function_exists('acf_add_options_page') ) {
	acf_add_options_page(array(
		'page_title' 	=> 'Theme General Settings',
		'menu_title'	=> 'Theme Settings',
		'menu_slug' 	=> 'theme-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Theme Header Settings',
		'menu_title'	=> 'Header',
		'parent_slug'	=> 'theme-general-settings',
	));
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Theme Footer Settings',
		'menu_title'	=> 'Footer',
		'parent_slug'	=> 'theme-general-settings',
	));
}
add_filter('use_block_editor_for_post', '__return_false');


// The following code snippet removes the bundle on the frontend, thus removing jquery-migrate.js, then re-loads ‘jquery-core’ by itself.
function crave_remove_jquery_migrate( &$scripts) {
	if(!is_admin()) {
		$scripts->remove('jquery');
		$scripts->add('jquery', false, array( 'jquery-core' ), '1.12.4');
	}
}
add_action( 'wp_default_scripts', 'crave_remove_jquery_migrate' );


// event order



// activate DNS prefetch lookup.
function dns_prefetch() {
$prefetch = 'on';
    echo '<meta http-equiv="x-dns-prefetch-control" content="'.$prefetch.'">';
    if ($prefetch != 'on') {
      $dns_domains = array( 
          "//use.typekit.net",
          "//netdna.bootstrapcdn.com", 
          "//cdnjs.cloudflare.com",
          "//ajax.googleapis.com", 
          "//s0.wp.com",
          "//s.gravatar.com",
          "//stats.wordpress.com",
          "//www.google-analytics.com"
      );
      foreach ($dns_domains as $domain) {
        if (!empty($domain)) echo '<link rel="dns-prefetch" href="'.$domain.'" />';
      }
      unset($domain);
    }
}
add_action( 'wp_head', 'dns_prefetch', 0 );



function getStyles($string, $tag, $color) {
  switch ($tag) {
    case "h1":
      return '<h1 class="' .$color. '">' .$string. '</h1>';
      break;
    case "h2":
      return '<h2 class="' .$color. '">' .$string. '</h2>';
      break;
    case "h3":
      return '<h3 class="' .$color. '">' .$string. '</h3>';
      break;
    case "h4":
      return '<h4 class="' .$color. '">' .$string. '</h4>';
      break;
    case "h5":
      return '<h5 class="' .$color. '">' .$string. '</h5>';
      break;
    case "h6":
      return '<h6 class="' .$color. '">' .$string. '</h6>';
      break;
    case "p":
      return '<p class="' .$color. '">' .$string. '</p>';
      break;
    default:
      return $string;
  }
}

function getColClass($count) {
  switch ($count) {
    case 1:
      return 'col-md-12';
      break;
    case 2:
      return 'col-md-6';
      break;
    case 3:
      return 'col-md-4';
      break;
    case 4:
      return 'col-md-3';
      break;
    default:
      return 'col-md-3';
  }
}

function getBadgeClass($badge) {
  switch ($badge) {
    case 'full-time':
      return 'badge-primary';
      break;
    case 'temporary':
      return 'badge-danger';
      break;
    case 'freelance':
      return 'badge-success';
      break;
    case 'part-time':
      return 'badge-warning';
      break;
    default:
      return '';
  }
}

add_filter( 'get_the_archive_title', function ($title) {    
  if ( is_category() ) {    
          $title = single_cat_title( '', false );    
      } elseif ( is_tag() ) {    
          $title = single_tag_title( '', false );    
      } elseif ( is_author() ) {    
          $title = '<span class="vcard">' . get_the_author() . '</span>' ;    
      } elseif ( is_tax() ) { //for custom post types
          $title = sprintf( __( '%1$s' ), single_term_title( '', false ) );
      }    
  return $title;    
});


function get_taxonomy_hierarchy( $taxonomy, $parent = 0 ) {
	$taxonomy = is_array( $taxonomy ) ? array_shift( $taxonomy ) : $taxonomy;
	$terms = get_terms( $taxonomy, array( 'parent' => $parent ) );
	$children = [];
	foreach ( $terms as $term ){
		$term->children = get_taxonomy_hierarchy( $taxonomy, $term->term_id );
		$children[ $term->term_id ] = $term;
	}
	return $children;
}


function timeago($date) {
  $timestamp = strtotime($date);	
  
  $strTime = array("second", "minute", "hour", "day", "month", "year");
  $length = array("60","60","24","30","12","10");

  $currentTime = time();
  if($currentTime >= $timestamp) {
   $diff     = time()- $timestamp;
   for($i = 0; $diff >= $length[$i] && $i < count($length)-1; $i++) {
   $diff = $diff / $length[$i];
   }

   $diff = round($diff);
   return $diff . " " . $strTime[$i] . "(s) ago ";
  }
}



function gt_get_post_view() {
  $count = get_post_meta( get_the_ID(), 'post_views_count', true );
  return "$count";
}
function gt_set_post_view() {
  $key = 'post_views_count';
  $post_id = get_the_ID();
  $count = (int) get_post_meta( $post_id, $key, true );
  $count++;
  update_post_meta( $post_id, $key, $count );
}
function gt_posts_column_views( $columns ) {
  $columns['post_views'] = 'Views';
  return $columns;
}
function gt_posts_custom_column_views( $column ) {
  if ( $column === 'post_views') {
      echo gt_get_post_view();
  }
}
add_filter( 'manage_posts_columns', 'gt_posts_column_views' );
add_action( 'manage_posts_custom_column', 'gt_posts_custom_column_views' );


/**
 * Filter the except length to 20 words.
 *
 * @param int $length Excerpt length.
 * @return int (Maybe) modified excerpt length.
 */
function wpdocs_custom_excerpt_length( $length ) {
  global $post;
    if ($post->post_type == 'news')
    {

      return 17;
    }
}
add_filter( 'excerpt_length', 'wpdocs_custom_excerpt_length', 999 );

/**
 * Change the excerpt more string
 */
function my_theme_excerpt_more( $more ) {
  global $post;
  if ($post->post_type == 'news')
  {
  return '&hellip;';
}
}
add_filter( 'excerpt_more', 'my_theme_excerpt_more' );


// define the wpcf7_is_tel callback 
function custom_filter_wpcf7_is_tel( $result, $tel ) { 
  $result = preg_match( '/^\(?\+?([0-9]{1,4})?\)?[-\. ]?(\d{10})$/', $tel );
  return $result; 
}

add_filter( 'wpcf7_is_tel', 'custom_filter_wpcf7_is_tel', 10, 2 );


/**
 * Disable the emoji's
 */
function disable_emojis() {
  remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
  remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
  remove_action( 'wp_print_styles', 'print_emoji_styles' );
  remove_action( 'admin_print_styles', 'print_emoji_styles' ); 
  remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
  remove_filter( 'comment_text_rss', 'wp_staticize_emoji' ); 
  remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
  add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
  add_filter( 'wp_resource_hints', 'disable_emojis_remove_dns_prefetch', 10, 2 );
 }
 add_action( 'init', 'disable_emojis' );
 
 /**
  * Filter function used to remove the tinymce emoji plugin.
  * 
  * @param array $plugins 
  * @return array Difference betwen the two arrays
  */
 function disable_emojis_tinymce( $plugins ) {
  if ( is_array( $plugins ) ) {
  return array_diff( $plugins, array( 'wpemoji' ) );
  } else {
  return array();
  }
 }
 
 /**
  * Remove emoji CDN hostname from DNS prefetching hints.
  *
  * @param array $urls URLs to print for resource hints.
  * @param string $relation_type The relation type the URLs are printed for.
  * @return array Difference betwen the two arrays.
  */
 function disable_emojis_remove_dns_prefetch( $urls, $relation_type ) {
  if ( 'dns-prefetch' == $relation_type ) {
  /** This filter is documented in wp-includes/formatting.php */
  $emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/' );
 
 $urls = array_diff( $urls, array( $emoji_svg_url ) );
  }
 
 return $urls;
 }



 // Function accepting current query
 function my_change_order( $query ) {
  if($query->is_archive()) {

    if( $query->query['post_type'] == 'events'){
      $today = date("Ymd");
      //$query->set( 'post_type', 'events' );
      $query->set( 'orderby' , 'meta_value' );
      $query->set( 'meta_key' , 'start_date' );
      //$query->set( 'meta_value', $today );
      $query->set( 'order', 'DESC' );
    } else {
      return $query;
    }

  }

  // Return the query
  return $query;

}
// Runs before the posts are fetched
add_filter( 'pre_get_posts' , 'my_change_order' );