<?php
add_shortcode( 'site_url', 'site_url_func' );
function site_url_func( $atts = null, $content = null ) {
	
	$colors['orange'] = "#e18621";
	$colors['green'] = "#188134"; 
	
	$qa_items = GetQA();
	
	$results = $_GET['results'];
	
	/*
	echo "<pre>";
	print_r( $qa_items );
	echo "</pre>";
	
	echo "<pre>";
	print_r( $results );
	echo "</pre>";
	*/
	
	foreach( $results as $title=>$percent ) {
		
		if( strtolower($title) == 'finish' ) { continue; } 
		
		$info = $qa_items[ strtolower($title) ];
		
		if( $percent >= $info['good_result_from'] && $percent <= $info['good_result_to'] ) { 
			$answer = 'good';
		}
		
		if( $percent >= $info['bad_result_from'] && $percent <= $info['bad_result_to'] ) { 
			$answer = 'bad';
		}
		
		if( strtolower($title) == 'fine motor' ) {
			
			/*echo $answer;
			
			echo "<pre>";
			print_r( $info );
			echo "</pre>";*/
			
		}
		

		
		if( $answer == 'good' ) {
			
			$blocks[] = array(
						"result" => $answer,
						"color" => $colors['green'],
						"title" => $title,
						"content" => $info['fields']['good_result_message'],
						"get_help_text" => $info['fields']['get_help_text'],
						"link" => $info['fields']['get_help_link'],
						);
						
		}
		
		if( $answer == 'bad' ) {
			
			$blocks[] = array(
						"result" => $answer,
						"color" => $colors['orange'],
						"title" => $title,
						"content" => $info['fields']['bad_result_message'],
						"get_help_text" => $info['fields']['get_help_text'],
						"link" => $info['fields']['get_help_link'],
						);
						
		}

		
	}
	
	/*
	echo "<pre>";
	print_r($_GET);
	echo "</pre>";
	*/
	
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
			
				<?php foreach( $blocks as $item ) { ?>
			
					<div class="item">
						
						<h2>
							<span class="yes" style="background: <?php echo $item['color']; ?>"></span>
							<?php echo $item['title']; ?>
						</h2>
						
						<p>
							<?php echo $item['content']; ?>
						</p>
						
						<?php if( $item['result'] == 'bad' && trim( $item['get_help_text'] ) != '' ) { ?>
							<a class="checklist-button" href="<?php echo $item['link']; ?>">
								<?php echo $item['get_help_text']; ?>
							</a>
						<?php } ?>
						
					</div>
				
				<?php } ?>
				
				<div style="clear: both;"></div>
			
			</div>
		
		
		</div>
	
	<?php 
	$content = ob_get_contents();

	ob_end_clean();

	return $content;

}
?>