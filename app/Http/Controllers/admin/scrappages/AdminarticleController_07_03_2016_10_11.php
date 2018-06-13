<?php


namespace App\Http\Controllers;

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


class AdminarticleController extends Controller
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
    public function show_article(Request $request)
    {
            $data=array();
            $useinPagiAr=array();
            $pagelimit=1;
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
            $article_db = DB::table('article as ac');
            $article_db=$article_db->select(DB::raw('ac.id,ac.title,ac.description,ac.status'));
            if(!empty($srch1))
            {
               $article_db=$article_db->where('ac.title', 'like', "%".$srch1."%");   
            }
            if(!empty($sort1) && !empty($sorttype1) && (in_array(strtoupper($sorttype1),array('ASC','DESC'))))
            {
                  
                  $article_db=$article_db->orderBy('ac.'.$sort1, $sorttype1);
            }
            $pagi_article=$article_db;
            //**** fetch data ends
            
            //***** pagination code starts
            
            
             //***** fetch data from settings table starts            
        
            $articlerow = DB::table('settings as st')->select(DB::raw('st.id,st.record_per_page_admin'))->where('st.id', 1)->first();            
            
            if(!empty($articlerow))
            {
                $pagelimit=$articlerow->record_per_page_admin;
            }
            //***** fetch data from settings table ends


            $pagi_article = $pagi_article->paginate($pagelimit);
            $pagi_article->setPath(url(ADMINSEPARATOR.'/article'));
            $data['pagi_article']=$pagi_article;
            $data['useinPagiAr']=$useinPagiAr;
            //***** pagination code ends
            
          
         // return view('admin.country.countrylist', $data);

               

          return view('admin.article.article_view',$data);
          
    }
    public function addarticle(Request $request,$id=0)
    {
        $successmsgdata=$request->session()->get('admin_successmsgdata_sess');
         $errormsgdata=$request->session()->get('admin_errormsgdata_sess');
          $data=array();
          $data['data1']="hello";
          if(!empty($id))
          {
            //**** fetch data starts
            $articlerow = DB::table('article')->where('id', $id)->first();
            $data['article']=$articlerow;
          }
          return view('admin.article.articleadd', $data);
   }
    
  //********Article add and edit function starts here
         public function articlesaeve(Request $request)
          {

            if(!empty($successmsgdata)){
            $data['successmsgdata']=$successmsgdata;
            }
            if(!empty($errormsgdata)){
            $data['errormsgdata']=$errormsgdata;               
            }

            $title = trim(addslashes($request->input('title')));
            $article_description = htmlentities($request->input('description'));
            $hiddentitle = $request->input('hidden_title');
            $create_date = date('Y-m-d H:i:s'); 
            $modified_date = date('Y-m-d H:i:s');
            // exit();
            $id = $request->input('id'); 
            $dataInsert=array();
            $dataInsert['title'] = $title;
            $dataInsert['description'] = $article_description;
            $dataInsert['create_date']= $create_date;
            $dataInsert['modified_date']= $modified_date;
            $dataInsert['status'] = 1;

            //******** array for update article

            $dataUpdate=array();
            $dataUpdate['title'] = $title;
            $dataUpdate['description'] = $article_description;
            $dataUpdate['modified_date']= $modified_date;

            $chkvalid=$this->checkarticleform($request,$id); 

            if($chkvalid===true)
            {

            //********Getting SEO name starts here
            $seoname = $this->seoUrl($title);
            $seoname = $seoname.'--';
            //********** Checking SEO name exists or not strats here

            $seoqry = DB::table('article');
            $seoqry=$seoqry->where('seo_name', 'like', $seoname.'%');
              if(!empty($id))
             {
                    //***check for edit
              $seoqry=$seoqry->where('id', '<>', $id);
             }
          
            $seoqry=$seoqry->count();
            $tot_seocount=$seoqry;
            $tot_seocount = $tot_seocount+1;
            $seoname = $seoname.$tot_seocount;
            $dataInsert['seo_name']= $seoname;
            //********** Checkign SEO name exists or not ends here
            //********Getting SEO name ends here
            if(empty($id))
            {
                  //*** insert  query
                  /*Insert query*/
                  $isInserted = DB::table('article')->insert($dataInsert);
                  /*Last Insert id*/
                  $last_insert_id=DB::getPdo()->lastInsertId();
            }
            else
            {
                //******checking seo already exists or not   starts here
                 $seoqrydoublechk = DB::table('article');
                 $seoqrydoublechk=$seoqrydoublechk->where('seo_name',$seoname);
                 $seoqrydoublechk=$seoqrydoublechk->count();

                 if($seoqrydoublechk == 0)
                 {
                  $dataUpdate['seo_name']= $seoname;
                 }
                 //******checking seo already exists or not ends here
                 //*** update query
                  $isUpdated=DB::table('article')
                  ->where('id', $id)
                  ->update($dataUpdate);
            }
              // if($isInserted >= 0 )
              //     {
                         $request->session()->flash('admin_successmsgdata_sess', 'Article Successfully saved.');
                         return redirect(ADMINSEPARATOR.'/article');
                  // }

          }
           
            return redirect(ADMINSEPARATOR.'/createarticle');
      
    } 

//********Article add and edit function ends here


//********** Article Delete Function starts here
        public function articledelete(Request $request,$id=0)
        {
            $del_qry = DB::table('article')->where('id', $id)->delete();
            if($del_qry)
            {
            $request->session()->flash('admin_successmsgdata_sess', 'Article Deleted successfully.');
            }
            return redirect(ADMINSEPARATOR.'/article');
        }

        public function checkarticleform($request,$id=0)
        {

            $validator = Validator::make($request->all(), [
            'title' => "required|max:100|alpha_spaces|articlenameunique:".$id,
            'description' => "required",
            ],['title.required'=>'*Title field required',
            'title.articlenameunique'=>'*Article name should be unique',
            'description.required'=>'*Description field required',
            "title.alpha_spaces"     => "The :attribute may only contain letters and spaces.",
            ]);

            // echo "validator==>"; var_dump($validator->fails()); echo "</pre>"; exit();

            // echo "----id==>".$id."here"; exit();
            if ($validator->fails())
            {
            // echo "----id==>".$id."here"; exit();
              if(!empty($id))
              {

              return redirect(ADMINSEPARATOR.'/createarticle/'.$id)
              ->withErrors($validator)
              ->withInput();
              }
              else
              {
              return redirect(ADMINSEPARATOR.'/createarticle')
              ->withErrors($validator)
              ->withInput();
              }
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

        public function statuschangearticle(Request $request) //***********Article status change starts here
       {
           //$country_name = $request->input('country_name','');
           
          $statuschange = $request->input('statuschange',0);
          // $countryid =    $request->input('countryid',0);
           $articleid =    $request->input('articleid',0);

          //exit();
          $respAr=array();
          $flagdata=0;
          
          
          if(!empty($articleid) && ($articleid>0) && in_array($statuschange,array(0,1)))
          {
            
            
                  //*** update status starts
                  $dataUpdate=array();
                  $dataUpdate['status']=$statuschange;
                  
                  $updstaus=DB::table('article')
                        ->where('id', $articleid)
                        ->update($dataUpdate);
                        
                        if(!empty($updstaus))
                        {
                               $flagdata=1;
                        }

                  
                  //*** update status ends
          }
          

          $respAr['flag']=$flagdata;
          $respAr['iddata']=$articleid;
          
          echo  json_encode($respAr);
       } //***********Article status change ends here
    
}
