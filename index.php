<?php
#------------------------------------->Free Google Translate<-----------------------------------#
	require_once("includes/GoogleTranslate.class.php");
#----------------------------------->Facebook API send_message<---------------------------------#
	include_once("facebook/send_message_plain_text.php");
#----------------------------------->Facebook API tokens<---------------------------------------#
	include_once("config.php");
#-----------------------------------------------------------------------------------------------#
	
	
#---------------------------->Facebook API webhook challange<-----------------------------------#
#------------------------------>to check if page responses<-------------------------------------#
	if(isset($_REQUEST['hub_challenge'])) {
		$challenge = $_REQUEST['hub_challenge'];
		$hub_verify_token = $_REQUEST['hub_verify_token'];
	}
	if ($hub_verify_token === $verify_token) {
		echo $challenge;
	}
#-----------------------------------------------------------------------------------------------#

#-------------------------->Receive message and fetch variables<--------------------------------#
	$input = json_decode(file_get_contents('php://input'), true);
	$sender = $input['entry'][0]['messaging'][0]['sender']['id'];
	$message = $input['entry'][0]['messaging'][0]['message']['text'];
	$message_to_reply = '';
	$message = htmlspecialchars(strtolower($message));
#-----------------------------------------------------------------------------------------------#
	
#-------------------------------------->Commands<-----------------------------------------------#
	if (strpos($message, 'time') === 0)
	{
		include("commands/command_time.php");
	}
	else if (strpos($message, 'wiki') === 0)
	{
		include("commands/command_wiki.php");
	}
	else if (strpos($message, 'ping') === 0)
	{
		send_message($sender, "Pong");
	}
	else if (strpos($message, 'hello') === 0)
	{
		send_message($sender, "Well Hello there :)");
	}
	else if (strpos($message, 'translate') === 0)
	{
		include("commands/command_translate.php");
	}
#-----------------------------------------------------------------------------------------------#
?>
