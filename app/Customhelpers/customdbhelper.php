<?php
function mailsnd($Temid=0,$replacefrom=array(),$replaceto=array(),$sndto,$subj='')
{
  $passarr=array(); $sendmailstatus=0;
  
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
				  $user_master_db=$user_master_db->select(DB::raw('et.subject,et.message,et.status'));
				  
				  $user_master_db=$user_master_db->where('et.id', $Temid);
				   $user_master_db=$user_master_db->where('et.status',1);
				  $user_master_db=$user_master_db->first();
				  
				  if(!empty($user_master_db))
				  {
							  
					  // $subject = $user_master_db->subject; //email subject
					  $body = $user_master_db->message; //email body
                      
                      
                      $subj=empty($subj)?($user_master_db->subject):$subj;
  
					  $passarr['adminfrom']=$emailfrom;
					  $passarr['emailsub']=$subj;
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
  
						 if($chkmail)
                         {
                             $sendmailstatus=1;
                         }
					
				  }
	  }
                
               //*** fetch data of email ends
    
    return $sendmailstatus;
  
}


/*for getdatafromtable() $fetchtype=>single/multiple
 *$wherear=>associative array of field name as key and  field value ( only and clauses will be implemented )
 */



function getdatafromtable($fetchtype='single',$tablename='',$fieldnames=' * ',$wherear=array(),$orderbyfield='',$orderbytype='asc',$limitstart=0,$limitend=0,$forinnotin=0,$forinnotin_type='IN',$infieldname='',$inar=array())
{
		$respar=array();
	
		$tab_db = DB::table($tablename);
		$tab_db=$tab_db->select(DB::raw($fieldnames));
		
		if(!empty($wherear))
		{
			
				$tab_db=$tab_db->where($wherear);
			
		}
		else
		{
			if($forinnotin==1)
			{
				if($forinnotin_type=="IN")
				{
						
						$tab_db=$tab_db->whereIn($infieldname, $inar);
				}
				elseif($forinnotin_type=="NOTIN")
				{
						$tab_db=$tab_db->whereNotIn($infieldname, $inar);
				}

			}
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