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



class AdmincountryController extends Controller
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
            
            $countries_db = DB::table('location_country as lc');
            $countries_db=$countries_db->select(DB::raw('lc.id,lc.country_name,lc.country_3_code,lc.country_2_code,lc.lat,lc.lng,lc.published'));
            if(!empty($srch1))
            {
               $countries_db=$countries_db->where('lc.country_name', 'like', "%".$srch1."%");   
            }
            
            
            if(!empty($sort1) && !empty($sorttype1) && (in_array(strtoupper($sorttype1),array('ASC','DESC'))))
            {
                  
                  $countries_db=$countries_db->orderBy('lc.'.$sort1, $sorttype1);
            }
            
            
            $pagi_country=$countries_db;
            
            
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
            
           $pagi_country = $pagi_country->paginate($pagelimit);

           $pagi_country->setPath(url(ADMINSEPARATOR.'/country'));
           
            /*  echo $pagi_country->count();
            echo  $pagi_country->perPage();
            echo  $pagi_country->total();           
            echo "pagi=><pre>";
            print_r($pagi_country);
            echo "</pre>"; exit(); */
          
            $data['pagi_country']=$pagi_country;
            $data['useinPagiAr']=$useinPagiAr;
            //***** pagination code ends
            
          
          return view('admin.country.countrylist', $data);
    }
    
    public function addcountry(Request $request,$id=0)
    {
          $data=array();
          $data['data1']="hello";
          
         
          
          if(!empty($id))
          {
            //**** fetch data starts
            
            $countryrow = DB::table('location_country as lc')->where('lc.id', $id)->first();
            
            if(!$countryrow)
            {
              return redirect(ADMINSEPARATOR.'/country');
            }

            $data['countryrow']=$countryrow;
            //**** fetch data ends
            
          }
          
          
          
          return view('admin.country.countryadd', $data);
    }
    
    
    public function savecountry(Request $request)
    {
            
            
            $country_name = addslashes(trim($request->input('country_name','')));
            $country_2_code =addslashes(strtoupper(trim( $request->input('country_2_code',''))));
            $country_3_code = addslashes(strtoupper(trim($request->input('country_3_code',''))));
            $lat = addslashes(trim($request->input('lat','')));
            $lng = addslashes(trim($request->input('lng','')));
$c_code = addslashes(trim($request->input('c_code','')));
$c_icon = addslashes(trim($request->input('c_icon','')));
            
            $id = addslashes(trim($request->input('countryid',0)));
            
             
            
            $dataInsert=array();
            $dataInsert['country_name']=$country_name;
            $dataInsert['country_2_code']=$country_2_code;
            $dataInsert['country_3_code']=$country_3_code;
            $dataInsert['lat']=$lat;
            $dataInsert['lng']=$lng;
            $dataInsert['currency_icon']=$c_icon;
            $dataInsert['currency_code']=$c_code;
            
            //var_dump($chkvalid); exit();
           // echo "i=>>".$id; exit();
            $chkvalid=$this->checkcountryform($request,$id);
            
           if($chkvalid===true)
           {
                  if(empty($id))
                  {
                        
                        
                        //*** insert  query
                        $isInserted = DB::table('location_country')->insert($dataInsert);
                        
                        /*Last Insert id*/
                        $isInserted=DB::getPdo()->lastInsertId();
                        // echo "====>".$last_insert_id;
                  
                  }
                  else
                  {
                       
                        //*** update query
                        
                        //echo "<pre>"; print_r($dataInsert); echo $id; exit();
                        
                        $isInserted=DB::table('location_country')
                        ->where('id', $id)
                        ->update($dataInsert);
      
                  }
                  
                 
                  if($isInserted >= 0 )
                  {
                  
                         $request->session()->flash('admin_successmsgdata_sess', 'Country Successfully saved.');
                         return redirect(ADMINSEPARATOR.'/country');
                  
                  }
           }
           else
           {
                  if(!empty($id))
                        {
                              
                              return redirect(ADMINSEPARATOR.'/countryadd/'.$id)
                              ->withErrors($chkvalid)
                              ->withInput();
                        }
                        else
                        {
                              return redirect(ADMINSEPARATOR.'/countryadd')
                              ->withErrors($chkvalid)
                              ->withInput();
                        }
           }
           
           return redirect(ADMINSEPARATOR.'/country');
                  
      
    }
     
    public function checkcountryform($request,$id=0)
           {
                  
               
                    $validator = Validator::make($request->all(), [
                    'country_name' => "required|alpha_spaces|max:100|countrynameunique:".$id,
                    'country_2_code' => "required|regex:(^[a-zA-Z]+$)|min:2|max:2|country2codeunique:".$id,
                    'country_3_code' => "required|regex:(^[a-zA-Z]+$)|min:3|max:3|country3codeunique:".$id,
                    'lat' => "required|numeric",
                     'lng' => "required|numeric",
                     'c_icon' => "required",
                     'c_code' => "required",
                    ],['country_name.required'=>'*Country name field required',
                       'country_name.alpha_spaces'=>'*country name can only contain letters and spaces',
                       'country_name.countrynameunique'=>'*Country name should be unique',
                       'country_2_code.required'=>'*Country 2 letter code field required',
                       'country_2_code.regex'=>'*Country 2 letter code field can only contain letters and no-spaces',
                       'country_2_code.country2codeunique'=>'*Country 2 letter code should be unique',
                       'country_3_code.required'=>'*Country 3 letter code field required',
                       'country_3_code.regex'=>'*Country 3 letter code field can only contain letters and no-spaces',
                       'country_3_code.country3codeunique'=>'*Country 3 letter code should be unique',
                       'country_2_code.min'=>'*Minimum 2 letter ',
                       'country_2_code.max'=>'*Maximum 2 letter ',
                       'country_3_code.min'=>'*Minimum 3 letter ',
                        'country_3_code.max'=>'*Maximum 3 letter',
                       'lat.required'=>'*Latitude field required',
                       'lng.required'=>'*Longitude field required',
                       'lat.numeric'=>'*Latitude field should be  numeric',
                       'lng.numeric'=>'*Longitude field should be numeric',
                       'c_icon.required'=>'*Currency Icon field required',
                       'c_code.required'=>'*Currency Code field required',
                       
                       ]);
                    
                  // echo "validator==>"; var_dump($validator->fails()); echo "</pre>"; exit();
                   
                   // echo "----id==>".$id."here"; exit();
                    if ($validator->fails())
                    {
                        return $validator;
                       
                    }
                    
                    
                  return true;
                    
        
           } 
           
        public function statuschangecountry(Request $request)
       {
           //$country_name = $request->input('country_name','');
           
          $statuschange = $request->input('statuschange',0);
          $countryid =    $request->input('countryid',0);
          
          $respAr=array();
          $flagdata=0;
          
          
          if(!empty($countryid) && ($countryid>0) && in_array($statuschange,array(0,1)))
          {
            
            
                  //*** update status starts
                  $dataUpdate=array();
                  $dataUpdate['published']=$statuschange;
                  
                  $updstaus=DB::table('location_country')
                        ->where('id', $countryid)
                        ->update($dataUpdate);
                        
                        if(!empty($updstaus))
                        {
                               $flagdata=1;
                        }
                  
                  //*** update status ends
          }
          
          $respAr['flag']=$flagdata;
          $respAr['iddata']=$countryid;
          
          echo  json_encode($respAr);
       }
       
        public function delcountry(Request $request,$id=0)
       {
           if(empty($id))
           {
             return redirect(ADMINSEPARATOR.'/country');
           }
           
           $i = strlen($id);
           if($i=='1'){
                //echo "-->".$id;
                $ar=DB::table('location_country')->where('id', '=', $id)->delete();
                $at=DB::table('location_state')->where('country_id', '=', $id)->delete();
           }else if($i>1){
                
                $id_arry = explode(",",$id);
                foreach ($id_arry as $value) {
                    //echo " ->".$value;
                    $ar=DB::table('location_country')->where('id', '=', $value)->delete();
                    $at=DB::table('location_state')->where('country_id', '=', $value)->delete();
                }
           }

           
           if($ar>0 && $at>0)
           {
                 $request->session()->flash('admin_successmsgdata_sess', 'Country and corresponding states are delete successfully.');  
           }

           return redirect(ADMINSEPARATOR.'/country');
       }
       
           
           
           
}