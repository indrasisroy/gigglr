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

class AdminassociationController extends Controller
{
    /**
        * Show the profile for the given user.
        *
        * @param  int  $id
        * @return Response
    **/
   
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
        $skills_db = DB::table('association_skill_rel as asr');
        $skills_db=$skills_db->join('association_master as am', 'asr.association_id', '=', 'am.id');
        $skills_db=$skills_db->join('usertype as ut', 'asr.user_type', '=', 'ut.id');
        $skills_db=$skills_db->join('skill_master as sm1', 'asr.genre_id', '=', 'sm1.id');
        $skills_db=$skills_db->leftJoin('skill_master as sm2', 'asr.category_id', '=', 'sm2.id');
        $skills_db=$skills_db->select(DB::raw('asr.genre_id, sm1.name as genre_name, GROUP_CONCAT(asr.association_id) as association_ids, GROUP_CONCAT(am.association_name) as association_names, asr.category_id, sm2.name as category_name, asr.user_type, ut.typename'));
        $skills_db=$skills_db->groupBy('asr.genre_id');
        if(!empty($srch1))
        {
            $skills_db=$skills_db->where('am.association_name', 'like', "%".$srch1."%");
            $skills_db=$skills_db->orwhere('sm1.name', 'like', "%".$srch1."%");
        }
        if(!empty($sort1) && !empty($sorttype1) && (in_array(strtoupper($sorttype1),array('ASC','DESC'))))
        {
            $skills_db=$skills_db->orderBy($sort1, $sorttype1);
        }
        else
        {
            $skills_db=$skills_db->orderBy('asr.genre_id', 'asc');
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
        $pagi_skill->setPath(url(ADMINSEPARATOR.'/association'));
        $data['pagi_association']=$pagi_skill;
        $data['useinPagiAr']=$useinPagiAr;
        //***** pagination code ends
        return view('admin.association.associationlist', $data);
    }
    
    public function addassociation(Request $request,$id=0)
    {
        $requestpost_sess=$request->session()->get('requestpost_sess'); // if error has happened
        $usertype='';
        $parentcat='';
        if(!empty($requestpost_sess))
        {
            $usertype = $requestpost_sess['catag_type'];  // used when validation throws error
            $parentcat = $requestpost_sess['parent_id'];  // used when validation throws error
        }
        $data=array();
        $uesrskilltypeidAr=array();
        $uesrgenreidAr=array();
        $uesrselassoidAr=array();
        $uesrcoreassoidAr=array();
        $skill_masterAr=array();
        if(!empty($id))
        {
            $skill_masterAr = DB::table('skill_master as ls')->where('ls.id', $id)->first();
            $usertype = $skill_masterAr->catag_type;
            $parentcat = $skill_masterAr->parent_id;
            //******** fetch association id data for drop down starts
            $userselasso_db = DB::table('association_skill_rel as asr');
            $userselasso_db=$userselasso_db->select(DB::raw('asr.association_id'));
            $userselasso_db=$userselasso_db->where('asr.genre_id',$id);
            $userselasso_db= $userselasso_db->get();
            foreach($userselasso_db as $userselasso_obj)
            {
                $asids=$userselasso_obj->association_id;
                array_push($uesrselassoidAr,$asids);
            }
            //******** fetch association id data for drop down ends
        }
        //******** fetch category data for drop down starts
        $userskilltype_db = DB::table('skill_master as sct');
        $userskilltype_db=$userskilltype_db->select(DB::raw('sct.id,sct.name'));
        $userskilltype_db=$userskilltype_db->where('sct.catag_type', $usertype);
        $userskilltype_db=$userskilltype_db->where('sct.parent_id',0);
        $userskilltype_db= $userskilltype_db->get();
        $uesrskilltypeidAr['']="Select a category";
        if(!empty($userskilltype_db))
        {
            foreach($userskilltype_db as $userskilltype_obj)
            {
                $uesrskilltypeidAr[$userskilltype_obj->id]=stripslashes($userskilltype_obj->name);
            }     
        }
        //******** fetch category data for drop down ends
        //******** fetch genre data for drop down starts
        $usergenretype_db = DB::table('skill_master as sct');
        $usergenretype_db=$usergenretype_db->select(DB::raw('sct.id,sct.name'));
        $usergenretype_db=$usergenretype_db->where('sct.catag_type', $usertype);
        $usergenretype_db=$usergenretype_db->where('sct.parent_id',$parentcat);
        $usergenretype_db= $usergenretype_db->get();
        $uesrgenreidAr['']="Select a genre";
        if(!empty($usergenretype_db))
        {
            foreach($usergenretype_db as $usergenretype_obj)
            {
                $uesrgenreidAr[$usergenretype_obj->id]=stripslashes($usergenretype_obj->name);
            }     
        }
        //******** fetch genre data for drop down ends
        //******** fetch association name data for drop down starts
        $usercoreasso_db = DB::table('association_master as cras');
        $usercoreasso_db=$usercoreasso_db->select(DB::raw('cras.id,cras.association_name'));
        $usercoreasso_db=$usercoreasso_db->where('cras.status', '1');
        $usercoreasso_db= $usercoreasso_db->get();
        $uesrcoreassoidAr['']="Select association";
        if(!empty($usercoreasso_db))
        {
            foreach($usercoreasso_db as $usercoreasso_obj)
            {
                $uesrcoreassoidAr[$usercoreasso_obj->id]=stripslashes($usercoreasso_obj->association_name);
            }  
        }
        //******** fetch association name data for drop down ends
        $data['uesrskilltypeidAr']=$uesrskilltypeidAr;
        $data['uesrgenreidAr']=$uesrgenreidAr;
        $data['uesrselassoidAr']=$uesrselassoidAr;
        $data['uesrcoreassoidAr']=$uesrcoreassoidAr;
        $data['skillrow']=$skill_masterAr;
        //******** fetch user type data for drop down starts
        $usertype_db = DB::table('usertype as utypec');
        $usertype_db=$usertype_db->select(DB::raw('utypec.id,utypec.typename'));
        $usertype_db=$usertype_db->orderBy('utypec.id', 'asc');
        $usertype_db= $usertype_db->get();
        $uesrtypeidAr=array();
        $uesrtypeidAr['']=ucwords("Select user");
        if(!empty($usertype_db))
        {
            foreach($usertype_db as $usertype_obj)
            {
                $uesrtypeidAr[$usertype_obj->id]=ucwords(stripslashes($usertype_obj->typename));
            }
        }
        $data['uesrtypeidAr']=$uesrtypeidAr;
        //******** fetch user type data for drop down ends 
        return view('admin.association.associationadd', $data);
    }
    
    public function saveassociation(Request $request)
    {
        $id = addslashes(trim($request->input('skillid',0)));
        $catag_type = $request->input('catag_type','');
        $parent_id = $request->input('parent_id','0');
        $genre_id = $request->input('genre_id','0');
        $association_ids=$request->input('association_id','0');
        $datedata=date("Y-m-d H:i:s");
        $dataInsert=array();
        $chkvalid=$this->checkassociationform($request);
        if($chkvalid===true)
        {
            if(empty($id))
            {
                if(!empty($association_ids)){
                    foreach($association_ids as $ascids){
                        $dataInsert=array(
                                        'user_type'=>$catag_type,
                                        'category_id'=>$parent_id,
                                        'genre_id'=>$genre_id,
                                        'association_id'=>$ascids,
                                        'create_date'=>$datedata,
                                        'modified_date'=>$datedata
                                    );
                        $isInserted = DB::table('association_skill_rel')->insert($dataInsert);
                    }
                }
            }
            else
            {
                $ar=DB::table('association_skill_rel')->where('genre_id', '=', $id)->delete();
                if(!empty($association_ids)){
                    foreach($association_ids as $ascids){
                        $dataInsert=array(
                                        'user_type'=>$catag_type,
                                        'category_id'=>$parent_id,
                                        'genre_id'=>$genre_id,
                                        'association_id'=>$ascids,
                                        'create_date'=>$datedata,
                                        'modified_date'=>$datedata
                                    );
                        $isInserted = DB::table('association_skill_rel')->insert($dataInsert);
                    }
                }
            }
            if($isInserted >= 0 )
            {
                $request->session()->flash('admin_successmsgdata_sess', 'Association saved successfully.');
                return redirect(ADMINSEPARATOR.'/association');
            }
        }
        else
        {
            $request->session()->flash('requestpost_sess',$_REQUEST);
            if(!empty($id))
            {
                return redirect(ADMINSEPARATOR.'/associationadd/'.$id)
                ->withErrors($chkvalid)
                ->withInput();
            }
            else{
                return redirect(ADMINSEPARATOR.'/associationadd')
                ->withErrors($chkvalid)
                ->withInput();
            }
        }
        return redirect(ADMINSEPARATOR.'/association');
    }
     
    public function checkassociationform($request,$id=0,$parntsklname='')
    {
        $catag_type = $request->input('catag_type','');
        $parent_id = $request->input('parent_id','0');
        $validator = Validator::make($request->all(), [
                        'catag_type' => "required",    
                        'parent_id'=>"required",
                        'genre_id'=>"required",
                        'association_id'=>"required|max:3",
                    ],[
                        'catag_type.required'=>'* User type field is required', 
                        'parent_id.required'=>'* Category field is required',
                        'genre_id.required'=>'* Genre field is required',
                        'association_id.required'=>'* Association field is required',
                        'association_id.max'=>'* maximum 3 options can be chosen',
                    ]);
        if ($validator->fails())
        {
            return $validator;  
        }
        return true;
    }
       
    public function delassociation(Request $request,$id=0)
    {
        if(empty($id))
        {
          return redirect(ADMINSEPARATOR.'/association');
        }
        $ar=DB::table('association_skill_rel')->where('genre_id', '=', $id)->delete();
        if($ar>0)
        {
            $request->session()->flash('admin_successmsgdata_sess', 'Association data has been deleted successfully.');  
        }
        else
        {
            $request->session()->flash('admin_errormsgdata_sess', 'Association data cannot be  deleted.'); 
        }
        return redirect(ADMINSEPARATOR.'/association');
    } 

    public function commonchangecategory(Request $request)
    {
        $skillid = $request->input('userid');
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
        echo  json_encode($respAr);
    }
       
    public function commonchangegenre(Request $request)
    {
        $ascnarr=array();
        $skillid = $request->input('userid');
        $respAr=array();
        $flagdata=0;
        if(!empty($skillid) && ($skillid>0))
        {
            $skilltype_db = DB::table('skill_master as sct');
            $skilltype_db=$skilltype_db->select(DB::raw('sct.id,sct.name'));
            $skilltype_db=$skilltype_db->where('sct.parent_id',$skillid);
            $skilltype_db= $skilltype_db->get();
        }
        $assotype_db = DB::table('association_skill_rel as ac');
        $assotype_db=$assotype_db->select(DB::raw('ac.genre_id'));
        $assotype_db=$assotype_db->where('ac.category_id',$skillid);
        $assotype_db= $assotype_db->get();
        if(!empty($assotype_db))
        {
            foreach($assotype_db as $assotype_obj)
            {
                $assoobid=$assotype_obj->genre_id;
                array_push($ascnarr,$assoobid);
            }  
        }
        $skilltypeidAr=array();
        if(!empty($skilltype_db))
        {
            foreach($skilltype_db as $skilltype_obj)
            {
                $sklobid=$skilltype_obj->id;
                if (!in_array($sklobid, $ascnarr))
                {
                    $skilltypeidAr[]=array('id'=>$skilltype_obj->id,'name'=>stripslashes($skilltype_obj->name));
                }
            }  
        }
        $respAr=$skilltypeidAr;
        echo  json_encode($respAr);
    }

}