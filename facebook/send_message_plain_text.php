<?php
#--------------->Function to post a plain text response to the Facebook<------------------------#
function send_message($id, $text)
{
	global $access_token;
	//API Url
	$url = 'https://graph.facebook.com/v2.6/me/messages?access_token='.$access_token;
	//Initiate cURL.
	$ch = curl_init($url);
	//The JSON data.
	$jsonData = '{
		"recipient":{
			"id":"'.$id.'"
		},
		"message":{
			"text":"'.$text.'"
		}
	}';
	//Encode the array into JSON.
	$jsonDataEncoded = $jsonData;
	//Tell cURL that we want to send a POST request.
	curl_setopt($ch, CURLOPT_POST, 1);
	//Attach our encoded JSON string to the POST fields.
	curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
	//Set the content type to application/json
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
	//Execute the request
	if(!empty($id))
	{
		$result = curl_exec($ch);
	}
}
#-----------------------------------------------------------------------------------------------#
?>