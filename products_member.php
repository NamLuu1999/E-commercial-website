<?php include('header_member.php');
require_once "config.php";


// Initialize the session
//session_start();

function get_product_details ()
{
    global $link;
    $items = array();
    $sql = "SELECT * FROM products";
    $result = mysqli_query($link, $sql);

    while ($ar = mysqli_fetch_assoc($result)){
        $items[] = $ar;
    }
    return $items;
}

?>

<div class ="row">

<?php
    $products = get_product_details();
    foreach ($products as $ap)
    {
        $name = $ap['name'];
        $price = $ap['price'];
        $image = $ap['image'];
        $id = $ap['id'];


?>

    <div class="col-md-3 col-sm-3 col-xs-12" style ="padding: 70px 60px;">
        <div class="item-box">
            <div class="item-image">
                <img src="<?php echo $image; ?>" class="img-responsive" alt="Phone" />
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

                            <form action = "index.php" method="POST">
                                <input type="hidden" name="action" value="add">
                                <label>Quantity:</label>
                                <select name="itemqty">
                                    <?php for($i = 1; $i <= 10; $i++) : ?>
                                        <option value="<?php echo $i; ?>">
                                            <?php echo $i; ?>
                                        </option>
                                    <?php endfor; ?>
                                </select><br>
                                <input type="hidden" name = "productkey" value = "<?php echo $id - 1; ?>">

                                <input name="button" type="submit" class="AddCart btn btn-info" value = "Add Product">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php };?>
</div>



<?php include('footer.php');?>