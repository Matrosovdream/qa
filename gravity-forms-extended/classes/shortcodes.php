<?php
add_shortcode( 'site_url', function( $atts = null, $content = null ) {
	
	$colors['green'] = "#e18621";
	$colors['orange'] = "#188134"; 
	
	$qa_items = GetQA();
	
	$results = $_GET['results'];
	
	
	foreach( $results as $title=>$percent ) {
		
		$info = $qa_items[ strtolower($title) ];
		
		if( $percent >= $info['good_result_from'] && $percent <= $info['good_result_to'] ) { 
			$answer = 'good';
		}
		
		if( $percent >= $info['bad_result_from'] && $percent <= $info['bad_result_to'] ) { 
			$answer = 'bad';
		}
		
		
		if( $answer == 'good' ) {
			
			$blocks[] = array(
						"color" => $colors['green'],
						"title" => $title,
						"content" => $info['fields']['good_result_message'],
						"link" => $info['fields']['get_help_link'],
						);
						
		}
		
		if( $answer == 'bad' ) {
			
			$blocks[] = array(
						"color" => $colors['orange'],
						"title" => $title,
						"content" => $info['fields']['bad_result_message'],
						"link" => $info['fields']['get_help_link'],
						);
						
		}

		
	}
	
	/*echo "<pre>";
	print_r($qa_items);
	echo "</pre>";*/
	
	ob_start();
	?> 
	
		<div class="results-block">
		
			<div class="block-top">
			
				<h1>ALL DONE!</h1>
			
			</div>
			
			<p>
				Thank you for completing the checklist! Here are the results we calculated for your child.
			<p>
		
			<div class="blocks">
			
				<? foreach( $blocks as $item ) { ?>
			
					<div class="item">
						
						<h2>
							<span class="yes" style="background: <? echo $item['color']; ?>"></span>
							<? echo $item['title']; ?>
						</h2>
						
						<p>
							<? echo $item['content']; ?>
						</p>
						
						<a class="checklist-button" href="<? echo $item['link']; ?>">Why get help now?</a>
						
					</div>
				
				<? } ?>
				
				<div style="clear: both;"></div>
			
			</div>
		
		
		</div>
	
	<? 
	$content = ob_get_contents();

	ob_end_clean();

	return $content;

} );

