jQuery(document).ready(function($){

	var Indicator = {

		$el: $('.wp-segment-ajax-indicator'),

		savingContent: 'Saving...',

		savedContent: '<span style="font-weight: bold; color: green;" >Saved!</span>',

		errorContent: '<span style="font-weight: bold; color: #cc0000;" >Please look through and correct errors (highligted in red)</span>',

		saving: function(){

			this.$el.html(this.savingContent).show();

		},

		saved: function(){

			this.$el.html(this.savedContent);
			this.$el.fadeOut(3000);
		},

		error:function(){

			this.$el.html(this.errorContent).show();

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


	});


	$('.wp-segment-result-settings').click(function () {
		indicate.saving();

		var _can_save = true;
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
			var points = $(value).val();
			var _points_message_id = $('#' + key + '-points-message');

			//Let's make sure the points values are not greater than 10
			if(points>10){

				_points_message_id.text('Points cannot be greater than 10');
				_can_save = false;
			} else {

				_points_message_id.text('');
			}

			wp_result_settings[key]['points'] = points;
			
		});


		$('.wp-segment-list').each(function (idx, value) {
			
			var key = $(value).attr('name').replace('wp-segment-result-list-', '');
			var list = $(value).val();

			wp_result_settings[key]['list'] = list;
			
		})
		
		var thing = ['key', 'key2'];

		var data_to_go = JSON.stringify(wp_result_settings);
		var settings = JSON.stringify(thing);//

		//If our _can_save variable is false we cannot save
		if(!_can_save) { 

			indicate.error();
			return; 
		}

		//Let's post this thing so it can be saved!
		var url = ajaxurl + '?action=actionphp_result_settings';
		$.post(url, { data: data_to_go}, function(response){

			indicate.saved();

		});

				
	})


});

