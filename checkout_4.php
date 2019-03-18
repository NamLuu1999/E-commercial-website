<?php include('header_member.php');?>


    <div class = "row-modify wrapper" >
        <div class = "left">
            <img class ="col" src = "samsung_j4.jpg" alt = "">

        </div>
        <div class = "right">
            <ul class = "label">
                <li class = info><b>Product:</b> Samsung J4</li>
                <li class = info><b>Price (after tax):</b> $<?php echo (160*1.13) ?></li>
                <li class = info><b>Customer: </b><?php echo $_SESSION["name"] ?></li>
                <li class = info><b>Email: </b><?php echo $_SESSION["email"] ?></li>
                <li class = info><b>Address: </b><?php echo $_SESSION["address"] ?></li>
                <li class = info><b>Postal code: </b><?php echo $_SESSION["postal_code"] ?></li>
            </ul>

            <a class=" btn btn-warning" href = "logout.php">Log out</a>
            <a class=" btn btn-light" href = "products_member.php">Continue shopping</a>
        </div>
    </div>
<?php include('footer.php');?>