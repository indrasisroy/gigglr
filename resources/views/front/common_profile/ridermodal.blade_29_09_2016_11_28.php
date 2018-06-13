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
                    echo $ridervalue;
                }else if($rider_type == 'edit'){
                    //idrasis code
                }
                ?>
                
                
               </div>
			</div>
         </div>
      </div>
   </div>