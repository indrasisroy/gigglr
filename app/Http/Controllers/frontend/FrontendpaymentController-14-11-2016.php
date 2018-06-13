<?php


namespace App\Http\Controllers\frontend;

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
use View;
use Mail;

class FrontendpaymentController extends Controller
{
    
public function paytowallet(Request $request)
    {
                $data=array();
                $data['data1']="hello";
                
                // return view('admin.logintemplate', $data);
                
                
                $user_id=0;
                
                if ($request->session()->has('front_id_sess'))
                {
                    $user_id= $request->session()->get('front_id_sess');
                  
                }
            
            $tot_wallet_amount=0;    
            $chkvalid=$this->checkpaymentdata($request);
            $error_message=''; $responseAr=array();
            $error_msgAr=array();
            
            if($chkvalid===true)
            {
                        $price = trim($request->input('price'));
                         $wallet_amount=0; $tot_wallet_amount=0;
                         
                         //**** fetch wallet_amount data of user from user_master starts
                         
                         $wherefar=array("id"=>$user_id);
                         
                        $userdta_db = DB::table("user_master");
                        $userdta_db=$userdta_db->select(DB::raw("id,wallet_amount"));
                        $userdta_db=$userdta_db->where($wherefar);
                                                
                        $userdta_db=$userdta_db->first();
                        
                        if(!empty($userdta_db))
                        {
                             $wallet_amount=  $userdta_db->wallet_amount;                           
                             
                        }
                         
                        $tot_wallet_amount= $wallet_amount+$price;
                         //**** fetch wallet_amount data of user from user_master ends
                         
               
                        //*** update user_master table starts
                        
                        $updateAr=array();
                        $updateAr['modified_date']=date('Y-m-d H:i:s');
                        $updateAr['wallet_amount']=$tot_wallet_amount;
                        
                        
                        $chkupd= DB::table('user_master')->where('id',$user_id) ->update($updateAr);
                        
                        //*** update user_master table ends
            }
            else
            {
                        $error_message = $chkvalid->messages();
            }
            
            
          $error_msgAr=array();
          if(!empty($error_message))
          {
            
            $error_message=json_decode(json_encode($error_message));
            
            
            foreach($error_message as $kk => $error_message_ar)
            {
               $error_msgAr[$kk]=implode("<br>",$error_message_ar);
                
                
            }
            
          }
                          
                         
            $respAr=array();
            $flagdata=0;
            if(!empty($chkupd))
            {
                           $flagdata=1;                          
                           
                   
            }
               
            $respAr['flagdata']=$flagdata;
            $respAr['error_message']=$error_msgAr;
            $respAr['tot_wallet_amount']=number_format(floatval($tot_wallet_amount),2);
        
             echo json_encode($respAr);  
    }
    
    public function checkpaymentdata($request)
           {
                $user_id=0;
                if ($request->session()->has('front_id_sess'))
                {
                        $user_id=$request->session()->get('front_id_sess'); // get session                       
                
                }
                $controlmsg="";
                
                        
              
                $validator = Validator::make($request->all(), [
               
                "price" => "required"         
                
                ],[
                   "price.required" => " Price is required"                  
                   
                ]);
                    
                        $userData=array();
                        $userData['request']=$request;
                        
                        
                        $validator->after(function($validator)  use ($userData)  {
                                    $request=$userData['request'];
                                    
                                     $price = trim($request->input('price'));
                                    

                                    if (!preg_match("/^([0-9]*){0,}(\.\d{1,2})?$/", $price))
                                  {
                                    
                                    $validatepricedata="Invalid Price";
                                    $validator->errors()->add('price', $validatepricedata);
                                     }
                        });
                    
                  // echo "validator==>"; var_dump($validator->fails()); echo "</pre>"; exit();
                
                if ($validator->fails())
                {
                    return $validator;
                   
                   //return false;
                   
                }
                    
                    
                return true;
                    
        
           }
    
     public function paymentwalletprocess(Request $request)
    {
                $data=array();
                $data['data1']="hello";
                
                // return view('admin.logintemplate', $data);
                
                
                $user_id=0;
                
                if ($request->session()->has('front_id_sess'))
                {
                    $user_id= $request->session()->get('front_id_sess');
                  
                }
            //$price = trim($request->input('price'));
         
         
                //***************** fetch settings data starts *********************
         
                $fetchtype='single'; $tablename="settings";

                $fieldnames=" pin_secret_key,pin_publishable_key,pin_liveortest,site_name,email_from,copyright_year,email_template_logo_image ";
                $wherear=array();
                $wherear['id']=1;
                $orderbyfield="id"; $orderbytype="asc";
                $limitstart=0;$limitend=0;                
                
                $fetchfrontwelcomedata=getdatafromtable($fetchtype,$tablename,$fieldnames,$wherear,$orderbyfield='',$orderbytype,$limitstart,$limitend);
                
                $pin_secret_key=''; $pin_publishable_key=''; $pin_liveortest='test';
                if(!empty($fetchfrontwelcomedata))
                {
                     
                     $pin_secret_key=stripslashes($fetchfrontwelcomedata->pin_secret_key);
                     $pin_publishable_key=stripslashes($fetchfrontwelcomedata->pin_publishable_key);
                     $pin_liveortest=stripslashes($fetchfrontwelcomedata->pin_liveortest);
                     
                     $sitename = stripslashes($fetchfrontwelcomedata->site_name);
                     $emailfrom = stripslashes($fetchfrontwelcomedata->email_from);
                     $copyright_year = stripslashes($fetchfrontwelcomedata->copyright_year);
                     $email_template_logo_image = stripslashes($fetchfrontwelcomedata->email_template_logo_image);

                     
                }
                
         
                //****************** fetch settings data ends ***********************
         
         
                //************ if user is logged in then  starts*****
                  
                $loggedin_user_email=''; $current_wallet_amount=0; $currency_country_id=0; $currency_code='';
                    if(!empty($user_id))
                   {
                        $fetchtype='single'; $tablename="user_master";
                        //$fieldnames=" first_name,middle_name,last_name,email,wallet_amount,currency ";
                        $fieldnames="address1,country,state,city,zip,first_name,middle_name,last_name,email,wallet_amount,currency "; 
                        $wherear=array();
                        $wherear['id']=$user_id;
                        $orderbyfield="id"; $orderbytype="asc";
                        $limitstart=0;$limitend=0;                

                        $fetchuserdata=getdatafromtable($fetchtype,$tablename,$fieldnames,$wherear,$orderbyfield='',$orderbytype,$limitstart,$limitend);


                        if(!empty($fetchuserdata))
                        {

                             $loggedin_user_email= stripslashes($fetchuserdata->email);
                             $current_wallet_amount=$fetchuserdata->wallet_amount;
                             $currency_country_id=$fetchuserdata->currency; // country id of the country 
                             
                        } 
                   }
                   

                //*********** if user is logged in then  ends *******
         
                //**** fetch data from location_country starts******************
                
                if(!empty($currency_country_id))
                {
                    $country_db = DB::table('location_country as lc');
                    $country_db=$country_db->select(DB::raw('lc.id,lc.currency_code,lc.currency_icon,lc.country_name'));
                    $country_db=$country_db->where('lc.id', '=',$currency_country_id);               
                    $country_db=$country_db->first();

                     if(!empty($country_db))
                     {
                         $currency_code=$country_db->currency_code;
                         $currency_icon=$country_db->currency_icon;
                         $country_name=$country_db->country_name;
                     }
                }
                //**** fetch data from location_country ends ********************
         
                      
                $amountdata=trim($request->input('amount'));
         
                //********** manipulate amount based on currency base unit according to pin payment gateway starts *****************
                $amount=convertamountbasedoncurrbaselimit($amountdata,$currency_code);
                    
                //********** manipulate amount based on currency base unit according to pin payment gateway ends *****************
                
                $card_token = trim($request->input('card_token'));   
                $logggedin_user_ip=urlencode(get_client_ip_server());
                $amount=urlencode($amount);
                $email=urlencode($loggedin_user_email);
                $currency=urlencode($currency_code);//urlencode(trim($request->input('currency','AUD')));
                $capture=urlencode("true"); 
                $description=urlencode(trim($request->input('description','Wallet respective payment')));
                
         
                //**************  calling  way to  chargecreditcard function starts ******************
         
                
         
                $postparamar=array();
                $postparamar['email'] =$email;
                $postparamar['description'] =$description;
                $postparamar['amount'] =$amount; 
                $postparamar['ip_address '] =$logggedin_user_ip; 
                $postparamar['currency'] =$currency; 
                $postparamar['capture'] =urlencode("true"); 
                $postparamar['card_token'] =$card_token; 

                $secretkeydata=$pin_secret_key;
                $liveortestmode=$pin_liveortest; // 'live' or 'test'

                $callchargecreditresp=chargecreditcard($liveortestmode,$postparamar,$secretkeydata); // call payment

                //echo "callcgargecredit==><pre>"; print_r($callcgargecredit); echo "</pre>";
         
                
                //************** calling way to  chargecreditcard function ends ******************
         
                
         
         
                //******** insert data in user_order  starts **************************
         
         
                $isInserted=0;
                if(!empty($callchargecreditresp) && ( $callchargecreditresp['flagresp']=='1' ))
                {
                        /*
                        "token":"ch_Rb2Kw2CGjn3SpK98EmpGGw","success":true,"status_message":"Success"
                        ,"amount":123,"currency":"AUD","description":"Wallet respective payment","email":"soumik@esolzmail.com"
                        ,"scheme":"visa"     */
                    
                    $amount_frm_response=$callchargecreditresp['succrespdataar']['amount'];
                    $currencycode_from_response=$callchargecreditresp['succrespdataar']['currency'];
                    
                    //********** re manipulate amount based on currency base unit according to pin payment gateway starts *****************
                    $amountdata_remanipulate=reconvertamountbasedoncurrbaselimit($amount_frm_response,$currencycode_from_response);

                    //********** re manipulate amount based on currency base unit according to pin payment gateway ends *****************
                    
                        
                    $datedata=date('Y-m-d H:i:s');
                    
                    
                    
                    $dataorderInsert=array();
                    $dataorderInsert['payment_for']="W";
                    $dataorderInsert['card_token']=$card_token;
                    $dataorderInsert['charge_token']=$callchargecreditresp['succrespdataar']['token'];
                    $dataorderInsert['payment_description']=$callchargecreditresp['succrespdataar']['description'];
                    $dataorderInsert['payment_scheme']=$callchargecreditresp['succrespdataar']['scheme'];
                    $dataorderInsert['email']=$callchargecreditresp['succrespdataar']['email'];
                    $dataorderInsert['total_price']=$amountdata_remanipulate;
                    $dataorderInsert['user_ip_address']=$logggedin_user_ip;
                    $dataorderInsert['debitorcredit']="C"; // C=> Credit , D=> Debit
                    $dataorderInsert['gigmaster_id']=0;
                    $dataorderInsert['currency']=$currencycode_from_response;
                    $dataorderInsert['payment_status']="SUCCESS";
                    $dataorderInsert['invoice_num']="INV-".time().rand(111111,999999);
                    $dataorderInsert['user_id']=$user_id;
                    $dataorderInsert['create_date']=$datedata;
                    $dataorderInsert['modified_date']=$datedata;
                    //*** insert  query
                    $isInserted = DB::table('user_order')->insert($dataorderInsert);

                    /*Last Insert id*/
                    $isInserted = DB::getPdo()->lastInsertId();
                }
         
               
         
                //******** insert data in user_order ends ***************************
         
         
         
                //*** update user_master table starts ******************************
                        
                        $tot_wallet_amount=0;
                        if(!empty($isInserted))
                        {
                            $tot_wallet_amount=$current_wallet_amount+$amountdata_remanipulate;
                            $updateAr=array();
                            $updateAr['modified_date']=date('Y-m-d H:i:s');
                            $updateAr['wallet_amount']=$tot_wallet_amount;


                            $chkupd= DB::table('user_master')->where('id',$user_id) ->update($updateAr);
                        }
                       
                        
               //*** update user_master table ends *********************************
               
               //******* sending mail to user start********//               
                        
                        $bsurl = url('/');
                  
                        $logoIMG = asset('public/upload/settings-image/source-file/'.$email_template_logo_image);
                        
                        if(stripslashes($fetchuserdata->middle_name)!=''){
                                    $full_user_name = stripslashes($fetchuserdata->first_name)." ".stripslashes($fetchuserdata->middle_name)." ".stripslashes($fetchuserdata->last_name);            
                        }else{
                                    $full_user_name = stripslashes($fetchuserdata->first_name)." ".stripslashes($fetchuserdata->last_name);
                        }
                        
                        $location_state_details = DB::table('location_state')->where('id',stripslashes($fetchuserdata->state))->first();
                        $state_name = $location_state_details->state_name;
                        
                        $replacefrom =array('{REASON}','{COUNTRY}','{STATE}','{PINCODE}','{CITY}','{ADDRESS}','{DATE}','{INV_ID}','{USER}','{AMOUNT}','{CURRENCY_ICON}','{SITENAME}','{YEAR}','{BASE_URL}','{LOGO_IMG}','{ADMINMAIL}');
                        
                        $replaceto =array($callchargecreditresp['succrespdataar']['description'],$country_name,$state_name,stripslashes($fetchuserdata->zip),stripslashes($fetchuserdata->city),stripslashes($fetchuserdata->address1),date('Y-m-d'),$dataorderInsert['invoice_num'],ucfirst($full_user_name),$amountdata_remanipulate,$currency_icon,$sitename,$copyright_year,$bsurl,$logoIMG,$emailfrom);
                        
                        mailsnd($Temid=28,$replacefrom,$replaceto,$callchargecreditresp['succrespdataar']['email']);
                        
               
               //******* sending mail to user end********//
                $respdataAr=array();
                $respdataAr['paymentresp']=$callchargecreditresp;
                $respdataAr['tot_wallet_amount']=$tot_wallet_amount;
         
                echo json_encode($respdataAr);
        
    }
    
     public function paymentsuccess(Request $request)
    {
                $data=array();
                $data['data1']="hello";
                
                // return view('admin.logintemplate', $data);
                
                
                $user_id=0;
                
                if ($request->session()->has('front_id_sess'))
                {
                    $user_id= $request->session()->get('front_id_sess');
                  
                }
            //$price = trim($request->input('price'));
         
         
         echo "ddddd";
         
         $chargresp=chargecreditcard($liveortestmode='test',$postparamar=array(),$secretkeydata='');
         echo "<pre>"; print_r($chargresp);echo "<pre>";
           
    }
    
    public function showtransactionlist(Request $request)
    {
                
                
                if ($request->session()->has('front_id_sess'))
                {
                    $user_id= $request->session()->get('front_id_sess');
                  
                }
        
             $selectfields=" id,payment_for,charge_token,payment_description,payment_status,
                 total_price,payment_scheme,debitorcredit,gigmaster_id,invoice_num,user_id,create_date ";

                $user_order_translist=" select ";        
                $user_order_translist.=$selectfields;
                $user_order_translist.=" from user_order as uo";
                $user_order_translist.="  where user_id='".$user_id."'";
                $user_order_translist.="  order by id desc";        
        
                $fetch_user_trans=DB::select($user_order_translist);  
        
            //**** fetch  settings - starts
                
                $fetchtype='single'; $tablename="settings";
                $fieldnames=" default_radius,max_radius_limit,record_per_page ";
                $wherear=array();
                $wherear['id']=1;
                $orderbyfield="id"; $orderbytype="asc";
                $limitstart=0;$limitend=0;                
                
                $fetchfrontwelcomedata=getdatafromtable($fetchtype,$tablename,$fieldnames,$wherear,$orderbyfield='',$orderbytype,$limitstart,$limitend);
                
                $default_radius=0; $max_radius_limit=100; $record_per_page_data=1;
                if(!empty($fetchfrontwelcomedata))
                {
                     
                    
                     $record_per_page_data=$fetchfrontwelcomedata->record_per_page;
                }
               
                
           //**** fetch  from settings - ends
        
        
           
        
        
        
            //****** for pagination starts****************************************
            
       
                $totaldata=0; //*** total count data
                if(!empty($fetch_user_trans))
                {
                      $totaldata=count($fetch_user_trans);
                }



            //**** calculate total pages starts

            $record_per_page=$record_per_page_data;
            $record_per_page=(empty($record_per_page)==true)?1:$record_per_page;

            //$record_per_page=1;
            $totpages=ceil($totaldata/$record_per_page);

            //**** calculate total pages ends


             $pagenum=  $request->input('pagenum','1') ; $startlimit=0; 
                if(!empty($pagenum))
                {
                            if($pagenum>1)
                            {
                                        $startlimit=($pagenum-1)*($record_per_page);
                            }
                }

               // $testme="==pagenum=>".$pagenum."===startlimit=>".$startlimit;
        
                $user_order_translist_lim=$user_order_translist." limit ".$startlimit.",".$record_per_page;                
                $fetch_user_trans_lim=DB::select($user_order_translist_lim);
        
        
                


            //*** call pagination starts

           // echo "=main_srch_union_lim=>$$$$$ ".$main_srch_union_lim." $$$$$"; 

            $reload="";
            $page=$pagenum;$tpages=$totpages;$ajaxstatus=1;

            $pagination_link=paginatecustom($reload, $page, $tpages,$ajaxstatus);

            //*** call pagination ends
            
            
            
        //****** for pagination ends*************************************************
        
        
         //*** get view data content starts*************************
            $data['user_trans_data']=$fetch_user_trans_lim;
            $view_obj = View::make('front.payment.ajax.transactionlist',$data);
            $ep_view_contents = $view_obj->render(); //echo $ep_view_contents;
            //*** get view data content ends***************************
        
        
            //*********** for  total_debit starts ****************
            $debitamountdataqry=" SELECT IF(ISNULL(sum( total_price )),0, sum( total_price )) as total_debit , user_id, payment_for
            FROM `user_order`
            WHERE user_id ='".$user_id."'
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
            WHERE user_id ='".$user_id."'
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
        
            
        
            $respar=array();        
            $respar['transactionresp']=$ep_view_contents;
            $respar['now_wallet_balance']=$now_wallet_balance;
            $respar['total_credit']=$total_credit;
            $respar['total_debit']=$total_debit;
        
            $respar['pagination_link']=$pagination_link;         
        
        
        
            echo json_encode($respar);
    }
    
    
    
        
          public function paytobank(Request $request)
    {
                $data=array();
                $data['data1']="hello";
                
                // return view('admin.logintemplate', $data);
                
                
                $user_id=0;
                
                if ($request->session()->has('front_id_sess'))
                {
                    $user_id= $request->session()->get('front_id_sess');
                  
                }
            //$price = trim($request->input('price'));
         
         
                //***************** fetch settings data starts *********************
         
                $fetchtype='single'; $tablename="settings";


                $fieldnames=" pin_secret_key,pin_publishable_key,pin_liveortest ";
                $fieldnames=" pin_secret_key,pin_publishable_key,pin_liveortest,site_name,email_from,copyright_year,email_template_logo_image ";
                $wherear=array();
                $wherear['id']=1;
                $orderbyfield="id"; $orderbytype="asc";
                $limitstart=0;$limitend=0;                
                
                $fetchfrontwelcomedata=getdatafromtable($fetchtype,$tablename,$fieldnames,$wherear,$orderbyfield='',$orderbytype,$limitstart,$limitend);
                
                $pin_secret_key=''; $pin_publishable_key=''; $pin_liveortest='test';
                if(!empty($fetchfrontwelcomedata))
                {
                     
                     $pin_secret_key=stripslashes($fetchfrontwelcomedata->pin_secret_key);
                     $pin_publishable_key=stripslashes($fetchfrontwelcomedata->pin_publishable_key);
                     $pin_liveortest=stripslashes($fetchfrontwelcomedata->pin_liveortest);
                     
                     
                     $sitename = stripslashes($fetchfrontwelcomedata->site_name);
                     $emailfrom = stripslashes($fetchfrontwelcomedata->email_from);
                     $copyright_year = stripslashes($fetchfrontwelcomedata->copyright_year);
                     $email_template_logo_image = stripslashes($fetchfrontwelcomedata->email_template_logo_image);
                     
                }
                
         
                //****************** fetch settings data ends ***********************
         
         
                //************ if user is logged in then  starts*****
                  
                $loggedin_user_email=''; $current_wallet_amount=0; $currency_country_id=0; $currency_code='';
                $first_name='';$last_name='';
              
                    if(!empty($user_id))
                   {
                        $fetchtype='single'; $tablename="user_master";
                        $fieldnames=" email,wallet_amount,currency,first_name,last_name,middle_name ";
                        $wherear=array();
                        $wherear['id']=$user_id;
                        $orderbyfield="id"; $orderbytype="asc";
                        $limitstart=0;$limitend=0;                

                        $fetchuserdata=getdatafromtable($fetchtype,$tablename,$fieldnames,$wherear,$orderbyfield='',$orderbytype,$limitstart,$limitend);


                        if(!empty($fetchuserdata))
                        {

                             $loggedin_user_email= stripslashes($fetchuserdata->email);
                             $current_wallet_amount=$fetchuserdata->wallet_amount;
                             $currency_country_id=$fetchuserdata->currency; // country id of the country 
                             $first_name=stripslashes($fetchuserdata->first_name);
                             $last_name=stripslashes($fetchuserdata->last_name);
                             
                        } 
                   }
                //*********** if user is logged in then  ends *******
         
                //**** fetch data from location_country starts******************
                
                if(!empty($currency_country_id))
                {
                    $country_db = DB::table('location_country as lc');
                    $country_db=$country_db->select(DB::raw('lc.id,lc.currency_code,lc.currency_icon'));
                    $country_db=$country_db->where('lc.id', '=',$currency_country_id);               
                    $country_db=$country_db->first();

                     if(!empty($country_db))
                     {
                         $currency_code=$country_db->currency_code;
                         $currency_icon=$country_db->currency_icon;
                     }
                }
                //**** fetch data from location_country ends ********************
         
                 $flagrespWithdrawl=0;  $tot_wallet_amount=0;
                $flagresp=0;
                $flagresp2=0;
                $flagresp3=0;     
                $ultimate_succeeded=''; $transfer_token=''; $recipient_token='';
                $message=''; $bank_acc_token=''; 
              
              
                $account_holder_name=trim($request->input('account_holder_name')); 
                $bank_account_number=trim($request->input('bank_account_number')); 
                $bank_state_branch_code=trim($request->input('bank_state_branch_code')); 
                $bank_transfer_amount=trim($request->input('bank_transfer_amount')); 
              
              
                //****** server side  validation starts **********
              
                    $allowbankpaymntflag=true;
              
                    $validation_err_msg='';
                        
                    $pattaccntholdername="/^[a-zA-Z ]+$/";           
                    $chk_account_holder_name =preg_match($pattaccntholdername, $account_holder_name); 
                    
                    if($chk_account_holder_name==false)
                    {
                        $allowbankpaymntflag=false;
                        $validation_err_msg=$validation_err_msg."<p>Invalid name </p>";
                    } 
                        
                        
                    $pattbsbcode="/^[0-9]{1,6}$/";
                    
                    $chk_bank_state_branch_code =preg_match($pattbsbcode, $bank_state_branch_code); 
                     
                    if($chk_bank_state_branch_code==false)
                    {
                        $allowbankpaymntflag=false;
                        $validation_err_msg=$validation_err_msg."<p>Invalid bsb code</p>";
                    }   
                        
                        
                        
                    $pattbnkaccnt="/^[0-9]{1,9}$/";
                   
                    $chk_bank_account_number =  preg_match($pattbnkaccnt, $bank_account_number); 
                    
                    if($chk_bank_account_number==false)
                    {
                        $allowbankpaymntflag=false;
                        $validation_err_msg=$validation_err_msg."<p>Invalid account number </p>";
                    }   
                        
                         
                    $pattpaymntammount = "/^\d+(\.\d{1,2})*$/"; 
                    
                    $chk_bank_transfer_amount = preg_match($pattpaymntammount, $bank_transfer_amount); 
                    // console.log("chk_bank_transfer_amount==>"+chk_bank_transfer_amount);  
                    if($chk_bank_transfer_amount==false)
                    {
                        $allowbankpaymntflag=false;
                        $validation_err_msg=$validation_err_msg."<p>Invalid amount provided</p>";
                    }
              
              
                //****** server side  validation ends **********
                
         
                //********** manipulate amount based on currency base unit according to pin payment gateway starts *****************
                $amount=convertamountbasedoncurrbaselimit($bank_transfer_amount,$currency_code);
                    
                //********** manipulate amount based on currency base unit according to pin payment gateway ends *****************
                
                 
                $logggedin_user_ip=urlencode(get_client_ip_server());
                $amount=urlencode($amount);
                $email=$loggedin_user_email;
                $currency=urlencode($currency_code);//urlencode(trim($request->input('currency','AUD')));
               
                $description="Transferred to Bank";
                
                $secretkeydata=$pin_secret_key;
                $liveortestmode=$pin_liveortest; // 'live' or 'test'

               
              //***** now**************************************************************************************
               
              
               
                $add_charge_amt=0; $deduct_perc_amt=2;
                
                $deduct_amt_from_wallet=0;
              
                if($current_wallet_amount>0)
                {
                
                        $add_charge_amt=($deduct_perc_amt/100)*$bank_transfer_amount;
                    
                        $deduct_amt_from_wallet=round($bank_transfer_amount+$add_charge_amt,2);
                }
              
              
              
         //********** check withdrawl amount is available in your wallet starts
        
              
              if($allowbankpaymntflag==true)
              {
                  
              
                  if( ($current_wallet_amount>0) && ($deduct_amt_from_wallet <= $current_wallet_amount)) 
                  {
                      $flagrespWithdrawl=1;
                  }
                  else
                  {
                      $message=" Insufficient fund in your wallet";
                  }
              }
              else
              {
                  $message=$validation_err_msg;
              }
              
         //********** check withdrawl amount is available in your wallet ends  
              
       
              
        if($flagrespWithdrawl==1)
        {
            
           
              
            $postbankaccountparamar['publishable_api_key'] = $pin_publishable_key;
            $postbankaccountparamar['name'] = urlencode($account_holder_name);
            $postbankaccountparamar['bsb'] = urlencode($bank_state_branch_code);
            $postbankaccountparamar['number'] = urlencode($bank_account_number);



            $bank_account_server_output= createbankaccounttoken($liveortestmode,$postbankaccountparamar);      

            $flagresp=$bank_account_server_output['flagresp'];
        
        
        
       // echo "baa result=><pre>"; print_r($bank_account_server_output); echo "<pre>";      
        
       
              
              
        if($flagresp=='1')
        {
            $bank_acc_token=$bank_account_server_output['succrespdataar']['token'];
            
            
                if(!empty($bank_acc_token))
                {
                    
                        $postrecipientsparamar=array();
                        $postrecipientsparamar['email'] = urlencode($email);
                        $postrecipientsparamar['bank_account_token'] = $bank_acc_token;
                        $postrecipientsparamar['name'] = $first_name." ".$last_name;

                        
                    
                        $recipienttopkenrespAr=createbankaccountrecipienttoken($liveortestmode,$postrecipientsparamar,$secretkeydata);       
                        //echo "recipienttopkenrespAr=><pre>"; print_r($recipienttopkenrespAr); echo "<pre>";  
                        $flagresp2=$recipienttopkenrespAr['flagresp'];
                        $recipient_token=$recipienttopkenrespAr['succrespdataar']['token'];
                    
                        if($flagresp2=='1')
                        {
                            $postransferamountparamar=array();
                            $postransferamountparamar['description'] = urlencode($description);
                            //$postparamar['number'] = "987654321";
                            $postransferamountparamar['amount'] = $amount;
                            $postransferamountparamar['currency'] = $currency_code;
                            $postransferamountparamar['recipient'] = $recipient_token;
                            
                        $tansferamounttorecipientresp=transferamounttorecipient($liveortestmode,$postransferamountparamar,$secretkeydata);
                            
                           // echo "tansferamounttorecipientresp=><pre>"; print_r($tansferamounttorecipientresp); echo "<pre>"; 
                            $flagresp3=$tansferamounttorecipientresp['flagresp'];
                           
                            
                            if($flagresp3=='1')
                            {
                                 $transfer_token=$tansferamounttorecipientresp['succrespdataar']['token'];
                                $status=$tansferamounttorecipientresp['succrespdataar']['status'];
                                $ultimate_succeeded=$status;
                            }
                            else
                            {
                                $message=$tansferamounttorecipientresp['message'];
                            }
                            
                            
                            
                        
                        }
                    else
                    {
                        $message=$recipienttopkenrespAr['message'];
                    }
                    
                }
            
        }
        else
        {
            $message=$bank_account_server_output['message'];
            
        }
        
         
                

                if($flagresp3=='1')
                {

                    //******** insert data in user_order  starts **************************


                            $isInserted=0;


                            $datedata=date('Y-m-d H:i:s');



                            $dataorderInsert=array();
                            $dataorderInsert['payment_for']="BP";
                            $dataorderInsert['bank_transfer_token']=$transfer_token;
                            $dataorderInsert['bank_recipient_token']=$recipient_token;

                            $dataorderInsert['bank_account_holder_name']=$account_holder_name;
                            $dataorderInsert['bank_account_number']=$bank_account_number;
                            $dataorderInsert['bank_state_branch_code']=$bank_state_branch_code;
                            $dataorderInsert['bank_transfer_amount']=$deduct_amt_from_wallet; //$bank_transfer_amount


                            $dataorderInsert['payment_description']=$description;

                            $dataorderInsert['email']=$email;
                            $dataorderInsert['total_price']=$deduct_amt_from_wallet;
                            $dataorderInsert['user_ip_address']=$logggedin_user_ip;
                            $dataorderInsert['debitorcredit']="D"; // C=> Credit , D=> Debit
                            $dataorderInsert['gigmaster_id']=0;
                            $dataorderInsert['currency']=$currency_code;
                            $dataorderInsert['payment_status']="SUCCESS";
                            $dataorderInsert['invoice_num']="INV-".time().rand(111111,999999);
                            $dataorderInsert['user_id']=$user_id;
                            $dataorderInsert['create_date']=$datedata;
                            $dataorderInsert['modified_date']=$datedata;
                            //*** insert  query
                            $isInserted = DB::table('user_order')->insert($dataorderInsert);

                            /*Last Insert id*/
                            $isInserted=DB::getPdo()->lastInsertId();




                        //******** insert data in user_order ends ***************************



                        //*** update user_master table starts ******************************


                                if(!empty($isInserted))
                                {
                                    $tot_wallet_amount=round($current_wallet_amount-$deduct_amt_from_wallet,2); //$bank_transfer_amount
                                    $updateAr=array();
                                    $updateAr['modified_date']=date('Y-m-d H:i:s');
                                    $updateAr['wallet_amount']=$tot_wallet_amount;


                                    $chkupd= DB::table('user_master')->where('id',$user_id) ->update($updateAr);
                                }


                       //*** update user_master table ends *********************************
                        //******* sending mail to user start********//
                        
                        
                        if($chkupd){
                                    $bsurl = url('/');
                              
                                    //$logoIMG = asset('upload/email-template/source-file/footer-logo.png');
                                    $logoIMG = asset('public/upload/settings-image/source-file/'.$email_template_logo_image);
                                    
                                    if(stripslashes($fetchuserdata->middle_name)!=''){
                                                $full_user_name = stripslashes($fetchuserdata->first_name)." ".stripslashes($fetchuserdata->middle_name)." ".stripslashes($fetchuserdata->last_name);            
                                    }else{
                                                $full_user_name = stripslashes($fetchuserdata->first_name)." ".stripslashes($fetchuserdata->last_name);
                                    }
                                    
                                    
                                    $replacefrom =array('{USER}','{AMOUNT}','{CURRENCY_CODE}','{CURRENCY_ICON}','{SITENAME}','{YEAR}','{BASE_URL}',"{LOGO_IMG}");
                                    
                                    $replaceto =array(ucfirst($full_user_name),$deduct_amt_from_wallet,$currency_code,$currency_icon,$sitename,$copyright_year,$bsurl,$logoIMG);
                                    mailsnd($Temid=27,$replacefrom,$replaceto,$email);         
                        }

                        
                        //******* sending mail to user end********//
                }
         

          }
              
        $respar=array();
        $respar['flagresp']=$flagresp3;//."--".$flagresp2."--".$flagresp;
              
        $respar['message']=$message;
        $respar['bank_trannsfer_token']=$transfer_token;
        $respar['updated_wallet_amount']=$tot_wallet_amount;
              
		echo json_encode($respar);
         
        
              
       //***** now**************************************************************************************
         
                
         
         
               
        
    }
    
    
   
}