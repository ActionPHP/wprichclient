<?php
require_once 'class-aweber.php';
require_once 'class-getresponse.php';
require_once 'class-icontact.php';
require_once 'class-infusionsoft.php';


class WPSegmentAutoresponder
{
	private $autoresponder = '';
	private $connection;
	private $lists = array();

	public function showLists($name='', $selected = '')
	{
		
		$autoresponder = get_option('wp_segment_autoresponder_service');

		if(empty($autoresponder)) {

			return;
		}

		$lists = $this->getLists($autoresponder);

		$list_select = '<select name="' . $name . '" class="wp-segment-list" >';
		$list_select .= '<option value="_none" >No list</option>';
		foreach ($lists as $list_id => $list) {
			
			$list_select .= '<option value="' . $list_id . '" >' . $list['name'] .
			'</option>';

		}


		$list_select .= '</select>';
		
		return $list_select;
	}
	public function getAutoresponder($autoresponder)
	{
		
		switch ($autoresponder) {
			case 'aweber':

				$_autoresponder = new WPSegmentAweber;
				$this->setAutoresponder($_autoresponder);
			
			break;

			case 'getresponse':

				$_autoresponder = new WPSegmentGetResponse;
				$this->setAutoresponder($_autoresponder);
			
			break;

			case 'icontact':
				$_autoresponder = new WPSegmentIcontact;
				$this->setAutoresponder($_autoresponder);
			
			break;

			case 'infusionsoft':
				$_autoresponder = new WPSegmentInfusionsoft;
				$this->setAutoresponder($_autoresponder);
			
			break;
			
			default:
				
				break;
		}

			return $_autoresponder;
	}

	public function getLists($_autoresponder)
	{	
		$autoresponder = $this->getAutoresponder($_autoresponder);

		$this->lists = $autoresponder->getLists();
		return $this->lists;
	}
	public function setAutoresponder($autoresponder)
	{
		$this->autoresponder = $autoresponder;
	}

}

?>