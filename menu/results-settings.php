<label><h2>Your quiz results settings:</h2></label>
<label>
	<h3>Score level: high</h3>
	<h4>Points required: <input type="text" name="high" class="small-text" />  <span class="description" >(suggested: 70)</span> </h4>
	<textarea name="wp-segment-result-message-high"></textarea>
	<script type="text/javascript">
	CKEDITOR.replace('wp-segment-result-message-high').setData('<?php echo $result_high ;?>');
	</script>
	</label>
<hr>
<label>
	<h3>Score level: medium</h3>
	<h4>Points required: <input type="text" name="medium"  class="small-text" /> <span class="description" >(suggested: 50)</span></h4> 
	<textarea name="wp-segment-result-message-medium"></textarea>
	<script type="text/javascript">
	CKEDITOR.replace('wp-segment-result-message-medium').setData('<?php echo $result_medium ;?>');
	</script>
	</label>
<hr>
<label>
	<h3>Score level: low</h3>
	<h4>Points required: <input type="text" name="low"  class="small-text" /> <span class="description" >(suggested: 30)</span> </h4>
	<textarea name="wp-segment-result-message-low"></textarea>
	<script type="text/javascript">
	CKEDITOR.replace('wp-segment-result-message-low').setData('<?php echo $result_low ;?>');
	</script>
	</label>
<hr>
<label>
	<h3>Score level: bottom</h3>
	<h4>Points required: <input type="text" name="bottom" value="0"  class="small-text" disabled="disabled" /> </h4> 
	<textarea name="wp-segment-result-message-bottom"></textarea>
	<script type="text/javascript">
	CKEDITOR.replace('wp-segment-result-message-bottom').setData('<?php echo $result_bottom ;?>');
	</script>
	</label>