<?php
if(isset($_POST['submit_image']))
{
  
  $folder="images/";
  
  
  //$uploadfile=$_FILES["upload_file"]["tmp_name"];
  
  $cnt=0;
  
  if( !empty($_FILES) )
  {
      $cnt=count($_FILES["upload_file"]["tmp_name"]);
  }
  
  echo "<pre>"; print_r($_FILES); echo "</pre>";
  echo "=cnt=>".$cnt;
  
  if($cnt>0)
  {
    for($cn=0;$cn<$cnt;$cn++)
    {
               // echo "<pre>"; print_r($_FILES["upload_file"]["tmp_name"]); echo "</pre>";
                $tmp_data=$_FILES["upload_file"]["tmp_name"][$cn];
                $name_data=$_FILES["upload_file"]["name"][$cn];
                
                echo "<br>=tmp_data=>".$tmp_data."==name_data=>".$name_data;
                $chkupld=move_uploaded_file($tmp_data, $folder.$name_data);
                var_dump($chkupld);
                echo '<img src="'.$folder."".$name_data.'">';
    }
    
  }
  
  
  //move_uploaded_file($_FILES["upload_file"]["tmp_name"], $folder.$_FILES["upload_file"]["name"]);
  //echo '<img src="'.$folder."".$_FILES["upload_file"]["name"].'">';
  exit();
}
?>