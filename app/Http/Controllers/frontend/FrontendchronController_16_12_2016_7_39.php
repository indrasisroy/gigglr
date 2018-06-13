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
use Cookie;
use Response;
use View;
use Mail;

class FrontendchronController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */

    
    public function index(Request $request)
    {
             $sessnID =  $request->session()->get('front_id_sess');
             
    }
   
     public function releaseescrowpayment(Request $request)
    {
          //******* fetch data from settings table starts *****
         
            $referral_commission=0; $site_commission=0;
         
            $logggedin_user_ip = get_client_ip_server();
         
            $wherefar=array("id"=>1);
         
            $userdta_db = DB::table("settings");
            $userdta_db=$userdta_db->select(DB::raw("referral_commission,site_commission"));
            $userdta_db=$userdta_db->where($wherefar);
            $userdta_db=$userdta_db->first();
         
            //echo "===userdta_db=><pre>";  
            //print_r($userdta_db);
            //echo "</pre>"; 
         
             if(!empty($userdta_db))
             {
                     $referral_commission=$userdta_db->referral_commission;
                     $site_commission=$userdta_db->site_commission;
             }
         
            //exit();
         //******* fetch data from settings table ends ********
         
         
            $artist_qry=" SELECT
            ggm.`id`,ggm.`giguniqueid`,ggm.`total_amount`,ggm.`artist_id`,ggm.`type_flag`,ggm.`booker_id`,ggm.`booking_status`,ggm.`dispute_flag`,ggm.`payment_flag`,ggm.`event_type`,ggm.`booking_cancellation_fee`,ggm.`artist_security_deposit`,now( ) as just_now_datetime ,ggm.`event_end_date_time`, (time_to_sec(timediff(now( ), `event_end_date_time`)) / 3600 ) as hours_event_passed

            FROM `gig_master` as ggm  

           
            WHERE

            ggm.`event_end_date_time` < now()

            AND

            ggm.`booking_status`=1

            AND

            ggm.`dispute_flag`=0

            AND

            ggm.`payment_flag` IN (2)

            having hours_event_passed >24


            ORDER BY ggm.`id` DESC  

            ";
         
            $releasegigrelateddataAr=DB::select($artist_qry); 
        
                       // echo "releasegigrelateddataAr=>><pre>"; 
                       // print_r($releasegigrelateddataAr); 
                       // echo "</pre>";
         
         
         
            if(!empty($releasegigrelateddataAr))
            {
                foreach($releasegigrelateddataAr as $releasegigrelateddataobj)
                {
                    
                        $event_gig_id=$releasegigrelateddataobj->id;
                        $giguniqueid=$releasegigrelateddataobj->giguniqueid;
                        $artist_id=$releasegigrelateddataobj->artist_id;
                        $type_flag=$releasegigrelateddataobj->type_flag;
                        $booker_id=$releasegigrelateddataobj->booker_id;
                        $dispute_flag=$releasegigrelateddataobj->dispute_flag;
                        $payment_flag=$releasegigrelateddataobj->payment_flag;
                        $event_type=$releasegigrelateddataobj->event_type;
                        $just_now_datetime=$releasegigrelateddataobj->just_now_datetime;
                        $event_end_date_time=$releasegigrelateddataobj->event_end_date_time;
                        $hours_event_passed=$releasegigrelateddataobj->hours_event_passed;
                        $total_amount=$releasegigrelateddataobj->total_amount;
                        
                        $booking_cancellation_fee=$releasegigrelateddataobj->booking_cancellation_fee;
                        $artist_security_deposit=$releasegigrelateddataobj->artist_security_deposit;
                    
                        
                        
                    
                    
                        if(!empty($artist_id) && ($type_flag==1))
                        {
                            
                //****** insert row in user_order table for atist to  make payment credited to artist wallet starts ******
                 
                            //*** fetch data of artist from user_master table starts*********
                            
                            $user_id=$artist_id; $email='';$artistname=''; $wallet_amount=0; $amnt_added_to_wallet=0;
                            $wallet_amt_updtd=0;
                            
                            $wherefar=array("id"=>$user_id);

                            $userdta_db = DB::table("user_master");
                            $userdta_db=$userdta_db->select(DB::raw("id,wallet_amount,email,nickname"));
                            $userdta_db=$userdta_db->where($wherefar);

                            $userdta_db=$userdta_db->first();

                            if(!empty($userdta_db))
                            {
                                $wallet_amount=  $userdta_db->wallet_amount;  
                                $email= $userdta_db->email;   
                                $artistname= $userdta_db->nickname;                                 
                                

                            }
                            
                            //*** fetch data of artist from user_master table ends********
                            
                             $amnt_added_to_wallet=$total_amount; // amount that gets added to Artists wallet
                            
                             
                            //***** manipulate amnt_added_to_wallet if security money   if credited starts ***
                        
                    
                            if($artist_security_deposit >0)
                            {
                                $amnt_added_to_wallet=$total_amount-$artist_security_deposit;
                            }

                            
                        
                        
                            //***** manipulate amnt_added_to_wallet if security money   if credited ends ***
                            
                            
                            
                            //*********** calculate total amount to update wallet_amount starts ********
                            
                             $site_com_debitedfrom_wallet=0;     
                            $site_com_debitedfrom_wallet=($site_commission/100)*$total_amount;
                            $site_com_debitedfrom_wallet=round(floatval($site_com_debitedfrom_wallet),2);
                            
                            
                            $wallet_amt_updtd=($amnt_added_to_wallet+$wallet_amount)-$site_com_debitedfrom_wallet;
                             $wallet_amt_updtd=round(floatval($wallet_amt_updtd),2);
                            //*********** calculate total amount to update wallet_amount ends ********
                            
                            $isInserted=0;

                            $datedata=date('Y-m-d H:i:s');                            

                            $description="Payment released to your wallet for ".$giguniqueid;

                                                        $dataorderInsert=array();
                                                        $dataorderInsert['payment_for']="APPR";
                                                       
                                                        
                                                        $dataorderInsert['payment_description']=$description;
                                                        $dataorderInsert['email']=$email;
                                                        $dataorderInsert['total_price']=$amnt_added_to_wallet;
                                                        $dataorderInsert['user_ip_address']=$logggedin_user_ip;
                                                        $dataorderInsert['debitorcredit']="C"; // C=> Credit , D=> Debit
                                                        $dataorderInsert['gigmaster_id']=$event_gig_id;
                                                        
                                                        $dataorderInsert['invoice_num']="INV-".time().rand(111111,999999);
                                                        $dataorderInsert['user_id']=$user_id;
                                                        $dataorderInsert['create_date']=$datedata;
                                                        $dataorderInsert['modified_date']=$datedata;
                            
                           // echo "1 dataorderInsert=><pre>"; print_r($dataorderInsert); echo "<pre>";
                                                       
                                                       $isInserted = DB::table('user_order')->insert($dataorderInsert);
                            
                                                       $isInserted=DB::getPdo()->lastInsertId();



                //****** insert row in user_order table for atist to  make payment credited to artist wallet ends ******
                            
                //****** insert row in user_order table for site commission debited to artist wallet starts ******
                            
                           
                            
                            $isInserted=0;

                            $datedata=date('Y-m-d H:i:s');                            

                            $description="Site commission debited from your wallet for ".$giguniqueid;
                            
                            
                            

                                                        $dataorderInsert=array();
                                                        $dataorderInsert['payment_for']="SCP";
                                                       
                                                        
                                                        $dataorderInsert['payment_description']=$description;
                                                        $dataorderInsert['email']=$email;
                                                        $dataorderInsert['total_price']=$site_com_debitedfrom_wallet;
                                                        $dataorderInsert['user_ip_address']=$logggedin_user_ip;
                                                        $dataorderInsert['debitorcredit']="D"; // C=> Credit , D=> Debit
                                                        $dataorderInsert['gigmaster_id']=$event_gig_id;
                                                        
                                                        $dataorderInsert['invoice_num']="INV-".time().rand(111111,999999);
                                                        $dataorderInsert['user_id']=$user_id;
                                                        $dataorderInsert['create_date']=$datedata;
                                                        $dataorderInsert['modified_date']=$datedata;
                                                       
                                                       $isInserted = DB::table('user_order')->insert($dataorderInsert);
                            
                                                       $isInserted=DB::getPdo()->lastInsertId();  
                            
                            //echo "2 dataorderInsert=><pre>"; print_r($dataorderInsert); echo "<pre>";
                            
                            
                //****** insert row in user_order table for site commission debited to artist wallet starts ******          

                //****** update row in user_master table for atist to  make update wallet_amount data starts ******
                            
                                                        $updateAr=array();
                                                        $updateAr['modified_date']=date('Y-m-d H:i:s');
                                                        $updateAr['wallet_amount']=$wallet_amt_updtd;
                            
                                                       $chkupd= DB::table('user_master')->where('id',$user_id)->update($updateAr);
                            
                          //echo "wallet_amt_updtd=><pre>"; print_r($updateAr); echo "<pre>"; 

                //****** update row in user_master table for atist to  make update wallet_amount data ends ******

                //************ Email send function for artist starts here
                                                       $extradata='';

                $artistescrowedamount = $this->artistgroupvenuecreditanddebitemail($giguniqueid,$event_gig_id,$artistname,$email,'$'.$amnt_added_to_wallet,'$'.$site_com_debitedfrom_wallet,$extradata);

                //************ Email send function for artist ends here


                //*** insert row in user_order table for (referrer)atist to  make  commision credited to his wallet starts ***
                            
                            $wherefar=array("user_id"=>$user_id);

                            $userdta_db = DB::table("referral_email");
                            $userdta_db=$userdta_db->select(DB::raw("id,user_id,emailid,referred_date,referral_expiry_date,DATEDIFF( now( ) , DATE_FORMAT( referred_date , '%Y-%m-%d %H:%i:%s' ) ) as refer_date_days_used,referrer_userid "));
                            $userdta_db=$userdta_db->where($wherefar);
                            $userdta_db=$userdta_db->havingRaw('refer_date_days_used <=365');
                            $userdta_db=$userdta_db->first();
                            
                            //echo "*************userdta_db=>><pre>"; 
                            //print_r($userdta_db); 
                            //echo "</pre>*****************";

                            if(!empty($userdta_db))
                            {
                                $referred_date=  $userdta_db->referred_date;  
                                $referral_expiry_date= $userdta_db->referral_expiry_date; 
                                $referrer_userid=$userdta_db->referrer_userid; 
                                
                                
                                //*** fetch data of artist from user_master table starts*********

                                $user_id=$referrer_userid; $email=''; $wallet_amount=0; $amnt_added_to_wallet=0;
                                $wallet_amt_updtd=0;

                                $wherefar=array("id"=>$user_id);

                                $userdta_db = DB::table("user_master");
                                $userdta_db=$userdta_db->select(DB::raw("id,wallet_amount,email"));
                                $userdta_db=$userdta_db->where($wherefar);

                                $userdta_db=$userdta_db->first();

                                if(!empty($userdta_db))
                                {
                                    $wallet_amount=  $userdta_db->wallet_amount;  
                                    $email= $userdta_db->email;                                 


                                }

                                //*** fetch data of artist from user_master table ends********

                                 $ref_com_creditedtorerrer_wallet=($referral_commission/100)*$total_amount;
                                $ref_com_creditedtorerrer_wallet=round(floatval($ref_com_creditedtorerrer_wallet),2);
                                
                                $amnt_added_to_wallet=$ref_com_creditedtorerrer_wallet; // amount that gets added to Artists (referrer) wallet

                                //*********** calculate total amount to update wallet_amount starts ********

                                $wallet_amt_updtd=$amnt_added_to_wallet+$wallet_amount;
                                $wallet_amt_updtd=round(floatval($wallet_amt_updtd),2);
                                //*********** calculate total amount to update wallet_amount ends ********
                                
                                
                                //********** insert data in user_order table starts *************
                                
                               
                                
                                $isInserted=0;

                                $datedata=date('Y-m-d H:i:s');                            

                                $description="Referral commission credited to your wallet for ".$giguniqueid;

                                $dataorderInsert=array();
                                $dataorderInsert['payment_for']="RC";


                                $dataorderInsert['payment_description']=$description;
                                $dataorderInsert['email']=$email;
                                $dataorderInsert['total_price']=$ref_com_creditedtorerrer_wallet;
                                $dataorderInsert['user_ip_address']=$logggedin_user_ip;
                                $dataorderInsert['debitorcredit']="C"; // C=> Credit , D=> Debit
                                $dataorderInsert['gigmaster_id']=$event_gig_id;

                                $dataorderInsert['invoice_num']="INV-".time().rand(111111,999999);
                                $dataorderInsert['user_id']=$user_id;
                                $dataorderInsert['create_date']=$datedata;
                                $dataorderInsert['modified_date']=$datedata;

                                $isInserted = DB::table('user_order')->insert($dataorderInsert);

                                $isInserted=DB::getPdo()->lastInsertId();
                                
                                //echo "3 dataorderInsert=><pre>"; print_r($dataorderInsert); echo "<pre>";
                                
                                
                                //********** insert data in user_order table ends *************   
                                
                                //****** update row in user_master table for atist to  make update wallet_amount data starts ******
                            
                                                        $updateAr=array();
                                                        $updateAr['modified_date']=date('Y-m-d H:i:s');
                                                        $updateAr['wallet_amount']=$wallet_amt_updtd;
                            
                                                        $chkupd= DB::table('user_master')->where('id',$user_id)->update($updateAr);
                                
                                                       //echo "updateAr=><pre>"; print_r($updateAr); echo "<pre>";
                            
                           

                                //****** update row in user_master table for atist to  make update wallet_amount data ends ******
                                
                                
                                
                                

                                            //************ Email send function for referer starts here

                                            $refereremail = $this->refereeremail($artistname,$email,'$'.$ref_com_creditedtorerrer_wallet);

                                            //************ Email send function for referer ends here





                                
                            }  


                            //****** update gig_master table payment_flag status to 3 mean full payment has been released starts ***
                                
                                            $updateAr=array();
                                            
                                            $updateAr['payment_flag']=3;

                                            $chkupd= DB::table('gig_master')->where('id',$event_gig_id)->update($updateAr);
                          //****** update gig_master table payment_flag status to 3 mean full payment has been released ends ***  
                            
                            
                
                //*** insert row in user_order table for (referrer)atist to  make  commision credited to his wallet ends ***
                            
                 
                        }
                        elseif(!empty($artist_id) && ($type_flag==2) )
                        {
                            
                            //*** fetch creator_id data of group from group_master table starts*********
                            $creater_id=0;                      
                            $group_id=$artist_id; 
                            $groupname='';
                            
                            $wherefar=array("id"=>$group_id);

                            $userdta_db = DB::table("group_master");
                            $userdta_db=$userdta_db->select(DB::raw("id,creater_id,nickname"));
                            $userdta_db=$userdta_db->where($wherefar);

                            $userdta_db=$userdta_db->first();

                            if(!empty($userdta_db))
                            {
                                $creater_id=  $userdta_db->creater_id;  
                                $groupname=  $userdta_db->nickname;                          

                            }
                            
                            //*** fetch creator_id data of group from group_master table ends*********
                            
                            
                            
                            
                
                            //****** insert row in user_order table for atist to  make payment credited to artist wallet starts ******
                 
                            //*** fetch data of artist from user_master table starts*********
                            
                            $user_id=$creater_id; $email=''; $wallet_amount=0; $amnt_added_to_wallet=0;$artistnickname='';
                            $wallet_amt_updtd=0;
                            
                            $wherefar=array("id"=>$user_id);

                            $userdta_db = DB::table("user_master");
                            $userdta_db=$userdta_db->select(DB::raw("id,wallet_amount,email,nickname"));
                            $userdta_db=$userdta_db->where($wherefar);

                            $userdta_db=$userdta_db->first();

                            if(!empty($userdta_db))
                            {
                                $wallet_amount=  $userdta_db->wallet_amount;  
                                $email= $userdta_db->email;                                 
                                $artistnickname = $userdta_db->nickname;

                            }
                            
                            //*** fetch data of artist from user_master table ends********
                            
                             $amnt_added_to_wallet=$total_amount; // amount that gets added to Artists wallet
                            
                            //***** manipulate amnt_added_to_wallet if security money   if credited starts ***
                        
                    
                            if($artist_security_deposit >0)
                            {
                                $amnt_added_to_wallet=$total_amount-$artist_security_deposit;
                            }

                           
                        
                        
                            //***** manipulate amnt_added_to_wallet if security money   if credited ends ***
                            
                            //*********** calculate total amount to update wallet_amount starts ********
                            
                             $site_com_debitedfrom_wallet=0;     
                            $site_com_debitedfrom_wallet=($site_commission/100)*$total_amount;
                            $site_com_debitedfrom_wallet=round(floatval($site_com_debitedfrom_wallet),2);
                            
                            
                            $wallet_amt_updtd=($amnt_added_to_wallet+$wallet_amount)-$site_com_debitedfrom_wallet;
                             $wallet_amt_updtd=round(floatval($wallet_amt_updtd),2);
                            //*********** calculate total amount to update wallet_amount ends ********
                            
                            $isInserted=0;

                            $datedata=date('Y-m-d H:i:s');                            

                            $description="Payment released to your wallet for ".$giguniqueid;

                                                        $dataorderInsert=array();
                                                        $dataorderInsert['payment_for']="APPR";
                                                       
                                                        
                                                        $dataorderInsert['payment_description']=$description;
                                                        $dataorderInsert['email']=$email;
                                                        $dataorderInsert['total_price']=$amnt_added_to_wallet;
                                                        $dataorderInsert['user_ip_address']=$logggedin_user_ip;
                                                        $dataorderInsert['debitorcredit']="C"; // C=> Credit , D=> Debit
                                                        $dataorderInsert['gigmaster_id']=$event_gig_id;
                                                        
                                                        $dataorderInsert['invoice_num']="INV-".time().rand(111111,999999);
                                                        $dataorderInsert['user_id']=$user_id;
                                                        $dataorderInsert['create_date']=$datedata;
                                                        $dataorderInsert['modified_date']=$datedata;
                            
                           // echo "1 dataorderInsert=><pre>"; print_r($dataorderInsert); echo "<pre>";
                                                       
                                                        $isInserted = DB::table('user_order')->insert($dataorderInsert);
                            
                                                        $isInserted=DB::getPdo()->lastInsertId();



                //****** insert row in user_order table for atist to  make payment credited to artist wallet ends ******
                            
                //****** insert row in user_order table for site commission debited to artist wallet starts ******
                            
                           
                            
                            $isInserted=0;

                            $datedata=date('Y-m-d H:i:s');                            

                            $description="Site commission debited from your wallet for ".$giguniqueid;
                            
                            
                            

                                                        $dataorderInsert=array();
                                                        $dataorderInsert['payment_for']="SCP";
                                                       
                                                        
                                                        $dataorderInsert['payment_description']=$description;
                                                        $dataorderInsert['email']=$email;
                                                        $dataorderInsert['total_price']=$site_com_debitedfrom_wallet;
                                                        $dataorderInsert['user_ip_address']=$logggedin_user_ip;
                                                        $dataorderInsert['debitorcredit']="D"; // C=> Credit , D=> Debit
                                                        $dataorderInsert['gigmaster_id']=$event_gig_id;
                                                        
                                                        $dataorderInsert['invoice_num']="INV-".time().rand(111111,999999);
                                                        $dataorderInsert['user_id']=$user_id;
                                                        $dataorderInsert['create_date']=$datedata;
                                                        $dataorderInsert['modified_date']=$datedata;
                                                       
                                                        $isInserted = DB::table('user_order')->insert($dataorderInsert);
                            
                                                        $isInserted=DB::getPdo()->lastInsertId();  
                            
                            //echo "2 dataorderInsert=><pre>"; print_r($dataorderInsert); echo "<pre>";
                            
                            
                //****** insert row in user_order table for site commission debited to artist wallet starts ******          

                //****** update row in user_master table for atist to  make update wallet_amount data starts ******
                            
                                                        $updateAr=array();
                                                        $updateAr['modified_date']=date('Y-m-d H:i:s');
                                                        $updateAr['wallet_amount']=$wallet_amt_updtd;
                            
                                                        $chkupd= DB::table('user_master')->where('id',$user_id)->update($updateAr);
                            
                          //echo "wallet_amt_updtd=><pre>"; print_r($updateAr); echo "<pre>"; 

                //****** update row in user_master table for atist to  make update wallet_amount data ends ******

                //************ Email send function for group starts here

                $extradata = ': for your group '.$groupname;

                $artistescrowedamount = $this->artistgroupvenuecreditanddebitemail($giguniqueid,$event_gig_id,$artistnickname,$email,'$'.$amnt_added_to_wallet,'$'.$site_com_debitedfrom_wallet,$extradata);

                //************ Email send function for group ends here


                //*** insert row in user_order table for (referrer)atist to  make  commision credited to his wallet starts ***
                            
                            $wherefar=array("user_id"=>$user_id);

                            $userdta_db = DB::table("referral_email");
                            $userdta_db=$userdta_db->select(DB::raw("id,user_id,emailid,referred_date,referral_expiry_date,DATEDIFF( now( ) , DATE_FORMAT( referred_date , '%Y-%m-%d %H:%i:%s' ) ) as refer_date_days_used,referrer_userid "));
                            $userdta_db=$userdta_db->where($wherefar);
                            $userdta_db=$userdta_db->havingRaw('refer_date_days_used <=365');
                            $userdta_db=$userdta_db->first();
                            
                            //echo "*************userdta_db=>><pre>"; 
                            //print_r($userdta_db); 
                            //echo "</pre>*****************";

                            if(!empty($userdta_db))
                            {
                                $referred_date=  $userdta_db->referred_date;  
                                $referral_expiry_date= $userdta_db->referral_expiry_date; 
                                $referrer_userid=$userdta_db->referrer_userid; 
                                
                                
                                //*** fetch data of artist from user_master table starts*********

                                $user_id=$referrer_userid; $email=''; $wallet_amount=0; $amnt_added_to_wallet=0;
                                $wallet_amt_updtd=0;

                                $wherefar=array("id"=>$user_id);

                                $userdta_db = DB::table("user_master");
                                $userdta_db=$userdta_db->select(DB::raw("id,wallet_amount,email"));
                                $userdta_db=$userdta_db->where($wherefar);

                                $userdta_db=$userdta_db->first();

                                if(!empty($userdta_db))
                                {
                                    $wallet_amount=  $userdta_db->wallet_amount;  
                                    $email= $userdta_db->email;                                 


                                }

                                //*** fetch data of artist from user_master table ends********

                                 $ref_com_creditedtorerrer_wallet=($referral_commission/100)*$total_amount;
                                $ref_com_creditedtorerrer_wallet=round(floatval($ref_com_creditedtorerrer_wallet),2);
                                
                                $amnt_added_to_wallet=$ref_com_creditedtorerrer_wallet; // amount that gets added to Artists (referrer) wallet

                                //*********** calculate total amount to update wallet_amount starts ********

                                $wallet_amt_updtd=$amnt_added_to_wallet+$wallet_amount;
                                $wallet_amt_updtd=round(floatval($wallet_amt_updtd),2);
                                //*********** calculate total amount to update wallet_amount ends ********
                                
                                
                                //********** insert data in user_order table starts *************
                                
                               
                                
                                $isInserted=0;

                                $datedata=date('Y-m-d H:i:s');                            

                                $description="Referral commission credited to your wallet for ".$giguniqueid;

                                $dataorderInsert=array();
                                $dataorderInsert['payment_for']="RC";


                                $dataorderInsert['payment_description']=$description;
                                $dataorderInsert['email']=$email;
                                $dataorderInsert['total_price']=$ref_com_creditedtorerrer_wallet;
                                $dataorderInsert['user_ip_address']=$logggedin_user_ip;
                                $dataorderInsert['debitorcredit']="C"; // C=> Credit , D=> Debit
                                $dataorderInsert['gigmaster_id']=$event_gig_id;

                                $dataorderInsert['invoice_num']="INV-".time().rand(111111,999999);
                                $dataorderInsert['user_id']=$user_id;
                                $dataorderInsert['create_date']=$datedata;
                                $dataorderInsert['modified_date']=$datedata;

                                $isInserted = DB::table('user_order')->insert($dataorderInsert);

                                $isInserted=DB::getPdo()->lastInsertId();
                                
                                //echo "3 dataorderInsert=><pre>"; print_r($dataorderInsert); echo "<pre>";
                                
                                
                                //********** insert data in user_order table ends *************   
                                
                                //****** update row in user_master table for atist to  make update wallet_amount data starts ******
                            
                                                        $updateAr=array();
                                                        $updateAr['modified_date']=date('Y-m-d H:i:s');
                                                        $updateAr['wallet_amount']=$wallet_amt_updtd;
                            
                                                        $chkupd= DB::table('user_master')->where('id',$user_id)->update($updateAr);
                                
                                                       //echo "updateAr=><pre>"; print_r($updateAr); echo "<pre>";
                            
                           

                                //****** update row in user_master table for atist to  make update wallet_amount data ends ******
                                
                              
                                
                                    //************ Email send function for referer starts here

                                            $refereremail = $this->refereeremail($groupname,$email,'$'.$ref_com_creditedtorerrer_wallet);

                                    //************ Email send function for referer ends here
                                
                            }

                              //****** update gig_master table payment_flag status to 3 mean full payment has been released starts ***
                                
                                            $updateAr=array();
                                            
                                            $updateAr['payment_flag']=3;

                                            $chkupd= DB::table('gig_master')->where('id',$event_gig_id)->update($updateAr);
                                //****** update gig_master table payment_flag status to 3 mean full payment has been released ends ***    
                            
                            
                
                //*** insert row in user_order table for (referrer)atist to  make  commision credited to his wallet ends ***
                            
                            
                            
                            
                            
                            
                            

                        }
                        elseif(!empty($artist_id) && ($type_flag==3) )
                        {
                            //*** fetch creator_id data of venue from group_master table starts*********
                            $creater_id=0;                      
                            $venue_id=$artist_id; 
                            $venuename= '';
                            
                            $wherefar=array("id"=>$venue_id);

                            $userdta_db = DB::table("venue_master");
                            $userdta_db=$userdta_db->select(DB::raw("id,creater_id,nickname"));
                            $userdta_db=$userdta_db->where($wherefar);

                            $userdta_db=$userdta_db->first();

                            if(!empty($userdta_db))
                            {
                                $creater_id=  $userdta_db->creater_id;
                                $venuename=  $userdta_db->nickname;                

                            }
                            
                            //*** fetch creator_id data of venue from group_master table ends*********
                            
                            
                            
                            
                
                            //****** insert row in user_order table for atist to  make payment credited to artist wallet starts ******
                 
                            //*** fetch data of artist from user_master table starts*********
                            
                            $user_id=$creater_id; $email=''; $wallet_amount=0; $amnt_added_to_wallet=0;$artistnickname='';
                            $wallet_amt_updtd=0;
                            
                            $wherefar=array("id"=>$user_id);

                            $userdta_db = DB::table("user_master");
                            $userdta_db=$userdta_db->select(DB::raw("id,wallet_amount,email,nickname"));
                            $userdta_db=$userdta_db->where($wherefar);

                            $userdta_db=$userdta_db->first();

                            if(!empty($userdta_db))
                            {
                                $wallet_amount=  $userdta_db->wallet_amount;  
                                $email= $userdta_db->email;                                 
                                $artistnickname = $userdta_db->nickname;

                            }
                            
                            //*** fetch data of artist from user_master table ends********
                            
                             $amnt_added_to_wallet=$total_amount; // amount that gets added to Artists wallet
                            
                            //***** manipulate amnt_added_to_wallet if security money     if credited starts ***
                        
                    
                            if($artist_security_deposit >0)
                            {
                                $amnt_added_to_wallet=$total_amount-$artist_security_deposit;
                            }

                           
                            //***** manipulate amnt_added_to_wallet if security money     if credited ends ***
                            
                            //*********** calculate total amount to update wallet_amount starts ********
                            
                             $site_com_debitedfrom_wallet=0;     
                            $site_com_debitedfrom_wallet=($site_commission/100)*$total_amount;
                            $site_com_debitedfrom_wallet=round(floatval($site_com_debitedfrom_wallet),2);
                            
                            
                            $wallet_amt_updtd=($amnt_added_to_wallet+$wallet_amount)-$site_com_debitedfrom_wallet;
                             $wallet_amt_updtd=round(floatval($wallet_amt_updtd),2);
                            //*********** calculate total amount to update wallet_amount ends ********
                            
                            $isInserted=0;

                            $datedata=date('Y-m-d H:i:s');                            

                            $description="Payment released to your wallet for ".$giguniqueid;

                                                        $dataorderInsert=array();
                                                        $dataorderInsert['payment_for']="APPR";
                                                       
                                                        
                                                        $dataorderInsert['payment_description']=$description;
                                                        $dataorderInsert['email']=$email;
                                                        $dataorderInsert['total_price']=$amnt_added_to_wallet;
                                                        $dataorderInsert['user_ip_address']=$logggedin_user_ip;
                                                        $dataorderInsert['debitorcredit']="C"; // C=> Credit , D=> Debit
                                                        $dataorderInsert['gigmaster_id']=$event_gig_id;
                                                        
                                                        $dataorderInsert['invoice_num']="INV-".time().rand(111111,999999);
                                                        $dataorderInsert['user_id']=$user_id;
                                                        $dataorderInsert['create_date']=$datedata;
                                                        $dataorderInsert['modified_date']=$datedata;
                            
                           // echo "1 dataorderInsert=><pre>"; print_r($dataorderInsert); echo "<pre>";
                                                       
                                                        $isInserted = DB::table('user_order')->insert($dataorderInsert);
                            
                                                        $isInserted=DB::getPdo()->lastInsertId();



                //****** insert row in user_order table for atist to  make payment credited to artist wallet ends ******
                            
                //****** insert row in user_order table for site commission debited to artist wallet starts ******
                            
                           
                            
                            $isInserted=0;

                            $datedata=date('Y-m-d H:i:s');                            

                            $description="Site commission debited from your wallet for ".$giguniqueid;
                            
                            
                            

                                                        $dataorderInsert=array();
                                                        $dataorderInsert['payment_for']="SCP";
                                                       
                                                        
                                                        $dataorderInsert['payment_description']=$description;
                                                        $dataorderInsert['email']=$email;
                                                        $dataorderInsert['total_price']=$site_com_debitedfrom_wallet;
                                                        $dataorderInsert['user_ip_address']=$logggedin_user_ip;
                                                        $dataorderInsert['debitorcredit']="D"; // C=> Credit , D=> Debit
                                                        $dataorderInsert['gigmaster_id']=$event_gig_id;
                                                        
                                                        $dataorderInsert['invoice_num']="INV-".time().rand(111111,999999);
                                                        $dataorderInsert['user_id']=$user_id;
                                                        $dataorderInsert['create_date']=$datedata;
                                                        $dataorderInsert['modified_date']=$datedata;
                                                       
                                                        $isInserted = DB::table('user_order')->insert($dataorderInsert);
                            
                                                        $isInserted=DB::getPdo()->lastInsertId();  
                            
                            //echo "2 dataorderInsert=><pre>"; print_r($dataorderInsert); echo "<pre>";
                            
                            
                //****** insert row in user_order table for site commission debited to artist wallet starts ******          

                //****** update row in user_master table for atist to  make update wallet_amount data starts ******
                            
                                                        $updateAr=array();
                                                        $updateAr['modified_date']=date('Y-m-d H:i:s');
                                                        $updateAr['wallet_amount']=$wallet_amt_updtd;
                            
                                                        $chkupd= DB::table('user_master')->where('id',$user_id)->update($updateAr);
                            
                          //echo "wallet_amt_updtd=><pre>"; print_r($updateAr); echo "<pre>"; 

                //****** update row in user_master table for atist to  make update wallet_amount data ends ******

                 //************ Email send function for venue starts here

                                                        $extradata = ': for your venue '.$venuename;

                $artistescrowedamount = $this->artistgroupvenuecreditanddebitemail($giguniqueid,$event_gig_id,$artistnickname,$email,'$'.$amnt_added_to_wallet,'$'.$site_com_debitedfrom_wallet,$extradata);

                //************ Email send function for venue ends here


                //*** insert row in user_order table for (referrer)atist to  make  commision credited to his wallet starts ***
                            
                            $wherefar=array("user_id"=>$user_id);

                            $userdta_db = DB::table("referral_email");
                            $userdta_db=$userdta_db->select(DB::raw("id,user_id,emailid,referred_date,referral_expiry_date,DATEDIFF( now( ) , DATE_FORMAT( referred_date , '%Y-%m-%d %H:%i:%s' ) ) as refer_date_days_used,referrer_userid "));
                            $userdta_db=$userdta_db->where($wherefar);
                            $userdta_db=$userdta_db->havingRaw('refer_date_days_used <=365');
                            $userdta_db=$userdta_db->first();
                            
                            //echo "*************userdta_db=>><pre>"; 
                            //print_r($userdta_db); 
                            //echo "</pre>*****************";

                            if(!empty($userdta_db))
                            {
                                $referred_date=  $userdta_db->referred_date;  
                                $referral_expiry_date= $userdta_db->referral_expiry_date; 
                                $referrer_userid=$userdta_db->referrer_userid; 
                                
                                
                                //*** fetch data of artist from user_master table starts*********

                                $user_id=$referrer_userid; $email=''; $wallet_amount=0; $amnt_added_to_wallet=0;
                                $wallet_amt_updtd=0;

                                $wherefar=array("id"=>$user_id);

                                $userdta_db = DB::table("user_master");
                                $userdta_db=$userdta_db->select(DB::raw("id,wallet_amount,email"));
                                $userdta_db=$userdta_db->where($wherefar);

                                $userdta_db=$userdta_db->first();

                                if(!empty($userdta_db))
                                {
                                    $wallet_amount=  $userdta_db->wallet_amount;  
                                    $email= $userdta_db->email;                                 


                                }

                                //*** fetch data of artist from user_master table ends********

                                 $ref_com_creditedtorerrer_wallet=($referral_commission/100)*$total_amount;
                                $ref_com_creditedtorerrer_wallet=round(floatval($ref_com_creditedtorerrer_wallet),2);
                                
                                $amnt_added_to_wallet=$ref_com_creditedtorerrer_wallet; // amount that gets added to Artists (referrer) wallet

                                //*********** calculate total amount to update wallet_amount starts ********

                                $wallet_amt_updtd=$amnt_added_to_wallet+$wallet_amount;
                                $wallet_amt_updtd=round(floatval($wallet_amt_updtd),2);
                                //*********** calculate total amount to update wallet_amount ends ********
                                
                                
                                //********** insert data in user_order table starts *************
                                
                               
                                
                                $isInserted=0;

                                $datedata=date('Y-m-d H:i:s');                            

                                $description="Referral commission credited to your wallet for ".$giguniqueid;

                                $dataorderInsert=array();
                                $dataorderInsert['payment_for']="RC";


                                $dataorderInsert['payment_description']=$description;
                                $dataorderInsert['email']=$email;
                                $dataorderInsert['total_price']=$ref_com_creditedtorerrer_wallet;
                                $dataorderInsert['user_ip_address']=$logggedin_user_ip;
                                $dataorderInsert['debitorcredit']="C"; // C=> Credit , D=> Debit
                                $dataorderInsert['gigmaster_id']=$event_gig_id;

                                $dataorderInsert['invoice_num']="INV-".time().rand(111111,999999);
                                $dataorderInsert['user_id']=$user_id;
                                $dataorderInsert['create_date']=$datedata;
                                $dataorderInsert['modified_date']=$datedata;

                                $isInserted = DB::table('user_order')->insert($dataorderInsert);

                                $isInserted=DB::getPdo()->lastInsertId();
                                
                                //echo "3 dataorderInsert=><pre>"; print_r($dataorderInsert); echo "<pre>";
                                
                                
                                //********** insert data in user_order table ends *************   
                                
                                //****** update row in user_master table for atist to  make update wallet_amount data starts ******
                            
                                                        $updateAr=array();
                                                        $updateAr['modified_date']=date('Y-m-d H:i:s');
                                                        $updateAr['wallet_amount']=$wallet_amt_updtd;
                            
                                                        $chkupd= DB::table('user_master')->where('id',$user_id)->update($updateAr);
                                
                                                       //echo "updateAr=><pre>"; print_r($updateAr); echo "<pre>";
                            
                           

                                //****** update row in user_master table for atist to  make update wallet_amount data ends ******
                                
                               
                                
                                //************ Email send function for referer starts here

                                            $refereremail = $this->refereeremail($venuename,$email,'$'.$ref_com_creditedtorerrer_wallet);

                                //************ Email send function for referer ends here
                                
                            } 

                             //****** update gig_master table payment_flag status to 3 mean full payment has been released starts ***
                                
                                            $updateAr=array();
                                            
                                            $updateAr['payment_flag']=3;

                                            $chkupd= DB::table('gig_master')->where('id',$event_gig_id)->update($updateAr);
                                //****** update gig_master table payment_flag status to 3 mean full payment has been released ends ***   
                            
                            
                
                //*** insert row in user_order table for (referrer)atist to  make  commision credited to his wallet ends ***      
                            
                            

                        }
                    
                    
                    
                }
                
            }
         
         
     
    }
    
    public function cancelgigevent(Request $request)
         {
             $booker_id = '';$artist_id = '';$artist_type = '';$artist_email = '';$booker_email = '';$artist_user_id = '';$gigpostrequestflag = '';
             $artist_user_wallet = ''; $booker_wallet = ''; $gig_master_id = '';
             $booking_cancellation_fee = '';$artist_security_deposit = '';
             $booker_name = '';$artist_user_name = '';
             $gig_master_qry = "SELECT * FROM `gig_master` WHERE  `booking_status` =  '1' AND  `payment_flag` =  '1' AND DATE( `event_start_date_time` ) >= CURDATE( ) order by  `event_start_date_time`";
             $cancel_gig_master = DB::select($gig_master_qry);
             
             if(!empty($cancel_gig_master)){
             
                      foreach($cancel_gig_master as $cancel){
                           
                               $time_diff = floor((strtotime($cancel->event_start_date_time) - strtotime(date('Y-m-d H:i:s')))/3600);
                               
                               $gig_master_id = $cancel->id;
                               $giguniqueid = $cancel->giguniqueid;
                               $artist_type = $cancel->type_flag;
                               $artist_id = $cancel->artist_id;
                               $booker_id = $cancel->booker_id;
                               $gigpostrequestflag = $cancel->gigpostrequestflag;
                               $booking_cancellation_fee = $cancel->booking_cancellation_fee;
                               $artist_security_deposit = $cancel->artist_security_deposit;
                               
                               if($artist_type == '1'){
                                        
                                        $artist_master_qry = "Select * from `user_master` where `id` = '".$artist_id."'";
                                        
                               }else if($artist_type == '2'){
                                        
                                        $artist_master_qry = "Select * from `user_master` where `id` = (Select `creater_id` from `group_master` where `id` = '".$artist_id."')";
                                        
                               }else if($artist_type == '3'){
                                        
                                        $artist_master_qry = "Select * from `user_master` where `id` = (Select `creater_id` from `venue_master` where `id` = '".$artist_id."')";
                                        
                               }
                               
                               $artist_master_result = DB::select($artist_master_qry);
                               
                               if(!empty($artist_master_result)){
                                        
                                        $artist_user_id = $artist_master_result[0]->id;
                                        $artist_email = $artist_master_result[0]->email;
                                        $artist_user_wallet = $artist_master_result[0]->wallet_amount;
                                        $artist_user_name = $artist_master_result[0]->first_name." ".$artist_master_result[0]->last_name;
                               }
                               $booker_sql = DB::table('user_master')->where('id',$booker_id)->first();
                               
                               if(!empty($booker_sql)){
                                        
                                        $booker_email = $booker_sql->email;
                                        $booker_wallet = $booker_sql->wallet_amount;
                                        $booker_name = $booker_sql->first_name." ".$booker_sql->last_name;
                               }
                               
                               //echo "<br>".$cancel->id." -> ".$time_diff." ".$booker_email." ".$artist_user_id." ".$artist_email." ".$artist_type." -> ".$artist_id;
                               
                               
                           $userssel = DB::table('settings')
                           ->select(DB::raw('site_name,email_from,copyright_year,email_template_logo_image'))
                           ->where('id', 1)
                           ->get();
                           
                           $sitename=$userssel[0]->site_name;
                           $emailfrom=$userssel[0]->email_from;
                           $copyright_year=$userssel[0]->copyright_year;
                           $Imgologo=$userssel[0]->email_template_logo_image;
                           $bsurl = url('/');
                           
                           $logoIMG = asset('public/upload/settings-image/source-file/'.$Imgologo);
                           
                               
                               if($time_diff == 168){
                                    //*************7 day remainder*********** start//
                                    $replacefrom =array('{USER}','{NOOFDAYS}','{GIGID}','{SITENAME}','{YEAR}','{BASE_URL}',"{LOGO_IMG}");
                                    $replaceto =array(ucfirst($booker_name),'7',$giguniqueid,$sitename,$copyright_year,$bsurl,$logoIMG);
                                    mailsnd($Temid=32,$replacefrom,$replaceto,$booker_email);
                                    //*************7 day remainder*********** end//
                               }else if($time_diff == 48){
                                    //*************2 day remainder*********** start//
                                    $replacefrom =array('{USER}','{NOOFDAYS}','{GIGID}','{SITENAME}','{YEAR}','{BASE_URL}',"{LOGO_IMG}");
                                    $replaceto =array(ucfirst($booker_name),'2',$giguniqueid,$sitename,$copyright_year,$bsurl,$logoIMG);
                                    mailsnd($Temid=32,$replacefrom,$replaceto,$booker_email);
                                    //*************2 day remainder*********** end//
                               }else if($time_diff == 4 || $time_diff < 4){
                               //}else if($time_diff == 4){
                                    //************* before 4 hrs gig cancel *********** start//
                                        $gig_master_update = array();
                                        $gig_master_update['booking_status']= '9';
                                        $gig_master_update['payment_flag']= '5';
                                        
                                        $isgig_masterUpdated = DB::table('gig_master')->where('id',$gig_master_id)->update($gig_master_update);
                                        
                                        if($isgig_masterUpdated){
                                             
                                             
                                                 if($gigpostrequestflag == '2'){
                                                      //************* individual cancel *********** start//
                                                      
                                                      //************* individual booking_cancellation_fee cancel *********** start//
                                                         $gig_master_update_booker_wallet= $booker_wallet + $booking_cancellation_fee;
                                                         $isupdate_booker_wallet = DB::table('user_master')->where('id',$booker_id)->update(['wallet_amount' => $gig_master_update_booker_wallet]);
                                                         
                                                         if($isupdate_booker_wallet){
                                                               
                                                               $booker_wallet_add_cr = $this->insertintouserorder($booker_id,$booker_email,$booking_cancellation_fee,$gig_master_id,'C','CPR','Cancellation payment release');
                                                               if($booker_wallet_add_cr){
                                                               $replacefrom =array('{USER}','{TYPEOFMONEY}','{AMOUNT}','{GIGID}','{SITENAME}','{YEAR}','{BASE_URL}',"{LOGO_IMG}");
                                                               $replaceto =array(ucfirst($booker_name),'Booking cancellation fee',$booking_cancellation_fee,$giguniqueid,$sitename,$copyright_year,$bsurl,$logoIMG);
                                                               mailsnd($Temid=33,$replacefrom,$replaceto,$booker_email);
                                                               }
                                                         }
                                                         
                                                      //************* individual booking_cancellation_fee cancel *********** end//            
                                                                  
                                                      //************* individual artist_security_deposit cancel *********** start//          
                                                         $gig_master_update_artist_user_wallet= $artist_user_wallet + $artist_security_deposit;
                                                         $isupdate_artist_wallet = DB::table('user_master')->where('id',$artist_user_id)->update(['wallet_amount' => $gig_master_update_artist_user_wallet]);
                                                         
                                                         
                                                         if($isupdate_artist_wallet){
                                                               $artist_wallet_add_cr = $this->insertintouserorder($artist_user_id,$artist_email,$artist_security_deposit,$gig_master_id,'C','CPR','Cancellation payment release');
                                                               if($artist_wallet_add_cr){
                                                               $replacefrom =array('{USER}','{TYPEOFMONEY}','{AMOUNT}','{GIGID}','{SITENAME}','{YEAR}','{BASE_URL}',"{LOGO_IMG}");
                                                               $replaceto =array(ucfirst($artist_user_name),'Artist security deposit',$artist_security_deposit,$giguniqueid,$sitename,$copyright_year,$bsurl,$logoIMG);
                                                               mailsnd($Temid=34,$replacefrom,$replaceto,$artist_email);
                                                               }
                                                         }
                                                      //************* individual artist_security_deposit cancel *********** start//
                                                         
                                                         //************* individual cancel *********** end//
                                                 }else if($gigpostrequestflag == '1'){
                                                         //************* Gig cancel *********** end//
                                                         $gig_master_update_artist_user_wallet= $artist_user_wallet + $artist_security_deposit;
                                                         $isupdate_artist_wallet = DB::table('user_master')->where('id',$artist_user_id)->update(['wallet_amount' => $gig_master_update_artist_user_wallet]);
                                                         
                                                         if($isupdate_artist_wallet){
                                                               $artist_wallet_add_cr = $this->insertintouserorder($artist_user_id,$artist_email,$artist_security_deposit,$gig_master_id,'C','CPR','Cancellation payment release');
                                                               if($artist_wallet_add_cr){
                                                               $replacefrom =array('{USER}','{TYPEOFMONEY}','{AMOUNT}','{GIGID}','{SITENAME}','{YEAR}','{BASE_URL}',"{LOGO_IMG}");
                                                               $replaceto =array(ucfirst($artist_user_name),'Artist security deposit',$artist_security_deposit,$giguniqueid,$sitename,$copyright_year,$bsurl,$logoIMG);
                                                               mailsnd($Temid=34,$replacefrom,$replaceto,$artist_email);
                                                               }
                                                         }
                                                         //************* Gig cancel *********** end//
                                                 }
                                        }

                                        
                                      //************* before 4 hrs gig cancel *********** end//  
                               }
    
                      }
                               
             }
         }
    

         
         function insertintouserorder($user_id,$user_email,$amount_trans,$gig_master_details_id,$trnstype,$payment_for,$payment_description)
         {
                $logggedin_user_ip = get_client_ip_server();
                
                $dataorderInsert=array();
                $dataorderInsert['payment_for']=$payment_for; //required
                $dataorderInsert['card_token']='';
                $dataorderInsert['charge_token']='';
                $dataorderInsert['payment_description']=$payment_description;
                $dataorderInsert['payment_scheme']='';
                $dataorderInsert['email']=$user_email;
                $dataorderInsert['total_price']= $amount_trans;//required
                $dataorderInsert['user_ip_address']= $logggedin_user_ip;//required
                $dataorderInsert['debitorcredit']=$trnstype; // C=> Credit , D=> Debit //required
                $dataorderInsert['gigmaster_id'] = $gig_master_details_id;//required
                $dataorderInsert['currency']='';
                $dataorderInsert['payment_status']="SUCCESS";//required
                $dataorderInsert['invoice_num']="INV-".time().rand(111111,999999);
                $dataorderInsert['user_id'] = $user_id;
                $dataorderInsert['create_date'] = date('Y-m-d H:i:s');
                $dataorderInsert['modified_date']= date('Y-m-d H:i:s');
                //*** insert  query
                $isInserted = DB::table('user_order')->insert($dataorderInsert);
                if($isInserted){
                        return true;
                }else{
                        return false;
                }
        }
    
    
        function checkchronmail(Request $request)
        {
            
            //*** send mail starts
            
            $body = "Hello mail is getting fired from from cron-".time(); //email body
            
            $passarr['adminfrom']="soumik@esolzmail.com";
            $passarr['emailsub']="prosessional cron mail test ".rand();
            $passarr['emailto']="soumik@esolzmail.com";
            $passarr['sitename']="prosessional"; $replacefrom=array(); $replaceto=array();
            $data = array(
            'replacefrom'=>$replacefrom,'replaceto'=>$replaceto,'email_body'=>$body
            );
            $chkmail= Mail::send('emails.emailviewfolder.commonemailtenplate', $data, function ($message) use ($passarr)
            {
            
                $message->from($passarr['adminfrom'], $passarr['sitename']);            
                $message->to($passarr['emailto'])->subject($passarr['emailsub']);
            
            }
                                
            );
                 
            //*** send mail ends
            
        }





        //***************** Email function starts here

        //*********** Email function for artist group and venue starts here
        public function artistgroupvenuecreditanddebitemail($giguniqueid,$event_gig_id,$artistname,$email,$amnt_added_to_wallet,$site_com_debitedfrom_wallet,$extradata)
      {
                //   echo "event_gig_id".$giguniqueid;
                // echo "<br>";

                // echo "event_gig_id".$event_gig_id;
                // echo "<br>";
                //    echo "receiver_name=>".$artistname;
                //    echo "<br>";
                //    echo "email=>".$email;
                //     echo "<br>";
                //    echo "amnt_added_to_wallet=>".$amnt_added_to_wallet;
                //     echo "<br>";
                //     echo "site_com_debitedfrom_wallet=>".$site_com_debitedfrom_wallet;

                //    die;
                  
                    $userssel = DB::table('settings')
                    ->select(DB::raw('site_name,email_from,copyright_year,email_template_logo_image'))
                    ->where('id', 1)
                    ->get();
                    $sitename=$userssel[0]->site_name;
                    $emailfrom=$userssel[0]->email_from;
                    $copyright_year=$userssel[0]->copyright_year;
                    $Imgologo=$userssel[0]->email_template_logo_image;
                    $bsurl = url('/');
                    $logoIMG = asset('public/upload/settings-image/source-file/'.$Imgologo);



                    //*********Helper Function Starts here

                 
                    $replacefrom =array('{USER}','{TOTALPAYMENT}','{GIGID}','{SITECOMMISION}','{SITENAME}','{YEAR}','{BASE_URL}',"{LOGO_IMG}","{EXTRADATA}");

                    $replaceto =array(ucfirst($artistname),$amnt_added_to_wallet,$giguniqueid,$site_com_debitedfrom_wallet,$sitename,$copyright_year,$bsurl,$logoIMG,$extradata);


                    mailsnd($Temid=41,$replacefrom,$replaceto,$email);
               
                

                  //*********Helper Function Ends here 
                
                     
      }
       //*********** Email function for artist group and venue ends here



      //***********Email function for refferer starts here


         public function refereeremail($artistname,$email,$ref_com_creditedtorerrer_wallet)
      {
            //echo "receiver_name=>".$receiver_name;die;





                       // echo "received from name=>".$artistname;
                       // echo "<br>";
                       // echo "email=>".$email;
                       //  echo "<br>";
                    
                       //  echo "site_com_debitedfrom_wallet=>".$ref_com_creditedtorerrer_wallet;

                       // die;
                  
                    $userssel = DB::table('settings')
                    ->select(DB::raw('site_name,email_from,copyright_year,email_template_logo_image'))
                    ->where('id', 1)
                    ->get();
                    $sitename=$userssel[0]->site_name;
                    $emailfrom=$userssel[0]->email_from;
                    $copyright_year=$userssel[0]->copyright_year;
                    $Imgologo=$userssel[0]->email_template_logo_image;
                    $bsurl = url('/');
                    $logoIMG = asset('public/upload/settings-image/source-file/'.$Imgologo);



                   // *********Helper Function Starts here

                 
                    $replacefrom =array('{ARTISTNAME}','{REFRERAMOUNT}','{SITENAME}','{YEAR}','{BASE_URL}','{LOGO_IMG}');

                    $replaceto =array($artistname,$ref_com_creditedtorerrer_wallet,$sitename,$copyright_year,$bsurl,$logoIMG);


                    mailsnd($Temid=42,$replacefrom,$replaceto,$email);
               
                

                  //*********Helper Function Ends here 
                
                     
      }

      //***********Email function for referrer ends here




        //***************** Email function ends here

   public function cancelgigeventmanualy(Request $request)
    {
         
         $logggedin_user_ip = get_client_ip_server();
         $datedata=date('Y-m-d H:i:s');                            
         $gig_master_id = ''; $gig_cancel_amount = ''; $gig_total_amount = '';$resttransferamout = '';$resttransferamoutartst = '';
         
         $cancelgigeventmanualy = "SELECT gm . *,lc.currency_icon FROM `gig_master` AS gm LEFT OUTER JOIN `location_country` As lc ON lc.`id` = gm.`event_country`  WHERE gm.`booking_status` = '7' AND gm.`payment_flag` !='5' AND TIMESTAMPDIFF( HOUR , gm.`cancel_date` , NOW( ) ) >24";
         $cancelgigeventmanualyAr=DB::select($cancelgigeventmanualy);
         if(!empty($cancelgigeventmanualyAr))
         {
                  
                  $userssel = DB::table('settings')
                  ->select(DB::raw('site_name,email_from,copyright_year,email_template_logo_image'))
                  ->where('id', 1)
                  ->get();
                  
                  $sitename=$userssel[0]->site_name;
                  $emailfrom=$userssel[0]->email_from;
                  $copyright_year=$userssel[0]->copyright_year;
                  $Imgologo=$userssel[0]->email_template_logo_image;
                  $bsurl = url('/');
                  
                  $logoIMG = asset('public/upload/settings-image/source-file/'.$Imgologo);
                  
                  foreach($cancelgigeventmanualyAr as $data)
                  {

                           
                           $artist_email = '';
                           $artist_id = '';
                           $artist_wallet = '';
                           $artist_name = '';
                           
                           $booker_email = '';
                           $booker_id = '';
                           $booker_wallet= '';
                           $booker_name= '';
                           
                           
                           
                           $gig_currency_icon = $data->currency_icon;
                           
                           $booker_details = DB::table('user_master')
                           ->select(DB::raw("email,id,wallet_amount,nickname"))
                           ->where('id',$data->booker_id)
                           ->first();
                           
                           if(!empty($booker_details)){
                                    $booker_email = $booker_details->email;
                                    $booker_id = $booker_details->id;
                                    $booker_wallet= $booker_details->wallet_amount;
                                    $booker_name= $booker_details->nickname;
                           }

                           if($data->type_flag == '1'){
                                    
                                    $artist_details = DB::table('user_master as um')
                                    ->select(DB::raw("um.email,um.id,um.wallet_amount,um.nickname"))
                                    ->where('id',$data->artist_id)
                                    ->first();
                           }else if($data->type_flag == '2'){
                                    $artist_details = DB::table('user_master as um')
                                    ->Join('group_master as gm', function($join)
                                    {
                                            $join->on('gm.creater_id','=','um.id');
                                    })
                                    ->select(DB::raw("um.email,um.id,um.wallet_amount,um.nickname"))
                                    ->where('gm.id',$data->artist_id)
                                    ->first();
                                    
                           }else if($data->type_flag == '3'){
                                    $artist_details = DB::table('user_master as um')
                                    ->Join('venue_master as vm', function($join)
                                    {
                                            $join->on('vm.creater_id','=','um.id');
                                    })
                                    ->select(DB::raw("um.email,um.id,um.wallet_amount,um.nickname"))
                                    ->where('vm.id',$data->artist_id)
                                    ->first();
                                    
                           }
                           
                           if(!empty($artist_details)){
                                  $artist_email =  $artist_details->email;
                                  $artist_id =  $artist_details->id;
                                  $artist_wallet = $artist_details->wallet_amount;
                                  $artist_name = $artist_details->nickname;
                           }
                           
                           $gig_master_id = $data->id;
                           $gig_total_amount = $data->total_amount;
                           $gig_cancel_amount = $data->booking_cancellation_fee;
                           
                           if($gig_cancel_amount == '0.00'){
                                    echo "No cancelation fee";
                           //********** No cancelation fee section *************//
                           }else{
                           //********** Cancelation fee section *************//
                                    
                                    if($data->cancel_by_whom == '1'){
                                             //********** Artist/Group/Venue cancel section *************//
                                             
                                             $check_other_gig_sd_rlsd = DB::table('user_order')
                                             ->where('gigmaster_id',$gig_master_id)
                                             ->where('payment_for','SMR')
                                             ->first();
                                             
                                             if(!empty($check_other_gig_sd_rlsd)){
                                                      //************** With SD released to artist***************//
                                                      $resttransferamout = $gig_total_amount - $check_other_gig_sd_rlsd->total_price;
                                                      $resttransferamoutartst = '';
                                             }else{
                                                      //************** Without SD released to artist***************//
                                                      $resttransferamout = $gig_total_amount;
                                                      $resttransferamoutartst = '';

                                             }
                                             
                                    }else if($data->cancel_by_whom == '2'){
                                             //********** Booker cancel section *************//
                                             
                                             $check_booker_gig_sd_rlsd = DB::table('user_order')
                                             ->where('gigmaster_id',$gig_master_id)
                                             ->where('payment_for','SMR')
                                             ->first();
                                             
                                             if(!empty($check_booker_gig_sd_rlsd)){
                                                      //************** With SD released to artist***************//
                                                      $resttransferamout = $gig_total_amount - ($check_booker_gig_sd_rlsd->total_price + $gig_cancel_amount); // to booker
                                                      $resttransferamoutartst = $gig_cancel_amount;
                                             }else{
                                                      //************** Without SD released to artist***************//
                                                      $resttransferamout = $gig_total_amount;
                                                      $resttransferamoutartst = '';
                                             }
                                    }
                                    
                                    if($resttransferamout!=''){

                                             /**** Added to booker wallet****/
                                             
                                             $description="Cancellation payment release to your wallet for ".$data->giguniqueid;
                                             
                                             $dataorderInsert=array();
                                             $dataorderInsert['payment_for']="CPR";
                                             
                                             
                                             $dataorderInsert['payment_description']=$description;
                                             $dataorderInsert['email']=$booker_email;
                                             $dataorderInsert['total_price']=$resttransferamout;
                                             $dataorderInsert['user_ip_address']=$logggedin_user_ip;
                                             $dataorderInsert['debitorcredit']="C"; // C=> Credit , D=> Debit
                                             $dataorderInsert['gigmaster_id']=$gig_master_id;
                                             
                                             $dataorderInsert['invoice_num']="INV-".time().rand(111111,999999);
                                             $dataorderInsert['user_id']=$booker_id;
                                             $dataorderInsert['create_date']=$datedata;
                                             $dataorderInsert['modified_date']=$datedata;
                                             
                                             
                                             $isInserted = DB::table('user_order')->insert($dataorderInsert);
                                             
                                             
                                             //***************** update in to booker wallet ****************//
                                             $updateBooker=array();
                                             $updateBooker['modified_date'] = date('Y-m-d H:i:s');
                                             $updateBooker['wallet_amount'] = $booker_wallet + $resttransferamout;
                 
                                             $chkupd= DB::table('user_master')->where('id',$booker_id)->update($updateBooker);
                                             
                                             //************* Send mail to booker***********//
                                             $replacefrom =array('{USER}','{CANCELLATION_AMOUNT}','{EVENT}','{SITENAME}','{YEAR}','{BASE_URL}',"{LOGO_IMG}");
                                             $replaceto =array(ucfirst($booker_name),$gig_currency_icon." ".$resttransferamout,$data->giguniqueid,$sitename,$copyright_year,$bsurl,$logoIMG);
                                             mailsnd($Temid=49,$replacefrom,$replaceto,$booker_email);
                                             //************* Send mail to booker ***********//
                                             
                                             
                                    }
                                    if($resttransferamoutartst!=''){
                                             
                                             
                                             /**** Added to artist wallet****/
                                             $description="Cancellation payment release to your wallet for ".$data->giguniqueid;
                                             
                                             $dataorderInsert=array();
                                             $dataorderInsert['payment_for']="CPR";
                                             
                                             
                                             $dataorderInsert['payment_description']=$description;
                                             $dataorderInsert['email']=$artist_email;
                                             $dataorderInsert['total_price']=$resttransferamoutartst;
                                             $dataorderInsert['user_ip_address']=$logggedin_user_ip;
                                             $dataorderInsert['debitorcredit']="C"; // C=> Credit , D=> Debit
                                             $dataorderInsert['gigmaster_id']=$gig_master_id;
                                             
                                             $dataorderInsert['invoice_num']="INV-".time().rand(111111,999999);
                                             $dataorderInsert['user_id']=$artist_id;
                                             $dataorderInsert['create_date']=$datedata;
                                             $dataorderInsert['modified_date']=$datedata;
                                             
                                             
                                             $isInserted = DB::table('user_order')->insert($dataorderInsert);
                                             
                                             
                                             //***************** update in to artist wallet ****************//
                                             $updateArtst=array();
                                             $updateArtst['modified_date'] = date('Y-m-d H:i:s');
                                             $updateArtst['wallet_amount'] = $artist_wallet + $resttransferamoutartst;
                 
                                             $chkupd= DB::table('user_master')->where('id',$artist_id)->update($updateArtst);
                                             
                                             //************* Send mail to artist ***********//
                                             $replacefrom =array('{USER}','{CANCELLATION_AMOUNT}','{EVENT}','{SITENAME}','{YEAR}','{BASE_URL}',"{LOGO_IMG}");
                                             $replaceto =array(ucfirst($artist_name),$gig_currency_icon." ".$resttransferamoutartst,$data->giguniqueid,$sitename,$copyright_year,$bsurl,$logoIMG);
                                             mailsnd($Temid=49,$replacefrom,$replaceto,$artist_email);
                                             //************* Send mail to artist ***********//
                                             
                                             
                                    }

                                    
                           }
                           
                                    //echo $gig_master_id." ************* Total amount->".$gig_total_amount." ******** Booker->".$resttransferamout." **************** Artist->".$resttransferamoutartst." Booker email-> ".$booker_email." Booker id ".$booker_id." booker_wallet ".$booker_wallet." Artist id ".$artist_id." Artist email ".$artist_email." Artist wallet ".$artist_wallet."<br><br><br><br><br><br>";
                           
                           $updategig_master=array();
                           $updategig_master['payment_flag'] = '5';

                           $chkupd= DB::table('gig_master')->where('id',$gig_master_id)->update($updategig_master);
                                    
                           
                  }
         }
    }



//*********************************************************************************************************



    public function releaseofsecuritymoneytoagvwallet(Request $request)
    {
        //echo "Hello Here"; 

         $qryforsecuritymoney = "SELECT
            ggm.`id`,ggm.`giguniqueid`,ggm.`artist_id`,ggm.`type_flag`,ggm.`booking_status`,ggm.`dispute_flag`,ggm.`payment_flag`,ggm.`event_type`,ggm.`booking_cancellation_fee`,ggm.`artist_security_deposit`,now( ) as just_now_datetime ,ggm.`booking_accept_date`, (time_to_sec(timediff(now( ), `booking_accept_date`)) / 3600 ) as hours_event_passed

            FROM `gig_master` as ggm  

           
            WHERE

            ggm.`booking_accept_date` < now()

            AND

            ggm.`booking_status`=1

            AND

            ggm.`dispute_flag`=0

            AND

            ggm.`payment_flag` IN (2)

            having hours_event_passed >24


            ORDER BY ggm.`id` DESC";


            $qryforsecuritymoneyAr=DB::select($qryforsecuritymoney); 
            // echo "qryforsecuritymoneyAr=>><pre>"; 
            // print_r($qryforsecuritymoneyAr); 
            // echo "</pre>";
            $datedata=date('Y-m-d H:i:s');
             $logggedin_user_ip = get_client_ip_server();
           
            if(!empty($qryforsecuritymoneyAr))
            {
                foreach($qryforsecuritymoneyAr as $qryforsecuritymoneyobj)
                {
                      $description="Security amount added in your wallet for  ".$qryforsecuritymoneyobj->giguniqueid;
                    
                        $event_gig_id=$qryforsecuritymoneyobj->id;
                        $giguniqueid=$qryforsecuritymoneyobj->giguniqueid;
                        $artist_id=$qryforsecuritymoneyobj->artist_id;
                        $type_flag=$qryforsecuritymoneyobj->type_flag;
                        // $booker_id=$releasegigrelateddataobj->booker_id;

                        $booking_status=$qryforsecuritymoneyobj->booking_status;
                        $dispute_flag=$qryforsecuritymoneyobj->dispute_flag;
                        $payment_flag=$qryforsecuritymoneyobj->payment_flag;
                        $event_type=$qryforsecuritymoneyobj->event_type;
                        $booking_cancellation_fee=$qryforsecuritymoneyobj->booking_cancellation_fee;
                        $artist_security_deposit=$qryforsecuritymoneyobj->artist_security_deposit;
                        $just_now_datetime=$qryforsecuritymoneyobj->just_now_datetime;
                        $booking_accept_date=$qryforsecuritymoneyobj->booking_accept_date;
                        $hours_event_passed=$qryforsecuritymoneyobj->hours_event_passed;


                        if(!empty($artist_id) && ($type_flag==1))
                        {
                           
                //****** insert row in user_order table for atist to  make payment credited to artist wallet starts ******
                 
                            //*** fetch data of artist from user_master table starts*********
                            
                            $user_id=$artist_id; $email='';$artistname=''; $wallet_amount=0; $amnt_added_to_wallet=0;
                            $wallet_amt_updtd=0;
                            
                            $wherefar=array("id"=>$user_id);

                            $userdta_db = DB::table("user_master");
                            $userdta_db=$userdta_db->select(DB::raw("id,wallet_amount,email,nickname"));
                            $userdta_db=$userdta_db->where($wherefar);

                            $userdta_db=$userdta_db->first();

                                if(!empty($userdta_db))
                                {
                                    $wallet_amount=  $userdta_db->wallet_amount;  
                                    $email= $userdta_db->email;   
                                    $artistname= $userdta_db->nickname;   
                                    
                                    

                                }


                                //*********************** calculation for addition of security amount into artist wallet starts here


                                 $amnt_added_to_wallet=$wallet_amount+$artist_security_deposit; // amount that gets added to Artists wallet

                                 //****************  If security amount not blank or not 0.00 then proceed to next step starts

                                 if(($artist_security_deposit!='') && ($artist_security_deposit!='0.00')) 
                                 {
                                    // echo "=============== HERE Artist =============================";
                                    // echo "<br>";
                                    // echo "Artist name is ".$artistname.'id is '.$artist_id."Event id ".$event_gig_id;
                                    // echo "<br>";
                                    // echo "Here we are security deposit for artist ".$artist_security_deposit;
                                    // echo "<br>";
                                    // echo "Wallet amount for this artist is ".$wallet_amount;
                                    // echo "<br>";
                                    // echo "Mail will be send to ". $email ;
                                    // echo "<br>";
                                    // echo "=============================================";


                        //****************   Insert of data into user order table starts here*****************************
                                                        $dataorderInsert=array();
                                                        $dataorderInsert['payment_for']="SMR";
                                                       
                                                        
                                                        $dataorderInsert['payment_description']=$description;
                                                        $dataorderInsert['email']=$email;
                                                        $dataorderInsert['total_price']=$artist_security_deposit;
                                                        $dataorderInsert['user_ip_address']=$logggedin_user_ip;
                                                        $dataorderInsert['debitorcredit']="C"; // C=> Credit , D=> Debit
                                                        $dataorderInsert['gigmaster_id']=$event_gig_id;
                                                        
                                                        $dataorderInsert['invoice_num']="INV-".time().rand(111111,999999);
                                                        $dataorderInsert['user_id']=$user_id;
                                                        $dataorderInsert['create_date']=$datedata;
                                                        $dataorderInsert['modified_date']=$datedata;
                                                        $dataorderInsert['payment_status']='SUCCESS';
                            
                           // echo "1 dataorderInsert=><pre>"; print_r($dataorderInsert); echo "<pre>";
                                                       
                                                       $isInserted = DB::table('user_order')->insert($dataorderInsert);
                            
                                                       // $isInserted=DB::getPdo()->lastInsertId();
                        //************* Insert of adat into user order table ends here ******************


                           //***************************Update into usermaster table strats here *************


                               $dataupdatearrayusermaster = array();
                               $dataupdatearrayusermaster['wallet_amount']=$amnt_added_to_wallet;
                               // echo "Wallet will be updat for id ".$user_id."<pre>";
                               // print_r($dataupdatearrayusermaster);
                               // echo "</pre>";

                               $chkupd= DB::table('user_master')->where('id',$user_id)->update($dataupdatearrayusermaster);

                           //****************************Update into user master table ends here****************


                               //******************** Update into gig master table starts here *****************

                               $dataupdatearraygigmaster = array();
                               $dataupdatearraygigmaster['payment_flag']='6';
                               // echo "Wallet will be updat for id ".$user_id."<pre>";
                               // print_r($dataupdatearraygigmaster);
                               // echo "</pre>";

                               $chkupdgig= DB::table('gig_master')->where('id',$event_gig_id)->update($dataupdatearraygigmaster);



                               //********************  Update into gig master tabele ends ehre****************


                               //****************** Sending of email to artist group and venue starts here


                                $artistgroupvenueemail_securityamount = $this->securityamountemail($giguniqueid,$artistname,$email,'$'.$artist_security_deposit,$artistname);

                               //****************** Sending of email to artist group and venue ends here






                                 }

                                  //****************  If security amount not blank or not 0.00 then proceed to next step ends

                                //***********************  calculation of addition of security amount into artist wallet ensd here




                            } //end of ($artist_id) && ($type_flag==1)
                        if(!empty($artist_id) && ($type_flag==2))
                        {
                            // echo "HERE group";
                //****** insert row in user_order table for atist to  make payment credited to artist wallet starts ******




                            //************************ Fetch data from group master starts here

                              //*** fetch creator_id data of group from group_master table starts*********
                            $creater_id=0;                      
                            $group_id=$artist_id; 
                            $groupname='';
                            
                            $wherefar=array("id"=>$group_id);

                            $userdta_db = DB::table("group_master");
                            $userdta_db=$userdta_db->select(DB::raw("id,creater_id,nickname"));
                            $userdta_db=$userdta_db->where($wherefar);

                            $userdta_db=$userdta_db->first();

                            if(!empty($userdta_db))
                            {
                                $creater_id=  $userdta_db->creater_id;  
                                $groupname=  $userdta_db->nickname;                          

                            }
                            
                            //*** fetch creator_id data of group from group_master table ends*********

                            //************************  ferch data from group maaster ends here
                 
                            //*** fetch data of artist from user_master table starts*********
                            
                            $user_id=$creater_id; $email=''; $wallet_amount=0; $amnt_added_to_wallet=0;$artistnickname='';
                            $wallet_amt_updtd=0;
                            
                            $wherefar=array("id"=>$user_id);

                            $userdta_db = DB::table("user_master");
                            $userdta_db=$userdta_db->select(DB::raw("id,wallet_amount,email,nickname"));
                            $userdta_db=$userdta_db->where($wherefar);

                            $userdta_db=$userdta_db->first();

                            if(!empty($userdta_db))
                            {
                                    $wallet_amount=  $userdta_db->wallet_amount;  
                                    $email= $userdta_db->email;    
                                    $artistnickname = $userdta_db->nickname;
                                    

                            }

                        //*********************** calculation for addition of security amount into group creater wallet starts here


                                 $amnt_added_to_wallet=$wallet_amount+$artist_security_deposit; // amount that gets added to Artists wallet

                                 //****************  If security amount not blank or not 0.00 then proceed to next step starts

                                 if(($artist_security_deposit!='') && ($artist_security_deposit!='0.00')) 
                                 {
                                    // echo "=================== HERE group =========================";
                                    // echo "<br>";
                                    // echo "Artist name is ".$artistnickname.' creater id is '.$creater_id."And group name is ".$groupname."Event id ".$event_gig_id;
                                    // echo "<br>";
                                    // echo "Here we are security deposit for group".$artist_security_deposit;
                                    // echo "<br>";
                                    // echo "Wallet amount for this group creator is ".$wallet_amount;
                                    // echo "<br>";
                                    // echo "Mail will be send to ". $email ;
                                    // echo "<br>";
                                    // echo "============================================";

                                    //****************   Insert of data into user order table starts here*****************************
                                                        $dataorderInsert=array();
                                                        $dataorderInsert['payment_for']="SMR";
                                                       
                                                        
                                                        $dataorderInsert['payment_description']=$description;
                                                        $dataorderInsert['email']=$email;
                                                        $dataorderInsert['total_price']=$artist_security_deposit;
                                                        $dataorderInsert['user_ip_address']=$logggedin_user_ip;
                                                        $dataorderInsert['debitorcredit']="C"; // C=> Credit , D=> Debit
                                                        $dataorderInsert['gigmaster_id']=$event_gig_id;
                                                        
                                                        $dataorderInsert['invoice_num']="INV-".time().rand(111111,999999);
                                                        $dataorderInsert['user_id']=$creater_id;
                                                        $dataorderInsert['create_date']=$datedata;
                                                        $dataorderInsert['modified_date']=$datedata;
                                                        $dataorderInsert['payment_status']='SUCCESS';
                            
                                      //  echo "2 dataorderInsert=><pre>"; print_r($dataorderInsert); echo "<pre>";
                                                       
                                                       $isInserted = DB::table('user_order')->insert($dataorderInsert);
                            
                                                       // $isInserted=DB::getPdo()->lastInsertId();
                               //************* Insert of adat into user order table ends here ******************
                                         //***************************Update into usermaster table strats here *************


                                               $dataupdatearrayusermaster = array();
                                               $dataupdatearrayusermaster['wallet_amount']=$amnt_added_to_wallet;
                                             //  echo "Wallet will be update for id ".$creater_id."<pre>";
                                               // print_r($dataupdatearrayusermaster);
                                               // echo "</pre>";

                                        $chkupd= DB::table('user_master')->where('id',$creater_id)->update($dataupdatearrayusermaster);

                           //****************************Update into user master table ends here****************

                                //******************** Update into gig master table starts here *****************

                               $dataupdatearraygigmaster = array();
                               $dataupdatearraygigmaster['payment_flag']='6';
                               // echo "Wallet will be updat for id ".$user_id."<pre>";
                               // print_r($dataupdatearraygigmaster);
                               // echo "</pre>";

                               $chkupdgig= DB::table('gig_master')->where('id',$event_gig_id)->update($dataupdatearraygigmaster);



                               //********************  Update into gig master tabele ensds here****************


                               //****************** Sending of email to artist group and venue starts here

                               
                                $artistgroupvenueemail_securityamount = $this->securityamountemail($giguniqueid,$artistnickname,$email,'$'.$artist_security_deposit,$groupname);
                               
                               //****************** Sending of email to artist group and venue ends here


                                 }

                                  //****************  If security amount not blank or not 0.00 then proceed to next step ends

                        //***********************  calculation of addition of security amount into group creater wallet ends here





                         //********* end of group condition 





                            //*** fetch data of artist from user_master table ends********
                            
                             //$amnt_added_to_wallet=$total_amount; // amount that gets added to Artists wallet

                        }
                        elseif(!empty($artist_id) && ($type_flag==3) )
                        {
                            //*** fetch creator_id data of venue from group_master table starts*********
                            // echo "Here venue";

                            $creater_id=0;                      
                            $venue_id=$artist_id; 
                            $venuename= '';
                            
                            $wherefar=array("id"=>$venue_id);

                            $userdta_db = DB::table("venue_master");
                            $userdta_db=$userdta_db->select(DB::raw("id,creater_id,nickname"));
                            $userdta_db=$userdta_db->where($wherefar);

                            $userdta_db=$userdta_db->first();

                            if(!empty($userdta_db))
                            {
                                $creater_id=  $userdta_db->creater_id;
                                $venuename=  $userdta_db->nickname;                

                            }
                            
                            //*** fetch creator_id data of venue from group_master table ends*********



                            
                            
                            
                            
                
                            //****** insert row in user_order table for atist to  make payment credited to artist wallet starts ******
                 
                            //*** fetch data of artist from user_master table starts*********
                            
                            $user_id=$creater_id; $email=''; $wallet_amount=0; $amnt_added_to_wallet=0;$artistnickname='';
                            $wallet_amt_updtd=0;
                            
                            $wherefar=array("id"=>$user_id);

                            $userdta_db = DB::table("user_master");
                            $userdta_db=$userdta_db->select(DB::raw("id,wallet_amount,email,nickname"));
                            $userdta_db=$userdta_db->where($wherefar);

                            $userdta_db=$userdta_db->first();

                            if(!empty($userdta_db))
                            {
                                    $wallet_amount=  $userdta_db->wallet_amount;  
                                    $email= $userdta_db->email;   
                                    $artistnickname = $userdta_db->nickname;
                                    

                            }



                             //*********************** calculation for addition of security amount into group creater wallet starts here


                                $amnt_added_to_wallet=$wallet_amount+$artist_security_deposit; // amount that gets added to Artists wallet

                                 //****************  If security amount not blank or not 0.00 then proceed to next step starts

                                 if(($artist_security_deposit!='') && ($artist_security_deposit!='0.00')) 
                                 {
                                    // echo "<br>";
                                    // echo "================= Here venue ===========================";
                                    // echo "<br>";
                                    // echo "Artist name is ".$artistnickname.' creater id is '.$creater_id."And venue name is ".$venuename."Event id ".$event_gig_id;
                                    // echo "<br>";
                                    // echo "Here we are security deposit for venue".$artist_security_deposit;
                                    // echo "<br>";
                                    // echo "Wallet amount for this venue creator is ".$wallet_amount;
                                    // echo "<br>";
                                    // echo "Mail will be send to ". $email ;
                                    // echo "<br>";
                                    // echo "============================================";
                                    // echo "<br>";


                                     //****************   Insert of data into user order table starts here*****************************
                                                        $dataorderInsert=array();
                                                        $dataorderInsert['payment_for']="SMR";
                                                       
                                                        
                                                        $dataorderInsert['payment_description']=$description;
                                                        $dataorderInsert['email']=$email;
                                                        $dataorderInsert['total_price']=$artist_security_deposit;
                                                        $dataorderInsert['user_ip_address']=$logggedin_user_ip;
                                                        $dataorderInsert['debitorcredit']="C"; // C=> Credit , D=> Debit
                                                        $dataorderInsert['gigmaster_id']=$event_gig_id;
                                                        
                                                        $dataorderInsert['invoice_num']="INV-".time().rand(111111,999999);
                                                        $dataorderInsert['user_id']=$creater_id;
                                                        $dataorderInsert['create_date']=$datedata;
                                                        $dataorderInsert['modified_date']=$datedata;
                                                        $dataorderInsert['payment_status']='SUCCESS';
                                                        
                            
                           // echo "3 dataorderInsert=><pre>"; print_r($dataorderInsert); echo "<pre>";
                                                       
                                                       $isInserted = DB::table('user_order')->insert($dataorderInsert);
                            
                                                       // $isInserted=DB::getPdo()->lastInsertId();
                               //************* Insert of adat into user order table ends here ******************


                            //***************************Update into usermaster table strats here *************


                                               $dataupdatearrayusermaster = array();
                                               $dataupdatearrayusermaster['wallet_amount']=$amnt_added_to_wallet;
                                               // echo "Wallet will be update for id ".$creater_id."<pre>";
                                               // print_r($dataupdatearrayusermaster);
                                               // echo "</pre>";

                             $chkupd= DB::table('user_master')->where('id',$creater_id)->update($dataupdatearrayusermaster);

                           //****************************Update into user master table ends here****************

                                //******************** Update into gig master table starts here *****************

                               $dataupdatearraygigmaster = array();
                               $dataupdatearraygigmaster['payment_flag']='6';
                               // echo "Wallet will be updat for id ".$user_id."<pre>";
                               // print_r($dataupdatearraygigmaster);
                               // echo "</pre>";

                               $chkupdgig= DB::table('gig_master')->where('id',$event_gig_id)->update($dataupdatearraygigmaster);



                               //********************  Update into gig master tabele ensds ehre****************



                               //****************** Sending of email to artist group and venue starts here
                               
                $artistgroupvenueemail_securityamount = $this->securityamountemail($giguniqueid,$artistnickname,$email,'$'.$artist_security_deposit,$venuename);
                               
                               //****************** Sending of email to artist group and venue ends here



                                 }

                                  //****************  If security amount not blank or not 0.00 then proceed to next step ends

                        //***********************  calculation of addition of security amount into group creater wallet ends here
                            
                            } //******* end of venue
                            //*** fetch data of artist from user_master table ends********




                }//******for each loop ends here
            }//************ $qryforsecuritymoneyAr ends

                     

    } //******  releaseofsecuritymoneytoagvwallet ends

//****************** email for security amount relase starts here
    public function securityamountemail($giguniqueid,$artistnickname,$email,$artist_security_deposit,$argvvenuename)
    {
            // echo "<br>";
            // echo "=========================";
            // echo "Gig ID ==== ".$giguniqueid;
            // echo "<br>";
            // echo "artistnickname ==== ".$artistnickname;
            // echo "<br>";
            // echo "email ========".$email;
            // echo "<br>";
            // echo "artist_security_deposit ==== ".$artist_security_deposit;
            // echo "<br>";
            // echo "argvvenuename ========".$argvvenuename;
            // echo "<br>";
            // echo "=========================";
            // echo "<br>";



                    $userssel = DB::table('settings')
                    ->select(DB::raw('site_name,email_from,copyright_year,email_template_logo_image'))
                    ->where('id', 1)
                    ->get();
                    $sitename=$userssel[0]->site_name;
                    $emailfrom=$userssel[0]->email_from;
                    $copyright_year=$userssel[0]->copyright_year;
                    $Imgologo=$userssel[0]->email_template_logo_image;
                    $bsurl = url('/');
                    $logoIMG = asset('public/upload/settings-image/source-file/'.$Imgologo);



                   // *********Helper Function Starts here

                 
                    $replacefrom =array('{USER}','{EVENT_NAME}','{SECURITY_AMOUNT}','{SITENAME}','{YEAR}','{BASE_URL}','{LOGO_IMG}','{PROFILE_NAME}');

                    $replaceto =array($artistnickname,$giguniqueid,$artist_security_deposit,$sitename,$copyright_year,$bsurl,$logoIMG,$argvvenuename);


                    mailsnd($Temid=51,$replacefrom,$replaceto,$email);



    }















}