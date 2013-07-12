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
			$answer_array = $this->getAnswerArray();
			$answer_storage = serialize($answer_array);

			$table = $this->getUserResponseTable();

			$result_id = $table->create($answer_storage, 'response');

			return $result_id;

		}

		public function html()
		{
			$answer_array = $this->getAnswerArray();
			$quiz_name = get_option('wp_segment_quiz_name');

			$site = get_site_url();

			$user = $this->getUser();

			$head = '<h1 style="text-align: center; color: #003366;">' . $quiz_name .
			'</h1>';

			$head .= '<h2 style="text-align: center;">Created for: <span style="font-weight: normal; " >' . $user->first_name . ' ' . $user->last_name
			. '</span></h2>';

			$template = '<div style="margin: 15px auto; padding: 15px; border-bottom: 1px #ccc solid; width:
			640px">'."\n";
			$template .= '<strong>%%question%%</strong>'."\n";
			$template .= '<p>Your answer: <span style="font-style: italic;"
			>%%answer%%</span></p>';
			$template .= '<p><strong>Analysis:</strong> '."\n";
			$template .= '%%response%%</p>'."\n";
			$template .= '</div>'."\n";

			$body = '<html>'."\n";
			$body .= '<head></head>';
			$body .= '<body>';
			$body .= $head;

			foreach ($answer_array as $answer) {
				
				//Please notice that the on the first line that uses the template there is
				// no underscore before $template in the str_replace function. Leave it
				// that way!
				$_template = str_replace('%%question%%', $answer->question_text, $template);
				$_template = str_replace('%%answer%%', $answer->answer_text, $_template);
				$_template = str_replace('%%response%%', $answer->custom_response, $_template);

				$body .= $_template;
			}

			$body .= '</body>';
			$body .= '</html>';
			
			$this->setHTML($body);
			return $body;

		}

		public function retrieve($result_id)
		{
			$table = $this->getUserResponseTable();

			$user = $table->get($result_id);
			$this->setUser($user);

			$response = stripslashes($user->response);

			$answer_array = unserialize($response);

			$this->setAnswerArray($answer_array);

			$html = $this->html();
			
			$this->convertToPDF();
		}

		public function storeContactDetails($result_id, $first_name, $last_name,
			$email)
		{
			$table = $this->getUserResponseTable();
			$table->update($result_id, $first_name, 'first_name');
			$table->update($result_id, $last_name, 'last_name');
			$table->update($result_id, $email, 'email');
		}

		public function convertToPDF()
		{
			ob_start();
			echo $this->html;
			$content = ob_get_clean();

			$user = $this->getUser();

			$filename = stripslashes($user->first_name . '_' . $user->last_name);
			$filename = str_replace(' ', '_', $filename);
			$filename .= '_custom_report';

			try
		    {
		        // init HTML2PDF
		        $html2pdf = new HTML2PDF('P', 'A4', 'en', true, 'UTF-8', array(15, 15, 15, 15));

		        // display the full page
		        $html2pdf->pdf->SetDisplayMode('fullpage');

		        // convert
		        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
		        // send the PDF
		        $html2pdf->Output($filename . '.pdf', 'D');
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
		
		public function setUser($user)
		{	
			$this->user = $user;
		}
		
		public function getUser()
		{
			return $this->user;
		}
		
		public function getUserResponseTable()
		{
			$table = new pp_action_php_builder('pp_actionphp_user_response');
			return $table;
		}
	}

?>