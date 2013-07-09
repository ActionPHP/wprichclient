<?php

	/**
	* 	
	*/
	class WPSegmentCustomReport
	{
		
		function __construct()
		{
			# code...
		}

		public function create($answer_array)
		{
			$head = '<h1 style="text-align: center;">' . $quiz_name . '</h1>';

			$template = '<div>';
			$template .= '<p><strong>%%question%%</strong></p>';
			$template .= '<p>Your answer: <span style="font-style: italic;"
			>%%answer%%</span></p>';
			$template .= '<p><strong>Analysis:</strong></p>';
			$template .= '<p>%%response%%</p>';
			$template .= '</div>';

			$body = '<html>';
			$body .= '<head></head>';
			$body .= '<body>';
			$body .= $head;

			foreach ($answer_array as $answer) {
				
				$template = str_replace('%%question%%', $answer->question, $template);
				$template = str_replace('%%answer%%', $answer->text, $template);
				$template = str_replace('%%response%%', $answer->custom_response, $template);

				$body .= $template;
			}

			return $body;

		}

		public function convertToPDF()
		{
			
		}
	}

?>