<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>File Upload</title>
    <style>
        body{
            margin:0px;
            padding: 0px;
            overflow: hidden;
        }
        img{
            width:100%;
            height: 601px;
            margin-bottom:0px;
            padding:0px;
            /* opacity: 0.7; */
        }
       #bannerContent{
            position:absolute;
            padding-top:4%;
            padding-bottom:4%;
            margin-top:-35%;
            margin-bottom:12%; 
            margin-left:32%;
            background-color:rgba(245, 235, 235, 0.719);
            width:500px;
        }
    </style>
</head>
<body>
    <img src="https://images.unsplash.com/photo-1582816441253-6a9a623bc3f0?ixid=MnwxMjA3fDB8MHxzZWFyY2h8MjJ8fGNsZWFuaW5nJTIwY29tcGFueXxlbnwwfHwwfHw%3D&ixlib=rb-1.2.1&w=1000&q=80" alt="Cleaning.jpg" />
    <center>
        <div id=bannerContent>
            <h1>GET ALL GEOCODES</h1>
            <h5>Generate data and Send it to Corporation.</h5>
            <br>
            <?php
            require 'getXlsData.php';

            if(isset($_POST['send'])) 
            {
                getXlData();
            }
            ?>
            <form method="post">
                <input type="submit" class="btn btn-primary" name="send" value="Generate and Send" />
            </form>
        </div>
    </center>
</body>  
</html>