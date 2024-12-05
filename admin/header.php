<?php
    session_start();

    if (!isset($_SESSION['admin_email'])) 
    {
        header('location: login.php');
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>A R I T Z I A</title>
    <link rel="icon" href="../assets/imgs/adminfavicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        header {
            background-color: darkblue;
            color: white;
            padding-left: 23px;
            padding-right: 23px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: -20px;
        }
        .btn-header{
            border-radius: 5px;
            background-color: white;
            color: darkblue;
            padding: 1px 7px;
            border: none;
            cursor: pointer;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <header>
        <h2>Aritzia</h2>
        <h4>Admin Dashboard</h4>
        <a href="logout.php"><button class="btn-header" >Logout</button></a>
    </header>
</body>
</html>
