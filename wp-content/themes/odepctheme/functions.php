<?php

require_once locate_template('/lib/pagination.php');
require_once locate_template('/lib/breadcrumb.php'); 
require_once locate_template('/lib/custom-post.php');
require_once locate_template('/lib/job-search.php');  
require_once locate_template('/lib/apply-job.php'); 
require_once locate_template('/lib/email-job.php');
require_once locate_template('/lib/custom.php');

add_filter( 'wpcf7_validate_text', 'wpcs_custom_validation_filter', 10, 2 );
add_filter( 'wpcf7_validate_text*', 'wpcs_custom_validation_filter', 10, 2 );
 
function wpcs_custom_validation_filter( $result, $tag ) {
	$name = $tag->name;
 
	$value = isset( $_POST[$name] )
		? trim( wp_unslash( strtr( (string) $_POST[$name], "\n", " " ) ) )
		: '';
 
	if ( 'text' == $tag->basetype ) {
		if ( preg_match('/\d/', $value ) ) {
			$result->invalidate( $tag, 'Please enter only alphabetic characters.' );
//$result->invalidate( $tag, wpcf7_get_message( 'invalid_wpcs_custom_error' ) );
		}
	}
    return $result;
}

add_filter('wpcf7_validate_textarea', 'custom_textarea_validation', 10, 2);
add_filter('wpcf7_validate_textarea*', 'custom_textarea_validation', 10, 2); // For required textareas

function custom_textarea_validation($result, $tag) {
    $name = $tag->name;
 
	$value = isset( $_POST[$name] )
		? trim( wp_unslash( strtr( (string) $_POST[$name], "\n", " " ) ) )
		: '';
 
	if ( 'textarea' == $tag->basetype ) {
		 if (!preg_match('/^[a-zA-Z0-9.,!? ]*$/', $value)) {
        $result->invalidate($tag, 'Please avoid using special characters in your message.');
    }
	}
    return $result;
    
}
