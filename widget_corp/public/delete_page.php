<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connections.php"); ?>
<?php require_once("../includes/functions.php"); ?>

<?php confirm_logged_in(); ?>

<?php 
    $current_page = find_page_by_id($_GET["page"], false);
    if(!$current_page){
        //subject ID was missing or invalid or
        //subject couldn't be found in database
        redirect_to("manage_content.php");
    }

    $id = $current_page["id"];
    $query = "DELETE FROM pages ";
    $query .= "WHERE id={$id} ";
    $query .= "LIMIT 1";
    $result = mysqli_query($connection, $query);

    if($result && mysqli_affected_rows($connection) == 1){
        //Success
        $_SESSION["message"] = "Page deleted.";
        redirect_to("manage_content.php");
    }else{
        // Failure
		$_SESSION["message"] = "Page deletion failed.";
		redirect_to("manage_content.php?subject={$current_page["subject_id"]}");
    }
?>