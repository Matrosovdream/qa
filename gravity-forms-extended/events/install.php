<?php
register_activation_hook( GF7_EXT_URL, 'cf7_ext_activate' );
function cf7_ext_activate() {
	
	
	/*
	global $wpdb;
	
	$sql = '
			CREATE TABLE `wp_verify_email` (
			  `id` int(100) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			  `email` varchar(100) NOT NULL,
			  `verified` varchar(100) NULL,
			  `token` varchar(100) NOT NULL
			);
			';
	
	$wpdb->query( $sql );
	*/
	
	
}

register_deactivation_hook( GF7_EXT_URL, 'cf7_ext_deactivate' );
function cf7_ext_deactivate() {
	
	
	/*
	global $wpdb;
	
	$sql = '
			DROP TABLE `wp_verify_email`
			';
	
	$wpdb->query( $sql );
	*/
	
}

?>