	<?php

$formfortype = Request::segment(3);
if (empty($formfortype)) {
    $formfortype = 0;
} else {
    $formfortype = 1;
}
//   echo $formfortype;
// die;

$successmsg = '';
$errormsg   = '';
if (!empty($successmsgdata)) {
    $successmsg = $successmsgdata;
}

if (!empty($errormsgdata)) {
    $errormsg = $errormsgdata;
}

?>
@extends('layouts.admin.adminmaster',['successmsg' => $successmsg,'errormsg'=>$errormsg])
@section('content')
    <?php
$uid                = '';
$first_name         = '';
$middle_name        = '';
$last_name          = '';
$username           = '';
$nickname           = '';
$email              = '';
$oldpass            = '';
$gen                = '';
$address1           = '';
$address2           = '';
$country_id         = '';
$state_id           = '';
$city               = '';
$zip                = '';
$language_id        = '';
$skill_id           = '';
$subskill_id        = '';
$abn                = '';
$gst                = '';
$tfn                = '';
$currency           = '';
$rider              = '';
$description        = '';
$fburl              = '';
$soundcloudurl      = '';
$residentadvisorurl = '';
$twitterurl         = '';
$youtubeurl         = '';
$instagramurl       = '';
$country_id_data    = array();
$language_id_data   = array();
$skill_id_data      = array();
$currency_id_data   = array();
$fetchstateidData   = array();
$userimage_admin_view = array();
$date               = '';
$pagemeta           = '';
$userprskt_data     = '';
$user_status        = '';
$techspecs          = '';
$packuptime         = '';
$setuptime          = '';
$securityamount     = '';
$hourlyrate         = '';
$availforuser       = '';
$bookingsfrom       = '';
$verifiedornot='';
$setuptime_arrdata  = array();
$packuptime_arrdata = array();
if (!empty($userrow)) {
    // echo "<pre>";
    // print_r($userrow);die;
    $uid                = $userrow->id;
    $first_name         = stripslashes($userrow->first_name);
    $middle_name        = stripslashes($userrow->middle_name);
    $last_name          = stripslashes($userrow->last_name);
    $username           = $userrow->username;
    $nickname           = $userrow->nickname;
    $email              = $userrow->email;
    $oldpass            = $userrow->password;
    $gen                = $userrow->gender;
    $address1           = $userrow->address1;
    $address2           = $userrow->address2;
    $country_id         = $userrow->country;
    $state_id           = $userrow->state;
    $city               = $userrow->city;
    $zip                = $userrow->zip;
    $language_id        = $userrow->language;
    $abn                = $userrow->abn_data;
    $gst                = $userrow->gst_status;
    $tfn                = $userrow->tfn_data;
    $currency           = $userrow->currency;
    $rider              = $userrow->rider_data;
    $description        = $userrow->user_description;
    $fburl              = $userrow->facebook_url;
    $soundcloudurl      = $userrow->soundcloud_url;
    $residentadvisorurl = $userrow->residentadvisor_url;
    $twitterurl         = $userrow->twitter_url;
    $youtubeurl         = $userrow->youtube_url;
    $instagramurl       = $userrow->instagram_url;
    
    $pagemeta = $userrow->user_meta_data;
    
    $date = $userrow->dob;
    
    $user_status    = $userrow->status;
    $techspecs      = stripslashes($userrow->tech_spec);
    $packuptime     = $userrow->packup_time;
    $setuptime      = $userrow->setup_time;
    $securityamount = $userrow->security_figure;
    $hourlyrate     = $userrow->rate_amount;
    
    $bookingsfrom = $userrow->booking_from;
    
    $availforuser = $userrow->available_for;

    $verifiedornot=$userrow->verify_status;
    
}
if (!empty($countryidAr)) {
    $country_id_data = $countryidAr;
}
if (!empty($stateidAr)) {
    $fetchstateidData = $stateidAr;
}
if (!empty($languageidAr)) {
    $language_id_data = $languageidAr;
}
if (!empty($skillidAr)) {
    $skill_id_data = $skillidAr;
}
if (!empty($currencyidAr)) {
    $currency_id_data = $currencyidAr;
}
if (!empty($userpresskit)) {
    $userprskt_data = $userpresskit->presskit_name;
}
if ($date != '0000-00-00 00:00:00') {
    //echo $date;die;
    $date = date('m/d/Y', strtotime($date));
} else if ("0000-00-00 00:00:00") {
    $date = '';
}





for ($i = 15; $i <= 240; $i += 15) {

     if($i == 105)
    {
        $i=$i+15; 
    }
    if($i == 135)
    {
        $i=$i+45; 
    }
    if($i == 195)
    {
        $i=$i+45; 
    }

    $setuptime_arrdata[$i] = $i . ' Minutes';
}

for ($i = 15; $i <= 240; $i += 15) {

     if($i == 105)
    {
        $i=$i+15; 
    }
    if($i == 135)
    {
        $i=$i+45; 
    }
    if($i == 195)
    {
        $i=$i+45; 
    }

    $packuptime_arrdata[$i] = $i . ' Minutes';
}


?>
           <!-- <div class="padding-md">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">

                    </div>
                    </div>
            </div>-->
            <!-- /.padding-md --> 



            <div class="panel panel-default">
                    <div class="panel-heading">
                        Save user
                    </div>


                    <div class="panel-tab">    
                        <ul class="wizard-steps" id="wizardTab"> 
                            <li class="active">
                                <a href="#wizardContent1" data-toggle="tab">Basic Info</a>
                            </li> 
                            <li>
                                <a href="#wizardContent2" data-toggle="tab">Account Info</a>
                            </li> 
                            
                            <li>
                                <a href="#wizardContent4" data-toggle="tab">Social links</a>
                            </li>

                            <li>
                                <a href="#wizardContent5" data-toggle="tab">Booking Options</a>
                            </li>


                            <li>
                                <a href="#wizardContent3" data-toggle="tab">Profile Info</a>
                            </li>
                        </ul>
                    </div>
                    <div class="panel-body">
                        <?php
echo Form::open(array(
    'url' => ADMINSEPARATOR . '/usersave',
    'files' => true,
    'method' => 'post',
    'id' => 'useraddfrmid',
    'class' => "form-horizontal form-border no-margin"
));
?>
                       <div class="tab-content">


                        <!-- Basic information content    starts     -->


                            <div class="tab-pane fade in active" id="wizardContent1">
                                
                                    
                                    
                                    
                                    
                                    
                                    
                                    <div class="form-group">
                                        <label class="control-label col-lg-4">* Nickname</label>
                                        <div class="col-lg-4">                                        
                                            <?php
echo Form::text("nickname", $value = $nickname, $attributes = array(
    "id" => "nickname",
    "class" => " form-control input-sm parsley-validated "
));
?>
                                           <span  class="errorcustclass">{{ $errors->first('nickname') }}</span>
                                        </div><!-- /.col -->
                                    </div><!-- /form-group -->
                                    
                                    <div class="form-group">
                                        <label class="control-label col-lg-4">* Email</label>
                                        <div class="col-lg-4">
                                            <?php
echo Form::text("email", $value = $email, $attributes = array(
    "id" => "email",
    "class" => " form-control input-sm parsley-validated "
));
?>
   <span  class="errorcustclass">{{ $errors->first('email') }}</span>                                        
                                        </div><!-- /.col -->
                                    </div><!-- /form-group -->
                                    
                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Password</label>
                                        <div class="col-lg-4">
                                            
                                            <?php
$passval = '';
//echo Form::text("newpass", $value=$passval, $attributes = array( "id"=>"newpass","class"=>" form-control input-sm parsley-validated ")); 
?>

    <input type="password" name="newpass" class="form-control input-sm parsley-validated" id="newpass" value="<?php
echo $passval;
?>">
    <span  class="errorcustclass">{{ $errors->first('newpass') }}</span>

                                        </div><!-- /.col -->
                                    </div><!-- /form-group -->
                                    
    <?php
echo Form::hidden("oldpass", $value = $oldpass, $attributes = array(
    "id" => "oldpass",
    "class" => " form-control input-sm parsley-validated "
));
?>
                                   
                                    <div class="form-group">
                                        <label class="control-label col-lg-4">* Gender</label>
                                        <div class="col-lg-4">
                                            <?php
echo Form::select('gender', array(
    '' => 'Choose gender',
    '1' => 'Male',
    '2' => 'Female',
    '3' => 'Other'
), $gen, $attributes = array(
    "id" => "gender",
    "class" => "form-control input-sm parsley-validated"
));
?>
  <span  class="errorcustclass">{{ $errors->first('gender') }}</span>    
                                        </div><!-- /.col -->
                                    </div><!-- /form-group -->

                                    <!-- for dob starts here -->
                                    <div class="form-group">
                                        <label class="control-label col-lg-4">* Date of birth</label>
                                        
                                            <div class="col-lg-4">
                                                
                                                <div class="input-group"> <!-- datepicker div -->
                                                <?php
echo Form::text("dateofbirth", $value = $date, $attributes = array(
    "id" => "dateofbirth",
    "class" => "datepicker form-control input-sm parsley-validated"
));
?>
                                               <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                </div> <!-- end of datepicker div -->
                                                <span  class="errorcustclass">{{ $errors->first('dateofbirth') }}</span>


                                            </div><!-- /.col -->
                                    </div><!-- /form-group -->


                                    <!-- for dob ends here -->


                                        <!-- for resend activation link starts here -->
                                        <?php 
                                        if($formfortype == 1 && $verifiedornot==0 && $user_status!=1){

                                        ?>

                                        <div class="form-group">
                                            <label class="control-label col-lg-4"> </label>
                                            <div class="col-lg-4"> 
                                                <input type="button" class="btn btn-success btn-sm" value="Send activation link" id="activationlinkresend" data-id="<?php echo $email.'#####'.$uid;?>">
                                            </div>

                                        </div>
                                    <?php 

                                }
                                    ?>
                                      <!-- for resend activation activation link ends here -->









                            </div>

                            <!-- Account content    starts     -->

                            <div class="tab-pane fade" id="wizardContent2">
                            <div class="form-group">
                                        <label class="control-label col-lg-4">* First Name</label>
                                        <div class="col-lg-4">
                                            
                                            <?php
echo Form::text("first_name", $value = $first_name, $attributes = array(
    "id" => "first_name",
    "class" => " form-control input-sm parsley-validated "
));
?>
   <span  class="errorcustclass">{{ $errors->first('first_name') }}</span>

                                        </div><!-- /.col -->
                                    </div><!-- /form-group -->
                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Middle Name</label>
                                        <div class="col-lg-4">
                                            <?php
echo Form::text("middle_name", $value = $middle_name, $attributes = array(
    "id" => "middle_name",
    "class" => " form-control input-sm parsley-validated "
));
?>
                                           <span  class="errorcustclass">{{ $errors->first('middle_name') }}</span>
                                        </div><!-- /.col -->
                                    </div><!-- /form-group -->

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">* Last Name</label>
                                        <div class="col-lg-4">
                                            
                                            <?php
echo Form::text("last_name", $value = $last_name, $attributes = array(
    "id" => "last_name",
    "class" => " form-control input-sm parsley-validated "
));
?>
   <span  class="errorcustclass">{{ $errors->first('last_name') }}</span>

                                        </div><!-- /.col -->
                                    </div><!-- /form-group -->

                                <div class="form-group">
                                        <label class="control-label col-lg-4">* Address 1</label>
                                        <div class="col-lg-4">
                                            
                                            <?php
echo Form::text("address1", $value = $address1, $attributes = array(
    "id" => "address1",
    "class" => " form-control input-sm parsley-validated "
));
?>
   <span  class="errorcustclass">{{ $errors->first('address1') }}</span>

                                        </div><!-- /.col -->
                                    </div><!-- /form-group -->
                                    
                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Address 2</label>
                                        <div class="col-lg-4">
                                            
                                            <?php
echo Form::text("address2", $value = $address2, $attributes = array(
    "id" => "address2",
    "class" => " form-control input-sm parsley-validated "
));
?>
   <span  class="errorcustclass">{{ $errors->first('address2') }}</span>

                                        </div><!-- /.col -->
                                    </div><!-- /form-group -->
                                    
                                    <div class="form-group">
                                        <label class="control-label col-lg-4">* Country</label>
                                        <div class="col-lg-4">
                                            
                                            <?php
echo Form::select('country_id', $country_id_data, $country_id, $attributes = array(
    "id" => "country_id",
    "class" => "form-control input-sm parsley-validated"
));
?>

    <span  class="errorcustclass">{{ $errors->first('country_id') }}</span>

                                        </div><!-- /.col -->
                                    </div><!-- /form-group -->
                                    
                                    <div class="form-group">
                                        <label class="control-label col-lg-4">* State</label>
                                        <div class="col-lg-4">
   
                                            <?php
// $admin_control_attrAr=array();
// $admin_control_attrAr['id']='state_id';
// $admin_control_attrAr['class']="form-control input-sm parsley-validated";
// $fetchstateidData=array();
echo Form::select('state_id', $fetchstateidData, $state_id, $attributes = array(
    "id" => "state_id",
    "class" => "form-control input-sm parsley-validated"
));
?>

    <span  class="errorcustclass">{{ $errors->first('state_id') }}</span>

                                        </div><!-- /.col -->
                                    </div><!-- /form-group -->
                                    
                                    <div class="form-group">
                                        <label class="control-label col-lg-4">* City</label>
                                        <div class="col-lg-4">
                                            
                                            <?php
echo Form::text("city", $value = $city, $attributes = array(
    "id" => "city",
    "class" => " form-control input-sm parsley-validated "
));
?>
   <span  class="errorcustclass">{{ $errors->first('city') }}</span>

                                        </div><!-- /.col -->
                                    </div><!-- /form-group -->
                                    
                                    <div class="form-group">
                                        <label class="control-label col-lg-4">* Zip</label>
                                        <div class="col-lg-4">
                                            
                                            <?php
echo Form::text("zip", $value = $zip, $attributes = array(
    "id" => "zip",
    "class" => " form-control input-sm parsley-validated "
));
?>
   <span  class="errorcustclass">{{ $errors->first('zip') }}</span>

                                        </div><!-- /.col -->
                                    </div><!-- /form-group -->
                                    
                                    <div class="form-group">
                                        <label class="control-label col-lg-4">* Language</label>
                                        <div class="col-lg-4">
                                            
                                            <?php
echo Form::select('language_id', $language_id_data, $language_id, $attributes = array(
    "id" => "language_id",
    "class" => "form-control input-sm parsley-validated"
));
?>

    <span  class="errorcustclass">{{ $errors->first('language_id') }}</span>

                                        </div><!-- /.col -->
                                    </div><!-- /form-group -->

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">* Currency</label>
                                        <div class="col-lg-4">
                                            
                                            <?php
echo Form::select('currency', $currency_id_data, $currency, $attributes = array(
    "id" => "currency",
    "class" => "form-control input-sm parsley-validated"
));
?>

    <span  class="errorcustclass">{{ $errors->first('currency') }}</span>

                                        </div><!-- /.col -->
                                    </div><!-- /form-group -->
                            </div>
                    

                    <!-- profile content    starts     -->


                            <div class="tab-pane fade" id="wizardContent3">
                                <div class="form-group">
                                        <label class="control-label col-lg-4">Category</label>
                                        <div class="col-lg-4">
                                            
                                            <?php
echo Form::select('skill_id', $skill_id_data, $skill_id, $attributes = array(
    "id" => "skill_id_usr",
    "class" => "form-control input-sm parsley-validated",
    "placeholder" => "Select category"
));
?>

    <span  class="errorcustclass">{{ $errors->first('skill_id') }}</span>

                                        </div><!-- /.col -->
                                    </div><!-- /form-group -->
                                    
                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Genre</label>
                                        <div class="col-lg-4">
   
                                            <?php
$admin_control_attrAr                = array();
$admin_control_attrAr['id']          = 'subskill_id_usr';
$admin_control_attrAr['class']       = "selectpicker form-control input-sm parsley-validated";
$admin_control_attrAr['placeholder'] = "Select genre";
$fetchsubskillidData                 = array();
echo Form::select('subskill_id', $fetchsubskillidData, $subskill_id, $admin_control_attrAr);
?>

    <span  class="errorcustclass">{{ $errors->first('subskill_id') }}</span>

                                        </div><!-- /.col -->
                                    </div><!-- /form-group -->


                                                        <div class="form-group">
                                                            <label class="control-label col-lg-4"></label>
                                                            <div class="col-lg-4" id="user_categorygenrelist">
                                                            <!-- <b>hello</b> -->
                                                            </div>
                                                        </div><!--/ display category and sub category-->
                                    
                                    <div class="form-group">
                                        <label class="control-label col-lg-4">ABN</label>
                                        <div class="col-lg-4">
                                            
                                            <?php
echo Form::text("abn", $value = $abn, $attributes = array(
    "id" => "abn",
    "class" => " form-control input-sm parsley-validated "
));
?>
   <span  class="errorcustclass">{{ $errors->first('abn') }}</span>

                                        </div><!-- /.col -->
                                    </div><!-- /form-group -->
                                    
                                    <div class="form-group">
                                        <label class="control-label col-lg-4">GST</label>
                                        <div class="col-lg-4">
                                            <?php
echo Form::select('gst', array(
    '1' => 'Yes',
    '0' => 'No'
), $gst, $attributes = array(
    "id" => "gst",
    "class" => "form-control input-sm parsley-validated"
));
?>
  <span  class="errorcustclass">{{ $errors->first('gst') }}</span>    
                                        </div><!-- /.col -->
                                    </div><!-- /form-group -->
                                    
                                    <div class="form-group" id="tfndiv">
                                        <label class="control-label col-lg-4">TFN</label>
                                        <div class="col-lg-4">
                                            
                                            <?php
echo Form::text("tfn", $value = $tfn, $attributes = array(
    "id" => "tfn",
    "class" => " form-control input-sm parsley-validated "
));
?>
   <span  class="errorcustclass">{{ $errors->first('tfn') }}</span>

                                        </div><!-- /.col -->
                                    </div><!-- /form-group -->
                                    
                                    
                                    
                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Rider</label>
                                        <div class="col-lg-4">
                                            <?php
echo Form::textarea("rider", $value = $rider, $attributes = array(
    "id" => "rider",
    "class" => "form-control input-sm"
));
?>
                                           <span  class="errorcustclass">{{ $errors->first('rider') }}</span>
                                        </div><!-- /.col -->
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Page Meta Tag</label>
                                        <div class="col-lg-4">
                                            <?php
echo Form::text("pagemeta", $value = $pagemeta, $attributes = array(
    "id" => "pagemeta",
    "class" => "form-control input-sm"
));
?>
                                           <span  class="errorcustclass">{{ $errors->first('pagemeta') }}</span>
                                        </div><!-- /.col -->
                                    </div>

                                        
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">Description</label>
                                        <div class="col-lg-4">
                                            <?php
echo Form::textarea("description", $value = $description, $attributes = array(
    "id" => "description",
    "class" => "form-control input-sm"
));
?>
                                           <span  class="errorcustclass">{{ $errors->first('description') }}</span>
                                        </div><!-- /.col -->
                                    </div>


                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">Load Press kit</label>
                                        <div class="col-lg-4">
                                            <input type="file" name="presskit_name[]" id="presskit_name" class="form-control input-sm"  >

                                            <span  class="errorcustclass"><?php
echo $errors->first('presskit_name');
?> </span>
                                        </div><!-- /.col -->
                                        <div class="col-lg-4">
                                            <!--  <a href="" class="fa fa-download">Download Press kit</a> -->


                       <?php
if (!empty($userprskt_data)) {
    $userprskt_data_user = ADMINSEPARATOR . '/userpresskitadmin/' . base64_encode($userprskt_data);
    echo link_to($userprskt_data_user, $title = 'Download press kit', $attributes = array(
        "class" => "fa fa-download",
        "target" => "_blank"
    ), $secure = null);
}

?>


                                        </div>

                                    </div>


                                    <!-- imageupload starts-->
                                    <div class="form-group" id="usrtotalimage">
                                        <label class="col-lg-4 control-label">Upload Image<br>(Maximum 3 Pictures Allowed)<br> Minimum Image Dimension (458 (Width) * 476 (Height)) <br> Preferred Image Dimension .jpg .jpeg .png</label>
                                        <div class="col-lg-2">
                                            <span class="userimgupldclsadmin">

                                                <img src="{{ADMINCSSPATH}}/otherfiles/progimages/upload_icon.png" alt=""> 

                                            </span>
                                        
                                        </div><!-- /.col -->
                                     
                                        
                                    </div>
                                    <div class="form-group" id="usrprogressbar">
                                        <label class="col-lg-4 control-label"></label>
                                            <div class="col-lg-4">
                                            <!--progressive  starts-->    
                                                <div class='userprofimgprogress' id="progress_div">
                                                    <div class='userprofimgbar' id='bar'></div>
                                                    <div class='userprofimgpercent' id='percent'></div>

                                                </div>
                                            <!--progressive  ends-->
                                            </div><!-- /.col -->

                                            
                                    </div>
                                    <!-- imageupload ends-->
                                    <!-- display image starts here -->
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label"></label>
                                            <div class="col-lg-4" id="showuserimageanchr">
			                                    <?php
			                                    if(!empty($userimage_admin)){
			                                    	foreach($userimage_admin as $userimage_admin_obj){
			                                    		$imgname= $userimage_admin_obj->image_name;
                                                        $userimgID = $userimage_admin_obj->id;
                                                        $userimgsts=$userimage_admin_obj->default_status;
                                                        $usID=$userimage_admin_obj->user_id;
			                                    		$imgurldata = BASEURLPUBLICCUSTOM.'upload/userimage/thumb-small/'.$userimage_admin_obj->image_name;?>
			                                    		<img src="{{$imgurldata}}" onclick="javascript:showIMageFancy('<?php echo $imgname; ?>');"><a onclick='deleteuserimage({{$userimgID }},{{$userimgsts}},{{$usID}});'> Delete</a>
			                                    		<?php
			                                    		}
			                                    }else if(empty($userimage_admin))
                                                {
                                                     $imgurldatablnk = BASEURLPUBLICCUSTOM.'admin/otherfiles/progimages/noimagefound52X52.jpg';?>
                                                     <img src="{{$imgurldatablnk}}" ><?php
                                                }
			                                    ?>
			                            </div>
                                  <!--progressive  ends-->
                                  </div><!-- /.col -->
                                    <!-- display image ensds here -->





                            </div> <!----end of profile content---->
                            <!------social content starts------>

                            <div class="tab-pane fade" id="wizardContent4">
                                    <div class="form-group">
                                        <label class="control-label col-lg-4">* Facebook URL</label>
                                        <div class="col-lg-4">                                        
                                            <?php
echo Form::text("fburl", $value = $fburl, $attributes = array(
    "id" => "fburl",
    "class" => "form-control input-sm parsley-validated "
));
?>
                                           <span  class="errorcustclass">{{ $errors->first('fburl') }}</span>
                                        </div><!-- /.col -->
                                    </div><!-- /form-group -->

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">* Soundcloud URL</label>
                                        <div class="col-lg-4">                                        
                                            <?php
echo Form::text("soundcloudurl", $value = $soundcloudurl, $attributes = array(
    "id" => "soundcloudurl",
    "class" => "form-control input-sm parsley-validated "
));
?>
                                           <span  class="errorcustclass">{{ $errors->first('soundcloudurl') }}</span>
                                        </div><!-- /.col -->
                                    </div><!-- /form-group -->

                                            <div class="form-group">
                                        <label class="control-label col-lg-4">* Mixcloud URL</label>
                                        <div class="col-lg-4">                                        
                                            <?php
echo Form::text("residentadvisorurl", $value = $residentadvisorurl, $attributes = array(
    "id" => "residentadvisorurl",
    "class" => "form-control input-sm parsley-validated "
));
?>
                                           <span  class="errorcustclass">{{ $errors->first('residentadvisorurl') }}</span>
                                        </div><!-- /.col -->
                                    </div><!-- /form-group -->
                                    
                                    <div class="form-group">
                                        <label class="control-label col-lg-4">* Twitter URL</label>
                                        <div class="col-lg-4">                                        
                                            <?php
echo Form::text("twitterurl", $value = $twitterurl, $attributes = array(
    "id" => "twitterurl",
    "class" => "form-control input-sm parsley-validated "
));
?>
                                           <span  class="errorcustclass">{{ $errors->first('twitterurl') }}</span>
                                        </div><!-- /.col -->
                                    </div><!-- /form-group -->
                                    
                                    <div class="form-group">
                                        <label class="control-label col-lg-4">* Youtube URL</label>
                                        <div class="col-lg-4">                                        
                                            <?php
echo Form::text("youtubeurl", $value = $youtubeurl, $attributes = array(
    "id" => "youtubeurl",
    "class" => "form-control input-sm parsley-validated "
));
?>
                                           <span  class="errorcustclass">{{ $errors->first('youtubeurl') }}</span>
                                        </div><!-- /.col -->
                                    </div><!-- /form-group -->
                                    
                                    <div class="form-group">
                                        <label class="control-label col-lg-4">* Instagram URL</label>
                                        <div class="col-lg-4">                                        
                                            <?php
echo Form::text("instagramurl", $value = $instagramurl, $attributes = array(
    "id" => "instagramurl",
    "class" => "form-control input-sm parsley-validated "
));
?>
                                           <span  class="errorcustclass">{{ $errors->first('instagramurl') }}</span>
                                        </div><!-- /.col -->
                                        <input type="hidden" name="uid" value="<?php
echo $uid;
?>" id="userID">
                                        <input type="hidden" name="formtype" value="<?php
echo $formfortype;
?>" >
                                    </div><!-- /form-group -->
                            </div><!---end of social content-->

<!-- for booking options starts-->
                            <div class="tab-pane fade" id="wizardContent5">
                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Available for</label>
                                        <div class="col-lg-4">                                        
                                            <?php
echo Form::select('availforuser', array(
    '' => 'Choose option',
    '3' => 'All',
    '1' => 'Public',
    '2' => 'Private'
), $availforuser, $attributes = array(
    "id" => "availforuser",
    "class" => "form-control input-sm parsley-validated"
));
?>
                                           <span  class="errorcustclass">{{ $errors->first('availforuser') }}</span>
                                        </div><!-- /.col -->
                                    </div><!-- /form-group -->

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Bookings from</label>
                                        <div class="col-lg-4">    

                                            <?php
echo Form::select('bookingsfrom', array(
    '' => 'Choose option',
    '1' => 'Worldwide',
    '2' => 'My country',
    '3' => 'My city'
), $bookingsfrom, $attributes = array(
    "id" => "availforuser",
    "class" => "form-control input-sm parsley-validated"
));
?>

                                            <span  class="errorcustclass">{{ $errors->first('bookingsfrom') }}</span>
                                        </div><!-- /.col -->
                                    </div><!-- /form-group -->

                                            <div class="form-group">
                                        <label class="control-label col-lg-4">Hourly Rate</label>
                                        <div class="col-lg-4">                                        
                                            <?php

echo Form::text("hourlyrate", $value = $hourlyrate, $attributes = array(
    "id" => "hourlyrate",
    "class" => "form-control input-sm parsley-validated "
));
?>
                                           <span  class="errorcustclass">{{ $errors->first('hourlyrate') }}</span>
                                        </div><!-- /.col -->
                                    </div><!-- /form-group -->
                                    
                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Security Deposit</label>
                                        <div class="col-lg-4">                                        
                                            <?php

echo Form::text("securityamount", $value = $securityamount, $attributes = array(
    "id" => "securityamount",
    "class" => "form-control input-sm parsley-validated "
));
?>
                                           <span  class="errorcustclass">{{ $errors->first('securityamount') }}</span>
                                        </div><!-- /.col -->
                                    </div><!-- /form-group -->
                                    
                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Set-up Time:</label>
                                        <div class="col-lg-4">    

                                            <?php
echo Form::select('setuptime', $setuptime_arrdata, $setuptime, $attributes = array(
    "id" => "setuptime",
    "class" => "form-control input-sm parsley-validated",
    "placeholder" => "select Set-up time"
));
?>

                                            <span  class="errorcustclass">{{ $errors->first('setuptime') }}</span>
                                        </div><!-- /.col -->
                                    </div><!-- /form-group -->
                                    
                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Pack-up Time:</label>
                                        <div class="col-lg-4">            

                                            <?php
echo Form::select('packuptime', $packuptime_arrdata, $packuptime, $attributes = array(
    "id" => "packuptime",
    "class" => "form-control input-sm parsley-validated",
    "placeholder" => "select Pack-up time"
));
?>


                                            <span  class="errorcustclass">{{ $errors->first('packuptime') }}</span>
                                        </div><!-- /.col -->


                                    <!--     <input type="hidden" name="uid" value="<?php //echo $uid; 
?>" id="userID">
                                        <input type="hidden" name="formtype" value="<?php // echo $formfortype; 
?>" > -->
                                    </div><!-- /form-group -->

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Tech Specs <br>(Maximum 250 characters)</label>
                                        <div class="col-lg-4">                                        
                                            <?php

echo Form::textarea("techspecs", $value = $techspecs, $attributes = array(
    "id" => "techspecs",
    "class" => "form-control input-sm parsley-validated "
));
?>
                                           <span  class="errorcustclass">{{ $errors->first('techspecs') }}</span>
                                        </div><!-- /.col -->
                                    </div><!-- /form-group -->


                            </div><!-- for booking options ends-->
                        </div><!-----end of tab content------>
                        
                    </div>
                    <div class="panel-footer">
                        <a class="btn btn-warning" id="prevStep" disabled><i class="fa fa-chevron-left"></i> Previous</a>
                        <a class="btn btn-primary" id="nextStep">Next <i class="fa fa-chevron-right"></i></a>
                        <span class="pull-right">
                            <button class="btn btn-success" type="submit" id="addeditcomplete">Submit</button> 
                            <a class="btn btn-warning" href="<?php
echo url(ADMINSEPARATOR . '/user');
?>"><i class="fa fa-chevron-left"></i> Back</a>
                        </span>
                    </div>
                    <div class="panel-footer" id="footer2">
                        
                            <button class="btn btn-success" type="button" id="addeditcomplete_btn">Submit</button> 
                            <a class="btn btn-warning" href="<?php
echo url(ADMINSEPARATOR . '/user');
?>"><i class="fa fa-chevron-left"></i> Back</a>
                    
                    </div>
                    <?php
echo Form::close();
?>

                    <!--file control form for image upload  starts-->                            
                        <?php
echo Form::open(array(
    'url' => ADMINSEPARATOR . '/userimagesaveadmin',
    'files' => true,
    'method' => 'post',
    'id' => 'imgfrmid',
    'class' => "form-horizontal form-border no-margin",
    'style' => 'display:none'
));
?>
                                           <input type="text" name="userid_fr_imageupload" value=<?php
echo $uid;
?>>        
                                            <input type="file" id="image_name" name="image_name[]"  />
                            <input  type="submit" id="submitbutnid" name='submit_image' value="Submit Comment"  onclick='upload_image("imgfrmid");' />
                                        <?php
echo Form::close();
?>                            
                        <!--file control form for image upload ends-->
                </div><!-- /panel -->
    
     <!-- for country respective state dorpdown js starts -->
    <!-- <script type="text/javascript" src="{{ URL::asset('public/admin')}}/otherfiles/progjs/countrywisestatelist.js"></script> -->
    <script type="text/javascript" src="{{ ADMINCSSPATH}}/otherfiles/progjs/countrywisestatelist.js"></script>
    <!-- for country respective state dorpdown js ends -->
    <!--for ajax file upload starts-->
        <script type="text/javascript" src="{{ ADMINCSSPATH}}/otherfiles/ajaximageupload_library/jquery.form.js"></script>
        <script type="text/javascript" src="{{ ADMINCSSPATH}}/otherfiles/progjs/userimageuploadadmin.js"></script>
    <!--for ajax file upload ends-->

    <!-- script for fancy box starts here -->
    <script type="text/javascript" src="{{ BASEURLPUBLICCUSTOM.'commonassets'}}/fancybox/source/jquery.fancybox.js?v=2.1.5"></script>
<link rel="stylesheet" type="text/css" href="{{ BASEURLPUBLICCUSTOM.'commonassets'}}/fancybox/source/jquery.fancybox.css?v=2.1.5" media="screen" />
    <!-- script for fancy box ends here -->
    <script>

    var typeflag = '<?php
echo $formfortype;
?>';
    var user_ststus_chk = '<?php
echo $user_status;
?>';

    var ststus_chk = '<?php
echo $user_status;
?>';


    var usertotalimagecount = '<?php echo $user_image_admin_count?>'
     $("#usrprogressbar").addClass('mydiplaymoneadmin');
        if(usertotalimagecount >= 3 ){
            $("#usrtotalimage").addClass('mydiplaymoneadmin');
            $("#usrprogressbar").addClass('mydiplaymoneadmin');
   }else if(usertotalimagecount <= 3){
      $("#usrtotalimage").removeClass('mydiplaymoneadmin');
     // $("#usrprogressbar").removeClass('mydiplaymoneadmin');
   }

//console.log("user_image_admin_count"+usertotalimagecount);
if(user_ststus_chk)
{
    if(user_ststus_chk!=1)
    {
                $("#useraddfrmid input").attr('readonly','readonly');
                $("#gender").attr("disabled", 'disabled');
                $("#country_id").attr("disabled", 'disabled');

                $("#state_id").attr("disabled", 'disabled');

                $("#language_id").attr("disabled", 'disabled');


                $("#currency").attr("disabled", 'disabled');

                $("#skill_id_usr").attr('disabled', true);

                $("#subskill_id_usr").attr('disabled', true);

                $("#gst").attr("disabled", 'disabled');

                $("#rider").attr("disabled", 'disabled');

                $("#description").attr("disabled", 'disabled');
        
        
        
    }
}

// fancybox script starts
 function showIMageFancy(imagename)
            {
         
                if(imagename!='')
                {
                    $.fancybox.open("<?php echo BASEURLPUBLICCUSTOM.'upload/userimage/thumb-big';?>"+"/"+imagename);
                
                    $('.fancybox-opened').css('z-index',999999);
                }
            }

            // fancybox script ends













    </script>

    <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
          <div class="modal-body">
          <p>Are you sure want to delete ? </p>
        </div>
        <div class="modal-footer">

        <input type="hidden" id="hdnursid" value="">
        <input type="hidden" id="hdnskillmaster_ID" value="">
        <input type="hidden" id="hdnskillmaster_parentID" value="">
            


          <button type="button" class="btn btn-default" data-dismiss="modal" id="close_modal">Close</button>
          <button type="button" class="btn btn-success" data-dismiss="modal" id="delete" onclick="delteusrskill();">Delete</button>
        </div>
      </div>
      
    </div>
  </div>


  <div class="modal fade" id="myModalusrskildltsts" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
          <div class="modal-body" id="skilldletststususr">
          <p>Are you sure want to delete ? </p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" id="close_modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>

  <!-- modalfor delete user image -->
  <div class="modal fade" id="myModalusrsimagedelete" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
          <div class="modal-body" id="skilldletststususr">
          <span id="userimagedeletetext"></span>
          <p>Are you sure want to delete ? </p>

        </div>
        <div class="modal-footer">
        <!-- <input type="hidden" id="hdnursidimagedel" value=""> -->
         <input type="hidden" id="hdnuserID" value="">
        <input type="hidden" id="hdnuserimgsts" value="">
        <input type="hidden" id="hdnuserimgID" value="">
            
          <button type="button" class="btn btn-default" data-dismiss="modal" id="close_modal">Close</button>
          <button type="button" class="btn btn-success" data-dismiss="modal" id="delete" onclick="deleteusrimg();">Delete</button>

        </div>
      </div>
      
    </div>
  </div>




   <div class="modal fade" id="adminsuerimagedeleteresponse" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
          <div class="modal-body" id="adminsuerimagedeleteresponseinner">
       
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" id="close_modal2">Close</button>
        </div>
      </div>
      
    </div>
  </div>


  <style>
  .userprofimgpercent {
position: absolute;
display: inline-block;
top: 3px;
left: 0;
right: 0;
text-align: center;
/*background-color: cyan;*/
}

.userprofimgprogress 
{
  display:none; 
  position:relative; 
  width:400px; 
  border: 1px solid #ddd; 
  padding: 1px; 
  border-radius: 3px;
  background-color: #5cb85c;
}
.userprofimgbar 
{ 
  /*background-color: cyan; */
  width:0%; 
  height:20px; 
  border-radius: 3px; 
}

.mydiplaymoneadmin{
    display: none;
}


  </style>



@endsection