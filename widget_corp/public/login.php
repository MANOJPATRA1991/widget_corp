<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connections.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>

<?php $username = ""; ?>

<?php
    if(isset($_POST['submit'])){
        //Process the form
        
        $required_fields = array("username", "password");
        validate_presences($required_fields);
        
        if(!empty($errors)){
            $_SESSION["errors"] = $errors;
            redirect_to("login.php");
        }
        
        $username = $_POST["username"];
        $password = $_POST["password"];
        
        $found_admin = attempt_login($username, $password);
        
        if($found_admin){
            //Success
            //Mark user as logged in
            $_SESSION["admin_id"] = $found_admin["id"];
            $_SESSION["username"] = $found_admin["username"];
            redirect_to("admin.php");
        }else{
            //Failure
            $_SESSION["message"] = "Username/Password did not match";
        }
    }else{
        //This is probably a GET request
    }
?>

<?php $layout_context = "admin"; ?>
<?php include("../includes/layouts/header.php"); ?>
<div id="main">
    <div id="navigation">
        
    </div>
    <div id="page">
        <?php
            echo message();
            $errors = errors();
            echo form_errors($errors);
        ?>
        <h2>Log In</h2>
        
        <form action="login.php" method="post">
            <p>Username:
                <input type="text" name="username" value="<?php echo htmlentities($username); ?>" />
            </p>
            <p>Password:
                <input type="password" name="password" value="" />
            </p>
            <input type="submit" name="submit" value="Log In"/>
        </form>
    </div>
</div>

<?php include("../includes/layouts/footer.php"); ?>
