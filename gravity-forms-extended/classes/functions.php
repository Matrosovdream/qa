<?php
function GetAgePages() {
	
	$pages = get_posts( array(
		'numberposts' => -1,
		'category'    => 0,
		'orderby'     => 'date',
		'order'       => 'DESC',
		'meta_key'    => 'child_test',
		'meta_value'  => '1',
		'post_type'   => 'page',
	) );
	
	foreach( $pages as $page ) {
		
		$age_from = get_post_meta( $page->ID, 'age_from' )[0];
		$age_to = get_post_meta( $page->ID, 'age_to' )[0];
		$link = get_page_link( $page->ID );
		
		$items[] = array(
						"age_from" => $age_from, 
						"age_to" => $age_to, 
						"link" => $link, 
						);
		
	}
	
	return $items;
	
	echo "<pre>";
	print_r($items);
	echo "</pre>";
	
	die();
	
}


function GetQA() {
	
	$pages = get_posts( array(
		'numberposts' => -1,
		'category'    => 0,
		'orderby'     => 'date',
		'order'       => 'DESC',
		'post_type'   => 'qa_results',
	) );
	
	$fields = array( "good_result", "good_result_message", "bad_result", "bad_result_message", "get_help_link"  );
	
	foreach( $pages as $page ) {
		
		foreach( $fields as $field ) {
			$item_fields[ $field ] = get_post_meta( $page->ID, $field )[0];
		}
		
		$good_raw = explode('-', $item_fields['good_result']);
		$bad_raw = explode('-', $item_fields['bad_result']);

		$title = strtolower( $page->post_title );
		
		$items[ $title ] = array(
						"good_result_from" => $good_raw[0], 
						"good_result_to" => $good_raw[1], 
						"bad_result_from" => $bad_raw[0], 
						"bad_result_to" => $bad_raw[1], 
						"fields" => $item_fields, 
						);
		
	}
	
	return $items;
	
	
	
}