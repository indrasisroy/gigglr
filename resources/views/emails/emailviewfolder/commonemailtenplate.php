<?php

	    $emailContent = str_replace($replacefrom,$replaceto,$email_body);
	    $emailcontent=html_entity_decode($emailContent);
		echo $emailcontent;

?>