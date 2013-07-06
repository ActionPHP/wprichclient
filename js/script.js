jQuery(document).ready(function($){

	var Indicator = {

		$el: $('.wp-segment-ajax-indicator'),

		savingContent: 'Saving...',

		savedContent: '<span style="font-weight: bold; color: green;" >Saved!</span>',

		saving: function(){

			this.$el.html(this.savingContent).show();

		},

		saved: function(){

			this.$el.html(this.savedContent);
			this.$el.fadeOut(3000);
		}
	}

	var indicate = Indicator;

	$('.wp-segment-settings').click(function () {

			indicate.saving();


			var wp_segment_settings = [];	
			var key = '';

			var quiz_name = $('#wp-segment-quiz-name').val();
			wp_segment_settings['name'] = quiz_name;

		$.each(CKEDITOR.instances, function (idx, value) {

			key = idx.replace('wp-segment-quiz-', '');
			wp_segment_settings[key] = value.getData();
		});
		
		var url = ajaxurl + '?action=actionphp_quiz_settings';
		$.post(url, 

			{ name: wp_segment_settings['name'], description: wp_segment_settings['description'], footer: wp_segment_settings['footer'] },

			function (response) {

				indicate.saved();
				console.log(response);
			}


		);


console.log(wp_segment_settings);
	})


});

