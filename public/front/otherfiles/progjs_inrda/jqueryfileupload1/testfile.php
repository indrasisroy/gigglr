<html>
<head>
  <link rel="stylesheet" type="text/css" href="progress_style.css">
  <script type="text/javascript" src="jquery.js"></script>
  <script type="text/javascript" src="jquery.form.js"></script>
  <script type="text/javascript" src="upload_progress.js"></script>
</head>
<body>
    
    <style>
        
        body
{ 
  padding: 30px 
}
form 
{ 
  display: block; 
  margin: 20px auto; 
  background: #eee; 
  border-radius: 10px; 
  padding: 15px 
}
.progress 
{
  display:none; 
  position:relative; 
  width:400px; 
  border: 1px solid #ddd; 
  padding: 1px; 
  border-radius: 3px; 
}
.bar 
{ 
  background-color: #B4F5B4; 
  width:0%; 
  height:20px; 
  border-radius: 3px; 
}
.percent 
{ 
  position:absolute; 
  display:inline-block; 
  top:3px; 
  left:48%; 
}
        
    </style>
    
<form action="upload_file.php"id="myForm" name="frmupload" method="post" enctype="multipart/form-data">
  <input type="file" id="upload_file" name="upload_file[]" multiple="multiple" />
  <input type="submit" id="submitbutnid" name='submit_image' value="Submit Comment" onclick='upload_image("myForm");'/>
</form>
<div class='progress' id="progress_div">
<div class='bar' id='bar'></div>
<div class='percent' id='percent'>0%</div>
</div>
<div id='output_image'> </div>
<script>
    
    jQuery(document).ready(function(){
        
        $("#upload_file").change(function(){
            
            
            console.log($(this).val());
            
           var filename = $('input[name="upload_file"]').val();
           //console.log(filename);
           
            var inp = document.getElementById('upload_file');
            
            
            for (var i = 0; i < inp.files.length; ++i) {
            var name = inp.files.item(i).name;
                             console.log("here is a file name: " + name + "==size=>"+ inp.files.item(i).size );
            }
           
               $("#submitbutnid").trigger("click");
            
            })
        
        
        });
</script>
</body>
</html>