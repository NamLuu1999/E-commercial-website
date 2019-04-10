<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 4/10/2019
 * Time: 4:05 PM
 */

include_once "header_admin.php";
// Include config file
require_once "config.php";

$product_name= $qty='';
$qty_err='';

function get_product_details ()
{
    global $link;
    $items = array();
    $sql = "SELECT name FROM products";
    $result = mysqli_query($link, $sql);

    while ($ar = mysqli_fetch_assoc($result)){
        $items[] = $ar;
    }
    return $items;
}

if($_SERVER["REQUEST_METHOD"] == "POST")
{

    
    $product_name = $_POST["product_name"];

    if (empty($_POST["qty"])) {
        $qty_err = "Quantity is required";
    }
    else{
        $qty = trim($_POST["qty"]);
    }

    //Delete the data in the product table
    $sql = "UPDATE `products` SET `quantity`= '$qty' WHERE `name` = '$product_name'";
    mysqli_query($link,$sql);


}
?>
<div class="wrapper">

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
            <label>Product name:</label>
            <select class="browser-default custom-select" name = "product_name">
                <?php
                $products = get_product_details();
                foreach ($products as $ap)
                {
                    $name = $ap['name'];
                    ?>
                    <option value = "<?php echo $name ?>" > <?php echo $name?> </option>
                <?php };?>
            </select>
        </div>

        <div class="form-group <?php echo (!empty($qty_err)) ? 'has-error' : ''; ?>">
            <label>Quantity</label>
            <input type="text" name="qty" class="form-control" value="<?php echo $qty; ?>">
            <span class="help-block"><?php echo $qty_err; ?></span>
        </div>

        
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Update Inventory">
        </div>
    </form>
</div>
<?php include "footer.php"?>
