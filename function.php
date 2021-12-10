<?php
function cogCurlGET($url)
{
	$ch       = curl_init($url);
	
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); //TRUE to return the transfer as a string of the return value of curl_exec() instead of outputting it out directly.
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE); //To follow any "Location: " header that the server sends as part of the HTTP header.
	curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE); //To automatically set the Referer: field in requests where it follows a Location: redirect.
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); //To stop cURL from verifying the peer's certificate.
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_FAILONERROR, true); //Report HTTP error also
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
	
	$contents = curl_exec($ch);
	if(curl_error($ch))
		$contents = "Error:".curl_error($ch);
	curl_close($ch);
	
	return $contents;
}

function cogCurlPOST($url,$params)
{
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); //TRUE to return the transfer as a string of the return value of curl_exec() instead of outputting it out directly.
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE); //To follow any "Location: " header that the server sends as part of the HTTP header.
	curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE); //To automatically set the Referer: field in requests where it follows a Location: redirect.
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); //To stop cURL from verifying the peer's certificate.
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_FAILONERROR, true); //Report HTTP error also
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

	$contents = curl_exec ($ch);
	if(curl_error($ch))
		$contents = "Error:".curl_error($ch);
	curl_close ($ch);
	
	return $contents;
}

function cogJsonDecode ($json)
{
	// first check and remove bad script added by Yahoo! hosting service
	$yahooBadScript = strpos ($json, "<script type = ");
	if ($yahooBadScript !== FALSE)
		$json = substr ($json, 0, $yahooBadScript);
	$output = json_decode($json);
	if ($output == null || empty($output) || !isset($output))
	{
		$output = json_decode($json, true);
		if ($output == null || empty($output) || !isset($output))
		{
			$output = json_decode ( preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $json), true );
			if ($output == null || empty($output) || !isset($output))
			{
				preg_match('#\{(.*?)\}#', $json, $match);
				$json = $match[0]."}";
				$output = json_decode($json);
			}
		}
	}
	return $output;
}

function generateRandomString($length,$allcaps=true)
{
	$key = md5(mt_rand());
	$str = "";
	for($i=0; $i < $length; $i ++ )
		$str .= $key[$i];
	if ($allcaps)
		$str = strtoupper($str);
	return $str;
}

function cogEmail ($to_email, $subject, $body, $from_name, $access_token)
{
	$bridge = "http://www.cognifront.net/api/queue-email-js.php";
	$params = new StdClass;
	$params->from_name = $from_name;
	$params->to_email = $to_email;
	$params->subject = $subject;
	$params->html_body = base64_encode($body);
	$params->cc = '';
	$params->attachments = '';
	$params->timeoffset = '+00:00';
	$params->instantone = 'sendnow';
	$params->access_token = $access_token;
	$record = array('record' => json_encode($params));
	return cogCurlPOST($bridge, $record);
}

function redirect ($url, $statusCode = 301)
{
    header ("Location: " . $url, true, $statusCode);
    die ();
}
?>