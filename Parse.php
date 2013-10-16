<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Parse {

	private $domain = "https://api.parse.com";
	
	private $objUrl = "/1/classes/";
	private $fileUrl = "/1/files/";
	
	/***
	 * 
	 * Update these values to match your Parse.com App ID / Key.
	 *
	 */
	private $app = PARSE_APP_ID;
	private $key = PARSE_REST_KEY;
	
    public function getUser()
    {
    }
    
    public function getParseObj($obj, $id=null, $params=null) {
    	$url = $this->domain . $this->objUrl . $obj;

		$curl = null;
    	if ($id!=null) {
			$curl = curl_init($url . "/" . $id);
		} else if ($params != null) {
			$url .= "?";
			for ($i=0; $i<count($params); $i++) {
				$url .= urlencode($params[$i]);
				if ($i < count($params))
					$url .= "&";
			}
    		$curl = curl_init($url);
		} else {
			$curl = curl_init($url);
		}
		
		$options = array(
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_HTTPHEADER => array("X-Parse-Application-Id:".$this->app, "X-Parse-REST-API-Key:" . $this->key, "Content-type: application/json"),
		);
		
		curl_setopt_array($curl, $options);
		
		return curl_exec($curl);
    }
    
    private function persistParseObj($request, $obj, $id=null, $params=null) {
    	$url = $this->domain . $this->objUrl . $obj;

		$curl = null;
		if ($id!=null)
    		$url = $url . "/" . $id;
    		
		$curl = curl_init($url);
		
		$options = array(
			CURLOPT_HTTPHEADER => array("X-Parse-Application-Id:".$this->app, "X-Parse-REST-API-Key:" . $this->key, "Content-type: application/json"),
			CURLOPT_CUSTOMREQUEST => $request, 
			CURLOPT_POSTFIELDS => json_encode($params), 
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_RETURNTRANSFER => true
		);
		
		curl_setopt_array($curl, $options);
		
		return curl_exec($curl);
    }
    
    private function persistParseFile($request, $path, $filename, $contentType) {
    	$url = $this->domain . $this->fileUrl . $filename;

		$curl = curl_init($url);
		
		$params = file_get_contents($path . '/' . $filename);
		
		$options = array(
			CURLOPT_HTTPHEADER => array("X-Parse-Application-Id:".$this->app, "X-Parse-REST-API-Key:" . $this->key, "Content-type: " . $contentType),
			CURLOPT_BINARYTRANSFER => true,
			CURLOPT_CUSTOMREQUEST => $request, 
			CURLOPT_POSTFIELDS => $params, 
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_RETURNTRANSFER => true
		);
		
		curl_setopt_array($curl, $options);
		
		return curl_exec($curl);
    }
    
    public function newParseObj($obj, $params=null) {
 		return $this->persistParseObj("POST", $obj, null, $params);   	
    }
    
    public function updateParseObj($obj, $id, $params=null) {
    	return $this->persistParseObj("PUT", $obj, $id, $params);	
    }
    
    public function is_uploaded_file(filename)($path, $filename, $type) {
    	return $this->persistParseFile("POST", $path, $filename, $type);
    }
}