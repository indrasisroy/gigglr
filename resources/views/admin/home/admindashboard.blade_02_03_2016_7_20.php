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
								<div class="value"><i class="fa fa-user"></i></div>
								<div class="title">
									<span class="m-left-xs">Setting Management</span>
								</div>
							</div>
						</div><!-- /panel -->
					</div><!-- /.col -->
                    
                    <div class="col-md-3 col-sm-3">
								<div class="panel panel-default panel-stat1 bg-success">
							<div class="panel-body">
								<div class="value"><i class="fa fa-user"></i></div>
								<div class="title">
									<span class="m-left-xs">Setting Management</span>
								</div>
							</div>
						</div><!-- /panel -->
					</div><!-- /.col -->
                    
                    <div class="col-md-3 col-sm-3">
								<div class="panel panel-default panel-stat1 bg-success">
							<div class="panel-body">
								<div class="value"><i class="fa fa-user"></i></div>
								<div class="title">
									<span class="m-left-xs">Setting Management</span>
								</div>
							</div>
						</div><!-- /panel -->
					</div><!-- /.col -->
                    
                    
                    <div class="col-md-3 col-sm-3">
								<div class="panel panel-default panel-stat1 bg-success">
							<div class="panel-body">
								<div class="value"><i class="fa fa-user"></i></div>
								<div class="title">
									<span class="m-left-xs">Setting Management</span>
								</div>
							</div>
						</div><!-- /panel -->
					</div><!-- /.col -->
                    
                    
							
				</div>                
                
                                <div class="row">
                
                
                
					<div class="col-md-3 col-sm-3">
								<div class="panel panel-default panel-stat1 bg-success">
							<div class="panel-body">
								<div class="value"><i class="fa fa-user"></i></div>
								<div class="title">
									<span class="m-left-xs">Setting Management</span>
								</div>
							</div>
						</div><!-- /panel -->
					</div><!-- /.col -->
                    
                    <div class="col-md-3 col-sm-3">
								<div class="panel panel-default panel-stat1 bg-success">
							<div class="panel-body">
								<div class="value"><i class="fa fa-user"></i></div>
								<div class="title">
									<span class="m-left-xs">Setting Management</span>
								</div>
							</div>
						</div><!-- /panel -->
					</div><!-- /.col -->
                    
                    <div class="col-md-3 col-sm-3">
								<div class="panel panel-default panel-stat1 bg-success">
							<div class="panel-body">
								<div class="value"><i class="fa fa-user"></i></div>
								<div class="title">
									<span class="m-left-xs">Setting Management</span>
								</div>
							</div>
						</div><!-- /panel -->
					</div><!-- /.col -->
                    
                    
                    <div class="col-md-3 col-sm-3">
								<div class="panel panel-default panel-stat1 bg-success">
							<div class="panel-body">
								<div class="value"><i class="fa fa-user"></i></div>
								<div class="title">
									<span class="m-left-xs">Setting Management</span>
								</div>
							</div>
						</div><!-- /panel -->
					</div><!-- /.col -->
                    
                    
							
				</div>                


</div>
</div>
 
 </div>   
    
@endsection