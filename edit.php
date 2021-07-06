<?php
	if(isset($_POST["submit"]))

        $db = mysqli_connect("localhost","root","","logoPrint");

        if(!$db)
        {
            die("Connection failed: " . mysqli_connect_error());
        }

		$EAN_Code = $_GET['EAN_Code']; // get id through query string

		$del = mysqli_query($db,"delete from productTabel where EAN_Code = '$EAN_Code'"); // delete query
		$add = mysqli_query($db,"INSERT INTO productTabel (EAN_Number, name)
				VALUES ('1111', 'Doe')"); // add query

		if($del)
		{
			if($add)
			{
		    	mysqli_close($db); // Close connection
		    	header("location:all_records.php"); // redirects to all records page
		    	exit;
			}
			else
			{
		    	echo "Error add record"; // display error message if not delete
			}
		}
		else
		{
		    echo "Error deleting record"; // display error message if not delete
		}


{
 }
?>

<section>
	<form action="edit.php" method="post">
	  <div class="mb-3">
	    <label for="exampleInputEmail1" class="form-label">EAN_Number</label>
	    <input type="text" class="form-control" name="eanNumber" id="eanNumber" aria-describedby="emailHelp">
	  </div>
	  <div class="mb-3">
	    <label for="exampleInputEmail1" class="form-label">Name</label>
	    <input type="text" class="form-control" name="name" id="name" aria-describedby="emailHelp">
	  </div>
	  <button type="submit" id="submit" name="submit" class="btn btn-primary">Submit</button>
	</form>
</section>
