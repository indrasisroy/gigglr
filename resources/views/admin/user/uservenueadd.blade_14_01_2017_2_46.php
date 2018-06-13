<?php

$formfortype = Request::segment(3);
$ucreaterid  = Request::segment(4);

$venueexistsflag = Request::segment(5);

if (empty($formfortype)) {
    $formfortype = 0;
} else {
    $formfortype = 1;
}
//   echo $formfortype;
// die;
if (empty($venueexistsflag)) {
    $venueexistsflag = 0;
} else {
    $venueexistsflag = 1;
}

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
$date               = '';
$pagemeta           = '';
$venuerow_press_kit = '';
$uvenue_id          = '';
$venuerowmenu       = '';
$select_amenity     = array();
$user_status        = '';


$techspecs          = '';
$opening_time       = '';
$closing_time       = '00:30';
$securityamount     = '';
$hourlyrate         = '';
$availforuser       = '';
$bookingsfrom       = '';
$setuptime_arrdata  = array();
$packuptime_arrdata = array();
$closingtimedata    = '';
$openingtimedata    = '';

if (!empty($uservenuerow)) {
    
    $uid        = $uservenuerow->id;
    $ucreaterid = $uservenuerow->creater_id;
    $nickname   = stripslashes(ucfirst($uservenuerow->nickname));
    
    $address1   = stripslashes($uservenuerow->address_1);
    $address2   = stripslashes($uservenuerow->address_2);
    $country_id = $uservenuerow->country;
    $state_id   = $uservenuerow->state;
    $city       = stripslashes($uservenuerow->city);
    $zip        = $uservenuerow->zip;
    
    $abn = $uservenuerow->abn_data;
    $gst = $uservenuerow->gst_status;
    $tfn = $uservenuerow->tfn_data;
    
    $rider              = $uservenuerow->rider_data;
    $description        = $uservenuerow->venue_description;
    $fburl              = $uservenuerow->facebook_url;
    $soundcloudurl      = $uservenuerow->soundcloud_url;
    $residentadvisorurl = $uservenuerow->residentadvisor_url;
    $twitterurl         = $uservenuerow->twitter_url;
    $youtubeurl         = $uservenuerow->youtube_url;
    $instagramurl       = $uservenuerow->instagram_url;
    
    $pagemeta = $uservenuerow->venue_meta_data;
    
    
    
    $techspecs      = stripslashes($uservenuerow->tech_spec);
    $securityamount = $uservenuerow->security_figure;
    $hourlyrate     = $uservenuerow->rate_amount;
    $bookingsfrom   = $uservenuerow->booking_from;
    $availforuser   = $uservenuerow->available_for;
    
    
    if ($uservenuerow->opening_time != "00:00:00") {
        
        $openingtimedata = $uservenuerow->opening_time;
        
        $opening_time = date('H:i', strtotime($openingtimedata)); // die;
    }
    
    if ($uservenuerow->closing_time != "00:00:00") {
        
        $closingtimedata = $uservenuerow->closing_time;
        
        $closing_time = date('H:i', strtotime($closingtimedata)); // die;
    }
    
}
if (!empty($countryidAr)) {
    $country_id_data = $countryidAr;
}
if (!empty($stateidAr)) {
    $fetchstateidData = $stateidAr;
}

if (!empty($skillidAr)) {
    $skill_id_data = $skillidAr;
}

if (!empty($venuerow_press)) {
    $venuerow_press_kit = $venuerow_press->presskit_name;
}



if (!empty($venuerow_menu)) {
    //echo 'sadsa';
    
    $venuerowmenu = $venuerow_menu->menu_name;
}




if (!empty($qry_select_amenity)) {
    
    $select_amenity = $qry_select_amenity;
    
    
    
}
if ($user_status_chk == 0 || $user_status_chk > 0) {
    $user_status = $user_status_chk;
}




?>
           
            <div class="panel panel-default">
                    <div class="panel-heading">
                        Save Venue
                    </div>


                    <div class="panel-tab">    
                        <ul class="wizard-steps" id="wizardTab"> 
                            <li class="active">
                                <a href="#wizardContent1" data-toggle="tab">Account Info</a>
                            </li> 
                            <li>
                                <a href="#wizardContent2" data-toggle="tab">Social links</a>
                            </li> 

                            <li>
                                <a href="#wizardContent4" data-toggle="tab">Booking Options</a>
                            </li>

                            <li>
                                <a href="#wizardContent3" data-toggle="tab">Profile Info</a>
                            </li>
                        </ul>
                    </div>
                    <div class="panel-body">
                        <?php
echo Form::open(array(
    'url' => ADMINSEPARATOR . '/uservenuesave',
    'files' => true,
    'method' => 'post',
    'id' => 'uservenueaddfrmid',
    'class' => "form-horizontal form-border no-margin"
));
?>
                       <div class="tab-content">


                        <!-- Basic information content    starts     -->


                            <div class="tab-pane fade in active" id="wizardContent1">
                                
                                    
                                    
                                    
                                                    <div class="form-group">
                                                    <label class="control-label col-lg-4">* Venue Name</label>
                                                    <div class="col-lg-4">

                                                    <?php
echo Form::text("nickname", $value = $nickname, $attributes = array(
    "id" => "nickname",
    "class" => " form-control input-sm parsley-validated "
));
?>
                                                   <span  class="errorcustclass">{{ $errors->first('nickname') }}</span>

                                                    </div><!-- /.col -->
                                                    </div><!-- /form-group --><!--/ Nickname-->
                                                    

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
                                                    </div><!-- /form-group --><!--/ Address1-->

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
                                                    </div><!-- /form-group --><!--/ Address2-->

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
                                                    </div><!-- /form-group --><!--/ Country-->

                                                    <div class="form-group">
                                                    <label class="control-label col-lg-4">* State</label>
                                                    <div class="col-lg-4">

                                                    <?php
// $admin_control_attrAr=array();
// $admin_control_attrAr['id']='state_id';
// $admin_control_attrAr['class']="form-control input-sm parsley-validated";
// $fetchstateidData=array();

// echo "<pre>";
// print_r($fetchstateidData);
echo Form::select('state_id', $fetchstateidData, $state_id, $attributes = array(
    "id" => "state_id",
    "data-venueid" => "venueIDchk",
    "class" => "form-control input-sm parsley-validated"
));
?>

                                                    <span  class="errorcustclass">{{ $errors->first('state_id') }}</span>

                                                    </div><!-- /.col -->
                                                    </div><!-- /form-group --><!--/ State-->

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
                                                    </div><!-- /form-group --><!--/ City-->

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
                                                    </div><!-- /form-group --><!--/ Zip-->

                                                
                                    
                            </div>

                            <!-- Account content    starts     -->

                            <div class="tab-pane fade" id="wizardContent2">
                            


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
                                                        </div><!-- /form-group --><!--/ Facebook URL-->

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
                                                        </div><!-- /form-group --><!--/ Soundcloud URL-->

                                                        <div class="form-group">
                                                        <label class="control-label col-lg-4">* Zomato URL</label>
                                                        <div class="col-lg-4">                                        
                                                        <?php
echo Form::text("residentadvisorurl", $value = $residentadvisorurl, $attributes = array(
    "id" => "residentadvisorurl",
    "class" => "form-control input-sm parsley-validated "
));
?>
                                                       <span  class="errorcustclass">{{ $errors->first('residentadvisorurl') }}</span>
                                                        </div><!-- /.col -->
                                                        </div><!-- /form-group --><!--/ Residentadvisor URL-->

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
                                                        </div><!-- /form-group --><!--/ Twitter URL-->

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
                                                        </div><!-- /form-group --><!--/ Youtube URL-->

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
?>" id="vnuID" >
                                                        <input type="hidden" name="ucreaterid" value="<?php
echo $ucreaterid;
?>" id="vnucreatrID">
                                                        <input type="hidden" name="formtype" value="<?php
echo $formfortype;
?>" >
                                                        </div><!-- /form-group --><!--/ Instagram URL-->









                            </div>
                    

                    <!-- profile content    starts     -->


                            <div class="tab-pane fade" id="wizardContent3">
                                                        <div class="form-group" id="chkcategoryflag">
                                                        <label class="control-label col-lg-4">Category</label>
                                                        <div class="col-lg-4">

                                                        <?php
echo Form::select('skill_id', $skill_id_data, $skill_id, $attributes = array(
    "id" => "skill_id",
    "class" => "form-control input-sm parsley-validated",
    "placeholder" => "Select category"
));
?>

                                                        <span  class="errorcustclass">{{ $errors->first('skill_id') }}</span>

                                                        </div><!-- /.col -->
                                                        </div><!-- /form-group --><!--/ -category-->

                                                        <div class="form-group" id="chksubcategoryflag">
                                                        <label class="control-label col-lg-4">Genre</label>
                                                        <div class="col-lg-4">

                                                        <?php
$admin_control_attrAr                = array();
$admin_control_attrAr['id']          = 'subskill_id';
$admin_control_attrAr['class']       = "selectpicker form-control input-sm parsley-validated";
$admin_control_attrAr['placeholder'] = "Select genre";
$fetchsubskillidData                 = array();
echo Form::select('subskill_id', $fetchsubskillidData, $subskill_id, $admin_control_attrAr);
?>

                                                        <span  class="errorcustclass">{{ $errors->first('subskill_id') }}</span>

                                                        </div><!-- /.col -->
                                                        </div><!-- /form-group --><!--/ Sub-category-->

                                                        <div class="form-group" id="chkcategorylistflag">
                                                        <label class="control-label col-lg-4"></label>
                                                            <div class="col-lg-4" id="sports_venuelist">
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
                                                        </div><!-- /form-group --><!--/ ABN-->

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
                                                        </div><!-- /form-group --><!--/ GST-->

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
                                                        </div><!-- /form-group --><!--/ TFN-->



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
                                                        </div><!--/ Rider-->

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
                                                        </div><!--/ Page Meta Tag-->






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
                                                        </div><!--/ description-->



                                                        <div class="form-group">
                                                        <label class="col-lg-4 control-label">Amienities</label>
                                                        <div class="col-lg-4">
                                                                        <?php
if (!empty($amenity_all)) {
    
    foreach ($amenity_all as $venue_amenities) {
        $amenitiesID   = $venue_amenities->id;
        $amenitiesname = $venue_amenities->amenity_name;
        
?>
                                                                       
                                                                                <label class="label-checkbox ">
                                                                                <input type="checkbox" class="lblcheckbox" name='valchk[]' value="{{$amenitiesID}}" id="venueamenities"

                                                                                <?php
        echo ((in_array($amenitiesID, $select_amenity)) ? 'checked' : '');
?>
                               

                                                                                >
                                                                                <span class="custom-checkbox"></span>
                                                                                {{$amenitiesname}}
                                                                                </label>

                                                                        <?php
    }
}
?>
                                                                       
                                                                        
                                                        </div><!-- /.col -->
                                                        

                                                        </div><!--/ Amienities-->



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
if (!empty($venuerow_press_kit)) {
    $uservnuprskt_data_user = ADMINSEPARATOR . '/uservenuepresskitadmin/' . base64_encode($venuerow_press_kit);
    echo link_to($uservnuprskt_data_user, $title = ' ', $attributes = array(
        "class" => "fa fa-download",
        "target" => "_blank",
        "title"=>"Click here to download press kit"
    ), $secure = null);
}

?>


                                                        </div>

                                                        </div><!--/ Press kit-->

                                                        <div class="form-group">
                                                        <label class="col-lg-4 control-label">Upload Menu</label>
                                                        <div class="col-lg-4">
                                                        <input type="file" name="venue_menu[]" id="venue_menu" class="form-control input-sm"  >

                                                        <span  class="errorcustclass"><?php
echo $errors->first('venue_menu');
?> </span>
                                                        </div><!-- /.col -->
                                                        <div class="col-lg-4">
                                                        <!--  <a href="" class="fa fa-download">Download Press kit</a> -->


                                                        <?php
if (!empty($venuerowmenu)) {
    $uservenue_data_user = ADMINSEPARATOR . '/uservenuemenuadmin/' . base64_encode($venuerowmenu);
    echo link_to($uservenue_data_user, $title = '', $attributes = array(
        "class" => "fa fa-download",
        "target" => "_blank",
         "title"=>"Click here to download menu"
    ), $secure = null);
}

?>


                                                        </div>

                                                        </div><!--/ Upload Menu-->


                                                           <!-- imageupload starts-->
                                    <div class="form-group" id="venuetotalimage">
                                        <label class="col-lg-4 control-label">Upload Image<br>(Maximum 3 Pictures Allowed<br> Minimum Image Dimension (458 (Width) * 476 (Height)) <br> Preferred Image Dimension .jpg .jpeg .png</label>
                                        <div class="col-lg-2">
                                            <span class="userimgupldclsadmin">

                                                <img src="{{ADMINCSSPATH}}/otherfiles/progimages/upload_icon.png" alt=""> 

                                            </span>
                                        
                                        </div><!-- /.col -->
                                          </div>
                                    <div class="form-group" id="venueprogressbar">
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
                                            <div class="col-lg-4" id="showuservenueimageanchr">
			                                    <?php
			                                    if(!empty($venueimage_admin)){
			                                    	foreach($venueimage_admin as $venueimage_admin_obj){
			                                    		$imgname= $venueimage_admin_obj->image_name;
			                                    		$venue_id= $venueimage_admin_obj->venue_id;
                                                        $venueimgID = $venueimage_admin_obj->id;
                                                        $venueimgsts=$venueimage_admin_obj->default_status;
                                                        $v_creator_id=$venueimage_admin_obj->v_creator_id;
			                                    		$imgurldata = BASEURLPUBLICCUSTOM.'upload/venueimage/thumb-small/'.$venueimage_admin_obj->image_name;?>
			                                    		<img src="{{$imgurldata}}" onclick="javascript:showIMageFancy('<?php echo $imgname; ?>');"><a onclick='deletevenueimage({{$venueimgID }},{{$venueimgsts}},{{$v_creator_id}},{{$venue_id}});'> Delete</a>
			                                    		<?php
			                                    		}
			                                    }else if(empty($venueimage_admin))
                                                {
                                                     $imgurldatablnk = BASEURLPUBLICCUSTOM.'admin/otherfiles/progimages/noimagefound52X52.jpg';?>
                                                     <img src="{{$imgurldatablnk}}" ><?php
                                                }
			                                    ?>
			                            </div>
                                  <!--progressive  ends-->
                                  </div><!-- /.col -->
                                    <!-- display image ensds here -->

                                                        






                            </div>
                        <!--     <div class="tab-pane fade" id="wizardContent4">
                                    
                            </div> -->

                            <!-- for booking options starts-->
                            <div class="tab-pane fade" id="wizardContent4">
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
                                        <label class="control-label col-lg-4">Opening Time:</label>
                                        <div class="col-lg-4">    

                                        <div class='input-group' id='datetimepicker_openingtime'>
                                        <!-- <input type='text' class="form-control" name="opening_time"/> -->
                                        <?php
echo Form::text("opening_time", $value = $opening_time, $attributes = array(
    "id" => "opening_time",
    "class" => "form-control input-sm parsley-validated "
));
?>
                                       <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-time"></span>
                                        </span>
                                        </div>
                                            
                                            <!-- <span  class="errorcustclass">{{ $errors->first('setuptime') }}</span> -->
                                        </div><!-- /.col-->
                                    </div><!-- /form-group -->
                                    
                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Closing Time:</label>
                                        <div class="col-lg-4">            

                                        <div class='input-group' id='datetimepicker_closingtime' >
                                    
                                        <?php
echo Form::text("closing_time", $value = $closing_time, $attributes = array(
    "id" => "closing_time",
    "class" => "form-control input-sm parsley-validated "
));
?>
                                           <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-time"></span>
                                            </span>
                                            </div>
                                            <!-- <span  class="errorcustclass">{{ $errors->first('setuptime') }}</span> -->
                                        </div><!-- /.col -->
                                    </div><!-- /form-group -->

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Tech Specs  <br>(Maximum 250 characters)</label>
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


                        </div>
                        
                    </div>
                    <div class="panel-footer">
                        <a class="btn btn-warning" id="prevStepvenue" disabled><i class="fa fa-chevron-left"></i> Previous</a>
                        <a class="btn btn-primary" id="nextStepvenue">Next <i class="fa fa-chevron-right"></i></a>
                        <span class="pull-right">
                            <button class="btn btn-success" type="submit" id="addeditcompletevenue">Submit</button> 
                            <a class="btn btn-warning" href="<?php
echo url(ADMINSEPARATOR . '/user');
?>"><i class="fa fa-chevron-left"></i> Back</a>
                        </span>
                    </div>
                    <!--  -->
                    <?php
echo Form::close();
?>
	
                    <!--file control form for image upload  starts-->                            
                        <?php
echo Form::open(array(
    'url' => ADMINSEPARATOR . '/uservenueimagesaveadmin',
    'files' => true,
    'method' => 'post',
    'id' => 'imgfrmid',
    'class' => "form-horizontal form-border no-margin",
    'style' => 'display:none'
));
?>
                                           <input type="text" name="userid_fr_imageupload" value=<?php
echo $ucreaterid;
?>>       
<input type="text" name="venueid_fr_imageupload" value=<?php
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

    <script type="text/javascript" src="{{ ADMINCSSPATH}}/otherfiles/progjs/countrywisestatelist.js"></script>
    <script type="text/javascript" src="{{ ADMINCSSPATH}}/otherfiles/progjs/moment.min.js"></script>
    <script type="text/javascript" src="{{ ADMINCSSPATH}}/otherfiles/progjs/bootstrap-datetimepicker.min.js"></script>
     <link rel="stylesheet" href="{{ ADMINCSSPATH}}/otherfiles/progcss/bootstrap-datetimepicker.css" />
    <!-- for country respective state dorpdown js ends -->

    <script type="text/javascript" src="{{ ADMINCSSPATH}}/otherfiles/ajaximageupload_library/jquery.form.js"></script>
        <script type="text/javascript" src="{{ ADMINCSSPATH}}/otherfiles/progjs/venueimageupload.js"></script>

         <script type="text/javascript" src="{{ BASEURLPUBLICCUSTOM.'commonassets'}}/fancybox/source/jquery.fancybox.js?v=2.1.5"></script>
<link rel="stylesheet" type="text/css" href="{{ BASEURLPUBLICCUSTOM.'commonassets'}}/fancybox/source/jquery.fancybox.css?v=2.1.5" media="screen" />
    <script>
    var typeflag = '<?php
echo $formfortype;
?>';
    var ststus_chk = '<?php
echo $user_status;
?>';
    var venueexistflag = '<?php
echo $venueexistsflag;
?>';

var imageclassshowhide = <?php echo $venueexistsflag;?>
//console.log(venueexistflag);
if(imageclassshowhide == 0)
{
	$("#venuetotalimage").addClass('mydiplaymoneadmin');
}else if (imageclassshowhide == 1){
	$("#venuetotalimage").removeClass('mydiplaymoneadmin');
}
  var venuetotalimagecount = '<?php echo $venueimage_admin_count?>'
     $("#venueprogressbar").addClass('mydiplaymoneadmin');
        if(venuetotalimagecount >= 3 ){
            $("#venuetotalimage").addClass('mydiplaymoneadmin');
            $("#venueprogressbar").addClass('mydiplaymoneadmin');
   }else if(venuetotalimagecount <= 3){
      $("#venuetotalimage").removeClass('mydiplaymoneadmin');
     // $("#usrprogressbar").removeClass('mydiplaymoneadmin');
   }

    if(ststus_chk!=1)
    {
        $("#uservenueaddfrmid input").attr('readonly','readonly');
        $("#country_id").attr('readonly','readonly');
        $("#skill_id").attr('disabled', true);
        

        $("#subskill_id").attr('disabled', true);
        $("#gst").attr('readonly','readonly');

        $("#rider").attr('readonly','readonly');

        $("#description").attr('readonly','readonly');

        $('[data-venueid="venueIDchk"]').prop('disabled', true);
        //$("#state_id").data('venueid').attr('disabled','disabled');

        $("input.lblcheckbox").attr("disabled", true);

        
        //$(".subskilldeleteajax").css('display','none');

        
    }
    if(venueexistflag == 0)
    {
        $("#chkcategoryflag").css('display','none');
        $("#chksubcategoryflag").css('display','none');
        $("#chkcategorylistflag").css('display','none');

        $("#venuetotalimage").addClass('mydiplaymoneadmin');
        $("#showuservenueimageanchr").addClass('mydiplaymoneadmin');

    }else if(venueexistflag == 1)
    {
        $("#chkcategoryflag").css('display','block');
        $("#chksubcategoryflag").css('display','block');
        $("#chkcategorylistflag").css('display','block');
        $("#showuservenueimageanchr").removeClass('mydiplaymoneadmin');

       // $("#venuetotalimage").removeClass('mydiplaymoneadmin');
    }


$(document).ready(function(){
    if(ststus_chk == 0)
    {

        //$(".subskilldeleteajax").css('display','none');
    }
});
    $('#datetimepicker_openingtime').datetimepicker({
        format: 'HH:mm',
     });
    $('#datetimepicker_closingtime').datetimepicker({
        format: 'HH:mm',
      });
    $("#datetimepicker_openingtime").on("dp.change", function (e) {
        $('#datetimepicker_closingtime').data("DateTimePicker").minDate('00:30');
    });
    
     $('#datetimepicker_closingtime').data("DateTimePicker").minDate('00:30');
     $('#datetimepicker_closingtime').data("DateTimePicker").maxDate('23:59');








 function showIMageFancy(imagename)
            {
         
                if(imagename!='')
                {
                    $.fancybox.open("<?php echo BASEURLPUBLICCUSTOM.'upload/venueimage/thumb-big';?>"+"/"+imagename);
                
                    $('.fancybox-opened').css('z-index',999999);
                }
            }

            // fancybox script ends
    </script>




<div class="modal fade" id="myModalvenue" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
          <div class="modal-body" id="modalbody">
          <p>Are you sure want to delete ? </p>
        </div>
        <div class="modal-footer">

            <input type="hidden" id="hdnursid" value="">
             <input type="hidden" id="hdnursvenueid" value="">
            <input type="hidden" id="hdnskillmaster_ID" value="">
            <input type="hidden" id="hdnskillmaster_parentID" value="">


          <button type="button" class="btn btn-default" data-dismiss="modal" id="close_modal">Close</button>
          <button type="button" class="btn btn-success" data-dismiss="modal" id="delete" onclick="deletevenuekill();">Delete</button>
        </div>
      </div>
      
    </div>
  </div>
  

<div class="modal fade" id="myModalvnuskildltsts" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
          <div class="modal-body" id="skilldletststusvnu">
          <!-- <p>Are you sure want to delete ? </p> -->
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
          <span id="uservnuimagedeletetext"></span>
          <p>Are you sure want to delete ? </p>

        </div>
        <div class="modal-footer">
        <!-- <input type="hidden" id="hdnursidimagedel" value=""> -->
         <input type="hidden" id="hdnuserID" value="">
         <input type="hidden" id="hdnuservenueID" value="">
        <input type="hidden" id="hdnuserimgsts" value="">
        <input type="hidden" id="hdnuserimgID" value="">
            
          <button type="button" class="btn btn-default" data-dismiss="modal" id="close_modal">Close</button>
          <button type="button" class="btn btn-success" data-dismiss="modal" id="delete" onclick="deleteusrvnueimg();">Delete</button>

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
