<?php
include_once "header_admin.php";
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 3/24/2019
 * Time: 4:38 PM
 */

// Include config file
require_once "config.php";

$product_name= '';


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
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST")
{

    $product_name = $_POST["product_name"];



    //Delete the data in the file
    $image_dir = 'images';
    $image_dir_path = getcwd() . DIRECTORY_SEPARATOR . $image_dir;
    $filename = mysql_get_var("SELECT `image` FROM `products` WHERE `name` = '$product_name'");
    $target = $image_dir_path . DIRECTORY_SEPARATOR . $filename;
    if (file_exists($target)){
        unlink($target);
    }

    //Delete the data in the product table
    $sql = "DELETE FROM `products` WHERE `name` = '$product_name'";
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
                {$name = $ap['name']; ?>
                <option value = "<?php echo $name ?>" > <?php echo $name?> </option>
                <?php };?>
            </select>
        </div>



        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Delete Item">
        </div>
    </form>
</div>
<?php include "footer.php"?>
