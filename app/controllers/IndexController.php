<?php

class IndexController extends \Phalcon\Mvc\Controller{

	private $offset = -100;
	private $limit  = 100;
	private $key = 'U0VMRUNUICogRlJPTSB0YmxidXNpbmVzc2xpc3RpbmcsIGNhdGVnb3J5LCB0Ymx1c2Vycywgc3RhdGUsIGNpdHkgV0hFUkUgIHRibGJ1c2luZXNzbGlzdGluZy51c2VyX2lkPXRibHVzZXJzLnVzZXJfaWQgQU5EIHRibGJ1c2luZXNzbGlzdGluZy5jYXRfaWQ9Y2F0ZWdvcnkuY2F0aWQgQU5EICB0Ymx1c2Vycy51c2VyX3N0YXR1cz0nQScgQU5EIHRibGJ1c2luZXNzbGlzdGluZy5zdGF0ZV9pZD1zdGF0ZS5zdGF0ZWlkIEFORCB0YmxidXNpbmVzc2xpc3RpbmcuY2l0eV9pZD1jaXR5LmNpdHlpZCBBTkQgY2F0ZWdvcnkuY2F0aWQ9NiBPUkRFUiBCWSBsaXN0aW5nX2lkIERFU0M=';


	public function indexAction(){

		ini_set('max_execution_time',1800);

		include __DIR__.'/../helpers/development_helper.php';
		include __DIR__.'/../libraries/simple_html_dom.php';

		// $this->createURL();

		// $html = $this->getHTML();
		// echo($html);
		// die;

		$data = array();

		$repeat = 0;

		while(count($data)<21806){
			$repeat ++;

			$data = array_merge($data,$this->parseHTML());

		}
		_print_r($repeat,false);
		_print_r($data);
		
		$this->exportXLS($data);		

	}


	private function createURL(){

		//-------------------
			// $offset = 20;
			// $limit = 10;
			// $key = 'U0VMRUNUICogRlJPTSB0YmxidXNpbmVzc2xpc3RpbmcsIGNhdGVnb3J5LCB0Ymx1c2Vycywgc3RhdGUsIGNpdHkgV0hFUkUgIHRibGJ1c2luZXNzbGlzdGluZy51c2VyX2lkPXRibHVzZXJzLnVzZXJfaWQgQU5EIHRibGJ1c2luZXNzbGlzdGluZy5jYXRfaWQ9Y2F0ZWdvcnkuY2F0aWQgQU5EICB0Ymx1c2Vycy51c2VyX3N0YXR1cz0nQScgQU5EIHRibGJ1c2luZXNzbGlzdGluZy5zdGF0ZV9pZD1zdGF0ZS5zdGF0ZWlkIEFORCB0YmxidXNpbmVzc2xpc3RpbmcuY2l0eV9pZD1jaXR5LmNpdHlpZCBBTkQgY2F0ZWdvcnkuY2F0aWQ9NiBPUkRFUiBCWSBsaXN0aW5nX2lkIERFU0M=';

		// update the parameters for the current url
		$this->offset = $this->offset + $this->limit;

		// set the url
		$this->url = 'http://www.hvacyellowpages.com/paging/get-menus-general.php?'.
							'offset='.$this->offset.'&'.
							'limit='.$this->limit.'&'.
							'sqlgeneral='.$this->key;

		// $this->url = 'http://localhost/';

	}


	private function getHTML(){

		$html = file_get_html($this->url);

		return $html;
	}


	private function parseHTML(){

		// create url for the new page
		$this->createURL();

		// get the raw html of the page
		$html = $this->getHTML();

		$data = array();

		// filter & extract data for the page

		$tables = $html->find('table[width=780]');

		foreach($tables as $table){

			$outer_tds = $table->first_child()->first_child();

			// 1st outer td
			$row['image'] = $outer_tds->first_child()->attr['src']; //image

			// 2nd outer td

			$table = $outer_tds->next_sibling()->first_child();

			$row['title']   = $table->children(0)->first_child()->plaintext;
			$row['address'] = $table->children(1)->children(0)->plaintext;
			$row['street']  = $table->children(1)->children(1)->plaintext;
			$row['city']    = $table->children(2)->children(1)->plaintext;
			$row['state']   = $table->children(3)->children(1)->plaintext;
			$row['phone']   = $table->children(4)->children(1)->plaintext;
			$row['email']   = $table->children(5)->children(1)->plaintext;
			// $row['link']    = $table->children(6)->children(1)->children(0)
			// 													->children(1)->attr['href'];
			$data[] = $row;
		}

		return $data;
	}
}