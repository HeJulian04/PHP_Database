<html>
<head>
	<title>PHP isset() example</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
</head>
<body>

	<form method="post">

		Gib eine EAN_Number ein :<input type="text" name="eanNumber"><br/>
		Gib ein Name ein :<input type="text" name="name"><br/>
		<input type="submit" value="Sum" name="Submit1"><br/><br/>

		<?php
			if(isset($_POST["Submit1"])){
				include "dbConn.php"; // Using database connection file here

				$eanNeu = $_POST["name"];
				$nameNeu = $_POST["eanNumber"];

				$EAN_Number = $_GET['EAN_Number']; // get id through query string

				$del = mysqli_query($db,"delete from productTabel where EAN_Number = '$EAN_Number'"); // delete query
				$add = mysqli_query($db,"INSERT INTO productTabel (EAN_Number, name)
				VALUES ('$nameNeu', '$eanNeu')"); // add query

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
			}
		?>

</form>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>

</html>
