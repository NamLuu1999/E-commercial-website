<?php
/**
 * Created by PhpStorm.
 * User: James Mai
 * Date: 3/14/2019
 * Time: 10:36 PM
 */
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$postal_code=$address=$email=$last_name=$first_name=$username = $password = $confirm_password = "";
$postal_code_err=$address_err=$email_err=$last_name_err=$first_name_err=$username_err = $password_err = $confirm_password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate first name
    if (empty($_POST["first_name"])) {
        $first_name_err = "First name is required";
    } else {
        $first_name = test_input($_POST["first_name"]);
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z ]*$/",$first_name)) {
            $first_name_err = "Only letters and white space allowed";
        }
    }

    //Validate last name
    if (empty($_POST["last_name"])) {
        $last_name_err = "Last name is required";
    } else {
        $last_name = test_input($_POST["last_name"]);
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z ]*$/",$last_name)) {
            $last_name_err = "Only letters and white space allowed";
        }
    }

    //Validate email address
    if (empty($_POST["email"])) {
        $email_err = "Email is required";
    } else {
        $email = test_input($_POST["email"]);
        // check if e-mail address is well-formed
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email_err = "Invalid email format";
        }
    }

    //Validate home address
    if (empty($_POST["address"])) {
        $address_err = "Address is required";
    }
    else{
        $address = trim($_POST["address"]);
    }

    //Validate postal code
    if (empty($_POST["postal_code"])) {
        $postal_code_err = "Postal code is required";
    }
    else{
        $postal_code = test_input($_POST["postal_code"]);
    }

    // Validate username
    if(empty($_POST["username"])){
        $username_err = "Please enter a username.";
    }elseif (preg_match('/\s/',$_POST["username"]) || preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $_POST["username"]))
    {
        $username_err ="No special character and white spaces allowed";
    }
    else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";

        if($stmt = mysqli_prepare($link, $sql)){
            // Set parameters
            $param_username = $_POST["username"];

            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);

                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = $_POST["username"];
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Validate password
    if(empty($_POST["password"])){
        $password_err = "Please enter a password.";
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have at least 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if(empty($_POST["confirm_password"])){
        $confirm_password_err = "Please confirm password.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }

    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($first_name_err) && empty($last_name_err) && empty($postal_code_errerr) && empty($email_err) && empty($address_err)){

        // Prepare an insert statement
        $sql = "INSERT INTO users (first_name, last_name, email, address, postal_code, username, password ) VALUES (?, ?, ?, ?, ?, ?, ?)";

        if($stmt = mysqli_prepare($link, $sql)){
            // Set parameters
            $param_first_name = $first_name;
            $param_last_name = $last_name;
            $param_email = $email;
            $param_address = $address;
            $param_postal_code = $postal_code;
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash


            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssssss", $param_first_name, $param_last_name, $param_email, $param_address, $param_postal_code, $param_username, $param_password);

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                session_start();

                // Redirect to login page
                header("Location: login.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }


            // Close statement

            mysqli_stmt_close($stmt);
        }
        else {
            echo "Something's wrong with the query: " . mysqli_error($link);
        }


    }

    // Close connection
    mysqli_close($link);
}

//Receive data input and clear all the unexpected data
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<title>Sign Up</title>

<?php include('header_guest.php');?>
<body>
<main class="container-fluid justify-content-center">
    <div class="wrapper container-fluid" style="padding: 100px 0;">
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

            <!--First name input field -->
            <div class="form-group <?php echo (!empty($first_name_err)) ? 'has-error' : ''; ?>">
                <label>First name</label>
                <input type="text" name="first_name" class="form-control" value="<?php echo $first_name; ?>">
                <span class="help-block"><?php echo $first_name_err; ?></span>
            </div>

            <!--Last name input field -->
            <div class="form-group <?php echo (!empty($last_name_err)) ? 'has-error' : ''; ?>">
                <label>Last name</label>
                <input type="text" name="last_name" class="form-control" value="<?php echo $last_name; ?>">
                <span class="help-block"><?php echo $last_name_err; ?></span>
            </div>

            <!--Email input field  -->
            <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="<?php echo $email; ?>">
                <span class="help-block"><?php echo $email_err; ?></span>
            </div>

            <!--User address input field  -->
            <div class="form-group <?php echo (!empty($address_err)) ? 'has-error' : ''; ?>">
                <label>Home address</label>
                <input type="text" name="address" class="form-control" value="<?php echo $address; ?>">
                <span class="help-block"><?php echo $address_err; ?></span>
            </div>

            <!--Postal code input field  -->
            <div class="form-group <?php echo (!empty($postal_code_err)) ? 'has-error' : ''; ?>">
                <label>Postal code</label>
                <input type="text" name="postal_code" class="form-control" value="<?php echo $postal_code; ?>">
                <span class="help-block"><?php echo $postal_code_err; ?></span>
            </div>

            <!--User name input field -->
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>

            <!--Password input field  -->
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>

            <!--Confirm password input field  -->
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>

            <!--Submit and Reset buttons  -->
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>

            <!--Redirect if the user already have an account  -->
            <p>Already have an account? <a href="login.php">Login here</a>.</p>

        </form>
    </div>
</main>
<?php include('footer.php');?>