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

class AdmintransactionController extends Controller
{
    
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */

    // public function index(Request $request,$id)
    // {
    //     $data =array();
    //    echo $id;die;
    //     return view('admin.transaction.transactionlist',$data);
    // }
    
    public function index(Request $request, $id=0)
    {
        $data=array();
        $useinPagiAr=array();
           
        $srch1=addslashes(trim($request->input('srch1','')));
        $sort1=addslashes(trim($request->input('sort1','')));
        $sorttype1=addslashes(trim($request->input('sorttype1','')));
            
        if(!empty($srch1))
        {
           // echo $srch1;die;
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
        
        //**** fetch data starts
        
        // $users_db = DB::table('user_master as um');
        // $users_db=$users_db->join('group_master as gm', 'gm.creater_id', '=', 'um.id', 'left outer');
        // $users_db=$users_db->join('venue_master as vm', 'vm.creater_id', '=', 'um.id', 'left outer');
        // $users_db=$users_db->select(DB::raw('um.id,CONCAT_WS(" ",um.first_name,um.last_name) AS name,um.nickname,um.email,um.status,gm.id AS grp,vm.id AS ven'));
        // $users_db=$users_db->where('um.user_type', 3);
        // $users_db=$users_db->where('um.status','<>', 9);
        // $users_db=$users_db->where('um.id','=', 12);
       
        // if(!empty($sort1) && !empty($sorttype1) && (in_array(strtoupper($sorttype1),array('ASC','DESC'))))
        // {
              
        //       $users_db=$users_db->orderBy('um.'.$sort1, $sorttype1);
        // }
       


            $selectfields=" id,payment_for,charge_token,payment_description,payment_status,
                 total_price,payment_scheme,debitorcredit,gigmaster_id,invoice_num,user_id,create_date ";

                // $user_order_translist=" select ";        
                // $user_order_translist.=$selectfields;
                // $user_order_translist.=" from user_order as uo";
                // $user_order_translist.="  where user_id='".$id."'";
                // $user_order_translist.="  order by id desc";   


                $user_order_translist = DB::table('user_order as uo');
                $user_order_translist=$user_order_translist->select(DB::raw('uo.id,uo.payment_for,uo.charge_token,uo.payment_description,uo.payment_status,uo.total_price,uo.payment_scheme,uo.debitorcredit,uo.gigmaster_id,uo.invoice_num,uo.user_id,uo.create_date'));
                $user_order_translist=$user_order_translist->where('uo.user_id',$id);

                     if(!empty($srch1))
                    {
                    $user_order_translist=$user_order_translist->where('uo.invoice_num', 'like', "%".$srch1."%");
                         
                    }


                $user_order_translist=$user_order_translist->orderBy('uo.id','desc');


                $pagi_user=$user_order_translist;
        // echo "<pre>";
        // print_r($pagi_user);
        
            
        //**** fetch data ends
        
        //***** fetch data from settings table starts
        
            $pagelimit=1;
            $transactionrow = DB::table('settings as st')->select(DB::raw('st.id,st.record_per_page_admin'))->where('st.id', 1)->first();            
            
            if(!empty($transactionrow))
            {
                 $pagelimit=$transactionrow->record_per_page_admin;
            }
         
        //***** fetch data from settings table ends
            
        //***** pagination code starts
          
        //$pagelimit=2;
        $pagi_user = $pagi_user->paginate($pagelimit);

        $pagi_user->setPath(url(ADMINSEPARATOR.'/transctiondeatils/'.$id));

    //        echo $pagi_user->count();
    //         echo  $pagi_user->perPage();
    //         echo  $pagi_user->total();           
    //         echo "pagi=><pre>";
    //         print_r($pagi_user);
    //         echo "</pre>"; exit(); 
    //     echo "<pre>";
    // //    print_r($user_order_translist);
    //     die;



        //*********** for  total_debit starts ****************
            $debitamountdataqry=" SELECT IF(ISNULL(sum( total_price )),0, sum( total_price )) as total_debit , user_id, payment_for
            FROM `user_order`
            WHERE user_id ='".$id."'
            AND debitorcredit = 'D' ";
            $debitamountdataobjAr=DB::select($debitamountdataqry); 
        
            //             echo "debitamountdataobjar=>><pre>"; 
            //             print_r($debitamountdataobjAr); 
            //             echo "</pre>";
        
            $total_debit=0;
        
            if(!empty($debitamountdataobjAr))
            {
                
                $debitamountdataobj=$debitamountdataobjAr[0]; 
                if(!empty($debitamountdataobj))
                {
                     $total_debit=$debitamountdataobj->total_debit;
                }
            }
        
            //*********** for  total_debit ends ****************
        
        
            //*********** for  total_credit starts ****************
            $creditamountdataqry=" SELECT IF(ISNULL(sum( total_price )),0, sum( total_price )) as total_credit , user_id, payment_for
            FROM `user_order`
            WHERE user_id ='".$id."'
            AND debitorcredit = 'C' ";
            $creditamountdataobjAr=DB::select($creditamountdataqry); 
        
//             echo "creditamountdataobjAr=>><pre>"; 
//             print_r($creditamountdataobjAr); 
//             echo "</pre>";
        
            $total_credit=0;
        
            if(!empty($creditamountdataobjAr))
            {
                
                $creditamountdataobj=$creditamountdataobjAr[0]; 
                if(!empty($creditamountdataobj))
                {
                     $total_credit=$creditamountdataobj->total_credit;
                }
            }
        
            //*********** for  total_credit ends ****************
        
            $now_wallet_balance=round($total_credit-$total_debit,2); //** now wallet balance        
            //echo "<br>===now_wallet_balance==>". $now_wallet_balance;




           
        $data['pagi_user']=$pagi_user;
        $data['now_wallet_balance']=$now_wallet_balance;
        $data['total_credit']=$total_credit;
        $data['total_debit']=$total_debit;
        $data['useinPagiAr']=$useinPagiAr;
        $data['userid'] = $id;
            
        //***** pagination code ends       
          
        return view('admin.transaction.transactionlist', $data);
    }
    
  
}
?>