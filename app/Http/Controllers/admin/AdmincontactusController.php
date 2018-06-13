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

class AdmincontactusController extends Controller
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
            
                $contactus_db = DB::table('contact_us as cu');
                $contactus_db=$contactus_db->join('contactus_category as cc', 'cu.contact_reason_id', '=', 'cc.id');
                $contactus_db=$contactus_db->select(DB::raw('cu.id,cu.contact_reason_id,
                    concat(cu.contact_first_name ," ", cu.contact_last_name) AS contactpersonname,cu.contact_email,cu.contact_message,cu.contact_date,cc.category_name,cu.contact_message,

                    IF(cu.contact_back_date="0000-00-00","---------------------",cu.contact_back_date) AS contactbackdate,
                    IF(cu.contact_back_flag="1", "Already replied", "not replied yet") AS replystatus
                    '));
                
                if(!empty($srch1))
                {

                        $contactus_db=$contactus_db->where('cu.contact_email', 'like', "%".$srch1."%");
                        $contactus_db=$contactus_db->orWhere('cu.contact_first_name', 'like', "%".$srch1."%");
                        $contactus_db=$contactus_db->orWhere('cu.contact_last_name', 'like', "%".$srch1."%");
                    //$contactus_db=$contactus_db->orWhere('(cu.contact_first_name',' ', 'cu.contact_last_name)', 'like', "%".$srch1."%");
                }
            
                if(!empty($sort1) && !empty($sorttype1) && (in_array(strtoupper($sorttype1),array('ASC','DESC'))))
                {
                        $contactus_db=$contactus_db->orderBy('cu.'.$sort1, $sorttype1);
                }
                $pagi_contactus=$contactus_db;
                
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
            
                $pagi_contactus = $pagi_contactus->paginate($pagelimit);

                $pagi_contactus->setPath(url(ADMINSEPARATOR.'/contactus'));
           
                /*  echo $pagi_country->count();
                echo  $pagi_country->perPage();
                echo  $pagi_country->total();           
                echo "pagi=><pre>";
                print_r($pagi_country);
                echo "</pre>"; exit(); */
          
                $data['pagi_contactus']=$pagi_contactus;
                $data['useinPagiAr']=$useinPagiAr;
                
                //***** pagination code ends
            
                return view('admin.contactus.contactuslist', $data);
        }
       
        // public function delcontact(Request $request,$id=0)
        // {
        //         if(empty($id))
        //         {
        //                 return redirect(ADMINSEPARATOR.'/contactus');
        //         }
        //         $ar=DB::table('contact_us')->where('id', '=', $id)->delete();
        //         if($ar>0)
        //         {
        //                 $request->session()->flash('admin_successmsgdata_sess', 'Data has been deleted successfully.');  
        //         }
        //         return redirect(ADMINSEPARATOR.'/contactus');
        // }

        public function detailsview(Request $request,$id=0)
        {
                $requestviewID = $id;
                $contactus_db = DB::table('contact_us as cu');
                $contactus_db=$contactus_db->join('contactus_category as cc', 'cu.contact_reason_id', '=', 'cc.id');
                $contactus_db=$contactus_db->select(DB::raw('cu.id,cu.contact_reason_id,
                    concat(cu.contact_first_name ," ", cu.contact_last_name) AS contactpersonname,cu.contact_email,cu.contact_message,cu.contact_date,cc.category_name,cu.contact_message,cu.contact_date,

                    IF(cu.contact_back_date="0000-00-00","---------------------",cu.contact_back_date) AS contactbackdate,
                    IF(cu.contact_back_flag="1", "Already replied", "not replied yet") AS replystatus,
                    IF(cu.request_response="1", "yes", "no") AS requestresponsestatus,
                    IF(cu.send_me_copy="1", "yes", "no") AS sendmecopystatus
                    '));
                $contactus_db=$contactus_db->where('cu.id', '=', $requestviewID);
                $contactus_db=$contactus_db->first();
                $data=array();
                $data['detail_contactus']=$contactus_db;

               
                $countdatares =  count($contactus_db);
                if($countdatares == 0)
                {
                    return redirect(ADMINSEPARATOR.'/contactus');
                }
               

                return view('admin.contactus.contactusdetails', $data);

              
        }

         public function detailsviewemailpage(Request $request,$id=0)
        {
                $requestviewID = $id;
                $contactus_db=DB::table('contact_us')->where('id',$requestviewID)->first();
                $data=array();
                $data['detail_contactus']=$contactus_db;

               
                $countdatares =  count($contactus_db);
                 if($countdatares == 0)
                {
                    return redirect(ADMINSEPARATOR.'/contactus');
                }
               

                return view('admin.contactus.contactusemail', $data);

              
        }

        public function sendemail(Request $request)
        {
          $id= $request->input('id');
          $emaildescription= ($request->input('emaildescription'));


          $emailto = $request->input('emailto');
          $receivename = $request->input('receivename');




          $wherearray =array();
          $wherearray['contact_back_flag']=1;
          $wherearray['contact_back_date']=date('Y-m-d H:i:s');

         
           $chkvalid=$this->validateemaildescuser($request);
            // echo "=====";
            // print_r($chkvalid);die;
            if($chkvalid===true)
            {




             $userssel = DB::table('settings')
                        ->select(DB::raw('site_name,email_from,copyright_year,email_template_logo_image'))
                        ->where('id', 1)
                        ->get();
        $sitename=$userssel[0]->site_name;
        $emailfrom=$userssel[0]->email_from;
        $copyright_year=$userssel[0]->copyright_year;
        $Imgologo=$userssel[0]->email_template_logo_image;
       // $fullname=$firstname;
        $bsurl = url('/');
        // $logoIMG = asset('upload/settings-image/source-file/'.$Imgologo);
        $logoIMG = BASEURLPUBLICCUSTOM.'upload/settings-image/source-file/'.$Imgologo;
        
        //*********Helper Function Starts here
                $replacefrom =array('{USER}','{EMAILCONTENT}','{SITENAME}','{YEAR}','{BASE_URL}',"{LOGO_IMG}");
                $replaceto =array(ucfirst($receivename),$emaildescription,$sitename,$copyright_year,$bsurl,$logoIMG);
           

           $emailprevstatuschk = $this->emailstatuscheck($id);  

           if($emailprevstatuschk == 1)

            {

                    $updatetable = DB::table('contact_us')
                    ->where('id', $id)
                    ->update($wherearray);

                mailsnd($Temid=40,$replacefrom,$replaceto,$emailto);
                $request->session()->flash('admin_successmsgdata_sess', 'Email successfully send');
                return redirect(ADMINSEPARATOR.'/contactus');
            }else
            {
                $request->session()->flash('admin_errormsgdata_sess', 'Email can not be send');
                return redirect(ADMINSEPARATOR.'/contactus');
            }
        //*********Helper Function Ends here 

        }
         else
            {
                return redirect(ADMINSEPARATOR.'/contactusdetailsemail/'.$id)
                 ->withErrors($chkvalid)
                 ->withInput();
            }
           
          

        }

        function emailstatuscheck($id)
        {
            $statuscheck = DB::table('contact_us')->where('id',$id)->first();
            $contact_back_flag = $statuscheck->contact_back_flag;

            if($contact_back_flag == 1)
            {
                // return 0;
                return 1;
            }else
            {
                return 1;
            }
        }


        public function validateemaildescuser($request)
    {
         // echo "<pre>";
         // print_r($request);die;
         $validator = Validator::make($request->all(), [
                'emaildescription' => "required",
            ],
            [   
                'emaildescription.required'=>' * Email Content is required ',
            ]);
       
      // print_r($validator);die;
        if ($validator->fails())
        {
            return $validator ;
        }
        return true;
    }



        
}

?>