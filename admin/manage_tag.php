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

try {
    if (isset($_REQUEST['form_up'])){
        if (empty($_REQUEST['tag_name'])){
            throw new Exception("Tage fild can't be empty");
            
        }
        $statement = $db->prepare("SELECT * FROM tbl_tag WHERE tag_name=?");
        $statement->execute(array($_POST['tag_name']));
        $total = $statement->rowCount();


        if ($total>0){
            throw new Exception($_REQUEST['tag_name'] ." Name already exists.");
        }
        $statement = $db->prepare("INSERT INTO tbl_tag (tag_name) VALUES (?)");
        $statement->execute(array($_POST['tag_name']));

        $message_success="Tag insurt successfully";
    }
    
} catch (Exception $e) {
    $message_empty=$e->getMessage();
}

if (isset($_REQUEST['tag_form'])){
    try {
        if(empty($_REQUEST['tag_name'])){
            throw new Exception( "tag fild can't be empty");   
        }

        $statement = $db->prepare(" UPDATE tbl_tag SET tag_name=? WHERE tag_id=?");
         $statement->execute(array($_REQUEST['tag_name'],$_POST['hdn']));
        $message_tag="Successfully you update tag";

    } catch (Exception $e) {
        $message_empty=$e->getMessage();
    }
}

if (isset($_REQUEST['id'])){
    $id=$_REQUEST['id'];
    $statement = $db->prepare(" DELETE FROM tbl_tag WHERE tag_id=?");
    $statement->execute(array($id));

    $message_delete="Delete successfully";
}




?>

<div class="heading">
    <h4>Add new tag </h4>
    <hr>
    <?php 
        if (isset($message_success)){
            echo " <span style='color:blue'> ".$message_success."</span>";
        }
        if (isset($message_empty)){
            echo " <span style='color:red'> ".$message_empty."</span>";
        }
    ?>
    <form action="" method="post">
        <table>
            <tr>
                <td>tag Name</td>
            </tr>
            <tr>
                <td><input class="short" type="text" name="tag_name"></td>
            </tr>
            <tr>
                <td>
                    <input type="submit" name="form_up" value="UPDATE" >
                </td>
            </tr>
        </table>
    </form>
    <div class="view_table">
        <h4> view Add tag </h4>
        <?php
            if (isset($message_tag)){
                echo " <span style='color:green;'> ". $message_tag."</span>";
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
                $statement = $db->prepare("SELECT * FROM tbl_tag ORDER BY tag_name ASC ");
                $statement->execute();
                $result=$statement->fetchAll(PDO::FETCH_ASSOC);
                foreach ($result as $row) {
                $i++;

            ?>
              <tr>
                  <td scope="row"><?php echo $i;?></td>
                  <td><?php echo $row['tag_name']; ?></td>
              <td>
                    <a class="fancybox" href="#inline<?php echo $i; ?>">Edit</a>
                        <div id="inline<?php echo $i; ?>" style="width:400px;display: none;">
                        <h3>Edit Data</h3>
                        <p>
                            <form action="" method="post">
                                <input type="hidden"  name="hdn" value="<?php echo $row['tag_id']?>">
                                <table class="table table-sm table-dark">
                                    <tr>
                                        <td>Category Name</td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" name="tag_name" value="<?php echo $row['tag_name'];?>"></td>
                                    </tr>
                                    <tr>
                                        <td><input type="submit" value="UPDATE" name="tag_form"></td>
                                    </tr>
                                </table>
                            </form>
                        </p>
                    </div>


                    &nbsp;||&nbsp;
                    <a onclick="return confirmdelete();" href="manage_tag.php?id= <?php echo $row['tag_id'];?>">Delete</a>
              </td>
            </tr>

            <?php

        }
        ?>
          
          </tbody>
        </table>
    </div>
    

    
</div>



<?php include('footer.php');?>            


