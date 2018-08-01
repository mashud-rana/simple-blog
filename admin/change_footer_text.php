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

            if(empty($_REQUEST['footer_text'])){
                throw new Exception("please enter the value footer");
                
            }

            $statement = $db->prepare(" UPDATE tbl_footer SET description=? WHERE id=1");
            $statement->execute(array($_REQUEST['footer_text']));
            throw new Exception("Successfully you update Category");
            
            $message_edit="";
            
        } catch (Exception $e) {

            $message= $e -> getMessage();
            
        }
    }


?>
<?php

        $statement = $db->prepare("SELECT * FROM tbl_footer WHERE id=1 ");
        $statement->execute();
        $result=$statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row){

            $description= $row['description'];
        }
?>



<div class="heading">
    <h4>Change Footer text </h4>
    <hr>

    <form action="" method="post">
        <table>
            <tr>
                <td>Footer text</td>
                <?php

                    if (isset($message)){
                        echo $message;
                    }

                ?>
               
               
            </tr>
            <tr>
                <td><input class="long" type="text" value="<?php echo $description; ?> " name="footer_text"></td>
            </tr>
            
                <tr>
                    
                    <td><input type="submit"  name="form1" value="UPDATE"></td>
                </tr>
               
            
        </table>
    </form>
</div>



<?php include('footer.php');?>            
