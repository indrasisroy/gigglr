<?php

	//echo "Password is =>".$password;
	$password_show = '';
	if(strlen($password)>11)
	{
	
	 	$password_show = $password;
	}else
	{
		$password_show = '';
	}

	$replaceFrom = array("{NAME}","{USERNAME}","{PASSWORD}","{SITENAME}","{YEAR}");
	    
	$replaceTo = array($to_name,$usernamelogin,$password_show,$sitename,$copyright_year);


	    $emailContent = str_replace($replaceFrom,$replaceTo,$email_body);

	    $emailcontent=html_entity_decode($emailContent);


	echo $emailcontent;


?>