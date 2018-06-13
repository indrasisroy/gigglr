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
use Redirect;


class AdminemailtemplateController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */
    public function index()
    {
           
    }
    public function show_emailtemaplate(Request $request)
    {
            $data=array();
            $useinPagiAr=array();
           
            $srch1=$request->input('srch1','');
            $sort1=$request->input('sort1','');
            $sorttype1=$request->input('sorttype1','');
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
            if(!empty($successmsgdata))
            {
              $data['successmsgdata']=$successmsgdata;
            }
            if(!empty($errormsgdata))
            {
                  $data['errormsgdata']=$errormsgdata;               
            }
            //**** fetch data starts
            $emailtemplate_db = DB::table('email_templates as ac');
            $emailtemplate_db=$emailtemplate_db->select(DB::raw('ac.id,ac.subject,ac.message,ac.status'));
            $emailtemplate_db=$emailtemplate_db->where('ac.status','<>',9);   
            if(!empty($srch1))
            {
               $emailtemplate_db=$emailtemplate_db->where('ac.subject', 'like', "%".$srch1."%");   
            }
            
            
            if(!empty($sort1) && !empty($sorttype1) && (in_array(strtoupper($sorttype1),array('ASC','DESC'))))
            {
                  
                  $emailtemplate_db=$emailtemplate_db->orderBy('ac.'.$sort1, $sorttype1);
            }
            $pagi_emailtemplate=$emailtemplate_db;
            //**** fetch data ends
            
            //***** pagination code starts

            //***** fetch data from settings table starts            
        
            $emailtemplaterow = DB::table('settings as st')->select(DB::raw('st.id,st.record_per_page_admin'))->where('st.id', 1)->first();            
            
            if(!empty($emailtemplaterow))
            {
                $pagelimit=$emailtemplaterow->record_per_page_admin;
            }
            //***** fetch data from settings table ends
            
            $pagi_emailtemplate = $pagi_emailtemplate->paginate($pagelimit);
            $pagi_emailtemplate->setPath(url(ADMINSEPARATOR.'/email-template'));
            $data['pagi_email']=$pagi_emailtemplate;
            $data['useinPagiAr']=$useinPagiAr;
            //***** pagination code ends
           

          return view('admin.email_template.emailtemplate_view',$data);
      //echo "I am Inside Email Tempalte";exit();
          
    }
    public function addtemplate(Request $request,$id=0)
    {
        $successmsgdata=$request->session()->get('admin_successmsgdata_sess');
         $errormsgdata=$request->session()->get('admin_errormsgdata_sess');
          $data=array();
          $data['data1']="hello";
          if(!empty($id))
          {
            //**** fetch data starts
            $articlerow = DB::table('email_templates')->where('id', $id)->where('status','<>',9)->first();

            if(!$articlerow)
            {
              return redirect(ADMINSEPARATOR.'/email-template');
            }

            $data['email_details']=$articlerow;
          }
          return view('admin.email_template.emailtemplateadd', $data);
   }
    
  //******** add and edit function starts here
         public function emailtemplatesaeve(Request $request)
          {
           

            if(!empty($successmsgdata)){
            $data['successmsgdata']=$successmsgdata;
            }
            if(!empty($errormsgdata)){
            $data['errormsgdata']=$errormsgdata;               
            }

             $subject = trim(addslashes($request->input('subject')));
            $article_description = htmlentities($request->input('description'));
             
            $id = $request->input('id'); 
            $dataInsert=array();
            $dataInsert['subject'] = $subject;
            $dataInsert['message'] = $article_description;
            $dataInsert['status'] = 1;
           

            //******** array for update 

            $dataUpdate=array();
            $dataUpdate['subject'] = $subject;
            $dataUpdate['message'] = $article_description;

            $dataUpdate['modified_date'] = date('Y-m-d H:i:s');

            // $dataUpdate['modified_date']= $modified_date;

            $chkvalid=$this->checkemailtemplateform($request,$id); 

            if($chkvalid===true)
            {

                  //********Getting SEO name starts here
                  $seoname = $this->seoUrl($subject);
                  $seoname = $seoname.'--';
                  //********** Checking SEO name exists or not strats here

                  $seoqry = DB::table('email_templates');
                  $seoqry=$seoqry->where('template_for_alias', 'like', $seoname.'%');
                    if(!empty($id))
                   {
                          //***check for edit
                    $seoqry=$seoqry->where('id', '<>', $id);
                   }
                
                  $seoqry=$seoqry->count();
                  $tot_seocount=$seoqry;
                  $tot_seocount = $tot_seocount+1;
                  $seoname = $seoname.$tot_seocount;
                  $dataInsert['template_for_alias']= $seoname;
                  //********** Checkign SEO name exists or not ends here
                  //********Getting SEO name ends here
                  if(empty($id))
                  {
                        //*** insert  query
                        /*Insert query*/
                        $isInserted = DB::table('email_templates')->insert($dataInsert);
                        /*Last Insert id*/
                        $any_id_or_rownum=DB::getPdo()->lastInsertId();
                  }
                  else
                  {
                      //******checking seo already exists or not   starts here
                       $seoqrydoublechk = DB::table('email_templates');
                       $seoqrydoublechk=$seoqrydoublechk->where('template_for_alias',$seoname);
                       $seoqrydoublechk=$seoqrydoublechk->count();

                       if($seoqrydoublechk == 0)
                       {
                        $dataUpdate['template_for_alias']= $seoname;
                       }
                       //******checking seo already exists or not ends here
                       //*** update query
                        $any_id_or_rownum=DB::table('email_templates')
                        ->where('id', $id)
                        ->update($dataUpdate);
                  }
                    
               if($any_id_or_rownum >= 0 )
                   {
                         $request->session()->flash('admin_successmsgdata_sess', 'Template Successfully saved.');
                         return redirect(ADMINSEPARATOR.'/email-template');
                         
                  }

                  

          }
           else
           {
               if(!empty($id))
                {

                  return redirect(ADMINSEPARATOR.'/createemailtemplate/'.$id)
                  ->withErrors($chkvalid)
                  ->withInput();
                }
                else
                {
                    return redirect(ADMINSEPARATOR.'/createemailtemplate')
                    ->withErrors($chkvalid)
                    ->withInput();
                }
           }
           
            return redirect(ADMINSEPARATOR.'/email-template');
      
    } 

//******** add and edit function ends here


//**********  Delete Function starts here
        public function emailtemplatedelete(Request $request,$id=0)
        {
            // $del_qry = DB::table('email_templates')->where('id', $id)->delete();
            // if($del_qry)
            // {
            // $request->session()->flash('admin_successmsgdata_sess', 'Template Deleted successfully.');
            // }
            return redirect(ADMINSEPARATOR.'/email-template');
        }

         
         public function checkemailtemplateform($request,$id=0)
        {

            $validator = Validator::make($request->all(), [
            'subject' => "required|unique:email_templates,subject,".$id,
            'description' => "required",

            
            
            ],['subject.required'=>'*subject field required',
            'description.required'=>'*Description field required',
            'subject.unique'=>'*subject already exists',
            
            ]);

            // echo "validator==>"; var_dump($validator->fails()); echo "</pre>"; exit();

            // echo "----id==>".$id."here"; exit();
            if ($validator->fails())
            {
                return $validator;
            }
             return true;
        } 


        //*********Custom SEO Function starts here
      

        public function seoUrl($string_main) 
      {
            $string = substr($string_main,0,50);
            //Lower case everything
            $string = strtolower($string);
            //Make alphanumeric (removes all other characters)
            $string = str_slug($string,'-');
            return $string;
       }

      //*********Custom SEO Function ends here

        public function statuschangeemail(Request $request) //***********Email status change starts here
       {
           //$country_name = $request->input('country_name','');
           
          $statuschange = $request->input('statuschange',0);
          // $countryid =    $request->input('countryid',0);
           $email_id =    $request->input('emailid',0);

          //exit();
          $respAr=array();
          $flagdata=0;
          
          
          if(!empty($email_id) && ($email_id>0) && in_array($statuschange,array(0,1)))
          {
            
            
                  //*** update status starts
                  $dataUpdate=array();
                  $dataUpdate['status']=$statuschange;
                  
                  $updstaus=DB::table('email_templates')
                        ->where('id', $email_id)
                        ->update($dataUpdate);
                        
                        if(!empty($updstaus))
                        {
                               $flagdata=1;
                        }

                  
                  //*** update status ends
          }
          

          $respAr['flag']=$flagdata;
          $respAr['iddata']=$email_id;
          
          echo  json_encode($respAr);
       } //***********Article status change ends here
    
    
}
