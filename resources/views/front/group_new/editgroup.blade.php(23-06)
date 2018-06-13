<?php
$successmsg='';$errormsg='';
if(!empty($successmsgdata))
{
        $successmsg=$successmsgdata;
}

if(!empty($errormsgdata))
{
        $errormsg=$errormsgdata;
}


$first_name=''; $facebook_url=''; $twitter_url='';
$instagram_url='';	$youtube_url='';	$residentadvisor_url='';
 $user_description=''; $soundcloud_url='';$nickname='';
 $fetchskillmasterArData=array();

if(!empty($fetchuserdata))
{
	//echo "<pre>";  print_r($fetchuserdata); echo "</pre>";
	
	$first_name=$fetchuserdata->group_name;
	$nickname=$fetchuserdata->group_name;
	$facebook_url=$fetchuserdata->facebook_url;
	$twitter_url=$fetchuserdata->twitter_url;
	$instagram_url=$fetchuserdata->instagram_url;
	$youtube_url=$fetchuserdata->youtube_url;
	$soundcloud_url=$fetchuserdata->soundcloud_url;
	$residentadvisor_url=$fetchuserdata->residentadvisor_url;
	$user_description=$fetchuserdata->group_description;
}

if(!empty($fetchskillmasterAr))
{
	$fetchskillmasterArData=$fetchskillmasterAr;
	
}


if(empty($facebook_url))
{
	$facebook_url="https://www.facebook.com/";
}

if(empty($soundcloud_url))
{
	$soundcloud_url="https://www.soundcloud.com/";
}

if(empty($residentadvisor_url))
{
	$residentadvisor_url="https://www.residentadvisor.net/";
}

if(empty($twitter_url))
{
	$twitter_url="https://www.twitter.com/";
}

if(empty($youtube_url))
{
	$youtube_url="https://www.youtube.com/";
}

if(empty($instagram_url))
{
	$instagram_url="https://www.instagram.com/";
}
?>
@extends('layouts.front.frontendmaster',['successmsg' => $successmsg,'errormsg'=>$errormsg])
@section('content')
<!-- profile-section-start -->


  <div id="epajxprofdvid">

	
  </div>	  
  <script type="text/javascript" src="{{ URL::asset('public/front')}}/otherfiles/progjs/frontendeditgroupajax.js"></script>
	
    @endsection