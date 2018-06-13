<?php
function mailsnd($Temid=0,$replacefrom=array(),$replaceto=array(),$sndto)
{
  $passarr=array();
  
	  if(!empty($Temid))
	  {
			  //**************fetch data fro settings starts here
			  $userssel = DB::table('settings')
						  ->select(DB::raw('site_name,email_from,copyright_year'))
						  ->where('id', 1)
						  ->get();
			  $sitename=$userssel[0]->site_name;
			  $emailfrom=$userssel[0]->email_from;
			  $copyright_year=$userssel[0]->copyright_year;
			  //************** fetch data for settings ends here
  
  
			   //*** fetch data of email starts
				   
				  $user_master_db = DB::table('email_templates as et');
				  $user_master_db=$user_master_db->select(DB::raw('et.subject,et.message'));
				  
				  $user_master_db=$user_master_db->where('et.id', $Temid);
				  
				  $user_master_db=$user_master_db->first();
				  
				  if(!empty($user_master_db))
				  {
							  
					  // $subject = $user_master_db->subject; //email subject
					  $body = $user_master_db->message; //email body
  
					  $passarr['adminfrom']=$emailfrom;
					  $passarr['emailsub']=$user_master_db->subject;
					  $passarr['emailto']=$sndto;
					  $passarr['sitename']=$sitename;
					   $data = array(
						'replacefrom'=>$replacefrom,'replaceto'=>$replaceto,'email_body'=>$body
						);
						  $chkmail= Mail::send('admin.emailviewfolder.admincommonemailtenplate', $data, function ($message) use ($passarr)
						   {
					  
							  $message->from($passarr['adminfrom'], $passarr['sitename']);
							  
							  $message->to($passarr['emailto'])->subject($passarr['emailsub']);
					  
						  });
  
						 
					
				  }
	  }
                
               //*** fetch data of email ends
  
}


function chekingIndrasis()
{
  echo "HELLEO";exit();
 
}
?>