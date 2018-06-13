<?php
function mailsnd($Temid=0,$replacefrom=array(),$replaceto=array(),$sndto)
{
  $passarr=array();
  
	  if(!empty($Temid))
	  {
			  //**************fetch data fro settings starts here
			  $userssel = DB::table('settings')
						  ->select(DB::raw('site_name,email_from,copyright_year,emailfromname'))
						  ->where('id', 1)
						  ->get();
			  $sitename=$userssel[0]->site_name;
			  $emailfromname = $userssel[0]->emailfromname;
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
					  $passarr['emailfromname']=$emailfromname;
					   $data = array(
						'replacefrom'=>$replacefrom,'replaceto'=>$replaceto,'email_body'=>$body
						);
						  $chkmail= Mail::send('emails.emailviewfolder.commonemailtenplate', $data, function ($message) use ($passarr)
						   {
					  
							  $message->from($passarr['adminfrom'], $passarr['emailfromname']);
							  
							  $message->to($passarr['emailto'])->subject($passarr['emailsub']);
					  
						  });
  
						 
					
				  }
	  }
                
               //*** fetch data of email ends
  
}


/*for getdatafromtable() $fetchtype=>single/multiple
 *$wherear=>associative array of field name as key and  field value ( only and clauses will be implemented )
 */



function getdatafromtable($fetchtype='single',$tablename='',$fieldnames=' * ',$wherear=array(),$orderbyfield='',$orderbytype='asc',$limitstart=0,$limitend=0)
{
		$respar=array();
	
		$tab_db = DB::table($tablename);
		$tab_db=$tab_db->select(DB::raw($fieldnames));
		
		if(!empty($wherear))
		{
			$tab_db=$tab_db->where($wherear);
		}
		
		if(!empty($orderbyfield))
		{
			$tab_db=$tab_db->orderBy($orderbyfield, $orderbytype);
		}
		
		if(!empty($limitend))
		{
			$tab_db = $tab_db->skip($limitstart)->take($limitend);
		}
		
		if($fetchtype=="single")
		{
			$tab_db=$tab_db->first();
		}
		elseif($fetchtype=="multiple")
		{
			$tab_db=$tab_db->get();
		}
	 
		if(!empty($tab_db))
		{
			$respar=$tab_db;
			
		}
		
		
		return $respar;
				  
				  
	
}
?>