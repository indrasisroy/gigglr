<?php

	$replaceFrom = array("{NAME}","{PASSWORD}","{SITENAME}","{YEAR}");
	    
	$replaceTo = array($fullname,$password,$sitename,$copyright_year);


	    $emailContent = str_replace($replaceFrom,$replaceTo,$email_body);

	    $emailcontent=html_entity_decode($emailContent);


	echo $emailcontent;


?>