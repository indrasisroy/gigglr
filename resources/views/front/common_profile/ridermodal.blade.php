	  <div class="modal-dialog popup-dialog" role="document">
      <div class="modal-content popup-content artist_popup">
         <div class="modal-body popup-body">
            <div class="artist_hedr request">
               <button type="button" class="close popup-close " data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
               <h2 id="booking">Rider</h2>
            </div>

			<div class="artist_form_outr clearfix">
			   <div id="ridertet">
                
                <?php
                if($rider_type == 'view'){
                    echo stripslashes($ridervalue);
                }else if($rider_type == 'edit'){ ?>
                   
                    <?php echo Form::open(array('url'=>'', 'method'=>'post', 'id'=>'riderfrm_frmid', 'class'=>"", 'autocomplete'=>'off' ));
?>
  <div class="col-md-12 margintop20">
                   <div class="inline artist_list">
                      <span>Edit Rider</span>
                  <?php echo Form::textarea("rider_txt", $value=$ridervalue,
                $attributes = array( "id"=>"rider_txt", "class"=>"form-control artist_txtaria", "cols"=>"50", "rows"=>"6","maxlength"=>"250" )); ?>
					  </div>
					 <input type="hidden" id="fieldtocountrider" value="250">
					  <p id="CharCountLabelride"></p>
                <button type="button" id="booking_opt_but_rider" class="btn btn-warning">save</button>
      <?php echo Form::close(); ?>
                   
                  </div>
  <?php
                }
                ?>
                
                
               </div>
			</div>
         </div>
      </div>
   </div>