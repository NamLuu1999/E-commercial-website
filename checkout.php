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

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {

    $ordered_qty = $_POST["ordered_qty"];
    $product_name = $_POST["product_name"];
    $unique_id = $_SESSION['unique_id'];

    $product_id = mysql_get_var("SELECT `id` FROM `products` WHERE `name` = '$product_name'");
    $order_id = mysql_get_var("SELECT `id` FROM `orders` WHERE `unique_id` = '$unique_id'");

    $sql = "INSERT INTO `order_items`(`orders_id`,`product_id`,`ordered_quantity`) VALUES ('$order_id','$product_id','$ordered_qty')";
    $conn = mysqli_query($link, $sql);
    if(!$conn){
        echo mysqli_error($link) or die (mysqli_error($link));
    }else{

        header ("Location: products_member.php");
    }
}


/**
// Query the users database and assigned it to an array
function get_customer_info ()
{
    global $link;
    $data = array();
    $sql = "SELECT first_name, last_name, email, postal_code FROM users WHERE username = '{$_SESSION['username']}'";
    $result = mysqli_query($link, $sql);

    while ($row = mysqli_fetch_assoc($result)){
        $data[] = $row;
    }
    return $data;
}
// Assign each column of data into a variable
$info = get_customer_info();
foreach ($info as $ap) {
    $name = $ap['first_name'] .' '. $ap['last_name'];
    $postal_code = $ap['postal_code'];
    $email = $ap['email'];
}
**/

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
                        <?php   echo $unique_id;
                        ?>

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
                                                <input type="hidden" name="product_name" value="<?php echo $item['name']; ?>">
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">$<?php echo $cost; ?></td>
                                    <td class="text-center"><?php echo $item['qty']; ?> <input type="hidden" name="ordered_qty" value="<?php echo $item['qty']; ?>"></td>
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