<?php
require_once "config.php";


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


// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    if(empty(trim($_POST["cardholder_name"]))){
        $cardholder_name_err = "Please enter the card holder name.";
    } else{
        $cardholder_name = trim($_POST["cardholder_name"]);
        if (!preg_match("/^[a-zA-Z ]*$/",$cardholder_name)) {
            $cardholder_name_err = "Only letters and white space allowed";
        }
    }

    if(empty(trim($_POST["card_number"]))) {
        $card_number_err = "Please enter the card number.";
    }elseif (strlen(trim($_POST['card_number'])) > 12 || strlen(trim($_POST['card_number'])) < 12 )
    {
        $card_number_err = "Please enter only 12 digits indicated on your card";
    }elseif(!preg_match('/^\d*$/',$_POST['card_number']))
    {
        $card_number_err = "Please enter numbers only";
    }else
    {
        $card_number = $_POST["card_number"];
    }

    if(empty(trim($_POST["security_code"]))) {
        $security_code_err = "Please enter the security code.";
    }elseif (strlen(trim($_POST['security_code'])) > 3 || strlen(trim($_POST['security_code'])) < 3 )
    {
        $security_code_err = "Please enter only 3 digits indicated at the back of your card";
    }elseif(!preg_match('/^\d*$/',$_POST['security_code']))
    {
        $security_code_err = "Please enter numbers only";
    }else
    {
        $security_code = $_POST["security_code"];
    }

    if (isset($_POST['radiosGroup'])){
        switch ($_POST['radiosGroup'])
        {
            case '1':
                if(empty(trim($_POST["new_address"]))){
                    $deliver_address_err = "Please enter your delivery address.";
                } else{
                    $deliver_address = trim($_POST["new_address"]);

                }
                break;
            case '2':
                //Collect the old address
                $sql = "SELECT address FROM users WHERE username = '{$_SESSION['username']}'";
                $deliver_address = mysqli_query($link, $sql);
                break;
        }
    }

    if ($card_number_err = '' && $security_code_err = '')
    {

        $sql = "INSERT INTO `orders` (`cardholder_name`,`card_number`,`security_code`) VALUES ($cardholder_name,$card_number,$security_code)";
        $conn = mysqli_query($link, $sql);
        if($conn === false){
           die("ERROR: Could not connect. " . mysqli_connect_error());
        }

    }
}


?>





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