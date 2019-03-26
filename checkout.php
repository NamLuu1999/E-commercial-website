<?php
require_once "config.php";
session_start();

// Query the users database and assigned it to an array
function get_customer_info ()
{
    global $link;

    $data = array();
    $sql = "SELECT first_name, last_name, address, email, postal_code FROM users WHERE username = '{$_SESSION['username']}'";
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
    $address = $ap['address'];
    $postal_code = $ap['postal_code'];
    $email = $ap['email'];
}
// Query the products database and assigned it to an array
function get_product_details ()
{
    global $link;
    $items = array();
    $sql = "SELECT * FROM products WHERE id = '{$_SESSION['product_id']}'";
    $result = mysqli_query($link, $sql);

    while ($ar = mysqli_fetch_assoc($result)){
        $items[] = $ar;
    }
    return $items;
}
// Assign each column of data into a variable
    $products = get_product_details();
    foreach ($products as $ap) {
        $products_name = $ap['name'];
        $price = $ap['price'];
        $image = $ap['image'];

    }


?>

<?php include('header_member.php');?>


<div class = "row-modify wrapper" >
    <div class = "left">
        <img class ="col" src = "<?php echo $image ?>" alt = "">

    </div>
    <div class = "right">
        <ul class = "label">
            <li class = info><b>Product:</b> <?php echo $products_name ?></li>
            <li class = info><b>Price (after tax):</b> $<?php echo (($price)*(1.13)) ?></li>
            <li class = info><b>Customer: </b><?php echo $name ?></li>
            <li class = info><b>Email: </b><?php echo $email ?></li>
            <li class = info><b>Address: </b><?php echo $address ?></li>
            <li class = info><b>Postal code: </b><?php echo $postal_code ?></li>
        </ul>

        <a class=" btn btn-warning" href = "logout.php">Log out</a>
        <a class=" btn btn-light" href = "products_member.php">Continue shopping</a>
    </div>
</div>
<?php include('footer.php');?>