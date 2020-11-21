<?php
/*
Plugin Name: Gravity forms Extension
Plugin URI: 
Description: 
Author: Matrosov Stanislav
Version: 1.0.0
*/

define('GF7_EXT_DIR', dirname(__FILE__) );

/*
Original site
https://checklist.abcpediatrictherapy.com/


Useful links
https://www.gravityforms.com/
https://docs.gravityforms.com/shortcodes/
https://docs.gravityforms.com/category/developers/


// Ready plugin with almost the same features
https://wordpress.org/plugins/auto-advance-for-gravity-forms/#description

!!! https://gravitywiz.com/gravity-forms-hook-reference/ !!!
*/




add_action( 'wp_enqueue_scripts', 'theme_name_scripts' );
// add_action('wp_print_styles', 'theme_name_scripts'); More late hook
function theme_name_scripts() {
	//wp_enqueue_style( 'style-name', plugins_url('style.css?t='.time(), __FILE__) );

	//wp_enqueue_script( 'newscript2', plugins_url('js/scripts.js?t='.time(), __FILE__) );
}


// For experiments
include( 'playground.php' );
include( 'classes/functions.php' );
include( 'classes/shortcodes.php' );
include( 'classes/custom_post_types.php' );

add_action('init', 'gf_ext_init');
function gf_ext_init() {
	
	if( $_GET['log'] ) {
		GetAgePages();
	}
	
}






/*
include( 'classes/class.php' );

include( 'events/install.php' );
include( 'events/main.php' );
*/





		
?>