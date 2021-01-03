<?php
// https://docs.gravityforms.com/category/developers/hooks/actions/submission/


add_action( 'gform_enqueue_scripts', 'enqueue_styles_form_test', 11 );
function enqueue_styles_form_test() {
	
	global $post;
	
	$page_type = get_post_meta( $post->ID, 'page_type' )[0];
	
	if( $page_type == 'Choose date' ) {
		wp_enqueue_style( 'choose-date.css', plugins_url('choose-date.css?t='.time(), __FILE__) );
	}
	if( $page_type == 'Multi-page test' ) {
		wp_enqueue_style( 'multi-test.css', plugins_url('multi-test.css?t='.time(), __FILE__) );
	}
	if( $page_type == 'Final page' ) {
		wp_enqueue_style( 'final-page.css', plugins_url('final-page.css?t='.time(), __FILE__) );
	}
	
	wp_enqueue_script( 'gravity-forms-extended-script.js', plugins_url('gravity-forms-extended-script.js?t='.time(), __FILE__) );
	
}


// QA validation
add_filter( 'gform_validation_11', 'custom_validation' );
function custom_validation( $validation_result ) {
	
    $form = $validation_result['form'];
	
	$pages = GetAgePages();
	
	foreach( $pages as $page ) {
		$all_ages[] = $page['age_from'];
		$all_ages[] = $page['age_to'];
	}	
	
	$min_age = round( min( $all_ages ) / 12 );
	$max_age = round( max( $all_ages ) / 12 ) - 1;
	if( $min_age == 0 ) { $min_age = 1; }
	
	/*echo "<pre>";
	print_r($pages);
	echo "</pre>";*/
	//die();
	
	if( $form['id'] == 11 ) {
	
		$date = rgpost( 'input_1' );
		
		$date = $_POST['input_1'];
		$diff = time() - strtotime( $date );
		
		$months = nb_mois( $date, date('m/d/Y') );
		
		/*$month_in_seconds = 2592000;
		//$month_in_seconds = 31 * 24 * 60 * 60;
		$months = round( $diff / $month_in_seconds );*/
		
		foreach( $pages as $page ) {
			if( 
				$months >= $page['age_from'] &&
				$months <= $page['age_to']
			) {
				$chosen_page = $page;
				break;
			}
		}
		
		/*echo $months; echo "<br/>";
		
		echo "<pre>";
		print_r( $chosen_page );
		echo "</pre>";
		
		die();*/
		
		if ( $chosen_page ) {
			
			foreach( $validation_result['form']['confirmations'] as $k=>$item ) {
				$validation_result['form']['confirmations'][$k]['type'] = 'redirect';
				$validation_result['form']['confirmations'][$k]['url'] = $chosen_page['link'];
			}
			
			wp_redirect( $chosen_page['link'] );
			exit();

		} else {
			
			$validation_result['is_valid'] = false;

			foreach( $form['fields'] as &$field ) {

				//NOTE: replace 1 with the field you would like to validate
				if ( $field->id == '1' ) {
					$field->failed_validation = true;
					//$field->validation_message = 'Age should be from '.$min_age.' to '.$max_age.' years';
					$field->validation_message = 'Аge should be from 1 month to 6 years old';
					break;
				}
			}
			
		}

		$validation_result['form'] = $form;
		return $validation_result;
	
	}

}


add_filter( 'gform_validation', 'gform_validation_func' );
function gform_validation_func( $validation_result ) {
	

	$pages = $validation_result['form']['pagination']['pages'];
	$form_id = $_POST['gform_submit'];
	$current_page = $_POST['gform_source_page_number_'.$form_id];
	
	$fields = $validation_result['form']['fields'];
	foreach( $fields as $key=>$field ) {
		if( !$field['inputs'] ) { continue; }
		$choices[ $key ] = $field['inputs'];
	}
	$choices = array_values( $choices );
	
	foreach( $pages as $key=>$page ) {
		$result[] = array(
							"title" => $page,
							"choices" => $choices[ $key ],
							);
	}
	
	// If it's the last page
	if( $current_page == count($result) ) {
		
		foreach( $result as $key=>$tab ) {
			
			$checked_amount = 0;
			
			foreach( $tab['choices'] as $key2=>$choice ) {
				$id = str_replace( '.', '_', $choice['id'] );
				
				$checked = $_POST[ 'input_'.$id ];
				if( $checked ) {
					$result[$key]['choices'][$key2]['checked'] = 1;
					$checked_amount++;
					$checked_fields[] = $choice['label'];
				}
				
			}
			
			$result[$key]['percent'] = round( $checked_amount / count( $tab['choices'] ) * 100 );
			
		}
		
		// Let's redirect
		foreach( $result as $key=>$tab ) {
			$get['results'][ $tab['title'] ] = $tab['percent'];
		}	
		
		$query = http_build_query( $get );
		$url = get_site_url().'/results/?'.$query;
		
		foreach( $validation_result['form']['confirmations'] as $k=>$item ) {
			$validation_result['form']['confirmations'][$k]['type'] = 'redirect';
			$validation_result['form']['confirmations'][$k]['url'] = $url;
		}
		
		
		/*
		foreach( $validation_result['form']['notifications'] as $k=>$item ) {
			
			if( $item['name'] == 'User notification' ) {
				
				echo "<br/>";
				echo "<br/>";
				echo "<br/>";
				echo "<br/>";
				echo "<br/>";
				echo "<br/>";
				echo "<br/>";
				echo "<br/>";
				echo "<br/>";
				echo "<br/>";
				echo "<br/>";
				echo "<br/>";
				
				
				$tips_html = makeListRecommend( $result );
				
				//$validation_result['form']['notifications'][ $k ]['message'] = str_replace( '{TIPS}', $tips_html, $validation_result['form']['notifications'][ $k ]['message'] );
				$validation_result['form']['notifications'][ $k ]['message'] = str_replace( '{TIPS}', '' );				
				
			}
				
		
		}	
		*/
		
	}
	

    return $validation_result;
 
}






