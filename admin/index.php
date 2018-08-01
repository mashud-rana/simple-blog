<?php
ob_start();
session_start();
if ($_SESSION['name'] != "admin" ){
	header('location:login.php');
}

?>

<?php include('header.php');?>


<div class="main_body_admin">
        <h2>Welcome to the dashboard of </br> sample Blog with PHP</h2>
</div>


<?php include('footer.php');?>            
