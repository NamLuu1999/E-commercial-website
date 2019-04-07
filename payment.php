<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 3/28/2019
 * Time: 12:05 PM
 */
session_start();
require_once "config.php";



$cardholder_name= $card_number= $security_code = $deliver_address='';
$cardholder_name_err = $card_number_err= $security_code_err =$deliver_address_err ='';

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
        $card_number_err = "Please enter the card holder name.";
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
        $security_code_err = "Please enter the card holder name.";
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
            case 1:
                if(empty(trim($_POST["new_address"]))){
                    $deliver_address_err = "Please enter the new address name.";
                } else{
                    $deliver_address = trim($_POST["new_address"]);

                }
                break;
            case 2:
                //Collect the old address
                $sql = "SELECT address FROM users WHERE username = '{$_SESSION['username']}'";
                $deliver_address = mysqli_query($link, $sql);
                break;
        }

    }
    $username = $_SESSION['username'];
    if ($cardholder_name_err = '' && $card_number_err = '' && $security_code_err = '')
    {
        $sql = "INSERT INTO orders (deliver_address,cardholder_name,card_number,security_code) VALUES ($deliver_address,$cardholder_name,$card_number,$security_code)";

    }



}


?>

<?php include "header_member.php"; ?>

<div class="wrapper">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group" <?php echo (!empty($cardholder_name_err)) ? 'has-error' : ''; ?>>
            <label>Card holder name:</label>
            <input type="text" name="cardholder_name" class="form-control">
            <span class="help-block"><?php echo $cardholder_name_err; ?></span>
        </div>

        <div class="form-group" <?php echo (!empty($card_number_err)) ? 'has-error' : ''; ?>>
            <label>Card number:</label>
            <input type="text" name="card_number" class="form-control">
            <span class="help-block"><?php echo $card_number_err; ?></span>
        </div>

        <div class="form-group" <?php echo (!empty($security_code_err)) ? 'has-error' : ''; ?>>
            <label>Security code:</label>
            <input type="text" name="security_code" class="form-control">
            <span class="help-block"><?php echo $security_code_err; ?></span>
        </div>

        <!-- Default checked -->
        <div class="custom-control custom-radio">
            <input type="radio" class="custom-control-input" id="defaultChecked" name="radiosGroup" checked>
            <label class="custom-control-label" for="defaultChecked">Deliver to my registered address</label>
        </div>

        <!-- Default unchecked -->
        <div class="custom-control custom-radio">
            <input type="radio" class="custom-control-input" id="defaultUnchecked" name="radiosGroup">
            <label class="custom-control-label" for="defaultUnchecked">Deliver to another address</label>
        </div>


        <div class="form-group" <?php echo (!empty($deliver_address_err)) ? 'has-error' : ''; ?> id="noId">
            <label>New address:</label>
            <input type="text" name="new_address" class="form-control">
            <span class="help-block"><?php echo $deliver_address_err; ?></span>
        </div>

        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Pay for the products" onclick="window.location.href='.?action=pay"'">
        </div>
    </form>
    <script>
        function yesnoCheck() {
            if (document.getElementById('defaultUnchecked').checked) {
                document.getElementById('noId').style.visibility = 'visible';
            }
            else document.getElementById('noId').style.visibility = 'hidden';

        }
    </script>
</div>

<?php include "footer.php"?>

