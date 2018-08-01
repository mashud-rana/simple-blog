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

  if (isset($_REQUEST['form1'])){
    try {
        if (empty($_REQUEST['cat_name'])){
            throw new Exception("You can't Empty the category fild");  
        }
        
        $statement = $db->prepare("SELECT * FROM tbl_category WHERE cat_name=?");
        $statement->execute(array($_POST['cat_name']));
        $total = $statement->rowCount();
        
        if($total>0) {
            throw new Exception($_REQUEST['cat_name'] ." Name already exists.");
        }

        $statement = $db->prepare("INSERT INTO tbl_category (cat_name) VALUES (?)");
        $statement->execute(array($_POST['cat_name']));
        
        $success_message = "Category name has been inserted successfully.";
        

    } catch (Exception $e) {
        $message=$e->getMessage();
    }
  }



  if (isset($_REQUEST['form2'])){
    try {
        if(empty($_REQUEST['cat_name'])){
            throw new Exception( "Edit fild can't be empty");   
        }

        $statement = $db->prepare(" UPDATE tbl_category SET cat_name=? WHERE cat_id=?");
        $statement->execute(array($_REQUEST['cat_name'],$_POST['hdn']));

        $message_edit=$_REQUEST['cat_name']." Successfully update in Category";

    } catch (Exception $e) {
        $message_empty=$e->getMessage();
    }
}
 

    
    if (isset($_REQUEST['id'])){
    $id=$_REQUEST['id'];
    $statement = $db->prepare(" DELETE FROM tbl_category WHERE cat_id=?");
    $statement->execute(array($id));
    
    $message_delete="Delete successfully";
    }
     


?>





<div class="heading">
    <h4>Add new category </h4>
    <hr>
    <form action="" method="post">
        <table>
            <tr>
                <td>Category Name</td>
            </tr>
            <?php
                if (isset($message)){
                    echo   "<span style='color:red;'> ". $message ."</span>";
                }
                if(isset($success_message)){
                    echo " <span style='color:green;'> ".$success_message."</span>";
                }

            ?>
            <tr>
                <td><input class="short" type="text" name="cat_name"></td>
            </tr>
            <tr>
                <td>
                    <input type="submit" name="form1" value="send" >
                </td>
            </tr>
        </table>
    </form>
    <div class="view_table">
        <h4> View Add category </h4>
         <?php
       
           if (isset($message_empty)){
                  echo  " <span style='color:red;'> ". $message_empty."</span>";
            }
            if (isset($message_edit)){
                   echo " <span style='color:green;'> ". $message_edit."</span>";
            }
            if (isset($message_delete)){
                echo " <span style='color:blue;'> ". $message_delete."</span>";
            }
       
       ?> 
    
    <table class="table table-striped category_table">
  <thead>
    <tr>
      <th scope="col">Slear No.</th>
      <th scope="col">Name</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>

    <?php
        
        $i=0;
        $statement = $db->prepare("SELECT * FROM tbl_category ORDER BY cat_name ASC ");
        $statement->execute();
        $result=$statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
        $i++;
    ?>
    <tr>
      <td scope="row"><?php echo $i; ?></td>
      <td><?php echo $row['cat_name'];?></td>
      <td>
            <a class="fancybox" href="#inline<?php echo $i; ?>">Edit</a>
                <div id="inline<?php echo $i; ?>" style="width:400px;display: none;">
                    <h3>Edit Data</h3>
                    <p>
                        <form action="" method="post">
                        <input type="hidden" name="hdn" value="<?php echo $row['cat_id']; ?>">
                        <table>
                        <tr>
                            <td>Category Name</td>
                            
                        </tr>
                        <tr>
                            <td><input type="text" name="cat_name" value="<?php echo $row['cat_name']; ?>"></td>
                        </tr>
                        <tr>
                            <td><input type="submit"  name="form2" value="UPDATE"></td>
                        </tr>
                    </table>
                    </form>
                </p>
            </div>
            &nbsp;|&nbsp;
            <a onclick="return confirmdelete();" href="manage_catagory.php?id= <?php echo $row['cat_id'];?>">Delete</a>
    </tr>

        <?php

        }


    ?>
    
  </tbody>
</table>
    </div>
    

    
</div>



<?php include('footer.php');?>            
