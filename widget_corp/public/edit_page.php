<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connections.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>

<?php confirm_logged_in(); ?>

<?php find_selected_page(); ?>

<?php 
    if(!$current_page){
        //subject ID was missing or invalid or
        //subject couldn't be found in database
        redirect_to("manage_content.php?subject=" . 
                   urlencode($current_subject["id"]));
    }
?>

<?php
    if(isset($_POST['submit'])){
        //validations
        $required_fields = array("menu_name", "position", "visible", "content");
        validate_presences($required_fields);
        
        $fields_with_max_lengths = array("menu_name" => 30, "content" => 250);
        validate_max_lengths($fields_with_max_lengths);
        
        if(empty($errors)){
            //Perform Update
            $id = $current_page["id"];
            $menu_name = mysql_prep($_POST["menu_name"]);
            $position = (int)$_POST["position"];
            $visible = (int)$_POST["visible"];
            $content = mysql_prep($_POST["content"]);

            $query = "UPDATE pages ";
            $query .= " SET menu_name='{$menu_name}', position={$position},";
            $query .= " visible={$visible}, content='{$content}'";
            $query .= " WHERE id={$id}";
            $query .= " LIMIT 1";
            $result = mysqli_query($connection, $query);

            //check if the row is affected or not
            if($result && mysqli_affected_rows($connection) >= 0){
                //Success
                $_SESSION["message"] = "Page updated.";
                redirect_to("manage_content.php?page=" . 
                           urlencode($current_page["id"]));
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
        <br/>
        <a href="manage_content.php?page=<?php echo urlencode($current_page["id"]); ?>">&laquo; Back</a><br/>
        <?php echo navigation($current_subject, $current_page); ?>
    </div>
    <div id="page">
        <?php //$message is just a variable, doesn't use the SESSION
            if(!empty($message)){
                echo "<div class=\"message\">" . htmlentities($message) . "</div>";
            }
            echo form_errors($errors);
        ?>
        <h2>Edit Page: <?php echo htmlentities($current_page["menu_name"]); ?></h2>
        
        <form action="edit_page.php?page=<?php echo urlencode($current_page["id"]); ?>" method="post">
            <p>Menu name:
                <input type="text" name="menu_name" value="<?php echo htmlentities($current_page["menu_name"]); ?>" />
            </p>
            <p>Position:
                <select name="position">
                    <?php
                        //find_all_subjects is a user defined function that returns //a mysqli_result object which contains all the rows of the //subject table as associative arrays
                        $page_set = find_pages_for_subject($current_page["subject_id"], false);
                        //mysqli_num_rows returns the number of rows in the result set or mysqli_result object
                        $page_count = mysqli_num_rows($page_set);
                        for($count = 1; $count <= $page_count; $count++){
                            echo "<option value=\"{$count}\"";
                            if($current_page["position"] == $count){
                                echo " selected";
                            }
                            echo ">{$count}</option>";
                        }
                    ?>
                </select>
            </p>
            <p>Visible:
                <input type="radio" name="visible" value="0" <?php if($current_page["visible"] == 0) {echo "checked"; } ?>/>No 
                &nbsp;
                <input type="radio" name="visible" value="1" <?php if($current_page["visible"] == 1) {echo "checked"; } ?>/>Yes
            </p>
            <p>Content: <br/>
                <textarea name="content" rows="10" cols="60"><?php echo htmlentities($current_page["content"]); ?></textarea>
            </p>
            <input type="submit" name="submit" value="Edit Page"/>
        </form>
        <br />
        <a href="manage_content.php">Cancel</a>
        &nbsp;
        &nbsp;
        <a href="delete_page.php?page=<?php echo urlencode($current_page["id"]); ?>" onclick="return confirm('Are you sure?'); ">Delete Page</a>
    </div>
</div>

<?php include("../includes/layouts/footer.php"); ?>
