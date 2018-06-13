
                 <?php

                 ?>

             <div class="select_cont search_select">
               <?php
                  $control_attrAr=array();
                  $control_attrAr['id']='category_sub_profile';
                  $control_attrAr['class']=" selectpicker";
                  $control_attrAr['title']="Category";
                  
                  $category_sub='';
                  $fetchcategorysubData=array();
                  for($i = 0;$i<count($category);$i++){
                     $fetchcategorysubData[$category[$i]->id] = $category[$i]->name;
                  }

                  echo Form::select('category_sub', $fetchcategorysubData, $category_sub,$control_attrAr);             
                  ?>
            </div>
            <div class="select_cont search_select">
               <?php
                  $control_attrAr=array();
                  $control_attrAr['id']='genre_sub_profile';
                  $control_attrAr['class']=" selectpicker";
                  $control_attrAr['title']="Genre";
                  
                  $genre_sub='';
                  $fetchgenresubData=array();
                  echo Form::select('genre_sub', $fetchgenresubData, $genre_sub,$control_attrAr);							
                  ?>
            </div>
               	  <!-- <script type="text/javascript" src="{{ FRONTCSSPATH}}/otherfiles/progjs/frontendpublicprofilegig.js"></script>-->