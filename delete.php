<?php

	include "dbConn.php"; // Using database connection file here

	$EAN_Number = $_GET['EAN_Number']; // get id through query string

	$del = mysqli_query($db,"delete from productTabel where EAN_Number = '$EAN_Number'"); // delete query

	if($del)
	{
	    mysqli_close($db); // Close connection
	    header("location:all_records.php"); // redirects to all records page
	    exit;	
	}
	else
	{
	    echo "Error deleting record"; // display error message if not delete
	}
?>