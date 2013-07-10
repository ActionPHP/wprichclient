<?php
require_once AP_PATH . 'vendor/html2pdf/html2pdf.class.php';
	/**
	* 	
	*/
	class WPSegmentCustomReport
	{
		
		function __construct()
		{
			# code...
		}

		public function create()
		{
			$html = $this->getHTML();

		}

		public function html()
		{
			$answer_array = $this->getAnswerArray();

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

			$body .= '</body>';
			$body .= '</html>';

			$this->setHTML($body);
			return $body;

		}

		public function convertToPDF()
		{
			ob_start();
			echo $this->html;
			$content = ob_get_clean();

			try
		    {
		        // init HTML2PDF
		        $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', array(0, 0, 0, 0));

		        // display the full page
		        $html2pdf->pdf->SetDisplayMode('fullpage');

		        // convert
		        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
		        // send the PDF
		        $html2pdf->Output('about.pdf');
		    }
		    catch(HTML2PDF_exception $e) {
		        echo $e;
		        exit;
		    }

		}

		public function setAnswerArray($answer_array)
		{
			$this->answer_array = $answer_array;
		}

		public function getAnswerArray()
		{
			return $this->answer_array;
		}
		
		public function setHTML($html)
		{
			$this->html = $html;
		}

		public function getHTML()
		{
			return $this->html;
		}
	}

?>