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
	if (!isset($_REQUEST['id'])){
		header('location:view_data.php');
	}else{
		$id=$_REQUEST['id'];
		
	}
?>

 <?php

if (isset($_REQUEST['form1'])){
	try {
		if (empty($_REQUEST['post_title'])) {
			throw new Exception("You can't fild tag");
			
		}
		if(empty($_REQUEST['description1'])){
			throw new Exception("You can't fild  description");
		}
		if(empty($_REQUEST['tag_id'])){
			throw new Exception("You can't fild tag");
		}
		if (empty($_REQUEST['cat_id'])){
			throw new Exception("You can't fild cat");
		}

			



		/*	$statement = $db->prepare("SHOW TABLE STATUS LIKE 'tbl_post'");
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
			
		
			move_uploaded_file($_FILES["post_image"]["tmp_name"],"../uploads/" . $f1);*/

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


			if(empty($_FILES["post_image"]["name"])){

				$statement = $db->prepare(" UPDATE tbl_post SET post_title=?,post_decription=?,cat_id=?,tag_id=? WHERE post_id=?");
				$statement->execute(array($_REQUEST['post_title'],$_POST['description1'],$_REQUEST['cat_id'],$tag_ids,$id));

			}else{
				$up_filename=$_FILES["post_image"]["name"];
				$file_basename = substr($up_filename, 0, strripos($up_filename, '.')); 
				$file_ext = substr($up_filename, strripos($up_filename, '.'));
				$f1 = $id . $file_ext;
		
				if(($file_ext!='.png')&&($file_ext!='.jpg')&&($file_ext!='.jpeg')&&($file_ext!='.gif'))
				throw new Exception("Only jpg, jpeg, png and gif format images are allowed to upload.");
			
			
					$statement1 = $db->prepare("SELECT * FROM tbl_post WHERE post_id=?");
					$statement1->execute(array($id));
					$result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
					foreach($result1 as $row1)
				{
				$real_path = "../uploads/".$row1['post_image'];
				unlink($real_path);
       			}

				move_uploaded_file($_FILES["post_image"]["tmp_name"],"../uploads/" . $f1);

				$statement = $db->prepare(" UPDATE tbl_post SET post_title=?,post_decription=?,post_image=?,cat_id=?,tag_id=? WHERE post_id=?");
				$statement->execute(array($_REQUEST['post_title'],$_POST['description1'],$f1,$_REQUEST['cat_id'],$tag_ids,$id));
			

			}

			 

			/*$post_date=date('Y-m-d'); 
			$post_timestamp=strtotime(date('Y-m-d'));*/


		
			$message_edit="Successfully you update tag";


			/*$statement = $db->prepare("INSERT INTO tbl_post (post_title,post_decription,post_image,cat_id,tag_id,post_date,post_timestamp) VALUES (?,?,?,?,?,?,?)");
			}
		$statement->execute(array($_POST['title_name'],$_POST['description1'],$f1,$_POST['cat_id'],$tag_ids,$post_date,$post_timestamp));*/
		
		} catch (Exception $e) {
			$message_post=$e->getMessage();
		}

	}
	
    

    ?>










<?php



		$statement = $db->prepare("SELECT * FROM tbl_post WHERE post_id=? ");
        $statement->execute(array($id));
        $result=$statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row){


        	$post_title=$row['post_title'];
        	$post_desription=$row['post_decription'];
        	$post_image=$row['post_image'];
        	$cat_id=$row['cat_id'];
        	$tag_id=$row['tag_id'];

        	

        }

    ?>


   

<h4>Post Edite</h4>
<hr>
<?php 
        if (isset($message_edit)){
            echo " <span style='color:blue'> ".$message_edit."</span>";
        }
        if (isset($message_post)){
            echo " <span style='color:red'> ".$message_post."</span>";
        }
    ?>
<form action="" method="post" enctype="multipart/form-data">
	<input type="hidden" name="id" value="<?php echo $id; ?>">
	<table>
		<tr>
			<td>Post edite</td>
		</tr>
	<tr>
		<td><input class="long" type="text" name="post_title" placeholder="Edite" value="<?php echo $post_title;?>"></td>
	</tr>
	<tr>
		<td>Discription</td>
	</tr>
	<tr>
		<td>
			

			<!-- <textarea name="description" id="" cols="30" rows="10"></textarea> -->

			<textarea name="description1" ><?php echo $post_desription;?></textarea>
		<script>
			CKEDITOR.replace( 'description1' );
		</script>
		</td>
	
	</tr>
	<tr>
		<td>View previous Image</td>
	</tr>
	<tr>
		<td><img src="../uploads/<?php echo $post_image; ?>" width="200" alt=""></td>
	</tr>
	<tr>
		<td>New Fetured Image</td>
	</tr>
	<tr>
		<td><input type="file" name="post_image"></td>
	</tr>
	
		<tr>
			<td>
			<select name="cat_id" >
				<option value="">Select cattagory</option>
				<?php
					$statement = $db->prepare("SELECT * FROM tbl_category ORDER BY cat_name ASC ");
        			$statement->execute();
        			$result=$statement->fetchAll(PDO::FETCH_ASSOC);
        			foreach ($result as $row){

        				if($row['cat_id']==$cat_id){

        					?><option  value="<?php echo $row['cat_id'];?>" selected><?php echo $row['cat_name'];?></option><?php
        				}else{
        					?><option value="<?php echo $row['cat_id'];?>"><?php echo $row['cat_name'];?></option><?php
        				}

        			
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

					   	$is_there=0;
					   	$arr2 = explode(",",$tag_id);
					   	$count_arr2=count(explode(",",$tag_id));

					   	for($j=0;$j<$count_arr2;$j++){
					   		if($arr2[$j]== $row['tag_id']){
					   			$is_there=1;
					   			break;
					   		}
					   	}

					   	if($is_there==1){
					   		?><input type="checkbox" name="tag_id[]" value="<?php echo $row['tag_id']; ?>"checked>&nbsp;<?php echo $row['tag_name'];?><br><?php
					   	}else{
					   		?><input type="checkbox" name="tag_id[]" value="<?php echo $row['tag_id'];?>">&nbsp;<?php echo $row['tag_name'];?><br><?php
					   	}

				
					   }

				?>
			</td>
		</tr>
	
	<tr>
		<td><input type="submit" value="UPDATE" name="form1"></td>
	</tr>
	</table>
</form>

<?php include('footer.php');?>            
