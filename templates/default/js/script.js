$(document).ready(function () {

	$('#submit-segment-quiz').click(validateQuiz);
	$(':radio').change(function(e){

		var question_id = getQuestionIDFromAnswer( $(this).attr('name') );
		
		changeQuestionColor(question_id, true);
		

	})

});

function validateQuiz(){

	if(totalQuestionsAnswered()){

		submitSegmentQuizForm();

	} else {



	}

}

function totalQuestionsAnswered(){
	$('#quiz-view-port-message').html('');
	var answers = {};
	var total = 0;
	
	$(':radio').each(function (idx, value) {

		answers[$(value).attr('name')] = true;
		
	});

	$.each(answers, function (name) {

		var question_id = name.replace('answer-for-question-', '');

		if(!$('input[name='+ name + ']:checked').length){

			
			changeQuestionColor(question_id, false);
			

		} 

		total++;
	})
	
	var totalChecked = $(':radio:checked').length;

	if( total != totalChecked){
		
		$('#quiz-view-port-message').html('<h5 style="color: #cc0000;">Please answer all questions - unanswered questions are highlighted in red.</h5>');
		console.log('There are still unanswered questions.');

		return false;


	} else {

		return true;
	}

	
	
}

function getAnsweredQuestions(){

	var checkedRadio= $(':radio:checked');
	var answeredQuestions = Array();
	
	$.each(checkedRadio, function(idx, element){

		var name = $(element).attr('name');
		var question_id = getQuestionIDFromAnswer (name);
		answeredQuestions.push(question_id);
	});

	return answeredQuestions();
}

function changeQuestionColor(question_id, answered){

	var el = '#segment-quiz-question-' + question_id;

	switch(answered){

		case true:
			
			$(el).css('color', '#000000');

		break;

		case false:

			$(el).css('color', '#cc0000');

		break;
	}

}

function getQuestionIDFromAnswer (name) {
	return name.replace('answer-for-question-', '');
}

function submitSegmentQuizForm(){

	$('#submit-segment-quiz').html('Submitting...');
	$.post(

			ajaxurl + '?action=actionphp_process_quiz',

			$('form#segment-quiz-form').serialize(),

			function(response)
			{
				showResult(response);
				console.log(response);

			}

		)


}

function showResult(response){


	var emailForm = $('#wp-segment-email-form-template').html();

	var results = JSON.parse(response);

	var html = results.html;
	var score = results.score;
	var list  = results.list;
	var result_id  = results.result_id;

	$('#quiz-view-port').html('');

	scoreHTML = '<center><p style="padding: 10px; border: 1px #cc0000 dashed;"><span style="font-size: 24px" >Your score is: <strong>' + score + '	</strong></span></p></center>';

	$('#quiz-view-port').append(scoreHTML);
	$('#quiz-view-port').append(html);

	console.log(results.html);
	
	if( list != '_none'){

		$('#quiz-view-port').append(emailForm);
		$('#submit-contact-details').click(function(){ 

			submitContactDetails(list, result_id);

		});

	}

	



}

function submitContactDetails(list, result_id){

	$('#wp-segment-email-form-message').html('');
	var firstName = $.trim($("#FirstName").val());
	var email 	  = $.trim($("#Email").val());
	var validatedEmail = false;
	var validatedName = false;
	if(!email || email.length === 0 || !validateEmail(email)){

		$("#Email").css('border-color', '#cc0000');
		$('#wp-segment-email-form-message').append('Please fill in your valid email.</br>')
		console.log('Please fill in your email.');
		

	} else {
		$("#Email").css('border-color', '#ccc');
		validatedEmail = true;
	}


	if(!firstName || firstName.length === 0){

		$("#FirstName").css('border-color' , '#cc0000');
		$('#wp-segment-email-form-message').append('Please fill in your name.</br>')
		console.log('Please fill in your name.');
		
	} else {

		$("#FirstName").css('border-color' , '#ccc');
		validatedName = true;
	}

	if(!validatedEmail || !validatedName){

		return false;
	}

	


	var formData = $('#wp-segment-email-form').serialize();

	formData = formData + '&List='+list + '&result_id=' + result_id;
		

	var submittingHTML = $("#wp-segment-submitting-template").html();
	$('#quiz-view-port').html(submittingHTML);

	$.post(

			ajaxurl + '?action=actionphp_store_contact',

			formData,

			function(response){

				var submittedHTML = $("#wp-segment-thank-you-template").html();
				$('#quiz-view-port').html(submittedHTML);
				$('#custom-report-link').attr("href", ajaxurl +	'?action=actionphp_custom_report&result_id=' + result_id);

			}



		);

}

function validateEmail($email) {
  var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
  if( !emailReg.test( $email ) ) {
    return false;
  } else {
    return true;
  }
}