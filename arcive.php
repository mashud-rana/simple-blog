<?php 
 
 if (!isset($_REQUEST['date'])){
 	header('location:index.php');
 }else{
 	$main_date= $_REQUEST['date'];

 	$year=substr($main_date, 0,4);
 	$month=substr($main_date, 5,2);
 }


?>
<?php include('header.php');?>
<?php include('config.php');


/* ===================== Pagination Code Starts ================== */
			$adjacents = 7;
			
			$statement = $db->prepare("SELECT * FROM tbl_post WHERE year=? AND month=? ORDER BY post_title DESC");
			$statement->execute(array($year,$month));
			$total_pages = $statement->rowCount();
							
			
			$targetpage = $_SERVER['PHP_SELF'];   //your file name  (the name of this file)
			$limit = 5;                                 //how many items to show per page
			$page = @$_GET['page'];
			if($page) 
				$start = ($page - 1) * $limit;          //first item to display on this page
			else
				$start = 0;
			
						
			$statement = $db->prepare("SELECT * FROM tbl_post WHERE year=? AND month=? ORDER BY post_title DESC LIMIT $start, $limit");
			$statement->execute(array($year,$month));
			$result = $statement->fetchAll(PDO::FETCH_ASSOC);
			
			
			if ($page == 0) $page = 1;                  //if no page var is given, default to 1.
			$prev = $page - 1;                          //previous page is page - 1
			$next = $page + 1;                          //next page is page + 1
			$lastpage = ceil($total_pages/$limit);      //lastpage is = total pages / items per page, rounded up.
			$lpm1 = $lastpage - 1;   
			$pagination = "";
			if($lastpage > 1)
			{   
				$pagination .= "<div class=\"pagination\">";
				if ($page > 1) 
					$pagination.= "<a href=\"$targetpage?page=$prev\">&#171; previous</a>";
				else
					$pagination.= "<span class=\"disabled\">&#171; previous</span>";    
				if ($lastpage < 7 + ($adjacents * 2))   //not enough pages to bother breaking it up
				{   
					for ($counter = 1; $counter <= $lastpage; $counter++)
					{
						if ($counter == $page)
							$pagination.= "<span class=\"current\">$counter</span>";
						else
							$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";                 
					}
				}
				elseif($lastpage > 5 + ($adjacents * 2))    //enough pages to hide some
				{
					if($page < 1 + ($adjacents * 2))        
					{
						for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
						{
							if ($counter == $page)
								$pagination.= "<span class=\"current\">$counter</span>";
							else
								$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";                 
						}
						$pagination.= "...";
						$pagination.= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";
						$pagination.= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";       
					}
					elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
					{
						$pagination.= "<a href=\"$targetpage?page=1\">1</a>";
						$pagination.= "<a href=\"$targetpage?page=2\">2</a>";
						$pagination.= "...";
						for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
						{
							if ($counter == $page)
								$pagination.= "<span class=\"current\">$counter</span>";
							else
								$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";                 
						}
						$pagination.= "...";
						$pagination.= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";
						$pagination.= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";       
					}
					else
					{
						$pagination.= "<a href=\"$targetpage?page=1\">1</a>";
						$pagination.= "<a href=\"$targetpage?page=2\">2</a>";
						$pagination.= "...";
						for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
						{
							if ($counter == $page)
								$pagination.= "<span class=\"current\">$counter</span>";
							else
								$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";                 
						}
					}
				}
				if ($page < $counter - 1) 
					$pagination.= "<a href=\"$targetpage?page=$next\">next &#187;</a>";
				else
					$pagination.= "<span class=\"disabled\">next &#187;</span>";
				$pagination.= "</div>\n";       
			}
			/* ===================== Pagination Code Ends ================== */	




		?>
	<?php 
        foreach ($result as $row){


        
       ?>
				       
				       <div class="post">
							<h2><?php echo $row['post_title'];?></h2
							<div><span class="date"><!-- Mar 12th -->
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


							</span><span class="categories">Tags
								<?php

									$tags=$row['tag_id'];

									$arr =explode(",",$tags);

									$count_arr= count($arr);

									$k=0;
									for ($i=0; $i < $count_arr ; $i++) { 

										$statement1 = $db->prepare("SELECT * FROM tbl_tag WHERE tag_id=? ");
							        	$statement1->execute(array($arr[$i]));
							       	 	$result1=$statement1->fetchAll(PDO::FETCH_ASSOC);
							        	foreach ($result1 as $row1){
							        	$tag_id[$k]=$row1["tag_name"];
										
							        	}
							        	$k++;

									}
									$tag_ids=implode(",",$tag_id);
									echo $tag_ids;       
							?>
							</span></div>
							<div class="description">
								<img src="uploads/<?php echo $row['post_image']; ?>" alt="" width="200"/>
								<p><?php 
									$statement5 = $db->prepare("SELECT * FROM tbl_post ORDER BY post_id DESC ");
							        $statement5->execute();
							        $result5=$statement5->fetchAll(PDO::FETCH_ASSOC);
							        foreach ($result5 as $row5){

							        	$description_post=$row5['post_decription'];
							        	

							        }
									$pieces = explode(" ", $description_post);
									$final_words = implode(" ", array_splice($pieces, 0, 200));
									$final_words = $final_words.' ...';
								?>
									 <?php echo $final_words;?> 
								</p>
							</div>
							<p class="comments">Comments - <a href="#">17</a>   <span>|</span>   <a href="index2.php?id=<?php echo $row['post_id'];?>">Continue Reading</a></p>

					<?php
				        }
					?>

&nbsp;		
<div class="pagination">

	<?php echo $pagination; ?>

</div>			
					
				
<?php include('footer.php');?>