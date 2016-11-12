<?php
#----------------------------->Simple get request for utc time<---------------------------------#
	ini_set('user_agent','Mozilla/4.0 (compatible; MSIE 6.0)');	//Set header {TODO: set better header}
	$result = file_get_contents("http://www.timeapi.org/utc/now?format=%25a%20%25b%20%25d%20%25I:%25M:%25S%20%25Y");
	if($result != '') 
	{
		send_message($sender, $result); //Send response to the Facebook
	}
#-----------------------------------------------------------------------------------------------#
?>