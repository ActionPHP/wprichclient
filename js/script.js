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
	});


	$('.wp-segment-result-settings').click(function () {
		

		var wp_result_settings = {};
		wp_result_settings['high'] = {};
		wp_result_settings['medium'] = {};
		wp_result_settings['low'] = {};
		wp_result_settings['bottom'] = {};

		//Let's get the HTML for each of the settings
		$.each(CKEDITOR.instances, function (idx, value) {

			var key = idx.replace('wp-segment-result-message-', '');
		

			wp_result_settings[key]['html'] = value.getData();

		
		});

		//Let's get the points
		//
		$('.wp-segment-result-points').each( function (idx, value){

			var key = $(value).attr('name');
			wp_result_settings[key]['points'] = $(value).val();
		
		});


		$('.wp-segment-list').each(function (idx, value) {
			
			var key = $(value).attr('name').replace('wp-segment-result-list-', '');
			var list = $(value).val();

			wp_result_settings[key]['list'] = list;
			
		})
		
		var thing = ['key', 'key2'];

		var data_to_go = JSON.stringify(wp_result_settings);
		var settings = JSON.stringify(thing);//
		console.log(JSON.stringify(['object']));
		//Let's post this thing so it can be saved!
		var url = ajaxurl + '?action=actionphp_result_settings';
		$.post(url, { data: data_to_go}, function(response){

			console.log(response);

		});

				
	})


});

