<?php

	class WPSegmentBranding 
	{


		public function top($show=false)
		{
			$css = '';//text-shadow: -1px -1px white, 1px 1px #333;';

			$branding = '<h1 style="' . $css . '">WP Baron</h1>';
			$branding .= '<hr>';

			if($show){

				echo $branding;
			} else {

				return $branding;
			}

		}


	}

?>