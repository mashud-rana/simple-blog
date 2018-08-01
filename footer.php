<?php include('config.php');?>
</div>
		</div>
		<div id="sidebar">
		    <div id="search">
				<input type="text" value="Search"> <a href="#"><img src="images/go.gif" alt="" width="26" height="26" /></a>	
			</div>
			<div class="list">
				<img src="images/title1.gif" alt="" width="186" height="36" />
				<ul>

					<?php
						include('config.php');
						$statement = $db->prepare("SELECT * FROM tbl_category ORDER BY cat_name ASC");
				        $statement->execute();
				        $result=$statement->fetchAll(PDO::FETCH_ASSOC);
				        foreach ($result as $row){
	        		?>

					<li><a href="#"><?php echo $row['cat_name'];?></a></li>	

	        	<?php

	        	}
	        ?>

				</ul>
				<img src="images/title2.gif" alt="" width="180" height="34" />
				<ul>
							
							<?php
								include('config.php');
								$j=0;
								$statement = $db->prepare("SELECT distinct (post_date) FROM tbl_post ORDER BY post_date DESC");
						        $statement->execute();
						        $result=$statement->fetchAll(PDO::FETCH_ASSOC);
						        foreach ($result as $row)
						        
						        {
									$full_date=$row['post_date'];
									$cut_date=substr($full_date, 0,7);
									$date_array[$j] = $cut_date;
									$j++;
								}

								$result= array_unique($date_array);
								$array_expolode= implode(",", $result);
								$arr =explode(",",$array_expolode);
								$array_count= count($arr);
			       			?>
			       			<?php
			       				for($i=0;$i<$array_count;$i++){
									$year=substr($arr[$i], 0,4);
									$month=substr($arr[$i], 5,2);

									

									if($month=='01'){
										  $month_new="January";
									}
									if($month=='02'){
										 $month_new="February";
									}
									if($month=='03'){
										 $month_new="March";
									}
									if($month=='04'){
										 $month_new="April";
									}
									if($month=='05'){
										 $month_new="May";
									}
									if($month=='06'){
										 $month="June";
									}
									if($month=='07'){
										 $month_new="July";
									}
									if($month=='08'){
										 $month_new="August";
									}
									if($month=='09'){
										$month_new="September";
									}
									if($month=='10'){
										 $month_new="Octobor";
									}
									if($month=='11'){
											$month_new="Novermer";
									}
									if($month=='12'){
										 $month_new="December";
									}

								?>
									<li><a href="arcive.php?date=<?php echo $arr[$i];?>"><?php echo $year." ".$month_new."<br>"; ?></a></li>

								<?php

																		
								}

			       			?>
			       			
				</ul>
			</div>
		</div>
	</div>
	<div id="footer">
		<?php
			$statement = $db->prepare("SELECT * FROM tbl_footer WHERE id=1 ");
	        $statement->execute();
	        $result=$statement->fetchAll(PDO::FETCH_ASSOC);
	        foreach ($result as $row){
	        	?>

				<p><?php echo $row['description'];?><a href="http://freecsstemplates.in">Free Css</a></p>	

	        	<?php

	        }

		?>
		
	</div>


		<script src="js/vendor/jquery-3.2.1.min.js"></script>
		<script src="js/jquery.fitvids.js"></script>
		<script src="js/bootstrap.min.js"></script>
        <script src="js/plugins.js"></script>
        <script src="js/main.js"></script>
		<script src="js/jquery.smoothscroll.min.js"></script>
        
       
       
</body>
</html>
