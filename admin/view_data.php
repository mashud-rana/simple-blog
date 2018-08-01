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
<?php include('header.php');?>



<div class="heading">
    <h4>View data  </h4>
    <hr>
    
    
    <table class="table table-striped ">
  <thead>
    <tr>
      <th scope="col">Slear No.</th>
      <th scope="col">Title</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
    <?php
        $i=0;
        $statement = $db->prepare("SELECT * FROM tbl_post ORDER BY post_id DESC ");
        $statement->execute();
        $result=$statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
        $i++

    ?>

    <tr>
      <td scope="row"><?php echo $i; ?></td>
      <td><?php echo $row['post_title']; ?></td>
      <td>
            <a class="fancybox" href="#inline<?php echo $i; ?>" >View</a>
            <div id="inline<?php echo $i; ?>" style="width:700px;display: none;">
                <h3> View Data </h3>
                <hr>
                <p>
                    <form action=" " method="post">

                    <table >
                        <tr>
                            <td><b>Post Title:--</b></td>
                        </tr>
                        <tr>
                            <td><?php echo $row['post_title'];?></td>
                        </tr>

                        <tr>
                            <td><b>Post Description:--</b></td>
                        </tr>
                        
                        <tr>
                            <td><?php echo $row['post_decription'];?></td>
                        </tr>
                        <tr>
                            <td><b>Fiture image:--</b></td>
                        </tr>

                         <tr>
                            <td><img src="../uploads/<?php echo $row['post_image'];?>" alt=""></td>
                        </tr>
                        <tr>
                            <td><b>Category Name:--</b></td>
                        </tr>
                        <tr>
                            <td>
                                <?php

                                $statement1 = $db->prepare("SELECT * FROM tbl_category WHERE cat_id=?");
                                $statement1->execute(array($row['cat_id']));
                                $result1=$statement1->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($result1 as $row1){

                                    echo $row1['cat_name'];

                                }

                                ?> 
                            </td>
                        </tr>
                        <tr>
                            <tr>
                                <td><b>View Tag:--</b></td>
                            </tr>
                            <td>
                                <?php
                                    $arr =explode(",",$row['tag_id']);
                                    $count_arr = count (explode(",",$row['tag_id']));

                                    $k=0;
                                    for($j=0;$j<$count_arr;$j++){

                                        // arr['$j']=$row['tag_name'];;
                                        

                                        $statement1 = $db->prepare("SELECT * FROM tbl_tag WHERE tag_id=? ");
                                        $statement1->execute(array($arr[$j]));
                                        $result1=$statement1->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($result1 as $row1){
                                        $arr1[$k] = $row1['tag_name'];
                                        }
                                        $k++;
                                    }

                                    $tag_name = implode(",",$arr1);
                                    echo $tag_name;

                                ?>
                            </td>
                            
                            </td>
                        </tr>
                          </table>
                    </form>
                </p>
            </div>
            &nbsp;||&nbsp;
            <a href="post_edit.php?id=<?php echo $row['post_id'];?>">Edit</a>
            &nbsp;||&nbsp;
            <a onclick="return confirmdelete();" href="delete_post.php?id=<?php echo $row['post_id'];?>">Delete</a>
      </td>
    </tr>



    <?php

}

?>
<?php include('footer.php');?>            
