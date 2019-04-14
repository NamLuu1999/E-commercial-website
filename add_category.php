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
$category_name= '';

function get_category_details ()
{
    global $link;
    $items = array();
    $sql = "SELECT `name` FROM categories";
    $result = mysqli_query($link, $sql);

    while ($ar = mysqli_fetch_assoc($result)){
        $items[] = $ar;
    }
    return $items;
}

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    if(empty(trim($_POST["category"]))){
        $category_err = "Please enter the product name.";
    } else{
        $category = trim($_POST["category"]);
    }
    if (empty($category_err)) {
        //Add the data in the product table if there is no error
        $sql_add_category = "INSERT INTO `categories` (`name`) VALUES ('$category')";
        $res1 = mysqli_query($link,$sql_add_category);
        if(!$res1){
            echo mysqli_error($link) or die (mysqli_error($link));
    }}


    //Get the category name
    $category_name = $_POST["category_name"];

    //Delete the data in the product table
    $sql_delete_category = "DELETE FROM `categories` WHERE `name` = '$category_name'";
    $res2 = mysqli_query($link, $sql_delete_category);
    if(!$res2){
        echo mysqli_error($link) or die (mysqli_error($link));
    }
}
?>
    <div class="wrapper">

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group" <?php echo (!empty($category_err)) ? 'has-error' : ''; ?>>
                <label>Category:</label>
                <input type="text" name="category" class="form-control">
                <span class="help-block"><?php echo $category_err; ?></span>
            </div>
            <?php if (empty($category_err)){?>
                <div><?php echo $_SESSION['message']; ?></div>
            <?php } ?>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Add Category">
            </div>

            <div class="form-group">
                <label>Product name:</label>
                <select class="browser-default custom-select" name = "category_name">
                    <?php
                    $categories = get_category_details();
                    foreach ($categories as $ap)
                    {$name = $ap['name']; ?>
                        <option value = "<?php echo $name ?>" > <?php echo $name?> </option>
                    <?php };?>
                </select>
            </div>
            <?php if ($res2){?>
                <div><?php echo $_SESSION['message']; ?></div>
            <?php } ?>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Delete Category">
            </div>
        </form>
    </div>
<?php include "footer.php"?><?php
