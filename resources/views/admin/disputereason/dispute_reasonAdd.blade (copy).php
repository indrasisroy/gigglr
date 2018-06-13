<?php
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
    <script type="text/javascript" src="{{ADMINCSSPATH}}/otherfiles/progjs/dispute_reason.js"></script>
    <?php
$Complaint_By           = '';
$Complaint_by_Type      = '';
$Complaint_Against      = '';
$Complaint_against_Type = '';
$Question               = '';
$Edit_id                = '';
if (!empty($DisputeReasons)) {
    $Complaint_By           = $DisputeReasons->complaint_by;
    $Complaint_by_Type      = $DisputeReasons->complaint_by_type;
    $Complaint_Against      = $DisputeReasons->complaint_against;
    $Complaint_against_Type = $DisputeReasons->complaint_against_type;
    $Question               = $DisputeReasons->question;
    $Edit_id                = $DisputeReasons->id;
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
    'id' => 'disputereasonaddfrmid',
    'class' => "form-horizontal form-border no-margin"
));
?>
                               <div class="panel-heading">
                                 Save Dispute Reason
                                </div>
                                <div class="panel-body">
                                
                                
                                    <div class="form-group">
                                        <label class="control-label col-lg-4">* Complaint by</label>
                                        <div class="col-lg-6">
    <?php
$complaint_by_data = array(
    '' => 'Select',
    '1' => 'Booker',
    '2' => 'Booked-artist/Group/Venue'
);
$attrbar           = array();
$attrbar['id']     = "complaint_by";
$attrbar['class']  = "form-control input-sm parsley-validated";
echo Form::select('complaint_by', $complaint_by_data, $Complaint_By, $attrbar);
?>
   
    <span  class="errorcustclass">{{ $errors->first('complaint_by') }}</span>

                                        </div><!-- /.col -->
                                    </div><!-- /form-group -->
                                    
                                    
                                    
                                    
                                    <?php
$Error_msg = '';
$Error_msg = $errors->first('complaint_by_type');
?>
                                   <div class="form-group" id="complaint_by_type_div" @if(empty($Error_msg) )style="display:none"; @endif>
                                        <label class="control-label col-lg-4">* complaint by type  </label>
                                        <div class="col-lg-6">
                                        
    <?php
$complaint_by_type = array(
    '' => 'Select',
    '1' => 'Artist',
    '2' => 'Group',
    '3' => 'Venue'
);
$attrib            = array();
$attrib['id']      = "complaint_by_type";
$attrib['class']   = "form-control input-sm parsley-validated";

echo Form::select('complaint_by_type', $complaint_by_type, $Complaint_by_Type, $attrib);
?>
   <span  class="errorcustclass">{{ $Error_msg }}</span>                                    
                                        </div><!-- /.col -->
                                    </div><!-- /form-group -->
                                    
                                    
                                    
                                    
                                    <?php
$Error_msg2 = '';
$Error_msg2 = $errors->first('complaint_agaist');
?>
                                   <div class="form-group" id='COMplaint_against' @if($Complaint_Against == '' || empty($Error_msg2) ) style="display:none"; @endif>
                                        <label class="control-label col-lg-4">* Complaint against </label>
                                        <div class="col-lg-6" id="COMPLAINT_AGAINST">
                                        <select class="form-control input-sm parsley-validated" name="complaint_agaist" id="complaint_agaist_slcted">
                                            
                                        </select>
    

    <span  class="errorcustclass">{{ $Error_msg2 }}</span>                                        
                                        </div><!-- /.col -->
                                    </div><!-- /form-group -->
                                    
                                    
                                    
                                    <?php
$Error_msg3 = '';
$Error_msg3 = $errors->first('complaint_against_type');
?>
                                   <div class="form-group" id="complaint_against_type_div" @if($Complaint_against_Type == '' || empty($Error_msg3) ) style="display:none"; @endif>
                                        <label class="control-label col-lg-4">* Complaint against type</label>
                                        <div class="col-lg-6">
    <?php
$complaint_against_type = array(
    '' => 'Select',
    '1' => 'Artist',
    '2' => 'Group',
    '3' => 'Venue'
);
$attributes             = array();
$attributes['id']       = 'complaint_against_type';
$attributes['class']    = 'form-control input-sm parsley-validated';
echo Form::select("complaint_against_type", $complaint_against_type, $Complaint_against_Type, $attributes);
?>
   <span  class="errorcustclass">{{ $Error_msg3 }}</span>                                            
                                        </div><!-- /.col -->
                                    </div><!-- /form-group -->
                                    
                                    
                                    
                                    
                                    <div class="form-group">
                                        <label class="control-label col-lg-4">* Dispute reason</label>
                                        <div class="col-lg-6">
    <?php
$attributes          = array();
$attributes['id']    = 'question';
$attributes['class'] = 'form-control input-sm parsley-validated';
echo Form::textarea("question", $Question, '', $attributes);
?>
   <span  class="errorcustclass">{{ $errors->first('question') }}</span>
        <input type="hidden" name="editId" value="{{$Edit_id}}">
                                        </div><!-- /.col -->
                                    </div><!-- /form-group -->
                                    
                                    
                                </div>
                                <div class="panel-footer ">
                                
                                    <button class="btn btn-success" type="submit">Submit</button>
                                    <a class="btn btn-warning" href="<?php
echo url(ADMINSEPARATOR . '/disputereason');
?>"><i class="fa fa-chevron-left"></i> Back</a>
                                </div>
                                    
                            <?php

echo Form::close();

?>
                       </div><!-- /panel -->
                    </div>
                    </div>
            </div><!-- /.padding-md -->

            
    
@endsection
