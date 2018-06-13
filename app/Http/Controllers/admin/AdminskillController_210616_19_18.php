<?php


namespace App\Http\Controllers\admin;

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

//use App\User
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use DB;
use Illuminate\Routing\Route;



class AdminskillController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */
    public function index(Request $request )
    {
     // echo "I am inside skill management";exit();
            $data=array();
            $useinPagiAr=array();
           
            $srch1=addslashes(trim($request->input('srch1','')));
            $sort1=addslashes(trim($request->input('sort1','')));
            $sorttype1=addslashes(trim($request->input('sorttype1','')));
            
            if(!empty($srch1))
            {
                $useinPagiAr['srch1']=trim($srch1);  
            }
            
            if(!empty($sort1))
            {
                $useinPagiAr['sort1']=trim($sort1);  
            }
            
            if(!empty($sorttype1))
            {
                $useinPagiAr['sorttype1']=trim($sorttype1);  
            }
            
            
            $successmsgdata=$request->session()->get('admin_successmsgdata_sess');
            $errormsgdata=$request->session()->get('admin_errormsgdata_sess');
            
            
            if(!empty($successmsgdata)){
              $data['successmsgdata']=$successmsgdata;
            }
            if(!empty($errormsgdata)){
                  $data['errormsgdata']=$errormsgdata;               
            }
            
            
           
            //**** fetch data starts
            
            $skills_db = DB::table('skill_master as ls');
            $skills_db=$skills_db->leftJoin('skill_master as ls2', 'ls2.id', '=', 'ls.parent_id'); //inner join
            //$skills_db=$skills_db->join('usertype as lu', 'ls.catag_type', '=', 'lu.id'); //inner join
            $skills_db=$skills_db->select(DB::raw('ls.id,IF(ls.parent_id=0,"---",ls2.name) as parent_id,ls.name,ls.status,ls.catag_type'));
           // $skills_db=$skills_db->select(DB::raw('ls.id,(CASE WHEN ls.parent_id = 0 THEN true ELSE ls.parent_id END) AS is_user,ls.name,ls.status,lu.typename'));

            if(!empty($srch1))
            {
               $skills_db=$skills_db->where('ls.name', 'like', "%".$srch1."%");   
            }
            
            
            if(!empty($sort1) && !empty($sorttype1) && (in_array(strtoupper($sorttype1),array('ASC','DESC'))))
            {
                  
                  $skills_db=$skills_db->orderBy('ls.'.$sort1, $sorttype1);
            }
            else
            {
                // $skills_db=$skills_db->orderBy('ls.name', 'asc');
                 $skills_db=$skills_db->orderBy('ls.parent_id', 'asc');
                 
            }
            
            
            
            
            $pagi_skill=$skills_db;
            
            
            //**** fetch data ends
            
            
            //***** fetch data from settings table starts            
            $pagelimit=1;
            $staterow = DB::table('settings as st')->select(DB::raw('st.id,st.record_per_page_admin'))->where('st.id', 1)->first();            
            
            if(!empty($staterow))
            {
                $pagelimit=$staterow->record_per_page_admin;
            }
            //***** fetch data from settings table ends
            
            
            
           //***** pagination code starts
            
           $pagi_skill = $pagi_skill->paginate($pagelimit);

           $pagi_skill->setPath(url(ADMINSEPARATOR.'/skill'));
           
            /*  echo $pagi_country->count();
            echo  $pagi_country->perPage();
            echo  $pagi_country->total();           
            echo "pagi=><pre>";
            print_r($pagi_country);
            echo "</pre>"; exit(); */
          
            $data['pagi_skill']=$pagi_skill;
            $data['useinPagiAr']=$useinPagiAr;
            //***** pagination code ends
            
          
          return view('admin.skill.skilllist', $data);
    }
    
    public function addskill(Request $request,$id=0)
    {

        $requestpost_sess=$request->session()->get('requestpost_sess'); // if error has happened
        
        
        
        $usertype='';
        
        if(!empty($requestpost_sess) && array_key_exists("catag_type",$requestpost_sess))
        {
                  $usertype = $requestpost_sess['catag_type'];  // used when validation throws error           
        }
        
        
         $data=array();
         $data['data1']="hello";
          
         $uesrskilltypeidAr=array();$skill_masterAr=array();
         $uesrskilltypeidAr['']="Select skill";
          if(!empty($id))
          {
                     //**** fetch data starts
            
                    $skill_masterAr = DB::table('skill_master as ls')->where('ls.id', $id)->first();
                    $usertype = $skill_masterAr->catag_type;
          }
            
            
            
            //**** fetch data ends

            //******** fetch parent skill data for drop down starts
        
            $userskilltype_db = DB::table('skill_master as sct');
            $userskilltype_db=$userskilltype_db->select(DB::raw('sct.id,sct.name'));
            //$userskilltype_db=$userskilltype_db->where('sct.catag_type', $usertype);
            $userskilltype_db=$userskilltype_db->where('sct.parent_id',0);
            $userskilltype_db= $userskilltype_db->get();
            
            // echo "<pre>"; print_r($userskilltype_db); exit();
            
            $uesrskilltypeidAr['']="Select skill";
            if(!empty($userskilltype_db))
            {
                    foreach($userskilltype_db as $userskilltype_obj)
                    {
                            $uesrskilltypeidAr[$userskilltype_obj->id]=stripslashes($userskilltype_obj->name);
                    }
                    
            }
            
            
            // echo "<pre>";
            // print_r($data);exit();
        
          //******** fetch parent skill data for drop down ends 

        
        $data['uesrskilltypeidAr']=$uesrskilltypeidAr;
        $data['skillrow']=$skill_masterAr;

        //******** fetch user type data for drop down starts
        
        $usertype_db = DB::table('usertype as utypec');
        $usertype_db=$usertype_db->select(DB::raw('utypec.id,utypec.typename'));
        $usertype_db=$usertype_db->orderBy('utypec.id', 'asc');
        $usertype_db= $usertype_db->get();
        
        // echo "<pre>"; print_r($usertype_db); exit();
        $uesrtypeidAr=array();
        //$uesrtypeidAr['']=ucwords("Select user");
        if(!empty($usertype_db))
        {
                foreach($usertype_db as $usertype_obj)
                {
                        $uesrtypeidAr[$usertype_obj->id]=ucwords(stripslashes($usertype_obj->typename));
                }
                
        }
        
        $data['uesrtypeidAr']=$uesrtypeidAr;
        
        //******** fetch user type data for drop down ends 

        
          
          return view('admin.skill.skilladd', $data);
    }
    
    
    public function saveskill(Request $request)
    {
            //********getting skill value
            $parntsklname = '';
            $skill_user_type = $request->input('catag_type','');
            //echo "<pre>"; print_r($skill_user_type); die;
            $catag_type='';
            if(!empty($skill_user_type))
            {
                $catag_type=implode(",",$skill_user_type);
            }

            $parent_id = addslashes(trim($request->input('parent_id','0')));
            $name =addslashes(strtoupper(trim( $request->input('name',''))));
         
            $id = addslashes(trim($request->input('skillid',0)));
            $datedata=date("Y-m-d H:i:s");

            if (!$request->has('parent_id')) { $parent_id=0;}
            
            $dataInsert=array();
            $dataUpdtseo=array();
            
            $dataInsert['name']=$name;
             $dataInsert['modified_date']=$datedata;
            
            $skillrow = DB::table('skill_master as skm')->select(DB::raw('skm.name'))->where('skm.id', $parent_id)->first(); 
            if(!empty($skillrow)){
            $parntsklname = $skillrow->name;
          }
            // echo "<pre>";
            // print_r($skillrow);exit();
           
           // $chkvalid=$this->checkskillsform($request,$id,$parntsklname);
            $chkvalid=$this->checkskillsform2nd($request,$id,$parntsklname);
           
           // 
           if($chkvalid===true)
           {
                  if(empty($id))
                  {
                        $dataInsert['catag_type']=$catag_type;
                        $dataInsert['parent_id']=$parent_id;
                        $dataInsert['create_date']=$datedata;
                        
                        //*** insert  query
                        $isInserted = DB::table('skill_master')->insert($dataInsert);
                        
                        /*Last Insert id*/
                        $isInserted=DB::getPdo()->lastInsertId();

                        //*******seo name starts here
                        $seoname_val = $this->gtseoname($isInserted,$name);

                        $dataUpdtseo['seo_name']=$seoname_val; //********updating starts here
                         $isUpdatedseo=DB::table('skill_master')
                        ->where('id', $isInserted)
                        ->update($dataUpdtseo);
                        //*******seo name ends here

                        //***** echo "====>".$last_insert_id;*/
                  
                  }
                  else
                  {
                       
                        //*** update query
                        
                        //echo "<pre>"; print_r($dataInsert); echo $id; exit();
                          
                         //*******seo name starts here
                        $seoname_val = $this->gtseoname($id,$name);
                  
                        $dataInsert['seo_name']=$seoname_val; //********updating starts here
                        //*******seo name ends here
                  
                        $isInserted=DB::table('skill_master')
                        ->where('id', $id)
                        ->update($dataInsert);
                  
                  
                  
                  
                  }
                  
                 
                  if($isInserted >= 0 )
                  {
                  
                         $request->session()->flash('admin_successmsgdata_sess', 'Skill Successfully saved.');
                         return redirect(ADMINSEPARATOR.'/skill');
                  
                  }
           }
           else
           {
           
                    $request->session()->flash('requestpost_sess',$_REQUEST);
                    
                  if(!empty($id))
                        {
                             
           
                              return redirect(ADMINSEPARATOR.'/skilladd/'.$id)
                              ->withErrors($chkvalid)
                              ->withInput();
                        }
                        else
                        {
                            
                            
                              return redirect(ADMINSEPARATOR.'/skilladd')
                              ->withErrors($chkvalid)
                              ->withInput();
                        }
           }
           
           return redirect(ADMINSEPARATOR.'/skill');
                  
      
    }
     
    public function checkskillsform($request,$id=0,$parntsklname)
           {
                   
                    $skill_user_type = $request->input('catag_type','');
                    $catag_type=implode("=",$skill_user_type);
                    $parent_id = addslashes(trim($request->input('parent_id','0')));
                    $name =addslashes(strtoupper(trim( $request->input('name',''))));

                    if (!$request->has('parent_id')) { $parent_id=0;}

                    /*
                    
                    $validAr=array();                    
                    $validAr['catag_type']="required";
                    $validAr['name'] ="required|alpha_spaces|skillunq_name:".$id.",".$parent_id.",".$parntsklname.",".$catag_type."|unique:skill_master,name,".$id.",id,catag_type,".$catag_type.",parent_id,".$parent_id;

                    $validMessgAr=array();
                    $validMessgAr["catag_type.required"]='*User field required';
                    $validMessgAr["name.required"]="*Skill name field required";
                    $validMessgAr["name.skillunq_name"]="*This skill name already exists for its parent";
                    $validMessgAr["name.alpha_spaces"]="*This skill name only contain letters and spaces";
                    
                    

                    $validator = Validator::make($request->all(),$validAr,$validMessgAr);
                    */
                    
                     $validator = Validator::make($request->all(), [
                    'catag_type' => "required",    
                    'name' => "required|alpha_spaces|skillunq_name:".$id.",".$parent_id.",".$parntsklname.",".$catag_type."|unique:skill_master,name,".$id.",id,catag_type,".$catag_type.",parent_id,".$parent_id
                   
                    
                    ],[
                       'catag_type.required'=>'*User field required', 
                       'name.required'=>'*Skill name field required',
                       
                       'name.skillunq_name'=>'*This skill name already exists for its parent',
                      
                       'name.alpha_spaces'=>'*This skill name only contain letters and spaces',
                      
                       
                       
                       
                       ]);
                    
                    
                  // echo "validator==>"; var_dump($validator->fails()); echo "</pre>"; exit();
                   
                   // echo "----id==>".$id."here"; exit();
                    if ($validator->fails())
                    {
                        return $validator;
                       
                    }
                    
                    
                  return true;
                    
        
           }
           
            public function checkskillsform2nd($request,$id=0,$parntsklname)
            {
                $validator = Validator::make($request->all(), [
                        
                    'name' => "required|alpha_spaces|unique:skill_master,name,".$id,
                ],[
                     
                    'name.required'=>'*Skill name field required',
                    'name.alpha_spaces'=>'*This skill name only contain letters and spaces',
                    'name.unique'=>'*This name already exists',
                ]);
                
                if(empty($id))
                {
                    $userData=array();
                    $userData['request']=$request;
                    $validator->after(function($validator)  use ($userData)  {         
                        $request=$userData['request'];
                        //***** here
                        $validatefilechk=$this->checkUtypeofSkill($request);
                        if (!empty($validatefilechk))
                        {
                            $validator->errors()->add('catag_type', $validatefilechk);
                        }
                        //***** here
                    });
                }
                
                if ($validator->fails())
                {
                    return $validator;
                }
                    
                return true;
            }
           
           
        public function checkUtypeofSkill($request)
        {
            $catag_type=$request->input('catag_type');
            if(empty($catag_type))
            {
                $errorMsg[]="*User type field is required ";
            }
            $errorMsgStr='';
            if(!empty($errorMsg))
            {
               
               foreach($errorMsg as $errorMsgData)
               {
                 $errorMsgStr.=$errorMsgData;
               }
            }
            $responseAr=array();
            $responseAr['errormsgs']=$errorMsgStr; 
            return $errorMsgStr;
        }
           
           
        public function statuschangeskill(Request $request)
       {
           //$country_name = $request->input('country_name','');
           
          $statuschange = $request->input('statuschange',0);
          $skillid =    $request->input('skillid',0);
          
          $respAr=array();
          $flagdata=0;

          
          if(!empty($skillid) && ($skillid>0) && in_array($statuschange,array(0,1)))
          {
              
              //*** check any child is present under  this skill starts


              $skill_master = DB::table('skill_master');
              $skill_master=$skill_master->where('parent_id', '=', $skillid);


              $skill_master=$skill_master->get();
              $tot2=count($skill_master);

              if($tot2>0)
              {

                  foreach($skill_master as $skill_masterobj)
                  {
                      $flagdata=0;
                      
                      //*** update status starts
                      $dataUpdate=array();
                      $dataUpdate['status']=$statuschange;
                      
                      $updstaus=DB::table('skill_master')
                            ->where('id', $skill_masterobj->id)
                            ->update($dataUpdate);
                            
                            if(!empty($updstaus))
                            {
                                   $flagdata=1;

                                   $respAr[]=array('flag'=>$flagdata,'iddata'=>$skill_masterobj->id);


                            }
                  
                      //*** update status ends
                  }

              }

              //*** check any child is present under  this skill ends

              $flagdata=0;
              //*** update status starts
                  $dataUpdate=array();
                  $dataUpdate['status']=$statuschange;
                  
                  $updstaus=DB::table('skill_master')
                        ->where('id', $skillid)
                        ->update($dataUpdate);
                        
                        if(!empty($updstaus))
                        {
                               $flagdata=1;
                        }
                  
               //*** update status ends
            
            
                  
          }
          
          $respAr[]=array('flag'=>$flagdata,'iddata'=>$skillid);
          
          echo  json_encode($respAr);
       }
       
        public function delskill(Request $request,$id=0)
       {
           if(empty($id))
           {
             return redirect(ADMINSEPARATOR.'/skill');
           }
           
           $flag1=1;
           $flag2=1;
           
           //*** check any user uses this skill starts
           
           
           $user_skill_rel = DB::table('user_skill_rel');
           $user_skill_rel=$user_skill_rel->where('skill_id', '=', $id);
           
          
            $user_skill_rel=$user_skill_rel->get();
            $tot=count($user_skill_rel);
            
            if($tot>0)
            {
                $flag1=0;
               
            }
           
            //*** check any user uses this skill ends
            
            
             //*** check any child is present under  this skill starts
           
           
           $skill_master = DB::table('skill_master');
           $skill_master=$skill_master->where('parent_id', '=', $id);
           
          
            $skill_master=$skill_master->get();
            $tot2=count($skill_master);
            
            if($tot2>0)
            {
                $flag2=0;
               
            }
           
             //*** check any child is present under  this skill ends
           
           
          
           
           
          if(!empty($flag1) && !empty($flag2))
          {
             $ar=DB::table('skill_master')->where('id', '=', $id)->delete();
           
            if($ar>0)
            {
                  $request->session()->flash('admin_successmsgdata_sess', 'Skill data delete successfully.');  
            }
          }
          else
          {
            $request->session()->flash('admin_errormsgdata_sess', 'Skill data cannot be  deleted.'); 
          }

           return redirect(ADMINSEPARATOR.'/skill');
       }
       

        public function commonchangeskill(Request $request)
       {
           //$country_name = $request->input('country_name','');
           
          
          $skillid = $request->input('userid');
          //echo $skillid;
          
          $respAr=array();
          $flagdata=0;
          
          
          if(!empty($skillid) && ($skillid>0))
          {
           $skilltype_db = DB::table('skill_master as sct');
           $skilltype_db=$skilltype_db->select(DB::raw('sct.id,sct.name'));
           $skilltype_db=$skilltype_db->where('sct.catag_type',$skillid);
           $skilltype_db=$skilltype_db->where('sct.parent_id',0);
           $skilltype_db= $skilltype_db->get();


          }
            $skilltypeidAr=array();
           
            if(!empty($skilltype_db))
            {
                    foreach($skilltype_db as $skilltype_obj)
                    {
                            $skilltypeidAr[]=array('id'=>$skilltype_obj->id,'name'=>stripslashes($skilltype_obj->name));
                    }
                    
            }
        
          $respAr=$skilltypeidAr;
          
          // $respAr['flag']=$flagdata;
          // $respAr['iddata']=$skillid;
          //$respAr['skillid']=$users;
          
          
          echo  json_encode($respAr);
       }
           
           
        public function usertypechangebyskill(Request $request)
        {
            $parentskillid = $request->input('parent_skill_id');
            if(!empty($parentskillid) && ($parentskillid>0))
            {
                $skilltype_db = DB::table('skill_master as sct');
                $skilltype_db=$skilltype_db->select(DB::raw('sct.id,sct.name,sct.catag_type'));
                $skilltype_db=$skilltype_db->where('sct.id',$parentskillid);
                $skilltype_db=$skilltype_db->where('sct.parent_id',0);
                $skilltype_db= $skilltype_db->get();
            }
            $manytype=$skilltype_db[0]->catag_type;
            if(!empty($manytype))
            {
                $manytype_exp=explode(",",$manytype);
            }
            $uesrtypeidAr=array();
            if(!empty($manytype_exp))
            {
                //echo "<pre>";print_r($manytype_exp);echo "</pre>";
                foreach($manytype_exp as $manytype_obj)
                {
                    $usertype_db = DB::table('usertype as utypec');
                    $usertype_db=$usertype_db->select(DB::raw('utypec.id,utypec.typename'));
                    $usertype_db=$usertype_db->where('utypec.id',$manytype_obj);
                    $usertype_db= $usertype_db->get();
                    $d_id=$usertype_db[0]->id;
                    $d_name=ucwords(stripslashes($usertype_db[0]->typename));
                    $uesrtypeidAr[]=array("typeID"=>$d_id,"typeName"=>$d_name);                    
                }  
            }
            $respAr=array();
            $respAr=$uesrtypeidAr;
            echo json_encode($respAr);
        }
        
        
        public function usertypechangebysubskill(Request $request)
        {
            $childskillid = $request->input('child_skill_id');
            $skilltype_db='';
            if(!empty($childskillid) && ($childskillid>0))
            {
                $skilltype_db = DB::table('skill_master as sct');
                $skilltype_db=$skilltype_db->select(DB::raw('sct.id,sct.name,sct.catag_type'));
                $skilltype_db=$skilltype_db->where('sct.id',$childskillid);
                $skilltype_db=$skilltype_db->where('sct.parent_id','<>',0);
                $skilltype_db= $skilltype_db->get();
            }
            $manytype=$skilltype_db[0]->catag_type;
            if(!empty($manytype))
            {
                $manytype_exp=explode(",",$manytype);
            }
            $uesrtypeidAr=array();
            if(!empty($manytype_exp))
            {
                //echo "<pre>";print_r($manytype_exp);echo "</pre>";
                foreach($manytype_exp as $manytype_obj)
                {
                    $usertype_db = DB::table('usertype as utypec');
                    $usertype_db=$usertype_db->select(DB::raw('utypec.id,utypec.typename'));
                    $usertype_db=$usertype_db->where('utypec.id',$manytype_obj);
                    $usertype_db= $usertype_db->get();
                    $d_id=$usertype_db[0]->id;
                    $d_name=ucwords(stripslashes($usertype_db[0]->typename));
                    $uesrtypeidAr[]=array("typeID"=>$d_id,"typeName"=>$d_name);                    
                }  
            }
            $respAr=array();
            $respAr=$uesrtypeidAr;
            echo json_encode($respAr);
        }
           
           
           
         //********* function for seo name starts here
        public function gtseoname($id,$name)
        {
          $string = substr($name,0,50);
          //Lower case everything
          $string = strtolower($string);
          //Make alphanumeric (removes all other characters)
          $string = str_slug($string,'-');

          $bsix = $id;
          $bsix = base64_encode($bsix);
          $completeurl = $string.$bsix;
          return $completeurl;
        }

         //******** function for seo name ends here  
           
}