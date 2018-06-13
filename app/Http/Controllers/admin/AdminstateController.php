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



class AdminstateController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */
    public function index(Request $request )
    {
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
            
            $states_db = DB::table('location_state as ls');
            $states_db=$states_db->join('location_country as lc', 'ls.country_id', '=', 'lc.id'); //inner join
            $states_db=$states_db->select(DB::raw('ls.id,ls.country_id,ls.state_name,ls.state_3_code,ls.state_2_code,ls.lat,ls.lng,ls.published,lc.country_name'));
            if(!empty($srch1))
            {
               $states_db=$states_db->where('ls.state_name', 'like', "%".$srch1."%");
               $states_db=$states_db->orwhere('lc.country_name', 'like', "%".$srch1."%");
            }
            
            
            if(!empty($sort1) && !empty($sorttype1) && (in_array(strtoupper($sorttype1),array('ASC','DESC'))))
            {
                  if($sort1 == 'state_name'){
                        $states_db=$states_db->orderBy('ls.'.$sort1, $sorttype1);
                  }else if($sort1 == 'country_name'){
                        $states_db=$states_db->orderBy('lc.'.$sort1, $sorttype1);
                  }
                  
            }
            
            
            $pagi_state=$states_db;
            
            
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
            
           $pagi_state = $pagi_state->paginate($pagelimit);

           $pagi_state->setPath(url(ADMINSEPARATOR.'/state'));
           
            /*  echo $pagi_country->count();
            echo  $pagi_country->perPage();
            echo  $pagi_country->total();           
            echo "pagi=><pre>";
            print_r($pagi_country);
            echo "</pre>"; exit(); */
          
            $data['pagi_state']=$pagi_state;
            $data['useinPagiAr']=$useinPagiAr;
            //***** pagination code ends
            
          
          return view('admin.state.statelist', $data);
    }
    
    public function addstate(Request $request,$id=0)
    {
          $data=array();
          $data['data1']="hello";
          
         
          
          if(!empty($id))
          {
            //**** fetch data starts
            
            $staterow = DB::table('location_state as ls')->where('ls.id', $id)->first();
            
            if(!$staterow)
            {
              return redirect(ADMINSEPARATOR.'/state');
            }
            /*echo "<pre>";           
            print_r($staterow);
            echo "</pre>"; exit();*/
            $data['staterow']=$staterow;
            //**** fetch data ends
            
          }
        
        //******** fetch country data for drop down starts
        
        $country_db = DB::table('location_country as lc');
        $country_db=$country_db->select(DB::raw('lc.id,lc.country_name,lc.published'));
        $country_db=$country_db->where('lc.published', '=', 1);
        $country_db=$country_db->orderBy('lc.country_name', 'asc');
        $country_db= $country_db->get();
        
        //echo "<pre>"; print_r($country_db); exit();
        $countryidAr=array();
        $countryidAr['']="Select a country";
        if(!empty($country_db))
        {
                foreach($country_db as $country_obj)
                {
                        $countryidAr[$country_obj->id]=stripslashes($country_obj->country_name);
                }
                
        }
        
        $data['countryidAr']=$countryidAr;
        
        //******** fetch country data for drop down starts 
          
          return view('admin.state.stateadd', $data);
    }
    
    
    public function savestate(Request $request)
    {
            
            $country_id = addslashes(trim($request->input('country_id','')));
            $state_name = addslashes(trim($request->input('state_name','')));
            $state_3_code = addslashes(strtoupper(trim($request->input('state_3_code',''))));
            $lat = addslashes(trim($request->input('lat','')));
            $lng = addslashes(trim($request->input('lng','')));
            
            $id = addslashes(trim($request->input('stateid',0)));
            
             
            
            $dataInsert=array();
            $dataInsert['country_id']=$country_id;
            $dataInsert['state_name']=$state_name;
            $dataInsert['state_3_code']=$state_3_code;
            $dataInsert['lat']=$lat;
            $dataInsert['lng']=$lng;
            
            
            
            //var_dump($chkvalid); exit();
           // echo "i=>>".$id; exit();
            $chkvalid=$this->checkstateform($request,$id,$country_id);
            
           if($chkvalid===true)
           {
                  if(empty($id))
                  {
                        
                        
                        //*** insert  query
                        $isInserted = DB::table('location_state')->insert($dataInsert);
                        
                        /*Last Insert id*/
                        $isInserted=DB::getPdo()->lastInsertId();
                        // echo "====>".$last_insert_id;
                  
                  }
                  else
                  {
                       
                        //*** update query
                        
                        //echo "<pre>"; print_r($dataInsert); echo $id; exit();
                        
                        $isInserted=DB::table('location_state')
                        ->where('id', $id)
                        ->update($dataInsert);
      
                  }
                  
                 
                  if($isInserted >= 0 )
                  {
                  
                         $request->session()->flash('admin_successmsgdata_sess', 'State data successfully saved.');
                         return redirect(ADMINSEPARATOR.'/state');
                  
                  }
           }
           else
           {
                  if(!empty($id))
                        {
                              
                              return redirect(ADMINSEPARATOR.'/stateadd/'.$id)
                              ->withErrors($chkvalid)
                              ->withInput();
                        }
                        else
                        {
                              return redirect(ADMINSEPARATOR.'/stateadd')
                              ->withErrors($chkvalid)
                              ->withInput();
                        }
           }
           
           return redirect(ADMINSEPARATOR.'/state');
                  
      
    }
     
    public function checkstateform($request,$id=0,$country_id=0)
           {
                  //regex:^[a-zA-Z]+$
                       
               
                    $validator = Validator::make($request->all(), [
                    'country_id' => "required",    
                    'state_name' => "required|alpha_spaces|max:100|unique:location_state,state_name,".$id.",id,country_id,".$country_id,
                    'state_3_code' =>"required|regex:(^[a-zA-Z]+$)|max:3|unique:location_state,state_3_code,".$id.",id,country_id,".$country_id,
                    'lat' => "required|numeric",
                     'lng' => "required|numeric",
                    
                    ],[
                       'country_id.required'=>'*Country field required', 
                       'state_name.required'=>'*State name field required',
                       'state_name.alpha_spaces'=>'*state name can only contain letters and spaces',
 
                       'state_3_code.required'=>'*State 3 letter code field required',
                       'state_3_code.regex'=>'*State 3 letter code field can only contain letters and no-spaces',
                       'state_3_code.max'=>'*Maximum 3 letter',
                       'lat.required'=>'*Latitude field required',
                       'lng.required'=>'*Longitude field required',
                       'lat.numeric'=>'*Latitude field should be numeric',
                       'lng.numeric'=>'*Longitude field should be numeric'
                       
                       
                       ]);
                    
                  // echo "validator==>"; var_dump($validator->fails()); echo "</pre>"; exit();
                   
                   // echo "----id==>".$id."here"; exit();
                    if ($validator->fails())
                    {
                        return $validator;
                       
                    }
                    
                    
                  return true;
                    
        
           } 
           
        public function statuschangestate(Request $request)
       {
           //$country_name = $request->input('country_name','');
           
          $statuschange = $request->input('statuschange',0);
          $stateid =    $request->input('stateid',0);
          
          $respAr=array();
          $flagdata=0;
          
          
          if(!empty($stateid) && ($stateid>0) && in_array($statuschange,array(0,1)))
          {
            
            
                  //*** update status starts
                  $dataUpdate=array();
                  $dataUpdate['published']=$statuschange;
                  
                  $updstaus=DB::table('location_state')
                        ->where('id', $stateid)
                        ->update($dataUpdate);
                        
                        if(!empty($updstaus))
                        {
                               $flagdata=1;
                        }
                  
                  //*** update status ends
          }
          
          $respAr['flag']=$flagdata;
          $respAr['iddata']=$stateid;
          
          echo  json_encode($respAr);
       }
       
        public function delstate(Request $request,$id=0)
       {
        $chkdelstate = '';
        $ar='';
           if(empty($id))
           {
             return redirect(ADMINSEPARATOR.'/state');
           }
           
           // $i = strlen($id);
           // if($i=='1'){
           //      //echo $id;
           //      $ar=DB::table('location_state')->where('id', '=', $id)->delete();
           // }

           //else if($i>1){
                
                $id_arry = explode(",",$id);
                foreach ($id_arry as $value) {

                  $chkdelstate = $this->deletecheck($value);
                        //echo $value;
                  if($chkdelstate !=1)
                  {
                     $ar=DB::table('location_state')->where('id', '=', $value)->delete();
                  }
                }
           //}

           
           if($ar>0 && $chkdelstate !=1)
           {
                 $request->session()->flash('admin_successmsgdata_sess', 'State data deleted successfully.');  
           }else if($ar>0 && $chkdelstate ==1)
           {
               $request->session()->flash('admin_successmsgdata_sess', 'State data deleted successfully.But some data can not be deleted');  
           }else if($ar=='' && $chkdelstate ==1)
           {
              $request->session()->flash('admin_errormsgdata_sess', 'State data can not be deleted');  
           }

           return redirect(ADMINSEPARATOR.'/state');
       }

        public function deletecheck($id)
           {
            $deletecheckstatususr =  DB::table('user_master')->where('state',$id)->first();
            $deletecheckstatusgrp =  DB::table('group_master')->where('state',$id)->first();
            $deletecheckstatusvenue =  DB::table('venue_master')->where('state',$id)->first();
            if( (count($deletecheckstatususr) > 0) || (count($deletecheckstatusgrp) > 0) || (count($deletecheckstatusvenue) >0) )
              {
                return 1;
              }


           }
       
           
           
           
}