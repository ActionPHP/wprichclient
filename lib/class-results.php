<?php
require_once 'class-answers.php';
require_once 'class-questions.php';
require_once 'class-score.php';
/**
 * Process the answers and calculates the final score.
 */
class WPSegmentResults
{
	function __construct() {

		$questionsMethod = new WPSegmentQuestions;
		$answersMethod = new WPSegmentAnswers;
		$scoreMethod = new WPSegmentScore;

		$this->setScoreMethod($scoreMethod);
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

		$this->score = $score;
		return $score;
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

		$this->setAnswerArray($answer_array);

		return $answer_array;
	}

	public function createSingleAnswerObject($answer)
	{
		//We will need to find out what the highest possible score for the question is.
		// We will store that in points_base, since that is the basis for our point system.
		
		$points_base = $this->getPointsBase($answer->question_id);

		$questionsMethod = $this->getQuestionsMethod();

		$question = $questionsMethod->get($answer->question_id);
		
		$question_text = $question->content;

		$single_answer_object = (object) array(

				'question_id' => $answer->question_id,
				'question_text' => $question_text,
				'answer_id' => $answer->id,
				'answer_text' => $answer->content,
				'points_base' => $points_base,
				'points' => $answer->points,
				'custom_response' => $answer->custom_text,

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
		$scoreMethod = $this->getScoreMethod();
		$scoreMethod->setAnswerArray($answer_array);
		$final_score = $scoreMethod->finalScore();

		return $final_score;
	}

	public function resultLevel($score)
	{
		$resultsTable = $this->getResultsTable();
		$score_levels = $resultsTable->get();

		$score_object = new stdClass();

		$score_array = array();

		foreach ($score_levels as $scores) {
			
			$level = $scores->level;
			$points = $scores->points;
			
			$score_object->$level = $points;
			//$score_object->$level->points = $scores->points;
		}

		$high  = $score_object->high;
		$medium = $score_object->medium;
		$low = $score_object->low;
		$bottom = $score_object->bottom;

		if($score < $low){

			$resultLevel = 'bottom';
		}

		if($score >= $high){

			$resultLevel = 'high';
		}

		if($score < $medium && $score >= $low){

			$resultLevel = 'low';
		}

		if($score < $high && $score >= $medium){

			$resultLevel = 'medium';
		}

		return $resultLevel;
	}
	
	public function resultsHTML($resultLevel)
	{	

		if(empty($resultLevel)){

			return;
		}

		
				

		return $resultsHtml;
	}

	public function getResultList($resultsLevel)
	{
		$lists = get_option('wp_segment_quiz_lists');

		$list = $lists['$resultsLevel'];
		return $list;
	}
	public function resultOutput()
	{
		
	}
	public function results(){
		
		$resultsTable = $this->getResultsTable();

		$resultLevel = $this->resultLevel($this->score);
		$score_info = $resultsTable->get_by( $resultLevel, 'level');
		$score_info = $score_info[0];

		$output = array();

		$output['score'] = $this->score;


		$resultHtml = $score_info->html;
		$output['html'] = trim(stripslashes($resultHtml));

		$resultList = $score_info->list;
		$output['list'] = ($resultList) ? $resultList : '_none';

		//Let's add the id of the stored results in the table.
		$output['result_id'] = $this->getId();

		$output = json_encode($output);

		
		return $output;
	}

	public function setAnswerArray($answer_array)
	{
		$this->answer_array = $answer_array;
	}

	public function getAnswerArray()
	{
		return $this->answer_array;
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

	public function setScoreMethod($scoreMethod)
	{
		$this->scoreMethod = $scoreMethod;
	}
	public function getScoreMethod()
	{
		return $this->scoreMethod;
	}

	public function saveSettings()
	{
		$data = trim(stripslashes($_POST['data']));
		$data = json_decode($data);

		$table = $this->getResultsTable();		

		foreach ($data as $level => $value) {
			
			$id = $table->get_by($level, 'level');
			$id = $id[0];
			$id = $id->id;
			
			$table->update($id, $value->points, 'points');
			$table->update($id, $value->list, 'list');
			$table->update($id, $value->html, 'html');

		}



	}

	public function setId($id)
	{
		$this->id = $id;
	}

	public function getId()
	{
		return $this->id;
	}

	public function getSettings()
	{	
		$resultsTable = $this->getResultsTable();
		$settings = $resultsTable->get();

		//Since we're getting the values ordered by Id DESC, let's reverse the order
		// so that 'high' comes first
		
		$settings = array_reverse($settings);
		
		return $settings;
	}
	public function getResultsTable()
	{
		$table = new pp_action_php_builder('pp_actionphp_results');
		return $table;
	}
}
?>