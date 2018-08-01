<?php
ob_start();
session_start();
if ($_SESSION['name'] != "admin" ){
	header('location:login.php');
}

?>

<?php include('header.php');?>

<?php
	include('../config.php');
?>
<?php

if (isset($_REQUEST['form1'])){
	try {
		if ((empty($_REQUEST['title_name'])) || (empty($_REQUEST['description1'])) || (empty($_REQUEST['tag_id'])) || (empty($_REQUEST['cat_id'])) ){
			throw new Exception("You can't fild title or Discription");
			
		}
		
		 //echo $_REQUEST['title_name']."<br>";
		//echo $_REQUEST['description1']."<br>";
		 //echo $_REQUEST['cat_id']."<br>";
		//echo $_REQUEST['tag_id']."<br>";
		// checkbox array
		

			



			$statement = $db->prepare("SHOW TABLE STATUS LIKE 'tbl_post'");
			$statement->execute();
			$result = $statement->fetchAll();
			foreach($result as $row)
			$new_id = $row[10];

			 $up_filename=$_FILES["post_image"]["name"];
			$file_basename = substr($up_filename, 0, strripos($up_filename, '.')); // strip extention
			$file_ext = substr($up_filename, strripos($up_filename, '.')); // strip name
			$f1 = $new_id . $file_ext;
		
			if(($file_ext!='.png')&&($file_ext!='.jpg')&&($file_ext!='.jpeg')&&($file_ext!='.gif')){
				throw new Exception("Only jpg, jpeg, png and gif format images are allowed to upload.");
			}
			
		
			move_uploaded_file($_FILES["post_image"]["tmp_name"],"../uploads/" . $f1);

			/*$statement=$db->prepare("SHOW TABLE STATUS LIKE 'tbl_post'");
			$statement ->execute();
			$result = $statement->fetchAll();
			foreach ($result as $row)
			$new_id = $row[10]; // hear 10 is fixt. always use 10 hear to get increment id


			$up_filename=$_FILES["post_image"]["name"];
			$file_basename = substr($up_filename, 0, strripos($up_filename, '.')); // strip extention
			$file_ext = substr($up_filename, strripos($up_filename, '.')); // strip name
			$f1 = $new_id . $file_ext;

			move_uploaded_file($_FILES["post_image"]["tmp_name"],"../upload/" .$f1);*/

			$tag_id=$_REQUEST['tag_id'];
			$i=0;
			if (is_array($tag_id)){
				foreach($tag_id as $key=>$val){
					$arr[$i]=$val;
					 //echo $arr[$i]."<br>";
					$i++; 
				}
			}



			$tag_ids=implode(",",$arr); // array name
			 //echo $tag_ids."<br>";

			$post_date=date('Y-m-d'); 
			$post_timestamp=strtotime(date('Y-m-d'));
			//echo $post_date."<br>";
		 	//echo $post_timestamp;



			/*$statement = $db->prepare("INSERT INTO tbl_post (post_title,post_decription,post_image,cat_id,tag_id,post_date,post_timestamp) VALUES (?,?,?,?,?,?,?)
			");
			
			$statement->execute(array($_REQUEST['title_name'],$_REQUEST['description1'],$f1,$_REQUEST['cat_id'],$tag_ids,$post_date,$post_timestamp));*/




		/*$statement = $db->prepare("INSERT INTO tbl_post (post_title,post_description,post_image,cat_id,tag_id,post_date,post_timestamp) VALUES (?,?,?,?,?,?,?)");
		$statement->execute(array($_POST['title_name'],$_POST['description1'],$f1,$_POST['cat_id'],$tag_ids,$post_date,$post_timestamp));*/


			$statement = $db->prepare("INSERT INTO tbl_post (post_title,post_decription,post_image,cat_id,tag_id,post_date,post_timestamp) VALUES (?,?,?,?,?,?,?)");
		$statement->execute(array($_POST['title_name'],$_POST['description1'],$f1,$_POST['cat_id'],$tag_ids,$post_date,$post_timestamp));
		
	} catch (Exception $e) {
		$message_post=$e->getMessage();
	}
}


?>
<h4>Add new post</h4>
<hr>
<?php
 if (isset($message_post)){
 	echo   "<span style='color:red;'> ". $message_post ."</span>";
 }
?>
<form action="" method="post" enctype="multipart/form-data">
	<table>
		<tr>
			<td>title</td>
		</tr>
	<tr>
		<td><input name="title_name" class="long" type="text" placeholder="Title"></td>
	</tr>
	<tr>
		<td>Discription</td>
	</tr>
	<tr>
		<td>

			<textarea name="description1"></textarea>
		<script>
			CKEDITOR.replace( 'description1' );
		</script>
		</td>
	
	</tr>
	
	<tr>
		<td>Featuared Image</td>
	</tr>
	<tr>
		<td><input type="file" name="post_image"></td>
	</tr>
	<tr>
		<td>select a categorys</td>
	</tr>
	
		<tr>
			<td>
				<select name="cat_id" >
					
					<option value="">Select catorory</option>
					<?php

					   $statement = $db->prepare("SELECT * FROM tbl_category ORDER BY cat_name ASC ");
					   $statement->execute();
					   $result=$statement->fetchAll(PDO::FETCH_ASSOC);
					   foreach ($result as $row) {
					   	?>
					   	<option value="<?php echo $row['cat_id'];?>"><?php echo $row['cat_name'];?></option>
					   	<?php
					   }
					?>
				
				</select>
			</td>
		</tr>
		<tr>
			<td>Select Tags</td>
		</tr>
		<tr>
			<td>
				<?php
					$statement = $db->prepare("SELECT * FROM tbl_tag ORDER BY tag_name ASC ");
					   $statement->execute();
					   $result=$statement->fetchAll(PDO::FETCH_ASSOC);
					   foreach ($result as $row){
				?>
					<input type="checkbox" name="tag_id[]" value="<?php echo $row['tag_id'];?>">&nbsp;<?php echo $row['tag_name'];?><br>
				<?php
					   }

				?>
				
			</td>
		</tr>
	


	
	
	<tr>
		<td><input type="submit" value="Save" name="form1"></td>
	</tr>
	</table>
</form>




<?php include('footer.php');?>            







