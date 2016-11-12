<?php
#------------------------->Lets use a 'FREE' google tanslate API<-------------------------------#
	$search = substr($message, 10); // remove command('translate')
	$language = substr($search, 0, strpos($search, " ")); // get language code
	if (strlen($language) === 5) // egz.: en-fr
	{
		$source = substr($language, 0, 2);
		$target = substr($language, 3, 5);
		#{TRANSLATE}#
		$translation = GoogleTranslate::translate($source, $target, substr($search, strpos($search, " ")+1));
		send_message($sender, $translation); //Send response to the Facebook
	}
	else if (strlen($language) === 2) // if we get only one language let's use auto for input
	{
		$source = 'auto';
		$target = $language;
		#{TRANSLATE}#
		$translation = GoogleTranslate::translate($source, $target, substr($search, strpos($search, " ")+1));
		send_message($sender, $translation); //Send response to the Facebook
	}
	else
	{
		send_message($sender, "Invalid language code"); //Send response to the Facebook
	}
#-----------------------------------------------------------------------------------------------#
?>