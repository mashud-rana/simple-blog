
<?php
if (!isset($_REQUEST['id'])){
	include('index.php');
}else{
	$id= (isset($_REQUEST['id']));
}

?>
<?php include('config.php');?>
<?php include('header.php');?>
	<?php

		if (isset($_REQUEST['form1'])){
			try {

				if (empty($_REQUEST['c_message'])){
					throw new Exception("Message con't be empty");
					
				}
				if (empty($_REQUEST['c_name'])){
					throw new Exception("Name con't be empty");
					
				}
				if (empty($_REQUEST['c_email'])){
					throw new Exception("Email id con't be empty");
					
				}

				$action=0;
				$statement = $db->prepare("INSERT INTO tbl_commend (c_name,c_email,c_commend,c_url,post_id,action) VALUES (?,?,?,?,?,?)");
				$statement->execute(array($_REQUEST['c_name'],$_REQUEST['c_email'],$_REQUEST['c_message'],$_POST['c_url'],$id,$action));

				$success_message="successfully commend insert";

				
			} catch (Exception $e) {

				$message = $e-> getMessage();
				
			}
		}

	?>


<?php
	
	$statement = $db->prepare("SELECT * FROM tbl_post WHERE post_id=? ");
     $statement->execute(array($_REQUEST['id']));
     $result=$statement->fetchAll(PDO::FETCH_ASSOC);
     foreach ($result as $row){

?>


<h2><?php echo $row['post_title'];?></h2>
					<div><span class="date">
							<?php
									$statement3 = $db->prepare("SELECT * FROM tbl_post WHERE post_date=? ");
							        $statement3->execute(array($row['post_date']));
							        $result3=$statement3->fetchAll(PDO::FETCH_ASSOC);
							        foreach ($result3 as $row3){
							        	$tbl_date= $row3['post_date'];

							        }

							        	$day=substr($tbl_date, 8,2);
							        	$month=substr($tbl_date, 5,2);
							        	$year=substr($tbl_date, 0,4);

							        	if($month=='01') {$month="Jan";}
										if($month=='02') {$month="Feb";}
										if($month=='03') {$month="Mar";}
										if($month=='04') {$month="Apr";}
										if($month=='05') {$month="May";}
										if($month=='06') {$month="Jun";}
										if($month=='07') {$month="Jul";}
										if($month=='08') {$month="Aug";}
										if($month=='09') {$month="Sep";}
										if($month=='10') {$month="Oct";}
										if($month=='11') {$month="Nov";}
										if($month=='12') {$month="Dec";}

							        	echo $day."-".$month."-".$year;


								?>

				</span><span class="categories">Tags: 
					<?php

						$tag_id= $row['tag_id'];


						$arr =explode(",",$tag_id);

						$tag_name=count($arr);
						$k=0;
						for($i=0;$i<$tag_name;$i++){

							$statement1 = $db->prepare("SELECT * FROM tbl_tag WHERE tag_id=? ");
	       					 $statement1->execute(array($arr[$i]));
	       					 $result1=$statement1->fetchAll(PDO::FETCH_ASSOC);
	       					 foreach ($result1 as $row1){

	       					 	$tag_names[$k]=$row1['tag_name'];
	       					 }
	       					 $k++;
						}
						$tag_ids=implode(",",$tag_names);

						echo $tag_ids;



					?>


				</span></div>
					<div class="description">
						<a  class="fancybox" href="uploads/<?php echo $row['post_image']; ?>" title=""><img src="uploads/<?php echo $row['post_image']; ?>" alt="" width="200" /></a>
						<p><?php echo $row['post_decription'];?></p>
					</div>


<?php


     }


?>

				
				<p><img src="images/photo1.jpg" alt="" width="511" height="310" /></p>
				<p>Lorem ipsum dolor sit amet, consectetuer adipi scing elit.Mauris urna urna, varius et, interdum a, tincidunt quis, libero. Aenean sit amturpis. Maecenas hendrerit, massa ac laoreet iaculipede mnisl ullamcorpermassa, cosectetuer feipsum eget pede. Proin nunc. </p>
				<p><img src="images/photo2.jpg" alt="" width="511" height="310" /></p>
				<p>Lorem ipsum dolor sit amet, consectetuer adipi scing elit.Mauris urna urna, varius et, interdum a, tincidunt quis, libero. Aenean sit amturpis. Maecenas hendrerit, massa ac laoreet iaculipede mnisl ullamcorpermassa, cosectetuer feipsum eget pede. Proin nunc. </p>
			</div>

			


			<div id="comments">
				<img src="images/title3.gif" alt="" width="216" height="39" /><br />												

				<?php
					$statement = $db->prepare("SELECT * FROM tbl_commend WHERE action=1 ORDER BY c_id DESC ");
	        		$statement->execute();
	        		$result=$statement->fetchAll(PDO::FETCH_ASSOC);
	        		foreach ($result as $row){

	        	?>

	        	<div class="comment">
					<div class="avatar">
					<?php 
						$gravatarMd5 = md5($row['c_email']);
						
					?>
					
					 <img src="http://gravatar.com/avatar/<?php echo $gravatarMd5; ?>"  width="80"> <br>
						<span><?php echo $row['c_name'];?></span><br />

					</div>
					<p><?php echo $row['c_commend'];?> </p>
				</div>



	        	<?php
	        		}
				?>																																					
				

				<div id="add">
					<img src="images/title4.gif" alt="" width="216" height="47" class="title" /><br />
					<?php

								if (isset($message)){
									echo "<div style='color:red;text-align:center; margin-bottom:10px;'> ". $message.'</div>';
								}
								if ( isset($success_message)){
									echo "<div style='color:green;text-align:center; margin-bottom:10px;'>".$success_message."</div>";
								}


							?>
					<div class="avatar">
						<img src="images/avatar2.gif" alt="" width="80" height="80" /><br />
						<span>Name User</span><br />
						April 12th
					</div>
					<div class="form">
						<form action=" " method="post">
							<textarea placeholder="Your message" name="c_message"></textarea>
							<script>
								CKEDITOR.replace( 'c_message' );
							</script><br/>
							<input type="text"  placeholder="Name" name="c_name" /><br />
							<input type="text"  placeholder="Email" name="c_email" /><br />
							<input type="text"   placeholder="Url" name="c_url"/><br />
							 <!-- <a href=" "><img src="images/button.gif" name="form1"  alt="" width="94" height="27" /></a> --> 
							<input type="submit" name="form1" value="send commend">
						</form>
					</div>
				</div>
			</div>
		</div>
<?php include('footer2.php');?>

