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

?>
@extends('layouts.admin.adminmaster',['successmsg' => $successmsg,'errormsg'=>$errormsg])
@section('content')
       
<div id="breadcrumb">
				<ul class="breadcrumb">
					 <li><i class="fa fa-dashboard"></i><a href="<?php echo url(ADMINSEPARATOR);?>"> Dashboard</a></li>
					<!-- <li class="active">Dear</li>	 -->
				</ul>
			</div>

<div class="padding-md">
<div class="row">
<div class="col-lg-11">
				

                <div class="row">
                
                
                
					<div class="col-md-3 col-sm-3">
								<div class="panel panel-default panel-stat1 bg-success">
							<div class="panel-body">
								<div class="value"><a class="anctxtwhitecolor" href="<?php echo url(ADMINSEPARATOR.'/user')?>"><i class="fa fa-user"></i></a></div>
								<div class="title">
									<span class="m-left-xs"><a class="anctxtwhitecolor" href="<?php echo url(ADMINSEPARATOR.'/user')?>">User </a></span>
								</div>
							</div>
						</div><!-- /panel -->
					</div><!-- /.col -->
                    
                    <div class="col-md-3 col-sm-3">
								<div class="panel panel-default panel-stat1 bg-success">
							<div class="panel-body">
								<div class="value"><a class="anctxtwhitecolor" href="<?php echo url(ADMINSEPARATOR.'/article')?>"><i class="fa fa-file-text"></i></a></div>
								<div class="title">
									<span class="m-left-xs"><a class="anctxtwhitecolor" href="<?php echo url(ADMINSEPARATOR.'/article')?>">Article </a></span>
								</div>
							</div>
						</div><!-- /panel -->
					</div><!-- /.col -->
                    
                    <div class="col-md-3 col-sm-3">
								<div class="panel panel-default panel-stat1 bg-success">
							<div class="panel-body">
								<div class="value"><a class="anctxtwhitecolor" href="<?php echo url(ADMINSEPARATOR.'/country')?>"><i class="fa fa-flag"></i> </a></div>
								<div class="title">
									<span class="m-left-xs"><a class="anctxtwhitecolor" href="<?php echo url(ADMINSEPARATOR.'/country')?>">Country </a></span>
								</div>
							</div>
						</div><!-- /panel -->
					</div><!-- /.col -->
                    
                    
                    <div class="col-md-3 col-sm-3">
								<div class="panel panel-default panel-stat1 bg-success">
							<div class="panel-body">
								<div class="value"><a class="anctxtwhitecolor" href="<?php echo url(ADMINSEPARATOR.'/state')?>"><i class="fa fa-flag"></i></a></div>
								<div class="title">
									<span class="m-left-xs"><a class="anctxtwhitecolor" href="<?php echo url(ADMINSEPARATOR.'/state')?>">State </a></span>
								</div>
							</div>
						</div><!-- /panel -->
					</div><!-- /.col -->
                    
                    
							
				</div>                
                
                                <div class="row">
                
                
                
					<div class="col-md-3 col-sm-3">
								<div class="panel panel-default panel-stat1 bg-success">
							<div class="panel-body">
								<div class="value"><a class="anctxtwhitecolor" href="<?php echo url(ADMINSEPARATOR.'/email-template')?>"><i class="fa fa-envelope"></i></a></div>
								<div class="title">
									<span class="m-left-xs"><a class="anctxtwhitecolor" href="<?php echo url(ADMINSEPARATOR.'/email-template')?>">Email </a></span>
								</div>
							</div>
						</div><!-- /panel -->
					</div><!-- /.col -->
                    
                    <div class="col-md-3 col-sm-3">
								<div class="panel panel-default panel-stat1 bg-success">
							<div class="panel-body">
								<div class="value"><a class="anctxtwhitecolor" href="<?php echo url(ADMINSEPARATOR.'/settings')?>"><i class="fa fa-cog"></i></a></div>
								<div class="title">
									<span class="m-left-xs"><a class="anctxtwhitecolor" href="<?php echo url(ADMINSEPARATOR.'/settings')?>">Setting </a></span>
								</div>
							</div>
						</div><!-- /panel -->
					</div><!-- /.col -->
					
					 <div class="col-md-3 col-sm-3">
								<div class="panel panel-default panel-stat1 bg-success">
							<div class="panel-body">
								<div class="value"><a class="anctxtwhitecolor" href="<?php echo url(ADMINSEPARATOR.'/skill')?>"><i class="fa fa-certificate"></i></a></div>
								<div class="title">
									<span class="m-left-xs"><a class="anctxtwhitecolor" href="<?php echo url(ADMINSEPARATOR.'/skill')?>">Skill </a></span>
								</div>
							</div>
						</div><!-- /panel -->
					</div><!-- /.col -->
                    
                    <!-- <div class="col-md-3 col-sm-3">
								<div class="panel panel-default panel-stat1 bg-success">
							<div class="panel-body">
								<div class="value"><i class="fa fa-user"></i></div>
								<div class="title">
									<span class="m-left-xs">Setting Management</span>
								</div>
							</div>
						</div>
					</div> --><!-- /.col -->
                    
                    
                    <!-- <div class="col-md-3 col-sm-3">
								<div class="panel panel-default panel-stat1 bg-success">
							<div class="panel-body">
								<div class="value"><i class="fa fa-user"></i></div>
								<div class="title">
									<span class="m-left-xs">Setting Management</span>
								</div>
							</div>
						</div>
					</div> --><!-- /.col -->
                    
                    <!--<div class="col-md-3 col-sm-3">
								<div class="panel panel-default panel-stat1 bg-success">
							<div class="panel-body">
								<div class="value"><a class="anctxtwhitecolor" href="<?php echo url(ADMINSEPARATOR.'/package')?>"><i class="fa fa-ticket"></i></a></div>
								<div class="title">
									<span class="m-left-xs"><a class="anctxtwhitecolor" href="<?php echo url(ADMINSEPARATOR.'/package')?>">Package </a></span>
								</div>
							</div>-->
						<!--</div>--><!-- /panel -->
					<!--</div>--><!-- /.col -->
					
					<div class="col-md-3 col-sm-3">
								<div class="panel panel-default panel-stat1 bg-success">
							<div class="panel-body">
								<div class="value"><a class="anctxtwhitecolor" href="<?php echo url(ADMINSEPARATOR.'/language')?>"><i class="fa fa-language"></i></a></div>
								<div class="title">
									<span class="m-left-xs"><a class="anctxtwhitecolor" href="<?php echo url(ADMINSEPARATOR.'/language')?>">Language </a></span>
								</div>
							</div>
						</div><!-- /panel -->
					</div><!-- /.col -->
					
					
					<div class="col-md-3 col-sm-3">
								<div class="panel panel-default panel-stat1 bg-success">
							<div class="panel-body">
								<div class="value"><a class="anctxtwhitecolor" href="<?php echo url(ADMINSEPARATOR.'/faq')?>"><i class="fa fa-question"></i></a></div>
								<div class="title">
									<span class="m-left-xs"><a class="anctxtwhitecolor" href="<?php echo url(ADMINSEPARATOR.'/faq')?>">FAQ </a></span>
								</div>
							</div>
						</div><!-- /panel -->
					</div><!-- /.col -->
					
					<!--<div class="col-md-3 col-sm-3">
								<div class="panel panel-default panel-stat1 bg-success">
							<div class="panel-body">
								<div class="value"><a class="anctxtwhitecolor" href="<?php echo url(ADMINSEPARATOR.'/contactus')?>"><i class="fa fa-phone"></i></a></div>
								<div class="title">
									<span class="m-left-xs"><a class="anctxtwhitecolor" href="<?php echo url(ADMINSEPARATOR.'/contactus')?>">Contactus </a></span>
								</div>
							</div>-->
						<!--</div>--><!-- /panel -->
					<!--</div>--><!-- /.col -->
					
					<div class="col-md-3 col-sm-3">
								<div class="panel panel-default panel-stat1 bg-success">
							<div class="panel-body">
								<div class="value"><a class="anctxtwhitecolor" href="<?php echo url(ADMINSEPARATOR.'/banner')?>"><i class="fa fa-picture-o"></i></a></div>
								<div class="title">
									<span class="m-left-xs"><a class="anctxtwhitecolor" href="<?php echo url(ADMINSEPARATOR.'/banner')?>">Banner </a></span>
								</div>
							</div>
						</div><!-- /panel -->
					</div><!-- /.col -->
					
					<!--<div class="col-md-3 col-sm-3">
								<div class="panel panel-default panel-stat1 bg-success">
							<div class="panel-body">
								<div class="value"><a class="anctxtwhitecolor" href="<?php echo url(ADMINSEPARATOR.'/association')?>"><i class="fa fa-arrows"></i></a></div>
								<div class="title">
									<span class="m-left-xs"><a class="anctxtwhitecolor" href="<?php echo url(ADMINSEPARATOR.'/association')?>">Association </a></span>
								</div>
							</div>-->
						<!--</div>--><!-- /panel -->
					<!--</div>--><!-- /.col -->
					<div class="col-md-3 col-sm-3">
								<div class="panel panel-default panel-stat1 bg-success">
							<div class="panel-body">
								<div class="value"><a class="anctxtwhitecolor" href="<?php echo url(ADMINSEPARATOR.'/howitsdone')?>"><i class="fa fa-question-circle"></i></a></div>
								<div class="title">
									<span class="m-left-xs"><a class="anctxtwhitecolor" href="<?php echo url(ADMINSEPARATOR.'/howitsdone')?>">How Its Done </a></span>
								</div>
							</div>
						</div><!-- /panel -->
					</div><!-- /.col -->
					<div class="col-md-3 col-sm-3">
								<div class="panel panel-default panel-stat1 bg-success">
							<div class="panel-body">
								<div class="value"><a class="anctxtwhitecolor" href="<?php echo url(ADMINSEPARATOR.'/supportbypage')?>"><i class="fa fa-hand-o-right"></i></a></div>
								<div class="title">
									<span class="m-left-xs"><a class="anctxtwhitecolor" href="<?php echo url(ADMINSEPARATOR.'/supportbypage')?>">Support By Page </a></span>
								</div>
							</div>
						</div><!-- /panel -->
					</div><!-- /.col -->
					<div class="col-md-3 col-sm-3">
								<div class="panel panel-default panel-stat1 bg-success">
							<div class="panel-body">
								<div class="value"><a class="anctxtwhitecolor" href="<?php echo url(ADMINSEPARATOR.'/subscription')?>"><i class="fa fa-bookmark"></i></a></div>
								<div class="title">
									<span class="m-left-xs"><a class="anctxtwhitecolor" href="<?php echo url(ADMINSEPARATOR.'/subscription')?>">Subscription </a></span>
								</div>
							</div>
						</div><!-- /panel -->
					</div><!-- /.col -->
					<div class="col-md-3 col-sm-3">
								<div class="panel panel-default panel-stat1 bg-success">
							<div class="panel-body">
								<div class="value"><a class="anctxtwhitecolor" href="<?php echo url(ADMINSEPARATOR.'/amenities')?>"><i class="fa fa-cubes"></i></a></div>
								<div class="title">
									<span class="m-left-xs"><a class="anctxtwhitecolor" href="<?php echo url(ADMINSEPARATOR.'/amenities')?>">Amenities</a></span>
								</div>
							</div>
						</div><!-- /panel -->
					</div><!-- /.col -->
					<div class="col-md-3 col-sm-3">
								<div class="panel panel-default panel-stat1 bg-success">
							<div class="panel-body">
								<div class="value"><a class="anctxtwhitecolor" href="<?php echo url(ADMINSEPARATOR.'/homesearch')?>"><i class="fa fa-home"></i></a></div>
								<div class="title">
									<span class="m-left-xs"><a class="anctxtwhitecolor" href="<?php echo url(ADMINSEPARATOR.'/homesearch')?>">Home-search</a></span>
								</div>
							</div>
						</div><!-- /panel -->
					</div><!-- /.col -->
				</div>                


</div>
</div>
 
 </div>   
    
@endsection