<?php
ob_start();
session_start();
if ($_SESSION['name'] != "admin" ){
	header('location:login.php');
}

?>

<?php
    include('../config.php');
?>

<?php
	if (!isset($_REQUEST['id'])){
		header('location:view_data.php');
	}else{
		$id=$_REQUEST['id'];
		
	}
?>

<?php 

		$statement = $db->prepare("SELECT * FROM tbl_post WHERE post_id=? ");
        $statement->execute(array($id));
        $result=$statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row){
        	$image_path="../uploads/".$row['post_image'];
        	unlink($image_path);
        }


$statement = $db->prepare(" DELETE FROM tbl_post WHERE post_id=?");
$statement->execute(array($id));

header('location:view_data.php')




?>