<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 4/13/2019
 * Time: 4:51 PM
 */

include "header_admin.php";
require_once "config.php";
$category_err = ''; 
if($_SERVER["REQUEST_METHOD"] == "POST")
{

    if(empty(trim($_POST["category"]))){
        $category_err = "Please enter the product name.";
    } else{
        $category = trim($_POST["category"]);
    }


    //Delete the data in the product table
    $sql = "INSERT INTO `categories` (`name`) VALUES ('$category')";
    mysqli_query($link,$sql);


}
?>
<div class="wrapper">

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group" <?php echo (!empty($category_err)) ? 'has-error' : ''; ?>>
            <label>Category:</label>
            <input type="text" name="category" class="form-control">
            <span class="help-block"><?php echo $category_err; ?></span>
        </div>



        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Delete Item">
        </div>
    </form>
</div>
<?php include "footer.php"?>
