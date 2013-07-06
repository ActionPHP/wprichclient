<form id="wp-segment-settings-form" >
<label>
<input type="button" class="button-primary wp-segment-settings" value="Save your settings" /> 
<span class="wp-segment-ajax-indicator"></span>
</label>

<label>
	<h3>Your quiz name: </h3>
	<textarea name="wp-segment-quiz-name" id="wp-segment-quiz-name" style="height: 60px"><?php echo $quiz_name ;?></textarea>
</label>
<label>
	<h3>This appears on top of your quiz:</h3>
	<!-- <span class="description">The content you put here will appear on top of your quiz. You can use HTML as well.</span>
	<p>(HTML enabled)</p>

	<textarea name="wp-segment-quiz-header" style="height: 120px;"><?php echo $wp_segment_quiz_header; ?></textarea>
-->
</label>
<!--
<label>
<h3>Create your headline:</h3>
<span class="description" ></span>

<textarea name="wp-segment-quiz-headline" style="height: 120px;"><?php echo $wp_segment_quiz_headline; ?></textarea>

</label>
-->
<label>
<!-- <h3>Create a description:</h3> -->
<span class="description" ></span>

<textarea name="wp-segment-quiz-description"></textarea>
<script type="text/javascript">
	CKEDITOR.replace('wp-segment-quiz-description').setData('<?php echo str_replace("\n", "\\n", $description); ?>');
</script>
</label>
<label>
<h3>This appears below your quiz questions: </h3>

<textarea name="wp-segment-quiz-footer"></textarea>
<script type="text/javascript">
	CKEDITOR.replace('wp-segment-quiz-footer').setData('<?php echo str_replace("\n", "\\n", $footer); ?>');
</script>
</label>

<label>
<input type="button" class="button-primary wp-segment-settings" value="Save your settings" /> 
<span class="wp-segment-ajax-indicator"></span>

</label>
</form>