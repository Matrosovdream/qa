<?php

function cptui_register_my_cpts_qa_results() {

	/**
	 * Post Type: QA results.
	 */

	$labels = [
		"name" => __( "QA results", "hello-elementor-child" ),
		"singular_name" => __( "QA result", "hello-elementor-child" ),
	];

	$args = [
		"label" => __( "QA results", "hello-elementor-child" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => [ "slug" => "qa_results", "with_front" => true ],
		"query_var" => true,
		"supports" => [ "title", "editor", "thumbnail" ],
	];

	register_post_type( "qa_results", $args );
}

add_action( 'init', 'cptui_register_my_cpts_qa_results' );


function cptui_register_my_cpts_qa_recommendations() {

	/**
	 * Post Type: QA recommendations.
	 */

	$labels = [
		"name" => __( "QA recommendations", "hello-elementor-child" ),
		"singular_name" => __( "QA recommendation", "hello-elementor-child" ),
	];

	$args = [
		"label" => __( "QA recommendations", "hello-elementor-child" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => [ "slug" => "qa_recommendations", "with_front" => true ],
		"query_var" => true,
		"supports" => [ "title", "editor", "thumbnail" ],
	];

	register_post_type( "qa_recommendations", $args );
}

add_action( 'init', 'cptui_register_my_cpts_qa_recommendations' );


