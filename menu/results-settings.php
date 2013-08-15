<?php

require_once AP_PATH . 'lib/class-autoresponder.php';
require_once AP_PATH . 'lib/class-results.php';
require_once AP_PATH . 'lib/class-branding.php';

$resultSettings = new WPSegmentResults;


?>
<!-- Preloader -->
<div id="preloader">
    <div id="status">Loading....</div>
</div>
<?php
$settings = $resultSettings->getSettings();

?>
	<label><h2>Your quiz results settings:</h2></label>
<input type="button" value="Save settings" class="wp-segment-result-settings
button-primary" /> <span class="wp-segment-ajax-indicator"></span>

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
			<input type="text" name="<?php echo $settings->level ;?>"
			class="wp-segment-result-points small-text"
			<?php _disabled($settings->level); ?>
			 value="<?php echo $settings->points; ?>" /> <span id="<?php echo $settings->level; ?>-points-message"
			  style="color: #cc0000;"></span>
		</h4>
	</label>
	<label>
		<h4>Choose list: </h4> 
		<?php 

			$list_item_name = 'wp-segment-result-list-' . $settings->level ;
			echo $autoresponder->showLists($list_item_name, $settings->list); 

		?>
	</label>
	<label>
		<textarea name="wp-segment-result-message-<?php echo $settings->level; ?>"></textarea>
		<script type="text/javascript">
		CKEDITOR.replace('wp-segment-result-message-<?php echo $settings->level; ?>').setData('<?php echo
			str_replace("\n", "\\n", $settings->html); ?>');
		</script>
		</label>
	<hr>	
<?php
}

?>
<input type="button" value="Save settings" class="wp-segment-result-settings
button-primary" /> <span class="wp-segment-ajax-indicator"></span>


<?php

	function _disabled($level){

		if($level == 'bottom'){

			echo ' disabled="disabled" ';
		}
	}

?>
<!-- Preloader -->
<script type="text/javascript">
    //<![CDATA[
        jQuery(window).load(function() { // makes sure the whole site is loaded
            jQuery("#status").fadeOut(); // will first fade out the loading animation
            jQuery("#preloader").delay(350).fadeOut("slow"); // will fade out the white DIV that covers the website.
        })
    //]]>
</script>