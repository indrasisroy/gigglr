<?php
$successmsg='';$errormsg='';$article_title='';
if(!empty($successmsgdata))
{
        $successmsg=$successmsgdata;
}

if(!empty($errormsgdata))
{
        $errormsg=$errormsgdata;
}
if(!empty($search_article_val))
{
        $article_title=$search_article_val;
}

?>
@extends('layouts.admin.adminmaster',['successmsg' => $successmsg,'errormsg'=>$errormsg])



@section('content')
 
  
            <div class="padding-md">
                <div class="row">
                    <div class="col-md-12">
                        
                    <div class="panel panel-default table-responsive">
                    <div class="panel-heading">
                        Article List
                        <span class="pull-right"><a type="button" class="btn btn-xs btn-success" href="<?php echo  url(ADMINSEPARATOR.'/createarticle'); ?>" >ADD</a></span>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-4 col-sm-4">
                            <?php echo Form::open(array('url' => ADMINSEPARATOR.'/article', 'method' => 'GET','id'=>'articlesearchfrmid','class'=>"form-horizontal form-border no-margin" )); ?>

                                <div class="input-group">

                                <?php
                                $srch1='';$sort1='';$sorttype1='ASC';
                                $default_srt_class1="fa fa-sort fa-sm";
                                if( !empty($useinPagiAr) && array_key_exists('srch1',$useinPagiAr))
                                {
                                                $srch1=$useinPagiAr['srch1'];
                                }
                                
                                if( !empty($useinPagiAr) && array_key_exists('sorttype1',$useinPagiAr))
                                {
                                                $sorttype1=$useinPagiAr['sorttype1']; // original sort type  ASC or DESC
                                                
                                                if(!empty($sorttype1) && ($sorttype1=="ASC") )
                                                {
                                                                $default_srt_class1="fa fa-sort-desc fa-sm";
                                                }
                                                elseif(!empty($sorttype1) && ($sorttype1=="DESC") )
                                                {
                                                      
                                                       $default_srt_class1="fa fa-sort-asc fa-sm";  
                                                }
                                                
                                }
                                
                                if( !empty($useinPagiAr) && array_key_exists('sort1',$useinPagiAr))
                                {
                                                $sort1=$useinPagiAr['sort1'];                                           
                                                
                                                
                                }?>
                                




                                 <?php  // echo Form::text("title", $value=$article_title, $attributes = array( "id"=>"title","class"=>" form-control input-sm","Placeholder"=>"Search by title")); ?>
                                 <?php echo Form::text("srch1", $value=$srch1, $attributes = array( "id"=>"srch1","class"=>" form-control input-sm ")); ?>
                                  
                                <?php echo Form::hidden("sort1", $value=$sort1, $attributes = array( "id"=>"sort1","class"=>" form-control input-sm ")); ?>
                                <?php echo Form::hidden("sorttype1", $value=$sorttype1, $attributes = array( "id"=>"sorttype1","class"=>" form-control input-sm ")); ?>   
                                        <div class="input-group-btn">
                                            <button tabindex="-1" class="btn btn-sm btn-success" type="button" id="srchbutton">Search</button>
                                            
                                        </div> <!-- /input-group-btn -->
                                    </div>
                                
                                
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div>

                     

                    <table class="table table-striped" id="responsiveTable">
                        <thead>
                            <tr>
                                <th data-sortname="title" data-sorttype="<?php echo $sorttype1; ?>" class="sorttrackclass" >Title <i  class=" <?php echo $default_srt_class1; ?>"></i></th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>



                       <?php
                        
                        if(!empty($pagi_article) && ( $pagi_article->count()>0 ) )
                        {
                        
                                foreach($pagi_article as $article_obj)
                                {
                                    $art_connctId = $article_obj->id;
                                    $status = $article_obj->status;
                                    $status_change_to=($status==1)?0:1;
                                    $status_icon_class=($status==1)? "fa fa-unlock fa-lg":"fa fa-lock fa-lg";

                                    $articletitle = $article_obj->title;//******article title value getting
                                    $art_tile_len = strlen($articletitle); //******article title length getting
                                    if($art_tile_len > 25)
                                    {
                                        $articletitle = substr($articletitle, 0,25).'..';
                                    }
                                    $articledescription = html_entity_decode($article_obj->description);//******article description value getting
                                    $art_desc_len = strlen($articledescription); //******article title length getting
                                    if($art_desc_len > 25)
                                    {
                                        $articledescription = substr($articledescription, 0,25).'..';
                                    }
                        ?>
                            <tr>
                                
                                <td><?php echo stripslashes($articletitle); ?></td>
                                <td><?php echo stripslashes($articledescription); ?></td>
                    
                                <td>
                                <a href="<?php echo  url(ADMINSEPARATOR.'/createarticle/'.$art_connctId); ?>"><i class="fa fa-edit fa-lg"></i></a>
                             
                                <a href="javascript:void(0);" ><i id="stat_<?php echo $article_obj->id; ?>" href="javascript:void(0);" data-articlestsid="<?php echo $article_obj->id; ?>" data-statuschange="<?php echo $status_change_to; ?>" class="statustrkclass <?php echo $status_icon_class; ?>"></i></a>


                               
                                <a href="<?php echo  url(ADMINSEPARATOR.'/delete_article/'.$art_connctId); ?>" onclick="javascript:return confirm('Are you  sure you want to delete?')"><i class="fa fa-trash-o fa-lg"></i></a>
                                </td>
                                
                            </tr>
                                 <?php
                                }
                        }   else
                            {
                                ?>
                            <tr><td colspan="3" >No data found.</td> </tr>  
                                <?php
                                }
                                ?>
                              
                            
                        </tbody>
                    </table>
                    <div class="panel-footer clearfix">
                    <?php echo $pagi_article->appends($useinPagiAr)->render(); ?>
                     </div>
                </div><!-- /panel -->

                        
                    </div>
                    </div>
            </div><!-- /.padding-md -->

            <script>
                jQuery(document).ready(function() //**********Sorting Submission Starts here
                {
                    jQuery(".sorttrackclass").click(function()
                    {
                            sortname = $(this).data('sortname');
                            sorttype = $(this).data('sorttype');
                            if (sorttype == 'ASC') {
                                    setsorttype = 'DESC';
                            }
                            else{
                                    setsorttype = 'ASC';
                            }
                            //alert(setsorttype);
                            jQuery("#sort1").val(sortname);
                            jQuery("#sorttype1").val(setsorttype);
                            $('#articlesearchfrmid').submit();
                    });
                                
                }); //**********Sorting Submission Ends here

                jQuery("#srchbutton").click(function() //**********Blank Submission Starts here
                {
                        var srch1data=jQuery("#srch1").val();
                        if (srch1data=='')
                        {
                          
                                    jQuery("#sort1").val('');
                                    jQuery("#sorttype1").val('');
                                    
                                    window.location.href="<?php echo url(ADMINSEPARATOR.'/article');?>";
                        }
                        else
                        {
                                     
                                    jQuery("#articlesearchfrmid").submit();
                        }
                    
                }); //**********Blank Submission Ends here

                jQuery(".statustrkclass").click(function(){  //**********Update Status Change Starts here

                var chkconfstatus=confirm(" Are you sure , you want to change the status ? ");
                
                var statuschange_data=jQuery(this).data('statuschange');
                //alert("statuschange_data==>"+statuschange_data);
                var articleid_data=jQuery(this).data('articlestsid');
                
                if (chkconfstatus==true)
                {
                
                                var snddata = {_token:"<?php echo csrf_token(); ?>",statuschange: statuschange_data,articleid:articleid_data};
                                                  
                                //alert(JSON.stringify(snddata));
                                          
                                jQuery.ajax({
                                                type: "POST",
                                                data:snddata,
                                                url: "<?php echo url(ADMINSEPARATOR.'/articlechangestatus');?>",
                                                dataType:"json",
                                                success: function(data)
                                                {
                                                    
                                                    // var tt=JSON.stringify(data);
                                                    // alert(tt);
                                                    
                                                    var flagdata=data.flag;
                                                    var iddata=data.iddata;
                                                    var ancid="stat_"+iddata;
                                                    
                                                    
                                                    if ( (flagdata==1) && (statuschange_data==1) )
                                                    {
                                                                
                                                                jQuery("#"+ancid).removeClass("fa-lock");
                                                                jQuery("#"+ancid).addClass("fa-unlock");
                                                                jQuery("#"+ancid).data('statuschange','0');
                                                    }
                                                    else if ((flagdata==1) && (statuschange_data==0))
                                                    {
                                                            
                                                                jQuery("#"+ancid).removeClass("fa-unlock");
                                                                jQuery("#"+ancid).addClass("fa-lock");                                                              
                                                                jQuery("#"+ancid).data('statuschange','1');                                                         
                                                                
                                                    }
                                                    
                                                    
                                                    
                                                }
                                       });
                }
                
                
                
                });    //**********Update Status change Ends here

                                
                                                 
            </script>

@endsection


 

