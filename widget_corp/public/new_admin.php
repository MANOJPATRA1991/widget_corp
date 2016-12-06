<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connections.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>

<?php confirm_logged_in(); ?>

<?php $layout_context = "admin"; ?>
<?php include("../includes/layouts/header.php"); ?>

<?php $admin_set = find_all_admins(); ?>

<?php
    if(isset($_POST['submit'])){
        //Process the form
        $username = mysql_prep($_POST["username"]);
        $hashed_password = password_encrypt($_POST["password"]);
        
        //validations
        $required_fields = array("username", "password");
        validate_presences($required_fields);
        
        $fields_with_max_lengths = array("username" => 50, "password" => 60);
        validate_max_lengths($fields_with_max_lengths);  
            
        
        if(!empty($errors)){
            $_SESSION["errors"] = $errors;
            redirect_to("new_admin.php");
        }
        
        $query = "INSERT INTO admins (";
        $query .= " username, hashed_password";
        $query .= ") VALUES (";
        $query .= " '{$username}','{$hashed_password}'";
        $query .= ")";
        $result = mysqli_query($connection, $query);

        if($result){
            //Success
            $_SESSION["message"] = "Admin created.";
            redirect_to("manage_admins.php");
        }else{
            //Failure
            $_SESSION["message"] = "Admin creation failed.";
        }
    }else{
        //This is probably a GET request
    }
?>

<div id="main">
    <div id="navigation">
        
    </div>
    <div id="page">
        <?php
            echo message();
            $errors = errors();
            echo form_errors($errors);
        ?>
        <h2>Create Admin</h2>
        
        <form action="new_admin.php" method="post">
            <p>Username:
                <input type="text" name="username" value="" />
            </p>
            <p>Password:
                <input type="text" name="password" value="" />
            </p>
            <input type="submit" name="submit" value="Create Admin"/>
        </form>
        <br />
        <a href="manage_admins.php">Cancel</a>
    </div>
</div>

<?php include("../includes/layouts/footer.php"); ?>
