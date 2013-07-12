<?php
/**
 * Activates the plugin
 */

require_once 'class-builder.php';

	class WPSegmentActivation
	{

		public function activate()
		{
			$this->questions_table();
			$this->answers_table();
			$this->response_table();
			$this->user_table();
			$this->results_table();
			$this->populate_results_table();
		}

		public function questions_table()
		{
			global $wpdb;

			$table_name = $wpdb->prefix . "pp_actionphp_questions";

			$sql = "CREATE TABLE IF NOT EXISTS ".$table_name." (

			id mediumint(9) NOT NULL AUTO_INCREMENT,

			content text NOT NULL,
			      
			position int(9) NOT NULL,

			Status varchar(10) NOT NULL DEFAULT 'fresh',

			UNIQUE KEY id (id)

			);";
      
	      	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

    		dbDelta($sql);
    		

		}

		public function answers_table()
		{
			global $wpdb;

			$table_name = $wpdb->prefix . "pp_actionphp_answers";

			$sql = "CREATE TABLE IF NOT EXISTS ".$table_name." (

			id mediumint(9) NOT NULL AUTO_INCREMENT,

			question_id mediumint(9) NOT NULL,

			content text NOT NULL,

			points mediumint(9) NOT NULL DEFAULT 0,
			      
			position int(9) NOT NULL,

			custom_text text NOT NULL,

			Status varchar(10) NOT NULL DEFAULT 'fresh',

			UNIQUE KEY id (id)

			);";
      
	      	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

    		dbDelta($sql);


		}

		public function response_table()
		{
			global $wpdb;

			$table_name = $wpdb->prefix . "pp_actionphp_user_response";

			$sql = "CREATE TABLE IF NOT EXISTS ".$table_name." (

			id mediumint(9) NOT NULL AUTO_INCREMENT,

			response text NOT NULL,
			      
			email varchar(250) NOT NULL,

			first_name varchar(250) NOT NULL,

			last_name varchar(250) NOT NULL,

			Status varchar(10) NOT NULL DEFAULT 'fresh',

			UNIQUE KEY id (id)

			);";
      
	      	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

    		dbDelta($sql);
		}

		public function user_table()
		{
			# code...
		}

		public function results_table()
		{
			global $wpdb;

			$table_name = $wpdb->prefix . "pp_actionphp_results";

			$sql = "CREATE TABLE IF NOT EXISTS ".$table_name." (

			id mediumint(9) NOT NULL AUTO_INCREMENT,

			level varchar(10) NOT NULL,

			html text NOT NULL,

			points mediumint(9) NOT NULL DEFAULT 0,

			list varchar(25) NOT NULL,

			autoresponder varchar(25) NOT NULL,
			      
			Status varchar(10) NOT NULL DEFAULT 'fresh',

			PRIMARY KEY id (id),

			UNIQUE KEY (level)

			);";
      
	      	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

    		dbDelta($sql);
		}

		public function populate_results_table()
		{
			$resultsTable = new pp_action_php_builder('pp_actionphp_results');

			//Results for high score
			$high_score_id = $resultsTable->create('high', 'level');
			$resultsTable->update($high_score_id, '7', 'points');
			$resultsTable->update($high_score_id, '_none', 'list');

			//Results for medium score
			$medium_score_id = $resultsTable->create('medium', 'level');
			$resultsTable->update($medium_score_id, '5', 'points');
			$resultsTable->update($medium_score_id, '_none', 'list');


			//Results for low score
			$low_score_id = $resultsTable->create('low', 'level');
			$resultsTable->update($low_score_id, '3', 'points');
			$resultsTable->update($low_score_id, '_none', 'list');


			//Results for bottom score
			$bottom_score_id = $resultsTable->create('bottom', 'level');
			$resultsTable->update($bottom_score_id, '0', 'points');
			$resultsTable->update($bottom_score_id, '_none', 'list');
			
			
		}

	}

	$activation = new WPSegmentActivation;

?>