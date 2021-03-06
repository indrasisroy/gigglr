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
use App\Models\User;
use DB;
use Response;
use Illuminate\Routing\Route;
use App\Customlibrary\Imageuploadlib;

class AdminreviewController extends Controller
{
    
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */
    
   public function index(Request $request,$id=0)
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
        //******
        $chk = DB::table('gig_review');
                if(!empty($srch1))
                {

                //  $sqlAdd = "and gr.booker_flag_type ='".$srch1."'";
                    if($srch1=='1')
                    {
                       $chk = $chk->where('booker_id',$id);
                    }
                    if($srch1=='2')
                    {
                        $chk = $chk->where('booker_id',$id);
                        $chk = $chk->where('artistgroupvenue_flag_type','1');
                    }
                    if($srch1=='3')
                    {
                        $chk = $chk->where('booker_id',$id);
                        $chk = $chk->where('artistgroupvenue_flag_type','2');
                    }
                    if($srch1=='4')
                    {
                        $chk = $chk->where('booker_id',$id);
                        $chk = $chk->where('artistgroupvenue_flag_type','3');
                    }
                  
                }
               $chk = $chk->where('booker_id',$id);
               $chk->orwhere('artistgroupvenue_id',$id);
               if(!empty($srch1))
                {

               
                  if($srch1=='1')
                    {
                       $chk = $chk->where('booker_id',$id);
                    }
                    if($srch1=='2')
                    {
                        $chk = $chk->where('booker_id',$id);
                        $chk = $chk->where('artistgroupvenue_flag_type','1');
                    }
                    if($srch1=='3')
                    {
                        $chk = $chk->where('booker_id',$id);
                        $chk = $chk->where('artistgroupvenue_flag_type','2');
                    }
                    if($srch1=='4')
                    {
                        $chk = $chk->where('booker_id',$id);
                        $chk = $chk->where('artistgroupvenue_flag_type','3');
                    }
                  

                }
       $pagi_user=$chk;
       //***** fetch data from settings table starts
       $pagelimit=1;
       $staterow = DB::table('settings as st')->select(DB::raw('st.id,st.record_per_page_admin'))->where('st.id', 1)->first();            
       if(!empty($staterow))
        {
            $pagelimit=$staterow->record_per_page_admin;
        }
            
        //***** fetch data from settings table ends
            
        //***** pagination code starts
          
        //$pagelimit=2;
        $pagi_user = $pagi_user->paginate($pagelimit);

        $pagi_user->setPath(url(ADMINSEPARATOR.'/userreview/'.$id.''));
        
          
        $data['pagi_user']=$pagi_user;

        $data['useinPagiAr']=$useinPagiAr;
            
        //***** pagination code ends       
      //echo "<pre>";print_r( $data['pagi_user']);die;
        return view('admin.user.reviewlist', $data);
    }

    public function statuschangereview(Request $request) //***********Review status change starts here
       {
          
          $statuschange = $request->input('statuschange',0);
          $id =    $request->input('articleid',0);
          $respAr=array();
          $flagdata=0;
          if(!empty($id) && ($id>0) && in_array($statuschange,array(0,1)))
          {
            
            //*** update status starts
            $dataUpdate=array();
            $dataUpdate['status']=$statuschange;
            $updstaus=DB::table('gig_review')
                        ->where('id', $id)
                        ->update($dataUpdate);
                        
                        if(!empty($updstaus))
                        {
                               $flagdata=1;
                        }

                  
                  //*** update status ends
          }
          

          $respAr['flag']=$flagdata;
          $respAr['iddata']=$id;
          
          echo  json_encode($respAr);
       } 
    public function addreview(Request $request,$id=0)//************view page or edit page load*********
    {
          $successmsgdata=$request->session()->get('admin_successmsgdata_sess');
          $errormsgdata=$request->session()->get('admin_errormsgdata_sess');
          $data=array();
          $data['data1']="hello";
          if(!empty($id))
          {
            //**** fetch data starts
            $reviewrow = DB::table('gig_review')->where('id', $id)->first();
            if(!$reviewrow)
            {
              return redirect(ADMINSEPARATOR.'/userreview/'.$id.'');
            }
            $data['review']=$reviewrow;
          }
          return view('admin.user.reviewadd', $data);
   }
  public function addarticle(Request $request,$id=0)//**********review edit functionality
    {
         $successmsgdata=$request->session()->get('admin_successmsgdata_sess');
         $errormsgdata=$request->session()->get('admin_errormsgdata_sess');
         $data=array();
         $data['data1']="hello";
         if(!empty($id))
         {
            //**** fetch data starts
            $articlerow = DB::table('article')->where('id', $id)->first();
            if(!$articlerow)
            {
              return redirect(ADMINSEPARATOR.'/article');
            }
            $data['article']=$articlerow;
         }
          return view('admin.article.articleadd', $data);
   }
    
  //********review  edit function starts here
  public function reviewsave(Request $request)
    {
            if(!empty($successmsgdata)){
            $data['successmsgdata']=$successmsgdata;
            }
            if(!empty($errormsgdata)){
            $data['errormsgdata']=$errormsgdata;               
            }

            $hospitality = trim(addslashes($request->input('hospitality')));
            $environment = trim(addslashes($request->input('environment')));
            $readiness = trim(addslashes($request->input('readiness')));
            $bkr_review_data= htmlentities(strip_tags($request->input('bkr_review_data')));
      
            $punctualityy = trim(addslashes($request->input('punctualityy')));
            $performance= trim(addslashes($request->input('performance')));
            $presentation = trim(addslashes($request->input('presentation')));
            $agv_review_data= htmlentities(strip_tags($request->input('agv_review_data')));
            
            $id = $request->input('id'); 
            

            //******** array for update article

            $dataUpdate=array();
            $dataUpdate['bkr_hospitality'] = $hospitality;
            $dataUpdate['bkr_environment'] = $environment;
            $dataUpdate['bkr_readiness']= $readiness;
            $dataUpdate['bkr_review_data']= $bkr_review_data;
      
            $dataUpdate['punctuality'] = $punctualityy;
            $dataUpdate['performance'] = $performance;
            $dataUpdate['presentation']= $presentation;
            $dataUpdate['agv_review_data']= $agv_review_data;
      

            $chkvalid=$this->checkreviewform($request,$id); 

            if($chkvalid===true)
            {

            
            if(!empty($id))
            {
                //update functionality******
                $isUpdated=DB::table('gig_review')
                  ->where('id', $id)
                  ->update($dataUpdate);
            }
           
            $request->session()->flash('admin_successmsgdata_sess', 'User review Successfully saved.');
            return redirect(ADMINSEPARATOR.'/user');
                  

          }
          else
          {
            if(!empty($id))
            {
              return redirect(ADMINSEPARATOR.'/createreview/'.$id);
            }else
            {
              return redirect(ADMINSEPARATOR.'/user');
            }
          }
           
            
      
    } 
    public function checkreviewform($request,$id=0)
        {

            $validator = Validator::make($request->all(), [
            'hospitality' => "required",
            'environment' => "required",
            'readiness'   => "required",
            'bkr_review_data'   => "required",
            'punctualityy'   => "required",
            'performance'   => "required",
            'presentation'   => "required",
            'agv_review_data'=> "required",
            ],['hospitality.required'=>'*hospitality field required',
            'environment.required'=>'*environment field required',
            'readiness.required'=>'*readiness field required',
            'bkr_review_data.required'=>'*bkr_review_data field required',
            'punctualityy.required'=>'*punctualityy field required',
            'performance.required'=>'*performance field required',
            'presentation.required'=>'*presentation field required',
            'agv_review_data.required'=>'*agv_review_data field required',
               
            ]);

            // echo "validator==>"; var_dump($validator->fails()); echo "</pre>"; exit();

            // echo "----id==>".$id."here"; exit();
            if ($validator->fails())
            {
            // echo "----id==>".$id."here"; exit();
              if(!empty($id))
              {

              return redirect(ADMINSEPARATOR.'/createreview/'.$id)
              ->withErrors($validator)
              ->withInput();
              }
              else
              {
              return redirect(ADMINSEPARATOR.'/createreview'.$id)
              ->withErrors($validator)
              ->withInput();
              }
            }
             return true;
        } 
     
}
?>