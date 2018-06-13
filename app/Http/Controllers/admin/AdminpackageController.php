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
//use Illuminate\Routing\Route;




class AdminpackageController extends Controller
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
            
            $package_db = DB::table('package as p');
            $package_db=$package_db->select(DB::raw('p.id,p.package_categ_id,p.package_type_id,p.package_price,p.package_expiry,p.status,p.create_date,ut.typename as package_categname,pt.type_name as package_typename '));
            $package_db=$package_db->join('package_type as pt', 'pt.id', '=', 'p.package_categ_id'); //inner join
             $package_db=$package_db->join('usertype as ut', 'ut.id', '=', 'p.package_type_id'); //inner join
           
            if(!empty($srch1))
            {
               $package_db=$package_db->where('p.package_price', 'like', "%".$srch1."%");   
            }
            
            
            if(!empty($sort1) && !empty($sorttype1) && (in_array(strtoupper($sorttype1),array('ASC','DESC'))))
            {
                  
                  $package_db=$package_db->orderBy('p.'.$sort1, $sorttype1);
            }
            
            
            $pagi_package=$package_db;
            
            
            //**** fetch data ends
            
           
            //***** fetch data from settings table starts            
            $pagelimit=1;
            $settingrow = DB::table('settings as st')->select(DB::raw('st.id,st.record_per_page_admin'))->where('st.id', 1)->first();            
            
            if(!empty($settingrow))
            {
                $pagelimit=$settingrow->record_per_page_admin;
            }
            //***** fetch data from settings table ends
            
           //***** pagination code starts
            
           $pagi_package = $pagi_package->paginate($pagelimit);

           $pagi_package->setPath(url(ADMINSEPARATOR.'/package'));
           
            /* echo $pagi_package->count();
            echo  $pagi_package->perPage();
            echo  $pagi_package->total();           
            echo "pagi=><pre>";
            print_r($pagi_package);
            echo "</pre>"; exit(); */
          
            $data['pagi_package']=$pagi_package;
            $data['useinPagiAr']=$useinPagiAr;
            //***** pagination code ends
            
          
          return view('admin.package.packagelist', $data);
    }
    
    public function addpackage(Request $request,$id=0)
    {
                $data=array();
                $data['data1']="hello";
          
                $package_categAr=array(); $package_typeAr=array();
                 
                 if(!empty($id))
                 {
                   //**** fetch data starts
                   
                   $packagerow = DB::table('package as p')->where('p.id', $id)->first();
                   
                   /*echo "<pre>";           
                   print_r($packagerow);
                   echo "</pre>"; exit();*/
                   $data['packagerow']=$packagerow;
                   //**** fetch data ends
                   
                 }
          
                //******** fetch user type data for drop down starts
        
                $usertype_db = DB::table('usertype as utypec');
                $usertype_db=$usertype_db->select(DB::raw('utypec.id,utypec.typename'));
                $usertype_db=$usertype_db->orderBy('utypec.id', 'asc');
                $usertype_db= $usertype_db->get();
                
                // echo "<pre>"; print_r($usertype_db); exit();
               
                $package_typeAr['']=ucwords("Select package type");
                if(!empty($usertype_db))
                {
                        foreach($usertype_db as $usertype_obj)
                        {
                                $package_typeAr[$usertype_obj->id]=ucwords(stripslashes($usertype_obj->typename));
                        }
                        
                }
                
                // echo "<pre>"; print_r($package_typeAr); exit();
                $data['package_typeAr']=$package_typeAr;
        
                //******** fetch user type data for drop down ends
                
                //******** fetch user package category type  data for drop down starts
        
                $pkgtype_db = DB::table('package_type as pt');
                $pkgtype_db=$pkgtype_db->select(DB::raw('pt.id,pt.type_name'));
                $pkgtype_db=$pkgtype_db->orderBy('pt.type_name', 'asc');
                $pkgtype_db= $pkgtype_db->get();
                
                // echo "<pre>"; print_r($pkgtype_db); exit();
               
                $package_categAr['']=ucwords("Select category type");
                if(!empty($pkgtype_db))
                {
                        foreach($pkgtype_db as $pkgtype_obj)
                        {
                                $package_categAr[$pkgtype_obj->id]=ucwords(stripslashes($pkgtype_obj->type_name));
                        }
                        
                }
                //echo "<pre>"; print_r($package_categAr); exit();
                
                $data['package_categAr']=$package_categAr;
        
                //******** fetch package category type data for drop down ends
          

          
          return view('admin.package.packageadd', $data);
    }
    
    
    public function savepackage(Request $request)
    {
            
            
            $package_categ_id = addslashes(trim($request->input('package_categ_id','')));
            $package_type_id =addslashes(strtoupper(trim( $request->input('package_type_id',''))));
            $package_price = addslashes(strtoupper(trim($request->input('package_price',''))));
            $package_expiry = addslashes(trim($request->input('package_expiry','')));
            $status = 1;
            $date_data=date("Y-m-d H:i:s");
            
            $id = addslashes(trim($request->input('packageid',0)));
            
             
            
            $dataInsert=array();
            
            $dataInsert['package_expiry']=$package_expiry;
            $dataInsert['status']=$status;
            $dataInsert['package_price']=$package_price;
            $dataInsert['modified_date']=$date_data;
            
            
            //var_dump($chkvalid); exit();
           // echo "i=>>".$id; exit();
            $chkvalid=$this->checkpackageform($request,$id);
            
           if($chkvalid===true)
           {
                  if(empty($id))
                  {
                        $dataInsert['package_categ_id']=$package_categ_id;
                        $dataInsert['package_type_id']=$package_type_id;
            
            
                        $dataInsert['create_date']=$date_data;
                        
                        //*** insert  query
                        $isInserted = DB::table('package')->insert($dataInsert);
                        
                        /*Last Insert id*/
                        $isInserted=DB::getPdo()->lastInsertId();
                        // echo "====>".$last_insert_id;
                  
                  }
                  else
                  {
                       
                        //*** update query
                        
                        //echo "<pre>"; print_r($dataInsert); echo $id; exit();
                        
                        $isInserted=DB::table('package')
                        ->where('id', $id)
                        ->update($dataInsert);
      
                  }
                  
                 
                  if($isInserted >= 0 )
                  {
                  
                         $request->session()->flash('admin_successmsgdata_sess', 'Package Successfully saved.');
                         return redirect(ADMINSEPARATOR.'/package');
                  
                  }
           }
           else
           {
                  if(!empty($id))
                        {
                              
                              return redirect(ADMINSEPARATOR.'/packageadd/'.$id)
                              ->withErrors($chkvalid)
                              ->withInput();
                        }
                        else
                        {
                              return redirect(ADMINSEPARATOR.'/packageadd')
                              ->withErrors($chkvalid)
                              ->withInput();
                        }
           }
           
           return redirect(ADMINSEPARATOR.'/package');
                  
      
    }
     
    public function checkpackageform($request,$id=0)
           {

                $package_categ_id = addslashes(trim($request->input('package_categ_id','')));
                $package_type_id =addslashes(strtoupper(trim( $request->input('package_type_id',''))));
               
                    $validator = Validator::make($request->all(), [
                    'package_categ_id' => "required",
                    'package_type_id' => "required",
                    'package_price' => "required|regex:/^([1-9][0-9]*)+(\.\d{1,2})?$/|unique:package,package_price,".$id.",id,package_categ_id,".$package_categ_id.",package_type_id,".$package_type_id,
                    'package_expiry' => "required|regex:/^([1-9][0-9]*)+(\.){0}$/",
                    
                    
                    ],['package_categ_id.required'=>'*Package category required',
                       'package_type_id.required'=>'*Package type required',
                       'package_price.required'=>'*Package price required',
                       'package_price.regex'=>'* Any Number greater than 0 should be provided',
                       'package_expiry.required'=>'*Package expiry span required',
                       'package_expiry.regex'=>'* Any Number greater than 0 without decimal should be provided',
                       
                       ]);
                    
                  // echo "validator==>"; var_dump($validator->fails()); echo "</pre>"; exit();
                   
                   // echo "----id==>".$id."here"; exit();
                    if ($validator->fails())
                    {
                        return $validator;
                       
                    }
                    
                    
                  return true;
                    
        
           } 
           
        public function statuschangepackage(Request $request)
       {
          
           
          $statuschange = $request->input('statuschange',0);
          $packageid =    $request->input('packageid',0);
          
          $respAr=array();
          $flagdata=0;
          
          
          if(!empty($packageid) && ($packageid>0) && in_array($statuschange,array(0,1)))
          {
            
            
                  //*** update status starts
                  $dataUpdate=array();
                  $dataUpdate['status']=$statuschange;
                  
                  $updstaus=DB::table('package')
                        ->where('id', $packageid)
                        ->update($dataUpdate);
                        
                        if(!empty($updstaus))
                        {
                               $flagdata=1;
                        }
                  
                  //*** update status ends
          }
          
          $respAr['flag']=$flagdata;
          $respAr['iddata']=$packageid;
          
          echo  json_encode($respAr);
       }
       
        public function delpackage(Request $request,$id=0)
       {
           if(empty($id))
           {
             return redirect(ADMINSEPARATOR.'/package');
           }
           
           
           $ar=DB::table('package')->where('id', '=', $id)->delete();
         
           
           if($ar>0)
           {
                 $request->session()->flash('admin_successmsgdata_sess', 'Package data delete successfully.');  
           }

           return redirect(ADMINSEPARATOR.'/package');
       }
       
           
           
           
}