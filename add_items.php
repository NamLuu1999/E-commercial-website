<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 3/24/2019
 * Time: 1:53 PM
 */


// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$image=$product_name = $price = $description= "";
$image_err=$product_name_err= $price_err = $description_err =  "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    if(empty(trim($_POST["product_name"]))){
        $product_name_err = "Please enter the product name.";
    } else{
        $product_name = trim($_POST["product_name"]);
    }

    if(empty(trim($_POST["price"]))){
        $price_err = "Please enter price.";
    }elseif(!filter_var($_POST["price"], FILTER_VALIDATE_FLOAT)){
        $price_err = "Please enter numbers and decimal point only";
    }
    elseif ($_POST["price"] <= 0)
    {
        $price_err = "Please enter the number above $0.00";
    }
    else{
        $price = trim($_POST["price"]);
    }

    if(empty(trim($_POST["description"]))){
        $description_err = "Please enter username.";
    } else{
        $description = trim($_POST["username"]);
    }

    $target_dir = "images/";
    $target_file = $target_dir . basename($_FILES["uploaded_file"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["uploaded_file"]["tmp_name"]);
        if($check !== false) {
            $image_success = "File is an image - " . $check["mime"] . ".";

        } else {
            $image_err = "File is not an image.";
        }
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        $image_err = "Sorry, file already exists.";
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
        $image_err = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    }



    //Stores the submitted data into the product table
    $sql = "INSERT INTO product (product_name,price,description,image) VALUES ($product_name,$price,$description,$image)";
    if ($image_err = '')
    {
        if(mysqli_query($link,$sql))
        {
            //Move the uploaded image into the folder: images
            move_uploaded_file($_FILES["uploaded_file"]["tmp_name"], $target_file);
        }
    }
}





?>

<?php include "header_admin.php"?>
<div class="wrapper">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
        <div class="form-group" <?php echo (!empty($product_name_err)) ? 'has-error' : ''; ?>>
            <label>Product name</label>
            <input type="text" name="product_name" class="form-control">
            <span class="help-block"><?php echo $product_name_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($price_err)) ? 'has-error' : ''; ?>">
            <label>Price</label>
            <input type="password" name="price" class="form-control">
            <span class="help-block"><?php echo $price_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($description_err)) ? 'has-error' : ''; ?>">
            <label>Description</label>
            <input type="password" name="description" class="form-control">
            <span class="help-block"><?php echo $description_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($description_err)) ? 'has-error' : ''; ?>">
            <label>Description</label>
            <input type="password" name="description" class="form-control">
            <span class="help-block"><?php echo $description_err; ?></span>
        </div>
        <div class="input-default-wrapper mt-3">
            <span class="input-group-text mb-3" id="input">Upload</span>
            <input type="file" id="file-with-current" class="input-default-js" name="uploaded_file" id="uploaded_file">
            <label class="label-for-default-js rounded-right mb-3" for="file-with-current"><span class="span-choose-file">Choose
      file</span>
                <div class="float-right span-browse">Browse</div>
            </label>
            <span class="help-block"><?php if ($image_err = ''){echo $image_success;} ?></span>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Add Item" name ="submit">
        </div>
    </form>
</div>
<?php include "footer.php"?>