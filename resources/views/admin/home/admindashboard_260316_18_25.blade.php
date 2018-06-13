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
					 <li><i class="fa fa-home"></i><a href="index.html"> Dashboard</a></li>
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
									<span class="m-left-xs"><a class="anctxtwhitecolor" href="<?php echo url(ADMINSEPARATOR.'/user')?>">User Management</a></span>
								</div>
							</div>
						</div><!-- /panel -->
					</div><!-- /.col -->
                    
                    <div class="col-md-3 col-sm-3">
								<div class="panel panel-default panel-stat1 bg-success">
							<div class="panel-body">
								<div class="value"><a class="anctxtwhitecolor" href="<?php echo url(ADMINSEPARATOR.'/article')?>"><i class="fa fa-file-text"></i></a></div>
								<div class="title">
									<span class="m-left-xs"><a class="anctxtwhitecolor" href="<?php echo url(ADMINSEPARATOR.'/article')?>">Article Management</a></span>
								</div>
							</div>
						</div><!-- /panel -->
					</div><!-- /.col -->
                    
                    <div class="col-md-3 col-sm-3">
								<div class="panel panel-default panel-stat1 bg-success">
							<div class="panel-body">
								<div class="value"><a class="anctxtwhitecolor" href="<?php echo url(ADMINSEPARATOR.'/country')?>"><i class="fa fa-flag"></i> </a></div>
								<div class="title">
									<span class="m-left-xs"><a class="anctxtwhitecolor" href="<?php echo url(ADMINSEPARATOR.'/country')?>">Country Management</a></span>
								</div>
							</div>
						</div><!-- /panel -->
					</div><!-- /.col -->
                    
                    
                    <div class="col-md-3 col-sm-3">
								<div class="panel panel-default panel-stat1 bg-success">
							<div class="panel-body">
								<div class="value"><a class="anctxtwhitecolor" href="<?php echo url(ADMINSEPARATOR.'/state')?>"><i class="fa fa-flag"></i></a></div>
								<div class="title">
									<span class="m-left-xs"><a class="anctxtwhitecolor" href="<?php echo url(ADMINSEPARATOR.'/state')?>">State Management</a></span>
								</div>
							</div>
						</div><!-- /panel -->
					</div><!-- /.col -->
                    
                    
							
				</div>                
                
                                <div class="row">
                
                
                
					<div class="col-md-3 col-sm-3">
								<div class="panel panel-default panel-stat1 bg-success">
							<div class="panel-body">
								<div class="value"><a class="anctxtwhitecolor" href="<?php echo url(ADMINSEPARATOR.'/email-template')?>"><i class="fa fa-file-text"></i></a></div>
								<div class="title">
									<span class="m-left-xs"><a class="anctxtwhitecolor" href="<?php echo url(ADMINSEPARATOR.'/email-template')?>">Email Management</a></span>
								</div>
							</div>
						</div><!-- /panel -->
					</div><!-- /.col -->
                    
                    <div class="col-md-3 col-sm-3">
								<div class="panel panel-default panel-stat1 bg-success">
							<div class="panel-body">
								<div class="value"><a class="anctxtwhitecolor" href="<?php echo url(ADMINSEPARATOR.'/settings')?>"><i class="fa fa-cog"></i></a></div>
								<div class="title">
									<span class="m-left-xs"><a class="anctxtwhitecolor" href="<?php echo url(ADMINSEPARATOR.'/settings')?>">Setting Management</a></span>
								</div>
							</div>
						</div><!-- /panel -->
					</div><!-- /.col -->
					
					 <div class="col-md-3 col-sm-3">
								<div class="panel panel-default panel-stat1 bg-success">
							<div class="panel-body">
								<div class="value"><a class="anctxtwhitecolor" href="<?php echo url(ADMINSEPARATOR.'/skill')?>"><i class="fa fa-cog"></i></a></div>
								<div class="title">
									<span class="m-left-xs"><a class="anctxtwhitecolor" href="<?php echo url(ADMINSEPARATOR.'/skill')?>">Skill Management</a></span>
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
                    
                    <div class="col-md-3 col-sm-3">
								<div class="panel panel-default panel-stat1 bg-success">
							<div class="panel-body">
								<div class="value"><a class="anctxtwhitecolor" href="<?php echo url(ADMINSEPARATOR.'/package')?>"><i class="fa fa-briefcase"></i></a></div>
								<div class="title">
									<span class="m-left-xs"><a class="anctxtwhitecolor" href="<?php echo url(ADMINSEPARATOR.'/package')?>">Package Management</a></span>
								</div>
							</div>
						</div><!-- /panel -->
					</div><!-- /.col -->
					
					<div class="col-md-3 col-sm-3">
								<div class="panel panel-default panel-stat1 bg-success">
							<div class="panel-body">
								<div class="value"><a class="anctxtwhitecolor" href="<?php echo url(ADMINSEPARATOR.'/language')?>"><i class="fa fa-exclamation"></i></a></div>
								<div class="title">
									<span class="m-left-xs"><a class="anctxtwhitecolor" href="<?php echo url(ADMINSEPARATOR.'/language')?>">Language Management</a></span>
								</div>
							</div>
						</div><!-- /panel -->
					</div><!-- /.col -->
					
					
					<div class="col-md-3 col-sm-3">
								<div class="panel panel-default panel-stat1 bg-success">
							<div class="panel-body">
								<div class="value"><a class="anctxtwhitecolor" href="<?php echo url(ADMINSEPARATOR.'/faq')?>"><i class="fa fa-exclamation"></i></a></div>
								<div class="title">
									<span class="m-left-xs"><a class="anctxtwhitecolor" href="<?php echo url(ADMINSEPARATOR.'/faq')?>">FAQ Management</a></span>
								</div>
							</div>
						</div><!-- /panel -->
					</div><!-- /.col -->
							
				</div>                


</div>
</div>
 
 </div>   
    
@endsection