<?php

namespace App\Http\Controllers\admin;

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
//use App\User
use Mail;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Redirect;
use Storage;
use App\Models\User;
use DB;
use Illuminate\Routing\Route;
use Lang;
// use Illuminate\Support\Facades\Input;
class AdmindisputereasonController extends Controller
{
    
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */
    
    public function index(Request $request){
        
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
        $data['data1']="hello";
        $successmsgdata=$request->session()->get('admin_successmsgdata_sess');
        $errormsgdata=$request->session()->get('admin_errormsgdata_sess');
        if(!empty($successmsgdata))
        {
            $data['successmsgdata']=$successmsgdata;
        }
        if(!empty($errormsgdata))
        {
            $data['errormsgdata']=$errormsgdata;               
        }
        
        //**********Data fatch for listing starts here
        $searchResults = DB::table('dispute_reason_master')
            ->where(function($query) use ($srch1) {
            if($srch1 != ''){
                $query->where('complaint_by',$srch1);
            }
           
        });//->where('status', '1')
        //********Data fatch for listing Ends here
        //***** fetch data from settings table starts
        $pagelimit=1;
        $staterow = DB::table('settings as st')->select(DB::raw('st.id,st.record_per_page_admin'))->where('st.id', 1)->first();            
        if(!empty($staterow))
        {
            $pagelimit=$staterow->record_per_page_admin;
            
        }
        //***** fetch data from settings table ends
        //***** pagination code starts
        $pagi_user=$searchResults->orderBy('id', 'desc');
        $pagi_user = $pagi_user->paginate($pagelimit);
        $pagi_user->setPath(url(ADMINSEPARATOR.'/disputereason'));
        $data['DisputeReason']=$pagi_user;
        $data['useinPagiAr']=$useinPagiAr;
        //***** pagination code ends 
        return view('admin.disputereason.dispute_reasonList',$data); 
    }
    
    
    
    
    public function adddisputereason(Request $request,$id='' )
    {
        $data['disputereasons'] = array();
        if($id != ''){
         //**** fetch reason starts
            $getreasonDetails = DB::table('dispute_reason_master')->where('id',$id);
            $total = $getreasonDetails->count();
            if($total>0){
               $data['disputereasons'] = $getreasonDetails->first();
            }
            
         //**** fetch reason ends 
        }
        return view('admin.disputereason.disputereasonadd',$data);
    }
    
    public function savedisputereason(Request $request){
        

        $complaint_byedit =0;
        $complaint_by_typeedit =0;
        $complaint_agaistedit =0;
        $complaint_against_typeedit =0;

        //*********Add Edit Dispute Starts
                    $complaint_by=($request->input('complaint_by'));
                    $complaint_by_type =($request->input('complaint_by_type'));
                    $complaint_agaist=($request->input('complaint_against')); 
                    $complaint_against_type=($request->input('complaint_against_type'));
                    $question=addslashes(trim($request->input('question')));
                    //********Geting the ID for Edit section
                    $editid=trim($request->input('editid',0));

                    if($editid > 0)
                    {
                        $complaint_byedit=($request->input('diputreson_complaintby'));
                        $complaint_by_typeedit =($request->input('diputreson_complaintby_type'));
                        $complaint_agaistedit=($request->input('diputreson_complaintagainst')); 
                        $complaint_against_typeedit=($request->input('diputreson_complaintagainst_type'));
                    }

                    $id = 0;
                    $chkvalid=$this->checkdsiputereasonform($request,$editid);

                if($chkvalid===true)
                {
                    $insertArray = array();
                    $insertArray['question']=$question;
                    $insertArray['modified_date'] = date("Y-m-d H:i:s");
                    if($editid==0)
                    {
                                    $insertArray['complaint_by']=$complaint_by;
                                    $insertArray['complaint_by_type']=$complaint_by_type;
                                    $insertArray['complaint_against']=$complaint_agaist;
                                    $insertArray['complaint_against_type']=$complaint_against_type;
                                    $insertArray['create_date'] = date("Y-m-d H:i:s");

                         $reasonInserted = DB::table('dispute_reason_master')->insert($insertArray);
                            if($reasonInserted){
                            $request->session()->flash('admin_successmsgdata_sess', 'Dispute reason Successfully saved.');
                            return redirect(ADMINSEPARATOR.'/disputereason');
                            }
                    }else if($editid>0)
                    {
                        
                           $updateqry_dispute =  DB::table('dispute_reason_master')->where('id', $editid)->update($insertArray);
                           if($updateqry_dispute)
                           {
                            $request->session()->flash('admin_successmsgdata_sess', 'Dispute reason Successfully updated.');
                            return redirect(ADMINSEPARATOR.'/disputereason');
                           }
                           else
                           {
                            return redirect(ADMINSEPARATOR.'/disputereason');
                           }
                    }
                 
                

                }
                else
                {
                        if(!empty($editid))
                        {
                              
                                return redirect(ADMINSEPARATOR.'/disputereasonadd/'.$editid)
                                ->withErrors($chkvalid)
                                ->withInput();
                        }
                        else
                        {
                                return redirect(ADMINSEPARATOR.'/disputereasonadd')
                                ->withErrors($chkvalid)
                                ->withInput();
                      }
                }

          
        //*********Add Edit Dispute Ends    
    }
    
    public function statuschangedisputereason(Request $request){
        
        $statuschange = $request->input('statuschange');
        
        $respAr=array();
        $updateStatus=0;
        
        if($statuschange != ''){
            
            $dispute_status = DB::table('dispute_reason_master')->select('status')->where('id',$statuschange)->first();
            if(($statuschange != '') && (count($dispute_status)>0)){
                $status = $dispute_status->status;
                if($status == '1'){
                    $updateStatus = '0';
                }
                else{
                    $updateStatus = '1';
                }
                $dataUpdate = array(
                    'status'=>$updateStatus
                );
                $updateDStatus = DB::table('dispute_reason_master')->where('id', $statuschange)->update($dataUpdate);
                $respAr['flag']=$updateStatus;
                echo  json_encode($respAr);
            }
        }
    }
    
    public function deldisputereason(Request $request){
        
        $delete_row_id = $request->input('delete_id');
        $respAr=array();
        if(empty($delete_row_id)){
            
            $respAr['messege'] = 'Something went fwrong ! Check your internet connection.';
            $respAr['type'] = 'error';
        }else{
            $deleted = DB::table('dispute_reason_master')->where('id', $delete_row_id)->delete();
            if($deleted){
                $request->session()->flash('admin_successmsgdata_sess', 'Dispute reason Successfully deleted.');
                $respAr['messege'] = 'Dispute reason deleted successfully.';
                $respAr['type'] = 'success';
                 //return redirect(ADMINSEPARATOR.'/disputereason');
            }
        }
         echo  json_encode($respAr);
    }

   
    //************** form  validation strats here

      public function checkdsiputereasonform($request,$id=0)
        {
           if($id == 0)
            {
                $validator = Validator::make($request->all(), [
                            'complaint_by' => "required",
                            'complaint_by_type' => "required",
                            'complaint_against' => "required",
                            'complaint_against_type' => "required",
                            'question' => "required",

                ],[
                            'complaint_by.required'=>'*Please Select an option',
                            'complaint_by_type.required'=>'*Please Select an option',
                            'complaint_against.required'=>'*Please Select an option',
                            'complaint_against_type.required'=>'*Please Select an option',
                            'question.required'=>'*Please enter a question',
                ]);

                $userData=array();
                $userData['request']=$request;
                $userData['addeditid']=$id;
                
                $validator->after(function($validator)  use ($userData)  {
                        
                        $request=$userData['request'];
                        $addeditid=$userData['addeditid'];
                      
                        $validatefilechk=$this->adrequestform($request,$addeditid);
                        
                        // echo "==validatefilechk==><pre>";
                        // print_r($validatefilechk);
                        // echo "</pre>===="; exit();
                        
                        if (!empty($validatefilechk))
                        {
                                $validator->errors()->add('question', $validatefilechk);
                                // echo "<pre>"; print_r($tt); echo "</pre>"; exit();
                        }
                });

            }
                else if($id > 0)
            {
                // echo "<pre>";
                // print_r($request->input());die;
                 $validator = Validator::make($request->all(), [
                                    'question' => "required",

                            ],[
                                       'question.required'=>'*Please enter a question',
                            ]);

                $userData=array();
                $userData['request']=$request;
                $userData['addeditid']=$id;
                
                $validator->after(function($validator)  use ($userData)  {
                        
                        $request=$userData['request'];
                        $addeditid=$userData['addeditid'];
                      
                        $validatefilechk=$this->editrequestform($request,$addeditid);
                        
                        // echo "==validatefilechk==><pre>";
                        // print_r($validatefilechk);
                        // echo "</pre>===="; exit();
                        
                        if (!empty($validatefilechk))
                        {
                                $validator->errors()->add('question', $validatefilechk);
                                // echo "<pre>"; print_r($tt); echo "</pre>"; exit();
                        }
                });






            }
                    
                if ($validator->fails())
                {
                        return $validator;   
                }  
                    
                return true;
        } 
        public function editrequestform($request,$addeditid)
        {
            // echo "I am inside second validation";
            // echo "<pre>";
            // print_r($request->input());
            $responseval = "";
            //die;

            $diputreson_complaintby = $request->input('diputreson_complaintby');
            $diputreson_complaintby_type = $request->input('diputreson_complaintby_type');
            $diputreson_complaintagainst = $request->input('diputreson_complaintagainst');
            $diputreson_complaintagainst_type = $request->input('diputreson_complaintagainst_type');
            $diputreson_complaint =addslashes(trim($request->input('question')));

            $disputresonaddeditid = $request->input('editid');

            $duplicheck=DB::table('dispute_reason_master')
            ->select('id')
            ->where('complaint_by',$diputreson_complaintby)
            ->where('complaint_by_type',$diputreson_complaintby_type)
            ->where('complaint_against',$diputreson_complaintagainst)
            ->where('complaint_against_type',$diputreson_complaintagainst_type)
            ->where('question',$diputreson_complaint)
            ->first();
            $duplicheckcount =count($duplicheck);
            if($duplicheckcount > 0)
            {
                $duplicheckid = $duplicheck->id;

                if($duplicheckcount == 1)
                {

                   if($disputresonaddeditid != $duplicheckid)
                   {
                    //echo "I am repetating";
                    $responseval = "This question already exists";
                   }else
                   {
                   // echo "I am fine 1";
                    $responseval ="";
                   }
                }
            }
            else if($duplicheckcount == 0)
            {
                //echo "I am fine 0";
                $responseval ="";
            }
                return $responseval;
//die;
        }

         public function adrequestform($request,$addeditid)
        {
            
            $responseval = "";
            $complaint_by = $request->input('complaint_by');
            $complaint_by_type = $request->input('complaint_by_type');
            $complaint_against = $request->input('complaint_against');
            $complaint_against_type = $request->input('complaint_against_type');
            $complaint =addslashes(trim($request->input('question')));

            $duplicheck=DB::table('dispute_reason_master')
           // ->select('id')
            ->where('complaint_by',$complaint_by)
            ->where('complaint_by_type',$complaint_by_type)
            ->where('complaint_against',$complaint_against)
            ->where('complaint_against_type',$complaint_against_type)
            ->where('question',$complaint)
            ->first();
            $duplicheckcount =count($duplicheck);
            if($duplicheckcount > 0)
            {
                $responseval = "This question already exists";
            }
            else if($duplicheckcount == 0)
            {
                //echo "I am fine 0";
                $responseval = "";
            }
         //   echo $responseval;die;
                return $responseval;
//die;
        }




    //************** form validation rnsds here
}