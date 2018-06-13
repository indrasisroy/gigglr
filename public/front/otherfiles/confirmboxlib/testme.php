<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <!-- <meta http-equiv="X-UA-Compatible" content="chrome=1"> -->
        <title>jquery-confirm.js | The multipurpose alert & confirm</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
        <!--[if lt IE 9]>
       
        <![endif]-->
       <!---->

        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
     
        <script>
            var version = '2.5.1';
        </script>
        <style type="text/css">
            .space10{
                height: 10px;
            }
            body{
                font-family: Segoe UI,Frutiger,Frutiger Linotype,Dejavu Sans,Helvetica Neue,Arial,sans-serif;
                position: relative;
            }
        </style>
        <!-- Add the minified version of files from the /dist/ folder. -->
        <!-- jquery-confirm files -->
        <link rel="stylesheet" type="text/css" href="css/jquery-confirm.css" />
        <script type="text/javascript" src="js/jquery-confirm.js"></script>
        <!--END jquery-confirm files-->
    </head>
    <body data-spy="scroll" data-target=".navbar">
       
        
         <button class="btn btn-primary myconfirm">My Confirm Box</button>
                            <script type="text/javascript">
                                $('.myconfirm').on('click', function () {
                                    
                                $.confirm({
                                title: 'Confirm!',
                                content: 'Are you sure !',
                                confirmButton: 'Yes',
                                cancelButton: 'No',
                                confirmButtonClass: 'btn-success',
                                cancelButtonClass: 'btn-danger',
                                closeIcon: false,
                                backgroundDismiss: false,
                                theme:'material',
                                confirm: function(){
                                         $.alert('Confirmed!');
                                },
                                cancel: function(){
                                         $.alert('Canceled!')
                                }
                                });
                                    
                                    
                                    
                                });
                            </script>
        
        
        
    </body>
</html>