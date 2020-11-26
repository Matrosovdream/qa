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


function makeListRecommend( $result ) {
	
	$posts_raw = get_posts( array(
		'numberposts' => -1,
		'category'    => 0,
		'orderby'     => 'date',
		'order'       => 'DESC',
		'post_type'   => 'qa_recommendations',
	) );
	
	foreach( $posts_raw as $post ) {
		$posts[ $post->post_title ] = $post->post_content;
	}
	
	
	foreach( $result as $key=>$tab ) {
		
		if( $tab['title'] == 'Finish' ) { continue; }
		
		foreach( $tab['choices'] as $key2=>$choice ) {
			
			if( $choice['checked'] ) {
				
				$text = $posts[ $choice['label'] ];
				
				if( $text ) {
					$rows[ $tab['title'] ][ $choice['label'] ] = $text;
				}
				
			}
			
		}
		
		$result[$key]['percent'] = round( $checked_amount / count( $tab['choices'] ) * 100 );
		
	}
	
	$html = '';
	foreach( $rows as $block_title=>$items ) {
		
		$html .= "<h2 style='font-size: 25px;'> $block_title </h2>";
		
		foreach( $items as $item_title=>$item_text ) {
			
			$html .= "<h3 style='font-size: 21px;'> $item_title </h3>";
			
			$html .= "<p style='font-size: 17px;'> $item_text </p>";
			
		}
		
		$html .= "<br/>";
		
	}
	
	return $html;
	
	echo $html;
	
	
	echo "<pre>";
	print_r( $rows );
	echo "</pre>";
	
	echo "<pre>";
	print_r( $posts );
	echo "</pre>";
	
	
	
}








