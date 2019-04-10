<?php

require_once "config.php";
// Start session management with a persistent cookie
$lifetime = 60 * 60 * 24 * 14;    // 2 weeks in seconds
session_set_cookie_params($lifetime, '/');
session_start();




// Create a cart array if needed
if (empty($_SESSION['cart'])) { $_SESSION['cart'] = array(); }





// Create a table of products

function create_products_table ()
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

$phones = create_products_table();
foreach ($phones as $ap) {
    $id = $ap['id'];
    $name = $ap['name'];
    $price = $ap['price'];

}

// Include cart functions
require_once('cart.php');

// Get the action to perform
$action = filter_input(INPUT_POST, 'action');
if ($action === NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action === NULL) {
        $action = 'show_add_item';
    }
}

// Add or update cart as needed
switch($action) {
    case 'add':
        $product_key = filter_input(INPUT_POST, 'productkey');
        $item_qty = filter_input(INPUT_POST, 'itemqty');
        add_item($product_key, $item_qty);
        include('cart_view.php');
        break;
    case 'update':
        $new_qty_list = filter_input(INPUT_POST, 'newqty', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        foreach($new_qty_list as $key => $qty) {
            if ($_SESSION['cart12'][$key]['qty'] != $qty) {
                update_item($key, $qty);
            }
        }
        include('cart_view.php');
        break;
    case 'show_cart':
        include('cart_view.php');
        break;
    case 'show_add_item':

        include('products_member.php');
        break;
    case 'empty_cart':
        unset($_SESSION['cart12']);
        include('cart_view.php');
        break;

    case 'check_out':
        header('Location: payment.php');
        break;

}
?>