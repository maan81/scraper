<?php

class IndexController extends \Phalcon\Mvc\Controller{


	public function indexAction(){

		$this->createURL();

		$html = $this->getHTML();

		$data = $this->parseHTML($html);

		$this->exportXLS($data);		

	}


	private function createURL(){

		$offset = 20;
		$limit = 10;
		$key = 'U0VMRUNUICogRlJPTSB0YmxidXNpbmVzc2xpc3RpbmcsIGNhdGVnb3J5LCB0Ymx1c2Vycywgc3RhdGUsIGNpdHkgV0hFUkUgIHRibGJ1c2luZXNzbGlzdGluZy51c2VyX2lkPXRibHVzZXJzLnVzZXJfaWQgQU5EIHRibGJ1c2luZXNzbGlzdGluZy5jYXRfaWQ9Y2F0ZWdvcnkuY2F0aWQgQU5EICB0Ymx1c2Vycy51c2VyX3N0YXR1cz0nQScgQU5EIHRibGJ1c2luZXNzbGlzdGluZy5zdGF0ZV9pZD1zdGF0ZS5zdGF0ZWlkIEFORCB0YmxidXNpbmVzc2xpc3RpbmcuY2l0eV9pZD1jaXR5LmNpdHlpZCBBTkQgY2F0ZWdvcnkuY2F0aWQ9NiBPUkRFUiBCWSBsaXN0aW5nX2lkIERFU0M=';
			


		$this->url = 'http://www.hvacyellowpages.com/paging/get-menus-general.php?'.
							'offset='.$offset.'&'.
							'limit='.$limit.'&'.
							'sqlgeneral='.$key;

		// public $url = 'http://localhost/';

	}

	private function getHTML(){
		// $timemout = 5;

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		// curl_setopt($ch, CURLOPT_HEADER, false);
		// curl_setopt($ch, CURLOPT_CONNECTTIMOUT, $timemout);

		$html = curl_exec($ch);

		curl_close($ch);

		return $html;
	}

	private function parseHTML($html){

		$dom = new DOMDocument();

		@$dom->loadHTML($html);

			$node = $dom->getElementsByTagName('table')->item(0);

			$tmp = $node->childNodes;

			$attrs = array();

			// while($node->nextSibling!=null){
				
			// 	if($node->hasAttributes()){

			// 		foreach($node->attributes as $attr){

			// 			$attrs = $attr->nodeValue;

			// 		}
			// 	}

			// 	print_r($attrs);
			// 	// print_r($node);		
			// 	$node=$node->nextSibling;
			// }

   if ($node->hasAttributes())
    {
        foreach ($node->attributes as $attr)
        {
            $array[$attr->nodeName] = $attr->nodeValue;
        }
    }

    if ($node->hasChildNodes())
    {
        if ($node->childNodes->length == 1)
        {
            $array[$node->firstChild->nodeName] = $node->firstChild->nodeValue;
        }
        else
        {
            foreach ($node->childNodes as $childNode)
            {
                if ($childNode->nodeType != XML_TEXT_NODE)
                {
                    $array[$childNode->nodeName][] = $this->getArray($childNode);
                }
            }
        }
    } 
	//-------------------
	print_r($array);    
	die;
	//-------------------
			print_r($tmp);die;
					$table = $dom->getElementById('divpagincontent');

					print_r($table);

	}

	private function exportXLS(){}


}