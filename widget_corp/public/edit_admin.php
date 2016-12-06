<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connections.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>

<?php confirm_logged_in(); ?>

<?php $admin = find_admin_by_id($_GET["id"]); ?>

<?php 
    if(!$admin){
        //subject ID was missing or invalid or
        //subject couldn't be found in database
        redirect_to("manage_admins.php");
    }
?>

<?php
    if(isset($_POST['submit'])){
        //validations
        $required_fields = array("username", "password");
        validate_presences($required_fields);
        
        $fields_with_max_lengths = array("username" => 50, "password" => 60);
        validate_max_lengths($fields_with_max_lengths);
        
        if(empty($errors)){
            //Perform Update
            $username = mysql_prep($_POST["username"]);
            $hashed_password = password_encrypt($_POST["password"]);
            $id = $admin["id"];

            $query = "UPDATE admins ";
            $query .= " SET username='{$username}', hashed_password='{$hashed_password}' ";
            $query .= " WHERE id={$id}";
            $query .= " LIMIT 1";
            $result = mysqli_query($connection, $query);

            //check if the row is affected or not
            if($result && mysqli_affected_rows($connection) == 1){
                //Success
                $_SESSION["message"] = "Admin updated.";
                redirect_to("manage_admins.php");
            }else{
                //Failure
                $message = "Page update failed.";
            }
        }
    }else{
        //This is probably a GET request
    }
?>

<?php $layout_context = "admin"; ?>
<?php include("../includes/layouts/header.php"); ?>
<div id="main">
    <div id="navigation">
        &nbsp;
    </div>
    <div id="page">
        <?php //$message is just a variable, doesn't use the SESSION
            if(!empty($message)){
                echo "<div class=\"message\">" . htmlentities($message) . "</div>";
            }
            echo form_errors($errors);
        ?>
        <h2>Edit Admin: <?php echo htmlentities($admin["username"]); ?></h2>
        
        <form action="edit_admin.php?id=<?php echo urlencode($admin["id"]); ?>"  method="post">
            <p>Username:
                <input type="text" name="username" value="<?php echo htmlentities($admin["username"]); ?>" />
            </p>
            <p>Password:
                <input type="password" name="password" value="" />
            </p>
            <input type="submit" name="submit" value="Edit Admin"/>
        </form>
        <br />
        <a href="manage_admins.php">Cancel</a>
    </div>
</div>

<?php include("../includes/layouts/footer.php"); ?>
