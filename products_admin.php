<?php include('header_admin.php');
require_once "config.php";

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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <?php };?>
    </div>
<?php include('footer.php');?>