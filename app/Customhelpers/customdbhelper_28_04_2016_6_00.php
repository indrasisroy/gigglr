<?php
function testmenow1()
{
  
  echo "Its Soumik test";
  
                //*** fetch data of user starts
                 
                $user_master_db = DB::table('user_master as um');
                $user_master_db=$user_master_db->select(DB::raw('um.id,um.first_name,um.password,um.email,um.status,um.user_type'));
                
                $user_master_db=$user_master_db->where('um.id', 1);
                
                $user_master_db=$user_master_db->first();
                
                if(!empty($user_master_db))
                {
                               $flag_id=1;
                               
                               echo "first_name==>".$user_master_db->first_name;
                       
                              
                       
                }
                
               //*** fetch data of user ends
}
?>