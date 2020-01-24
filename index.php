<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="templates/css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Lato&display=swap" rel="stylesheet">

    <title>Control Vehicular</title>
</head>
<body>
<?php
session_start();

if(isset($_GET['view'])){
    switch($_GET['view']){
        case "login":
            if(isset($_SESSION['val']))
            {
                header("Location:index.php?view=menu");    
            }else{
                include("templates/views/login.html");
            }
            break;
        case "close":
            header("Location:functions/close.php");
            break;
        case "block":
            include('templates/views/block.html');
            break;
        case "menu":
            require_once('functions/menu.php');
            break;
        default:
            header("Location:index.php?view=".urlencode("login"));        
            break;
    }
}else{
    if($_SESSION['val'] == TRUE){
        $_GET['view'] = "inicio";
        header("Location:index.php?view=".urlencode("menu"));    
    }else{
        $_GET['view'] = "inicio";
        header("Location:index.php?view=".urlencode("login"));
    }
}

?>

<script src="templates/js/functions.js"></script>

</body>
</html>