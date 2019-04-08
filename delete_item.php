<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 3/24/2019
 * Time: 4:38 PM
 */

// Include config file
require_once "config.php";

$product_name= '';
$product_name_err = '';

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    if(empty(trim($_POST["product_name"]))){
        $product_name_err = "Please enter the product name.";
    } else{
        $product_name = trim($_POST["product_name"]);
    }

    //Delete the data in the product table
    $sql = "DELETE FROM `products` WHERE `name` = '$product_name'";
    if ($product_name_err =''){
        mysqli_query($link,$sql);
    }

}

?>
<?php include "header_admin.php"?>
<div class="wrapper">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group" <?php echo (!empty($product_name_err)) ? 'has-error' : ''; ?>>
            <label>Product name</label>
            <input type="text" name="product_name" class="form-control" />
            <span class="help-block"><?php echo $product_name_err; ?></span>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Delete Item">
        </div>
    </form>
</div>
<?php include "footer.php"?>
