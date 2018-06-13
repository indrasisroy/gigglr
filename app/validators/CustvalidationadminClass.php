<?php
//use DB;
class CustvalidationadminClass{
    
    public  function countrynameunique($attribute, $value, $parameters, $validator) {
 
         $id=0;  $country_name=$value;           
             if(!empty($parameters)&& array_key_exists(0,$parameters))
             {
                 $id=$parameters[0]; 
                
             }
              
            
            $user_single = DB::table('location_country');
            $user_single=$user_single->where('country_name', '=', $country_name);
            if(!empty($id))
             {
                    //***check for edit
                    $user_single=$user_single->where('id', '<>', $id);
             }
          
            $user_single=$user_single->get();
            
            
            $tot=count($user_single);
            
            if($tot>0)
            {
                return false;
            }
            else
            {
                return true;
            }
       
    }
    
    
    
    public  function country2codeunique($attribute, $value, $parameters, $validator) {
 
         
            
             $id=0;  $country_2_code=addslashes(strtoupper(trim($value)));           
             if(!empty($parameters)&& array_key_exists(0,$parameters))
             {
                 $id=$parameters[0]; 
                
             }
              
            
            $user_single = DB::table('location_country');
            $user_single=$user_single->where('country_2_code', '=', $country_2_code);
            if(!empty($id))
             {
                    //***check for edit
                    $user_single=$user_single->where('id', '<>', $id);
             }
          
            $user_single=$user_single->get();
            
            
            $tot=count($user_single);
            
            if($tot>0)
            {
                return false;
            }
            else
            {
                return true;
            }
        
       
    }
    
    public  function country3codeunique($attribute, $value, $parameters, $validator) {
 
         
          
            
             $id=0;  $country_3_code=addslashes(strtoupper(trim($value)));           
             if(!empty($parameters)&& array_key_exists(0,$parameters))
             {
                 $id=$parameters[0]; 
                
             }
              
            
            $user_single = DB::table('location_country');
            $user_single=$user_single->where('country_3_code', '=', $country_3_code);
            if(!empty($id))
             {
                    //***check for edit
                    $user_single=$user_single->where('id', '<>', $id);
             }
          
            $user_single=$user_single->get();
            
            
            $tot=count($user_single);
            
            if($tot>0)
            {
                return false;
            }
            else
            {
                return true;
            }
      
       
    }
    
     public  function articlenameunique($attribute, $value, $parameters, $validator) {
 
                    
             $id=0;  $title=$value;           
             if(!empty($parameters)&& array_key_exists(0,$parameters))
             {
                 $id=$parameters[0]; 
                
             }
              
            
            $user_single = DB::table('article');
            $user_single=$user_single->where('title', '=', $title);
            if(!empty($id))
             {
                    //***check for edit
                    $user_single=$user_single->where('id', '<>', $id);
             }
          
            $user_single=$user_single->get();
            $tot=count($user_single);
            
            if($tot>0)
            {
                return false;
            }
            else
            {
                return true;
            }
      
      
       
    }
    
    
     public  function alpha_spaces($attribute, $value, $parameters, $validator) {
 
                    
             return preg_match('/^[\pL\s]+$/u', $value);
     
       
    }
    
    public  function skillunq_name($attribute, $value, $parameters, $validator) {
 
                    
            

            $id=0;$parent_id=0;$nwname='';  $title=$value; $catgorytype=0;           
             if(!empty($parameters)&& array_key_exists(0,$parameters))
             {
                 $id=$parameters[0]; 
                 $parent_id=$parameters[1]; 
                 $nwname = $parameters[2];     
                 $nwname = strtoupper($nwname);
                 $catgorytype = $parameters[3]; 
             }
              $title = strtoupper($title);
            
              $user_single = DB::table('skill_master');
            // $user_single=$user_single->where('name', '=', $value);
            // $user_single=$user_single->where('parent_id', '=', $parent_id);

             $user_single=$user_single->where('name', '=', $title);
             // $user_single=$user_single->where('id', '=', $parent_id);
             $user_single=$user_single->where('catag_type', '=', $catgorytype);
             $user_single=$user_single->where('parent_id', '=', 0);



            if(!empty($id))
             {
                    //***check for edit
                    $user_single=$user_single->where('id', '<>', $id);
             }
          
            $user_single=$user_single->get();
            $tot=count($user_single);
            
            if($tot>0)
            {
                return false;
            }
            else
            {
                return true;
            }
         
            
        
     
       
    }
    public  function checkadminusername($attribute, $value, $parameters, $validator) {
 
            $password='';  $country_name=$value;
            
            $username = $value;
          
             if(!empty($parameters)&& array_key_exists(0,$parameters))
             {
                 $password =$parameters[0]; 
                
             }
             
         $user_single = DB::table('user_master')->where([
         
          ['username',$username],
          ['password',md5($password)]
          ])->first();

          /*echo "==user_single==><pre>";
          print_r($user_single);
          echo "</pre>";*/
          $returnflag=true;
          $status=0;$user_type=1;$userid=0;
          if(!empty($user_single))
          {
               $status=$user_single->status;
               $user_type=$user_single->user_type;
               $userid=$user_single->id;
               
               
               if(($user_type!=1))
               {
                    $returnflag=false;
               }
               elseif( ($user_type==1) && ($status!=1) )
               {
                    $returnflag=false;
               }
               
          }else
          {
                  $returnflag=false;
          } 
            
          return $returnflag;  
       
    }
}

?>