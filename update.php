<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 4/10/2019
 * Time: 4:05 PM
 */

include "header_admin.php";
// Include config file
require_once "config.php";

$product_name=  '';
$add_err= $subtract_err= $blank_err = '';
$inventory_qty= $add_qty= $subtract_qty= $update_qty= $difference_qty = 0;

function get_product_details ()
{
    global $link;
    $items = array();
    $sql = "SELECT `name` FROM `products`";
    $result = mysqli_query($link, $sql);

    while ($ar = mysqli_fetch_assoc($result)){
        $items[] = $ar;
    }
    return $items;
}

if($_SERVER["REQUEST_METHOD"] == "POST")
{

    
    $product_name = $_POST["product_name"];



    $sql = "SELECT quantity FROM products WHERE name = '$product_name'";
    $result = mysqli_query($link, $sql);
    if (mysqli_num_rows($result) > 0)
    {
        while($row = mysqli_fetch_assoc($result))
        {
            $inventory_qty = $row['quantity'];
        }
    }

    if (empty($_POST['add']) && empty($_POST['subtract']))
    {
        $blank_err = 'You must input so as to do the stock take';
    }

    if (!preg_match('/^\d*$/',$_POST['add'])){
        $add_err = 'You must input only number';
    }else{
        $add_qty = $_POST['add'];
    }

    if (!preg_match('/^\d*$/',$_POST['subtract'])){
        $subtract_err = 'You must input only number';
    }elseif(  $_POST['subtract'] > $_POST['add'] + $inventory_qty){
        $subtract_err = "You can't issue more phone than we have in the inventory" ;
    }
    else{
        $subtract_qty = $_POST['subtract'];
    }

    $difference_qty = $add_qty  - $subtract_qty;

    if ($difference_qty < 0 )
    {
        $update_qty = max($difference_qty  ,$inventory_qty) + min($difference_qty  ,$inventory_qty);
    }else
    {
        $update_qty = $difference_qty + $inventory_qty;
    }

    $sql1 = "UPDATE `products` SET `quantity`= '$update_qty' WHERE `name` = '$product_name'";
    if ($subtract_err == '' && $add_err =='' && $blank_err =='')
    {
        mysqli_query($link,$sql1);
    }



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

        <div class="form-group <?php echo (!empty($add_err)) ? 'has-error' : ''; ?>">
            <label>Goods receipt:</label>
            <input type="text" name="add" class="form-control" value="<?php echo $add_qty; ?>">
            <span class="help-block"><?php echo $add_err; ?></span>
        </div>

        <div class="form-group <?php echo (!empty($subtract_err)) ? 'has-error' : ''; ?>">
            <label>Goods issue:</label>
            <input type="text" name="subtract" class="form-control" value="<?php echo $subtract_qty; ?>">
            <span class="help-block"><?php echo $subtract_err; ?></span>
        </div>

        <span class="help-block"><?php echo $blank_err; ?></span>

        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Update Inventory">
        </div>
    </form>
</div>
<?php include "footer.php"?>