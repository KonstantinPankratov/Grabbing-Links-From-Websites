<?php

/**
 * Grabbing links class from websites
 *
 * @author Konstantin Pankratov <hello@kopa.pw>
 */

$response = NULL;

class LinksGrabber
{
	protected $error = false;
	public $URL;
	public $URLs = [];

	public function __construct($URL){
		$this->validate_url($URL);
		$this->init($this->URL);
	}

	public function __deconstruct(){
		unset($this);
	}

	public function init($URL)
	{
		$html = $this->get_contents($URL);
	
		$dom = new DOMDocument;
		@$dom->loadHTML($html);

		$links = $dom->getElementsByTagName('a');
		$this->grabbing($links);
	}

	private function grabbing($data)
	{

		global $response;

		foreach ($data as $link)
		{
			$url = $link->getAttribute('href');

			if(		strpos($url, "javascript") === FALSE
				AND strpos($url, "#") === FALSE 
				AND $url != "/" 
				AND $url != "" )
			{
				if (strpos($url, "http") === FALSE) {
					if ($url[0] == "/") {
						$url[0] = "";
					}
					$url = $this->URL . $url;
				}
		    	array_push($this->URLs, $url);
		    }
		}
		if (!$this->error) {
			$response = $this->URLs;
		}
	}

	private function validate_url($url)
	{
		$temp = $url;

		if (strpos($temp, '/') === false) {
			$temp = $temp . '/';
		}
		if (empty(parse_url($temp)['scheme'])) {
			$temp = 'http://' . $temp;
		}
		if (empty(parse_url($temp)['path'])) {
			$temp = $temp . "/";
		}

		return $this->URL = $temp;
	}

	private function get_contents($url)
	{
		global $response;

	    $headers = @get_headers($url);
	    $status = substr($headers[0], 9, 3);

	    if ($status == '200') {
	        return file_get_contents($url);
	    } else {
	    	$this->error = true;
	    	return $response = ["Failed to open website. Please, be sure that the website address is correct."];
	    }
	}
}
?>