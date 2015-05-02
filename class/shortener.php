<?php
	include_once('dbconnection.php');
	
	class Shortener{
		protected $db;

		public function __construct(){
			$this->db = new dbConnect();
		}

		protected function generateCode($num){ //Generates Short Code by changing base of the ID from Links Table
			return base_convert($num, 10, 36);
		}
		public function genUrlCode($url, $userID){
			$url = trim($url);

			if(!filter_var($url, FILTER_VALIDATE_URL)){ //validate input is valid url or we would only have front end validation in the form easily bypassable
				return '';
			}

			$url = mysql_real_escape_string($url); //escaping url to make sure no problems occus when useing queries(escape for example quotation marks etc)

			//add to history of user
			$mysql = "INSERT INTO history (url, userId, created) VALUES ('$url', '$userID', NOW())";
			$result = mysql_query($mysql);

			//Check if URL alreadu exists
			$mysql = "SELECT code FROM links WHERE url = '$url'";
			$result = mysql_query($mysql);
			$value = mysql_fetch_object($result);
			
			if(!$value == false){
			//found and return code 
				$mysql = "UPDATE links SET counter = counter + 1 WHERE url = '$url'";
				$result = mysql_query($mysql);
				return $value->code;
			}
			else{
				//not in database store url and code	
				//insert record without a code
				$sitehome = str_replace("http://", "", $url);
				$sitehome = str_replace("https://", "", $sitehome);
				$sitehome = explode("/", $sitehome);
				$siteip = gethostbyname($sitehome[0]);
				if (filter_var($siteip, FILTER_VALIDATE_IP) === false) { //if invalid ip try ipv6
    				$result = dns_get_record($sitehome[0], DNS_AAAA);
    				print_r($result);
    				$siteip = $result[0]['ipv6'];
				}
				$mysql = "INSERT INTO links (url, created, IP) VALUES ('$url', NOW(), '$siteip')";
				$result = mysql_query($mysql);

				if(!$result){
					return '';	
				}

				$mysql = "SELECT * FROM links";
				$result = mysql_query($mysql);
			
				//Generate code based on inserted ID() Primary key
				$code = $this->generateCode(mysql_num_rows($result));

				//update the record with the generated code	
				$mysql = "UPDATE links SET code = '$code' WHERE url = '$url'";
				$result = mysql_query($mysql);

				return	$code;
			}


		}

		public function getUrl($code){
			$code = mysql_real_escape_string($code); //escape code
			$mysql = "SELECT url FROM links WHERE code = '$code'"; //search database for url correspawnding to code
			$result = mysql_query($mysql);
			$value = mysql_fetch_object($result);

			if(!$value == false){ 
				return $value->url;
			}

			return '';
		}

		public function searchdata($url){
			$url = trim($url);

			if(!filter_var($url, FILTER_VALIDATE_URL)){ //validate input is valid url or we would only have front end validation in the form easily bypassable
				return '';
			}

			$url = mysql_real_escape_string($url); //escaping url to make sure no problems occus when useing queries(escape for example quotation marks etc)

			//Check if URL alreadu exists
			$mysql = "SELECT code FROM links WHERE url = '$url'";
			$result = mysql_query($mysql);
			$value = mysql_fetch_object($result);

			if($value){
				return $value->code;
			}
			else{
				return '';
			}
		}

		public function deleterow($url){
			$url = trim($url);

			if(!filter_var($url, FILTER_VALIDATE_URL)){ //validate input is valid url or we would only have front end validation in the form easily bypassable
				return '';
			}

			$url = mysql_real_escape_string($url); //escaping url to make sure no problems occus when useing queries(escape for example quotation marks etc)

			$mysql = "DELETE from links where url = '$url'";
		}
	}

?>