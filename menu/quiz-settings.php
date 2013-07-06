<form id="wp-segment-settings-form" >
<label>
<input type="button" class="button-primary wp-segment-settings" value="Save your settings" />
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

<textarea name="wp-segment-quiz-description"><?php echo $wp_segment_quiz_description; ?></textarea>
<script type="text/javascript">
	CKEDITOR.replace('wp-segment-quiz-description');
</script>
</label>
<label>
<h3>Create a footer:</h3>
<span class="description" >This will appear at the bottom of your quiz, below the questions.</span>

<p>(HTML enabled)</p>
<textarea name="wp-segment-quiz-footer"><?php echo $wp_segment_quiz_footer; ?></textarea>
<script type="text/javascript">
	CKEDITOR.replace('wp-segment-quiz-footer');
</script>
</label>

<label>
<input type="button" class="button-primary wp-segment-settings" value="Save your settings" />
</label>
</form>