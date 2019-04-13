<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 4/13/2019
 * Time: 12:20 PM
 */

require_once "config.php";
// Initialize the session
session_start();
include('header_guest.php');
function get_product_details ()
{
    global $link;
    $items = array();
    $sql = "SELECT * FROM `categories`";
    $result = mysqli_query($link, $sql);

    while ($ar = mysqli_fetch_assoc($result)){
        $items[] = $ar;
    }
    return $items;
}

?>

<?php
$products = get_product_details();
foreach ($products as $ap)
{
$name = $ap['name'];
$id = $ap['id'];
?>
<ul class="list-group">

    <li class="list-group-item list-group-item-action">
        <a href="products_guest.php?id=1">
            <?php echo $name ?>
        </a>
    </li>
</ul>
<?php } ?>
<?php include('footer.php');?>
