<?php
/**
 * Process the answers and calculates the final score.
 */
class WPSegmentScore
{
	private $answer_array;

	/**
	 * Computest the score for each question.
	 * 
	 * The basic formula is: the highest possible number of points
	 * for that question, divided by the actual points given for that
	 * question.
	 * 
	 * @param  object $answer An object containing the points given for that answer,
	 * as well as the highest possible points.
	 * @return float         number representing the score for the question.
	 */
	public function answerScore($answer)
	{	
		$score = null;

		$answer_points = $answer->points;

		//We have made all the answers reltive to 10 points
		$points_base = 10; //$answer->points_base;

		//Let's make sure we don't divide by 0
		if($points_base != 0){

			$score = $answer_points / $points_base;
		}

		return $score;
	}

	/**
	 * Loops through all the answers and outputs the score
	 * rounder to two decimal places.
	 * @return float number representing the score for the quiz.
	 */
	public function score()
	{
		//First we get all the answers
		$answers = $this->getAnswerArray();
		
		//Then we count them
		$total_answers = count($answers);

		//Now we will loop through each of them and get the score for each answer.
		//We will also add each score to the total
		//Let's set the total to zere and get started!
		$total = 0;
		
		foreach($answers as $answer){

			$answer_score = $this->answerScore($answer);

			$total += $answer_score;

		}

		//Let's get the average score - that's our final score!
		$score = $total / $total_answers;
		$score = round($score, 2);

		return $score;
	}

	public function setAnswerArray($answer_array)
	{
		$this->answer_array = $answer_array;
	}

	public function getAnswerArray()
	{	
		$answer_array = $this->answer_array;
		return $answer_array;
	}

	public function finalScore($multiplier=10)
	{
		if(!$this->getAnswerArray()) return false;

		$score = $this->score();

		$final_score = $score * $multiplier ;
		return $final_score;
	}

}
?>