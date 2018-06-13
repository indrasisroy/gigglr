<?php

	
	$replaceFrom = array("{NAME}","{USERNAME}","{PASSWORD}","{SITENAME}","{YEAR}");
	    
	$replaceTo = array($useremailtoname,$username,$password,$sitename,$copyright_year);


	    $emailContent = str_replace($replaceFrom,$replaceTo,$email_body);

	    $emailcontent=html_entity_decode($emailContent);


	echo $emailcontent;


?>