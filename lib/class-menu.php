<?php
/**
 * Creates WP menus for the plugin
 */
class SegmentMenu
{
	public $parent_slug = 'actionphp-segment';
	public $capability = 'manage_options';

 	public function menu()
 	{
 		$this->main_menu();
 		$this->create_quiz_menu();
 		$this->quiz_settings_menu();
 		$this->results_settings_menu();
		$this->autoresponder_menu();

 	}

 	public function main_menu()
 	{
 		$page_title = 'Segment This';
		$menu_title = 'Segmenting';
		$capability = $this->capability;
		$menu_slug = $this->parent_slug;
		$function = array($this, 'main_menu_view');

		add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );

 	}

 	public function main_menu_view()
 	{
 		
 		$branding = new WPSegmentBranding;
 		echo $branding->top();

 		$path = AP_PATH;
 		$path.= 'menu/main-page.php';

 		include($path);
 	}

 	public function create_quiz_menu()
 	{
 		$parent_slug = 'actionphp-segment';//$this->parent_slug;
 		$page_title = 'Create quiz';
 		$menu_title = 'Create your quiz';
 		$capability = $this->capability;
 		$menu_slug = 'actionphp-segment-create-quiz';
 		$function = array ($this, 'create_quiz_menu_view');

		add_submenu_page( 'actionphp-segment', $page_title, $menu_title, $capability, $menu_slug, $function );


 	}

 	public function create_quiz_menu_view()
 	{
 		$branding = new WPSegmentBranding;
 		echo $branding->top();

 		$path = AP_PATH;
 		$path.= 'menu/create-quiz.php';
 		
 		include($path);

 	}

 	public function results_settings_menu()
 	{
 		$parent_slug = 'actionphp-segment';//$this->parent_slug;
 		$page_title = 'Your results settings';
 		$menu_title = 'Results settings';
 		$capability = $this->capability;
 		$menu_slug = 'actionphp-segment-results-settings';
 		$function = array ($this, 'results_settings_menu_view');

		add_submenu_page( 'actionphp-segment', $page_title, $menu_title, $capability, $menu_slug, $function );


 	}

 	public function results_settings_menu_view()
 	{	

 		$branding = new WPSegmentBranding;
 		echo $branding->top();

 		$path = AP_PATH;
 		$path.= 'menu/results-settings.php';
 		
 		include($path);

 	}

 	public function quiz_settings_menu()
 	{
 		$parent_slug = 'actionphp-segment';//$this->parent_slug;
 		$page_title = 'Your quiz settings';
 		$menu_title = 'Quiz settings';
 		$capability = $this->capability;
 		$menu_slug = 'actionphp-segment-quiz-settings';
 		$function = array ($this, 'quiz_settings_menu_view');

		add_submenu_page( 'actionphp-segment', $page_title, $menu_title, $capability, $menu_slug, $function );


 	}

 	public function quiz_settings_menu_view()
 	{
 		$branding = new WPSegmentBranding;
 		echo $branding->top();

 		$path = AP_PATH;
 		$path.= 'menu/quiz-settings.php';
 		
 		 $quiz_name	= get_option('wp_segment_quiz_name');
 		 $description= get_option('wp_segment_quiz_description');
		 $footer= get_option('wp_segment_quiz_footer');

 		include($path);

 	}


 	public function autoresponder_menu()
 	{
 		$parent_slug = 'actionphp-segment';//$this->parent_slug;
 		$page_title = 'Your autoresponder settings.';
 		$menu_title = 'Autoresponder';
 		$capability = $this->capability;
 		$menu_slug = 'actionphp-segment-autoresponder' ;
 		$function = array ($this, 'autoresponder_menu_view');

		add_submenu_page( 'actionphp-segment', $page_title, $menu_title, $capability, $menu_slug, $function );
 	}

 	public function autoresponder_menu_view()
 	{
 		
 		$branding = new WPSegmentBranding;
 		echo $branding->top();
 		
 		$path = AP_PATH;
 		$path.= 'menu/autoresponder-settings.php';
 		
 		include($path);
 	}


}