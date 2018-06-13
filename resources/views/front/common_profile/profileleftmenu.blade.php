<div class="event_left_row scrollforrosterleftclass">
   <!--<h2>March 2015</h2>-->
   <ul class="event_list">
   <?php
      $booking_stat = '';
      if(count($all)> 0){
            $oldDate = array();
            $i = 0;
            $varCurrntDate = '';
         foreach($all as $details){
            
            $currentMonth = date('F Y',strtotime($details->event_start_date_time));
            $oldDate[$i] = $currentMonth;
            ?>
            <br>
            <h2>
            <?php
            if($i == 0){
            //echo $oldDate[$i];
            }else if($oldDate[$i-1] != $oldDate[$i]){
            //echo $oldDate[$i];
            }
            $i++;
            
            if($varCurrntDate!= (date("F Y",strtotime($details->event_start_date_time))))
            {
                $varCurrntDate = date("F Y",strtotime($details->event_start_date_time));
                echo $varCurrntDate;
            }
            ?>
            </h2>
            <li>
            <img class="rosterlefticonclass" src="{{ FRONTCSSPATH}}/images/<?php
            if($details->icone=='star'){
            $booktext = "booked";
            $booking_stat = '1';
               if($details->event_type == '2'){
               echo "ash-star.png";
               }else{
               echo "yellow_star.png";
               }
            
            }else{
            $booktext = "send booking request";
            $booking_stat = '2';
            echo "clock-red.png";
            }?>">
            <a href="javascript:void(0)" class="clickMe" data-value="<?php echo $details->giguniqueid;?>" data-event_type="<?php echo $details->event_type;?>" data-booking_stat="<?php echo $booking_stat;?>" data-type_flag="<?php echo $details->type_flag;?>">
            <?php echo ucfirst(trim(stripslashes($details->Booker_name)))." ".$booktext; ?> <?php echo ucfirst(trim(stripslashes($nickname)));?> on <?php echo date('d/m/Y',strtotime($details->event_start_date_time));?> Category
            <?php
            foreach($skill as $allSkill){
               if( $details->category == $allSkill->id){
                  echo $allSkill->name;
               }
            }
            echo " and Genre ";
            foreach($skill as $allSkill){
               if( $details->genre == $allSkill->id){
                  echo $allSkill->name;
               }
            }
            ?>
            </a></li>
            <?php
            }
         //}
                     
      }else{
      echo "<h2>No record found</h2";
      }
   ?>
      
   </ul>
</div>
   