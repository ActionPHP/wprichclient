<?php
/**
 * Routes AJAX requests, and processes some of them. (Yeah, I know bad! ;) )
 */
class WPSegmentRouter
{

	public function route($route){



		}

	public function save_question()
	{	
		
		$wp_segment_questions = new WPSegmentQuestions;
		$request = $this->getRequest();
		$method = $_SERVER['REQUEST_METHOD'];

		$content = trim(stripslashes($request->text));
		switch($method)
		{
			case 'POST':

				$id = $wp_segment_questions->create($request);

			break;

			case 'PUT':

				$wp_segment_questions->update($request);

				$id = (int)$request->id;

			break;

		}

		;

		$text = trim(stripslashes($request->text));
				
		$response = array(

				'text' => $content,
				'id'   => $id
			);

		wp_send_json($response);
	}

	public function save_answer()
	{
		$wp_segment_answers = new WPSegmentAnswers;
		$request = $this->getRequest();
		$method = $_SERVER['REQUEST_METHOD'];

		$content = trim(stripslashes($request->text));
		switch($method)
		{
			case 'POST':

				$id = $wp_segment_answers->create($request);

			break;

			case 'PUT':

				$wp_segment_answers->update($request);

				$id = (int)$request->id;

			break;

		}
		
		$text = trim(stripslashes($request->text));
		$points = trim(stripslashes($request->points));
		$question_id = trim(stripslashes($request->question_id));
		$response = array(

				'id'   => $id,
				'question_id' => $question_id,
				'text' => $text,
				'points' => $points,

			);

		wp_send_json($response);
	}


	public function get_question()
	{
		$wp_segment_questions = new WPSegmentQuestions;

		$request = $this->getRequest();

		$id = $request->id;

		$response = $wp_segment_questions->get($id);

		wp_send_json($response);
				
	}

	public function get_answers()
	{
		$wp_segment_answers = new WPSegmentAnswers;

		$question_id = $_GET["question_id"];

		$response = $wp_segment_answers->get_by($question_id);

		wp_send_json($response);

	}

	public function delete_question(){

		$request = $this->getRequest();

		$method = $this->getMethod();

		if($method == 'DELETE'){

			$wp_segment_questions = new WPSegmentQuestions;
			
			$question_id = trim(stripslashes($_GET["question_id"]));

			$wp_segment_questions->delete($question_id);

			wp_send_json(array());
			
		}


	}

	public function quiz_settings()
	{
		$quiz = new WPSegmentQuiz;
		$quiz->saveSettings();
		
		die();
	}

	public function delete_answer()
	{
		$request = $this->getRequest();
		$method = $this->getMethod();

		if($method == 'DELETE'){

			$wp_segment_answers = new WPSegmentAnswers;
			
			$answer_id = trim(stripslashes($_GET["answer_id"]));

			$wp_segment_answers->delete($answer_id);

			wp_send_json(array());
			
		}


	}

	public function result_settings()
	{
		$wp_segment_quiz_results = new WPSegmentResults;
		$wp_segment_quiz_results->saveSettings();		

		die();
	}

	public function getRequest(){

		$request_body = file_get_contents(('php://input'));
		$request = json_decode($request_body);

		return $request;

	}

	public function getMethod(){

		$method = $_SERVER['REQUEST_METHOD'];
		return $method;

	}

	public function show_quiz($style='')
	{
		$quiz = new WPSegmentQuiz;

		$quiz->render('desktop-php');
		die();

	}

	public function process_quiz()
	{
		if($this->getMethod() != 'POST') die('Really?');
		
		$wp_segment_quiz_results = new WPSegmentResults;
		$wp_segment_quiz_results->processQuiz();
		//Let's get the answer array to be used with the custom report
		$answer_array = $wp_segment_quiz_results->getAnswerArray();

		$wp_segment_custom_report = new WPSegmentCustomReport;
		$wp_segment_custom_report->setAnswerArray($answer_array);
		$body = $wp_segment_custom_report->html();

		$result_id = $wp_segment_custom_report->create();

		$wp_segment_quiz_results->setId($result_id);

		echo $wp_segment_quiz_results->results();
		die();
	}

	public function custom_report()
	{
		$result_id = $_GET['result_id'];

		if(!ctype_digit($result_id)) die('Really?');

		$wp_segment_custom_report = new WPSegmentCustomReport;
		$wp_segment_custom_report->retrieve($result_id);

		die();

	}
	public function store_contact(){

		$first_name = trim(stripslashes($_POST['FirstName']));
		$last_name = trim(stripslashes($_POST['LastName']));
		$email = trim(stripslashes($_POST['Email']));
		$list = trim(stripslashes($_POST['List']));
		$result_id = trim(stripslashes($_POST['result_id']));


		//If there isn't a list set, we just get out of here.
		if($list == "_none"){

			return;
		}

		$autoresponder_service = get_option('wp_segment_autoresponder_service');

		

		switch($autoresponder_service){
			
			case "aweber":

				$aweber = new WPSegmentAweber;
				
				$aweber->addContact($first_name, $last_name, $email, $list);

			break;

			case "getresponse":

				$getresponse = new WPSegmentGetResponse;
				
				$getresponse->addContact($first_name, $last_name, $email, $list);

			break;

			case "infusionsoft":

				$infusionsoft = new WPSegmentInfusionsoft;
				$infusionsoft->addContact($first_name, $last_name, $email, $list);				

			break;

			case "icontact":

				$icontact = new WPSegmentIContact;
				$icontact->addContact($first_name, $last_name, $email, $list);

			break;



		}

		//Let's store the contact details in the user_response table
		//
		$wp_segment_custom_report = new WPSegmentCustomReport;
		$wp_segment_custom_report->storeContactDetails($result_id, $first_name,
			$last_name, $email);


		die();

	}

}

?>