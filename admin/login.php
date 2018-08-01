<?php

if(isset($_POST['form1'])) 
{
  
  try {
  
    
    if(empty($_POST['username'])) {
      throw new Exception('Username can not be empty');
    }
    
    if(empty($_POST['password'])) {
      throw new Exception('Password can not be empty');
    }
  
    
    $password = $_POST['password']; // admin
    $password = md5($password);
  
  
    include('../config.php');
    $num=0;
        
    $statement = $db->prepare("select * from admin where user_name=? and password=?");
    $statement->execute(array($_POST['username'],$password));   
    
    $num = $statement->rowCount();
    
    if($num>0) 
    {
      session_start();
      $_SESSION['name'] = "admin";
      header("location: index.php");
    }
    else
    {
      throw new Exception('Invalid Username and/or password');
    }
  
  
  
  }
  
  catch(Exception $e) {
    $error_message = $e->getMessage();
  }
  
}

?>


 <!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>login</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="manifest" href="site.webmanifest">
        <link rel="apple-touch-icon" href="icon.png">
        <!-- Place favicon.ico in the root directory -->

        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/font-awesome.min.css">
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="css/slicknav.css">
    </head>
    <body>
        <!--[if lte IE 9]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
        <![endif]-->

        <!-- Add your site or application content here -->
        
          <div class="wrapper">
            <form class="form-signin " action="" method="post">
            <table>       
              <h2 class="form-signin-heading">Please login</h2>
              <?php
            if(isset($error_message))
                {
                echo "<div class='error'> <span style='color:red; font-weight:bold;'> ".$error_message."</span></div>";
                }
            ?>
              <input type="text" class="form-control" name="username" placeholder="Username" required="" autofocus="" />
              <input type="password" class="form-control" name="password" placeholder="Password" required=""/>      
              <label class="checkbox text-center">
                <input type="checkbox" value="remember-me" id="rememberMe" name="rememberMe"> Remember me
              </label>
              <input type="submit" class="btn btn-lg btn-primary btn-block" value="Login" name="form1">
             </table>    
            </form>
          </div>
    
    
    
    
    
    
        
    <script src="js/vendor/jquery-3.2.1.min.js"></script>
    <script src="js/jquery.fitvids.js"></script>
    <script src="js/bootstrap.min.js"></script>
        <script src="js/plugins.js"></script>
        <script src="js/main.js"></script>
    <script src="js/jquery.smoothscroll.min.js"></script>
        <script src="js/jquery.slicknav.min.js"></script>

    </body>
</html>


