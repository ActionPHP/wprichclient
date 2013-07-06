jQuery(document).ready(function($){



	$('.wp-segment-settings').click(function () {
		
			var wp_segment_settings = [];	
			var key = '';
		$.each(CKEDITOR.instances, function (idx, value) {

			key = idx.replace('wp-segment-quiz-', '');
			wp_segment_settings[key] = value.getData();
		});
		
		var url = ajaxurl + '?action=actionphp_quiz_settings';
		$.post(url, 

			{ description: wp_segment_settings['description'], footer: wp_segment_settings['footer'] },

			function (response) {
				console.log(response);
			}


		);



	})


});