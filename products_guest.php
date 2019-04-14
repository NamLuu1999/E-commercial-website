<?php
require_once "config.php";
// Initialize the session
session_start();

// Store data in session variable
$_SESSION["inventory_unlogged"] = 1;

$id = $_GET['id'];

if ($id == 'Iphone'){
    $sql_products = "SELECT * FROM `products` INNER JOIN `categories` WHERE categories.id = products.cat_id AND categories.name = 'Iphone'";
}   elseif ($id == 'Samsung'){
    $sql_products = "SELECT * FROM `products` INNER JOIN `categories` WHERE categories.id = products.cat_id AND categories.name = 'Samsung'";
}   elseif ($id == 'BKAV'){
    $sql_products = "SELECT * FROM `products` INNER JOIN `categories` WHERE categories.id = products.cat_id AND categories.name = 'BKAV'";
}   else {
    $sql_products = "SELECT * FROM `products`";
}

function get_product_details ()
{
    global $link;
    global $sql_products;
    $items = array();
    $result = mysqli_query($link, $sql_products);
    while ($ar = mysqli_fetch_assoc($result)){
        $items[] = $ar;
    }
    return $items;
}
?>
<?php include('header_guest.php'); ?>

<div class ="row">
<?php
$products = get_product_details();
foreach ($products as $ap)
{
    $name = $ap['name'];
    $price = $ap['price'];
    $image = $ap['image'];
    $id = $ap['id'];
    $qty = $ap['quantity'];

    if ($qty > 0) {

    ?>
    <div class="col-md-3 col-sm-3 col-xs-12" style ="padding: 70px 60px;">
        <div class="item-box">
            <div class="item-image">
                <img src="<?php echo $image; ?>" class="img-responsive" alt="a" />
            </div>
            <div class="item-main-detail">
                <div>
                    <div class="product-detail">
                        <h5 class="small-font">Name: <?php echo $name; ?></h5>
                        <h5 class="detail-price small-font">Price: $<?php echo $price; ?></h5>
                    </div>
                </div>
                <div class="cart-section">
                    <div class="row justify-content-end">
                        <div class="col-md-6 col-sm-12 col-xs-6 ">
                            <a href="login.php" class="AddCart btn btn-info"> Buy Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <?php
    }
};?>
</div>


<?php include('footer.php');?>