<?php
#--------------->Using Wikipedia API to find first page and send first <p></p><-----------------#
	ini_set('user_agent','Mozilla/4.0 (compatible; MSIE 6.0)');//Set header {TODO: set better header}

	$search = substr($message, 5); // remove command('wiki')
	$search = str_replace(" ","+",$search); // replace all backspaces with + for wiki API
	
#------------------------->Use Wikipedia API and fetch first page<------------------------------#
	$json_string = file_get_contents("https://en.wikipedia.org/w/api.php?action=query&format=json&list=search&utf8=1&srsearch=".$search);
	$json_a = json_decode($json_string);
	$wikiPage = file_get_contents("https://en.wikipedia.org/wiki/".str_replace(" ","_",$json_a->query->search[0]->title));
#-----------------------------------------------------------------------------------------------#

#------------------>Fetch first <p></p> and clean up result for Facebook<-----------------------#

	$first = strstr($wikiPage, '<p>');															#\
	$second = strstr($wikiPage, '</p>');														# \ Extract from Wikipedia page body
	$final = strip_tags(str_replace($second, "", $first));										# / first paragraph
	$final = str_replace("\"", "'",$final);														#/
	
	$pattern = "/&#160;/";																		#\
	$final = preg_replace($pattern, " ", $final);												# \ Replace what's left
	$pattern = "/&amp;/";																		# / out of html
	$final = preg_replace($pattern, "&", $final);												#/
	
	if (strrpos($final, "[") >= 0)																#\
		while (strrpos($final, "[") !== False)													# \
		{																						#   Remove those pesky reference tooltips out of text
			$final = substr_replace($final ," ", strrpos($final, "["), 4);						# /
		}																						#/

#-----------------------------------------------------------------------------------------------#

#------------------>Separate response into smaller pieces if necessary<-------------------------#
	if (strlen($final) > 300) // Facebook API has a limit of 320 chars per message
	{
		while (true)
		{
			$part = substr($final, 0, 300);
			$pos = strrpos($part, ".", -1);
			if ($pos === false) 
			{
				$pos = strrpos($part, " ", -1);
			}
			send_message($sender, substr($final, 0, $pos+1)); //Send response fragment to the Facebook
			$final = substr($final, $pos+1, strlen($final)-$pos+1);
			if (strlen($final) < 300)
				break;
		}		
		send_message($sender, $final);//Send response last fragment to the Facebook
		send_message($sender, "Source: https://en.wikipedia.org/wiki/".str_replace(" ","_",$json_a->query->search[0]->title));
	}
	else
	{
		send_message($sender, $final);//Send response to the Facebook
		send_message($sender, "Sou&rce: https://en.wikipedia.org/wiki/".str_replace(" ","_",$json_a->query->search[0]->title));
	}
#-----------------------------------------------------------------------------------------------#
?>