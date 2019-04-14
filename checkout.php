<?php
require_once "config.php";
require_once('cart.php');
session_start();

function mysql_get_var($query,$y=0){
    global $link;
    $result = mysqli_query($link ,$query);
    $row = mysqli_fetch_array($result);
    mysqli_free_result($result);
    $record = $row[$y];
    return $record;
}

function get_product ($query)
{
    global $link;
    $items = array();
    $result = mysqli_query($link, $query);

    while ($ar = mysqli_fetch_assoc($result)){
        $items[] = $ar;
    }
    return $items;
}

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {

    $ordered_qty = $_POST["ordered_qty"];
    $product_name = $_POST["product_name"];
    $unique_id = $_SESSION['unique_id'];
    $order_id = mysql_get_var("SELECT `id` FROM `orders` WHERE `unique_id` = '$unique_id'");

for ($i = 0; $i < count($product_name); $i++) {
    $product_ids = get_product("SELECT `id` FROM `products` WHERE `name` = '$product_name[$i]'");
    foreach ($product_ids as $ap) {
        $product_id = $ap['id'];

        $sql = "INSERT INTO `order_items` (`orders_id`,`product_id`,`ordered_quantity`) VALUES ('$order_id','$product_id','$ordered_qty[$i]')";
        $conn = mysqli_query($link, $sql);
        if(!$conn){
            echo mysqli_error($link) or die (mysqli_error($link));
        }else{
            $sql_get_quantity = "SELECT `quantity` FROM `products` WHERE `name` = '$product_name[$i]'";
            $result = mysqli_query($link, $sql_get_quantity);
            if (mysqli_num_rows($result) > 0)
            {
                while($row = mysqli_fetch_assoc($result))
                {
                    $inventory_qty = $row['quantity'];
                }
            }

            $update_qty = $inventory_qty - $ordered_qty[$i];

            $sql_update = "UPDATE `products` SET `quantity`= '$update_qty' WHERE `name` = '$product_name[$i]'";
            $res = mysqli_query($link,$sql_update);
            if (!res){
                echo mysqli_error($link) or die (mysqli_error($link));
            } else {
                unset($_SESSION['cart12']);
                header ("Location: products_member.php");
            }
    }}
}
}

// Create a cart array if needed
if (empty($_SESSION['cart'])) { $_SESSION['cart'] = array(); }


?>

<?php include('header_member.php');?>

<?php if (empty($_SESSION['cart12']) || count($_SESSION['cart12']) == 0) : ?>
    <p>There are no items in your cart.</p>
<?php else: ?>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" style="padding-top: 100px">

    <div class="container">
        <div class="row" style="padding-top: 50px">
            <br>
                <div class="col-md-8 col-sm-6 col-xs-12 col-md-pull-6 col-sm-pull-6">
                    <!--Cart section-->
                    <div class="panel panel-default">
                        <div class="panel-heading text-center"><h4>Current Cart</h4></div>
                        <div class="panel-body">
                            <table class="table borderless">
                                <thead>
                                <tr>
                                    <td><strong>Your item</strong></td>
                                    <td class="text-center"><strong>Price</strong></td>
                                    <td class="text-center"><strong>Quantity</strong></td>
                                    <td class="text-right"><strong>Subtotal</strong></td>
                                    <td></td>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach( $_SESSION['cart12'] as $key => $item ) :
                                    $cost  = number_format($item['price'],  2);
                                    $total = number_format($item['total'], 2);
                                    ?>
                                <tr>
                                    <td class="col-md-3">
                                        <div class="media">
                                            <a class="thumbnail pull-left" href="#"> <img class="media-object" src="images/<?php $item['image'] ?>" style="width: 72px; height: 72px;"> </a>
                                            <div class="media-body">
                                                <h5 class="media-heading"> <?php echo $item['name']; ?></h5>
                                                <input type="hidden" name="product_name[]" value="<?php echo $item['name']; ?>">
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">$<?php echo $cost; ?></td>
                                    <td class="text-center"><?php echo $item['qty']; ?> <input type="hidden" name="ordered_qty[]" value="<?php echo $item['qty']; ?>"></td>
                                    <td class="text-right">$<?php echo $total; ?></td>
                                </tr>
                                <?php endforeach;  ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!--Cart section END-->
                </div>
            <div class="col-md-4 col-sm-6 col-xs-12 col-md-push-6 col-sm-push-6">
                <!--REVIEW ORDER-->
                <div class="panel panel-default">
                    <div class="panel-heading text-center">
                        <h4>Review Order</h4>
                    </div>
                    <div class="panel-body">
                        <div class="col-md-12">
                            <strong>Subtotal (All items)</strong>
                            <div class="pull-right"><span>$</span><span><?php echo number_format(get_subtotal(), 2);; ?></span></div>
                        </div>
                        <div class="col-md-12">
                            <strong>Tax</strong>
                            <div class="pull-right"><span>$</span><span><?php echo number_format(get_subtotal()*0.13, 2);; ?></span></div>
                        </div>
                        <div class="col-md-12">
                            <strong>Shipping</strong>
                            <div class="pull-right"><span>-</span></div>
                            <hr>
                        </div>
                        <div class="col-md-12">
                            <strong>Order Total</strong>
                            <div class="pull-right"><span>$</span><span><?php echo number_format(get_subtotal()*1.13, 2);; ?></span></div>
                            <hr>
                        </div>

                        <input type="submit" class="btn btn-primary btn-lg btn-block" value="Check out">

                    </div>

                </div>
                <!--REVIEW ORDER END-->
            </div>
        </div>
    </div>
</form>
<?php endif; ?>
<?php include('footer.php');?>