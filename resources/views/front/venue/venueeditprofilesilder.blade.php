<?php
if(!empty($venue_master_img_db))
{
    $totimg=count($venue_master_img_db);
    
    
    foreach($venue_master_img_db as $venue_master_dta)
    {
         $first_image_flag=0;
        $default_status=$venue_master_dta->default_status;
        
        //$imgurldata = asset('upload/venueimage/thumb-big/'.$venue_master_dta->image_name);
        $imgurldata = BASEURLPUBLICCUSTOM.'upload/venueimage/thumb-big/'.$venue_master_dta->image_name;
        
        if( $default_status==1)
        {        
         $first_image_flag=1;
        }
?>


    <div class="item" style="background-image: url({{ $imgurldata}});">
        <a href="javascript:void(0);" class="remove_pick mycustdelimgcls" data-firstimageflag="<?php echo $first_image_flag; ?>" data-imageid="<?php echo $venue_master_dta->id; ?>" data-imagename="<?php echo $venue_master_dta->image_name; ?>" data-toggle="modal" data-target="#alertPopup"><span class="cls"><img src="{{ URL::asset('public/front')}}/images/close2.png" alt="" /></span></a>
       
        <?php if($totimg<=2){  ?>              
        <div class="remove_pick add_pick">
        <!--<input type="file" />-->
        
        <span class="upld userimgupldcls"><img src="{{ URL::asset('public/front')}}/images/upload_icon.png" alt="" />
        
        </span>
        </div>
         <?php  }  ?>   
            
    </div>



    <?php
    }
   }
   else
		{
        //$imgurldata = asset("front/otherfiles/progimages/"."noimagefound537X507.png");
        $imgurldata = BASEURLPUBLICCUSTOM."front/otherfiles/progimages/"."noimagefound537X507.png";
        ?>
    
      <!--default image starts	-->
      <div class="item" style="background-image: url({{ $imgurldata}});">
        <!--<a href="#" class="remove_pick" data-toggle="modal" data-target="#alertPopup"><span class="cls"><img src="{{ URL::asset('public/front')}}/images/close2.png" alt="" /></span></a>-->
        <div class="remove_pick add_pick">
                                    
        <span class="upld userimgupldcls"><img src="{{ URL::asset('public/front')}}/images/upload_icon.png" alt="" />
        
        </span>
        </div>
      </div>
      <!--default image ends	-->
    <?php
    
    }
    ?>