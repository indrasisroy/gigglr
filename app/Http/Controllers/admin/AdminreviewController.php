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
        $srch2=addslashes(trim($request->input('srch2','')));
         $sort2=addslashes(trim($request->input('sort2','')));
        $sorttype2=addslashes(trim($request->input('sorttype2','')));
        if(!empty($srch1))
        {
            $useinPagiAr['srch1']=trim($srch1);  
        }
         if(!empty($srch2))
        {
            $useinPagiAr['srch2']=trim($srch2);  
        }
        if(!empty($sort1))
        {
            $useinPagiAr['sort1']=trim($sort1);  
        }
        if(!empty($sorttype1))
        {
            $useinPagiAr['sorttype1']=trim($sorttype1);  
        }
        if(!empty($sort2))
        {
            $useinPagiAr['sort2']=trim($sort2);  
        }
        if(!empty($sorttype1))
        {
            $useinPagiAr['sorttype2']=trim($sorttype2);  
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
        //************************main fetching program start here***************************
       // $chk = DB::table('gig_review');
         $chk = DB::table('gig_review as grv')
                    ->join('gig_master as gm', 'grv.gigmaster_id', '=', 'gm.id')

                        ->select(DB::raw('grv.id,gm.giguniqueid,grv.gigmaster_id,grv.artistgroupvenue_id,grv.booker_flag_type,grv.artistgroupvenue_flag_type,grv.bkr_hospitality,grv.bkr_environment,grv.bkr_readiness,grv.punctuality,grv.performance,grv.presentation,grv.bkr_review_data,grv.agv_review_data,grv.status,gm.booker_id,gm.type_flag,gm.artist_id'))
                        
                        ->where(function($query) use ($srch1) {
                        if($srch1 != ''){
                            $query->where('gm.giguniqueid','=',$srch1);
        
                        }
                     })
                        ->where(function($query) use ($srch2,$id) {
                        if($srch2 == '1'){
                            $query->orWhere('gm.booker_id','=',$id);
        
                        }
                     })  
                       ->where(function($query) use ($srch2,$id) {
                        if($srch2 == '2'){
                            $query->where('gm.artist_id','=',$id);
        
                        }
                     })    
                        ->where(function($query) use ($srch2) {
                        if($srch2 == '3'){
                            $query->orWhere('gm.type_flag','=','2');
        
                        }
                     }) 
                        ->where(function($query) use ($srch2) {
                        if($srch2 == '4'){
                            $query->orWhere('gm.type_flag','=','3');
        
                        }
                     }) 
                        
 
                        ->where(function($query) use ($srch1,$srch2,$id) {
                           if($srch1 == ''){
                               $query->where('gm.booker_id', $id);
                               $query->orWhere('gm.artist_id', $id);
                               $query->orWhere('grv.artistgroupvenue_id', $id);
          
                           }
                           else if($srch2 == '')
                           {
                              $query->where('gm.booker_id', $id);
                               $query->orWhere('gm.artist_id', $id);
                               $query->orWhere('grv.artistgroupvenue_id', $id);
                           }
                           
                        });
   
       //echo "<pre>";
       // print_r($chk);
       // 
       // die();
        
       //**************************This is for searching start here****************************
       
   
       $pagi_user=$chk;
       
       //************************ fetch data from settings table starts*****************************************
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
    //   echo "<pre>";print_r( $data['pagi_user']);die;
       //******************************from here fetch details from user_master,group_master,venue_master*************
         if(count($data['pagi_user'] ) > 0){
            $i = 0;
            
            foreach($data['pagi_user']  as $row){
                //***********************************in cASE of booker**********************************************
                
               if($id==$row->artist_id && $row->type_flag=='1')
                  {
                    $bookerid = $row->booker_id;
                    $sqluser=DB::table('user_master')->select('id','first_name','last_name')->where('id',$bookerid)->first();
        
                    if(!empty($sqluser)){
                     $link_address=url(ADMINSEPARATOR.'/useradd/'.$sqluser->id);
                     $StatusHtml=  "<a href='".$link_address."' style='color:blue;'>$sqluser->first_name  $sqluser->last_name</a>";
                     $roll_desc='Review received from booker'.' '.$StatusHtml;
                     $data['pagi_user'][$i]->roll2 = $roll_desc;
        
        
                      }
                   }
                elseif($id==$row->artist_id && $row->type_flag=='2')
                    {
                         $roll_desc='Review given as group';
                         $data['pagi_user'][$i]->roll2 = $roll_desc;
                    }
                elseif($id==$row->artist_id && $row->type_flag=='3')
                     {
                        $roll_desc='Review given as venue';
                        $data['pagi_user'][$i]->roll2 = $roll_desc;
                                           
                     }
                elseif($id !=$row->artist_id && $row->type_flag=='1')
                    {
                        $roll_desc='Review received from artist';
                        $data['pagi_user'][$i]->roll2 = $roll_desc;
                    }
                 //*********************************in cASE of group*****************************************
                elseif($id !=$row->artist_id && $row->type_flag=='2')
                    {
                          $groupid=$row->artist_id;
                          $sqlgroup=DB::table('group_master')->select('id','creater_id','nickname')->where('id',$groupid)->first();
                          if(!empty($sqlgroup))
                          {
                            $link_address=url(ADMINSEPARATOR.'/useradd/groupadd/'.$sqlgroup->creater_id.'/'.$sqlgroup->id);
                            $StatusHtml=  "<a href='".$link_address."' style='color:blue;'>$sqlgroup->nickname</a>";
                            $roll_desc='Review given to group'.' '.$StatusHtml;
                            $data['pagi_user'][$i]->roll2 = $roll_desc;
                          }
                                           
                   }  
                //**********************************in cASE of venue******************************************
                elseif($id !=$row->artist_id && $row->type_flag=='3')
                    {
                    
                        $venueid=$row->artist_id;
                       $sqlvenue=DB::table('venue_master')->select('id','creater_id','nickname')->where('id',$venueid)->first();
                       if(!empty($sqlvenue))
                          {
                          
                            $link_address=url(ADMINSEPARATOR.'/useradd/venueadd/'.$sqlvenue->creater_id.'/'.$sqlvenue->id);
                            $StatusHtml=  "<a href='".$link_address."' style='color:blue;'>$sqlvenue->nickname</a>";
                            $roll_desc='Review given to  venue'.' '.$StatusHtml;
                            $data['pagi_user'][$i]->roll2 = $roll_desc;
                          }
                                           
                  } 
                $i++;
            }
        }
 //***************************fetch details from user_master,group_master,venue_master end here********************
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