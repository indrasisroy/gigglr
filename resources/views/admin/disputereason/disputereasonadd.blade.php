<?php

$addeditflagcheck =Request::segment(3);
$addeditflag=0;
if(empty($addeditflagcheck))
{
  $addeditflag = 0;
}else
{
  $addeditflag = 1;
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
@extends('layouts.admin.adminmaster',['successmsg','errormsg'])
@section('content')
  
    <?php
$complaint_by           = '';
$complaint_by_type      = '';
$complaint_against      = '';
$complaint_against_type = '';
$question               = '';
$editid                = 0;
$question ='';
if (!empty($disputereasons)) {
    
    $complaint_by           = $disputereasons->complaint_by;
    $complaint_by_type      = $disputereasons->complaint_by_type;
    $complaint_against      = $disputereasons->complaint_against;
    $complaint_against_type = $disputereasons->complaint_against_type;
    $question               = $disputereasons->question;
    $editid                = $disputereasons->id;
   
}
if(empty($editid))
{
    $editid =0;
}
?>
  
            <div class="padding-md">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="panel panel-default">
                            
                               <?php
echo Form::open(array(
    'url' => ADMINSEPARATOR . '/disputereasonsave',
    'method' => 'post',
    'id' => 'adddeditformisputereason',
    'class' => "form-horizontal form-border no-margin",
    'files' =>'true'
));
?>
                               <div class="panel-heading">
                                 Save Dispute Reason
                                </div>
                                <div class="panel-body">
                                
                                
                                    <div class="form-group">
                                        <label class="control-label col-lg-3">*Complaint by</label>
                                        
                                        <div class="col-lg-8">
                                            
                                           <?php
echo Form::select('complaint_by', array('1' => 'Booker', '2' => 'Booked-artist/group/venue'), null, ['class'=>'form-control','placeholder' => 'Select option','id'=>'complaint_by']);
?>
                                       <span  class="errorcustclass">{{ $errors->first('complaint_by') }}</span>      
                                        </div><!-- /.col -->
                                    </div><!-- /form-group -->
                                    <div class="form-group" id="complaintbytypehndval">
                                        <label class="control-label col-lg-3">*Complaint by type</label>
                                        
                                        <div class="col-lg-8">
                                            <?php

                                           

echo Form::select('complaint_by_type', array(), null, ['class'=>'form-control','placeholder' => 'Select option','id'=>'complaint_by_type']);
?>
                                       <span  class="errorcustclass">{{ $errors->first('complaint_by_type') }}</span>      
                                        </div><!-- /.col -->
                                    </div><!-- /form-group -->
                                    <div class="form-group">
                                        <label class="control-label col-lg-3">*Complaint against</label>
                                        
                                        <div class="col-lg-8">
                                            
                                           
<?php
echo Form::select('complaint_against',  array(), null, ['class'=>'form-control','placeholder' => 'Select option','id'=>'complaint_against']);
?>

                                       <span  class="errorcustclass">{{ $errors->first('complaint_against') }}</span>      
                                        </div><!-- /.col -->
                                    </div><!-- /form-group -->
                                    <div class="form-group" id="complaintagainsttypehndval">
                                        <label class="control-label col-lg-3">*Complaint against type</label>
                                        
                                        <div class="col-lg-8">
                                            
                                            <?php
echo Form::select('complaint_against_type',  array(),null, ['class'=>'form-control','placeholder' => 'Select option','id'=>'complaint_against_type']);
?>
                                       <span  class="errorcustclass">{{ $errors->first('complaint_against_type') }}</span>      
                                        </div><!-- /.col -->
                                    </div><!-- /form-group -->




                                     <div class="form-group">
                                        <label class="control-label col-lg-3">* Dispute reason</label>
                                        <div class="col-lg-8">
    <?php
    $attributes = array();
    $attributes['id']='question';
    $attributes['class']='form-control input-sm parsley-validated';
    $attributes['cols']='60';
    $attributes['rows']='10';


    echo Form::textarea("question",stripslashes($question),'',$attributes );
    ?>
     <span  class="errorcustclass"><br>{{ $errors->first('question') }}</span>
       
                                        </div><!-- /.col -->

                                    </div><!-- /form-group -->





                                     <div class="form-group">
                                        <label class="control-label col-lg-3"></label>
                                        
                                        <div class="col-lg-8">

                                        <input type="hidden" id="hidden_complaint_by" value="<?php echo old('complaint_by')?>">
                                        <input type="hidden" id="hidden_complaint_by_type" value="<?php echo old('complaint_by_type')?>">
                                        <input type="hidden" id="hidden_complaint_against" value="<?php echo old('complaint_against')?>">
                                        <input type="hidden" id="hidden_complaint_against_type" value="<?php echo old('complaint_against_type')?>">

                                        <?php 
                                        if($editid > 0) {
                                        ?>
                                        <input type="hidden" name="diputreson_complaintby" value="<?php echo $complaint_by; ?>"> 
                                        <input type="hidden" name="diputreson_complaintby_type" value="<?php echo $complaint_by_type; ?>"> 
                                        <input type="hidden" name="diputreson_complaintagainst" value="<?php echo $complaint_against;?>"> 
                                        <input type="hidden" name="diputreson_complaintagainst_type" value="<?php echo $complaint_against_type; ?>">
    <?php
      }
?>


                                        <input type="hidden" id="addeditid" value=<?php echo $editid?> name="editid">

                                        <input type="hidden" id="addedittypeflagckeck" name="addedittypeflagckeck" value=<?php echo $addeditflag;?>>


                                     <input  class="btn btn-success" type="submit">
                                     <a class="btn btn-warning" href="http://localhost/betaprosessional/adminpannel/disputereason"><i class="fa fa-chevron-left"></i> Back</a>
                                        </div><!-- /.col -->
                                    </div><!-- /form-group -->
  <?php



echo Form::close();
?>
                      </div><!-- /panel -->
                       </div><!-- /panel -->
                    </div>
                    </div>
            </div><!-- /.padding-md -->

    <!-- <script type="text/javascript" src="{{ADMINCSSPATH}}/otherfiles/progjs/dispute_reason.js"></script>           -->
      <script type="text/javascript" src="{{ADMINCSSPATH}}/otherfiles/progjs/dispute_reason_selectbox.js"></script>  


<script>
var disputeresaonedit_flag = '<?php echo $editid?>';

var diputreson_complaintby ='<?php echo $complaint_by?>';
var diputreson_complaintby_type = '<?php echo $complaint_by_type?>';
var diputreson_complaintagainst = '<?php echo $complaint_against?>';
var diputreson_complaintagainst_type = '<?php echo $complaint_against_type?>';

</script>

<style>
.mydisplaynoneadmin{
    display: none;
}
</style>

@endsection
