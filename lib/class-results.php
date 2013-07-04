<?php
require_once 'class-answers.php';
require_once 'class-questions.php';
/**
 * Process the answers and calculates the final score.
 */
class WPSegmentResults
{
	function __construct() {

		$questionsMethod = new WPSegmentQuestions;
		$answersMethod = new WPSegmentAnswers;

		$this->setQuestionsMethod($questionsMethod);
		$this->setAnswersMethod($answersMethod);
	}
	public function processQuiz()
	{
		//First, let's get the user response
		$user_response = $this->getUserResponse();

		//Now let's create the answer array for processing.
		
		$answer_array = $this->createAnswerArray($user_response);

		//Finally, we will get the score and return it!
		
		$score = $this->fetchScore($answer_array);

		$this->results = $score;

		return $score;
	}

	public function calculate($answers)
	{	
		
	}

	public function createAnswerArray($answers)
	{
		
		$wp_segment_answers = $this->getAnswersMethod();
		$answer_array = array();

		foreach($answers as $answer_id )
		{
			$answer = $wp_segment_answers->get($answer_id);
			
			$answer_object = $this->createSingleAnswerObject($answer);

			$answer_array[] = $answer_object;

		}

		return $answer_array;
	}

	public function createSingleAnswerObject($answer)
	{
		//We will need to find out what the highest possible score for the question is.
		// We will store that in points_base, since that is the basis for our point system.
		
		$points_base = $this->getPointsBase($answer->question_id);

		$single_answer_object = (object) array(

				'question_id' => $answer->question_id,
				'answer_id' => $answer->answer_id,
				'points_base' => $points_base,
				'points' => $answer->points,

			);

		return $single_answer_object;
	}

	public function getPointsBase($question_id)
	{	
		$answersMethod = $this->getAnswersMethod();

		$answers = $answersMethod->get_by($question_id);

		foreach ($answers as $answer) {
			
			$points_array[] = $answer->points;
		}

		$points_base = max($points_array);

		return $points_base;
		
	}

	public function getUserResponse()
	{

		$user_response = $_POST;
		
		foreach($user_response as $element_name => $answer_id )
		{

			$question_id = (int) trim(stripslashes(str_replace('answer-for-question-', '', $element_name)));
			$answers[$question_id] = (int) $answer_id;

		}

		return $answers;
	}

	public function fetchScore($answer_array)
	{
		# code...
	}

	public function results(){


		return $this->results;
	}
public function getQuestionsMethod()
{

	return $this->questionsMethod;
	
}

public function setQuestionsMethod($questionsMethod)
{
	$this->questionsMethod = new $questionsMethod;
}

public function getAnswersMethod()
{
	return $this->answersMethod;
}

public function setAnswersMethod($answersMethod)
{
	
		$this->answersMethod = $answersMethod;
	
}
}
?>