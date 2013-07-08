<?php

require_once AP_PATH . 'lib/class-autoresponder.php';
require_once AP_PATH . 'lib/class-results.php';



$resultSettings = new WPSegmentResults;

$settings = $resultSettings->getSettings();

?>
	<label><h2>Your quiz results settings:</h2></label>

<?php
foreach ($settings as $level) {


wp_segment_result_setting_fields($level);

}

function wp_segment_result_setting_fields($settings){

	$autoresponder = new WPSegmentAutoresponder;

?>
	<label>
		<h3>Score level: <?php echo strtoupper($settings->level) ;?></h3>
	</label>
	<label>
		<h4>Points required: 
			<input type="text" name="<?php echo $settings->level ;?>" class="small-text" value="<?php echo $settings->points; ?>" />  
			<span class="description" >(suggested: 70)</span> </h4>
	</label>
	<label>
		<h4>Choose list: </h4> <?php echo $autoresponder->showLists($settings->list); ?>
	</label>
	<label>
		<textarea name="wp-segment-result-message-<?php echo $settings->level; ?>"></textarea>
		<script type="text/javascript">
		CKEDITOR.replace('wp-segment-result-message-<?php echo $settings->level; ?>').setData('<?php echo
			$settings->html; ?>');
		</script>
		</label>
	<hr>	
<?php
}

?>
