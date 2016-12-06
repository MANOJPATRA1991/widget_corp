        <div id="footer">Copyright <?php echo date("Y"); ?>, Widget Corp</div>
	</body>
</html>
<?php
  // Close database connection
if(isset($connection)){
    //closes a previously opened database connection
    mysqli_close($connection);
}
?>