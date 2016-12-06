<!--CRUD for manging content in our CMS-->

<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connections.php"); ?>
<?php require_once("../includes/functions.php"); ?>

<?php confirm_logged_in(); ?>

<?php 
    $admin_set = find_all_admins();
?>
<?php $layout_context = "admin"; ?>
<?php include("../includes/layouts/header.php"); ?>

<div id="main">
    <div id="navigation">
        <a href="admin.php">&laquo; Main menu</a><br/>
    </div>
    <div id="page">
        <?php
            echo message();
        ?>  
        <h2>Manage Admins</h2>
        <table>
            <tr>
                <th style="text-align: left; width: 200px;">Username</th>
                <th colspan="2" style="text-align: left;">Actions</th>
            </tr>
            <?php while($admin = mysqli_fetch_assoc($admin_set)){ ?>
            <tr>
                <th><?php echo htmlentities($admin["username"]); ?></th>
                <th><a href="edit_admin.php?id=<?php echo urlencode($admin["id"]); ?>">Edit</a></th>
                <th><a href="delete_admin.php?id=<?php echo urlencode($admin["id"]); ?>" onclick="return confirm('Are you sure?');">Delete</a></th>
            </tr>
            <?php } ?>
        </table>
        <br/>
        <a href="new_admin.php">Add new Admin</a>
    </div>
</div>

<?php include("../includes/layouts/footer.php"); ?>
