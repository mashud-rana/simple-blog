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
<?php
    if (isset($_REQUEST['id'])){

         try {

            $id= $_REQUEST['id'];

            $statement = $db->prepare(" UPDATE tbl_commend SET action=1 WHERE c_id=?");
            $statement->execute(array($id));

            $message_edit="Successfully you update Category";

             
         } catch (Exception $e) {

            $message= $e->getMessage();
             
         }
    }


?>
 <?php 
    if (isset($_REQUEST['id'])){

        $id= $_REQUEST['id'];


        $statement = $db->prepare(" UPDATE tbl_commend SET action=1 WHERE c_id=?");
        $statement->execute(array($id));

        /*$statement = $db->prepare(" DELETE FROM tbl_commend WHERE c_id=?");
        $statement->execute(array($id));*/
    }
?> 


<div class="heading">
    <h4>View command  </h4>
    <hr>
    
    
    <table class="table table-striped ">
        <form action="commend.php" method="post">
          <thead>
            <tr>
              <th scope="col">Slear No.</th>
              <th scope="col">Name</th>
              <th scope="col">Command</th>
              <th scope="col">url</th>
              <th scope="col">post id</th>
              <th scope="col">Approve</th>
              <th scope="col">Action</th>

            </tr>
          </thead>
              <tbody>
                <?php
                    $i=0;
                    $statement = $db->prepare("SELECT * FROM tbl_commend WHERE action=0 ORDER BY c_id DESC ");
                    $statement->execute();
                    $result=$statement->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($result as $row) {
                    $i++

                ?>

                <tr>
                  <td scope="row"><?php echo $i; ?></td>
                  <td><?php echo $row['c_name']; ?></td>
                  <td><?php echo $row['c_commend'];?></td>
                  <td><?php echo $row['c_url'];?></td>
                  <td><?php echo $row['post_id'];?></td>
                  <td><a href="commend.php?id=<?php echo $row['c_id'];?>">Approve</a></td>
                 <!--  <td><a onclick="return confirmdelete();" href="commend.php?id=<?php echo $row['c_id'];?>">Delete</a></td> -->
                  
                </tr>



                    <?php

                }

                ?>

        </tbody>
    </form>
</table>



<div class="heading">
    <h4>All Approvial command</h4>
    <?php 
        if (isset($message)){
            echo $message;
        }
        if (isset($message_edit)){
            echo $message_edit;
        }

    ?>
    <hr>


    <table class="table table-striped ">
        <form action="commend.php" method="post">
          <thead>
            <tr>
              <th scope="col">Slear No.</th>
              <th scope="col">Name</th>
              <th scope="col">Command</th>
              <th scope="col">url</th>
              <th scope="col">post id</th>
              <th scope="col">Approve</th>
              

            </tr>
          </thead>
              <tbody>
                <?php
                    $i=0;
                    $statement = $db->prepare("SELECT * FROM tbl_commend ORDER BY c_id DESC ");
                    $statement->execute();
                    $result=$statement->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($result as $row) {
                    $i++

                ?>

                <tr>
                  <td scope="row"><?php echo $i; ?></td>
                  <td><?php echo $row['c_name']; ?></td>
                  <td><?php echo $row['c_commend'];?></td>
                  <td><?php echo $row['c_url'];?></td>
                  <td><?php echo $row['post_id'];?></td>
                  <td><a href="commend.php?id=<?php echo $row['c_id'];?>">Approve</a></td>
                 
                  
                </tr>



                    <?php

                }

                ?>

        </tbody>
    </form>
</table>
<?php include('footer.php');?>            
