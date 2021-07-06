<?php
// Load the database configuration file
// Database configuration
$dbHost     = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName     = "logoPrint";

// Create database connection
$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

if(isset($_POST['importSubmit'])){

    // Allowed mime types
    $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');

    // Validate whether selected file is a CSV file
    if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $csvMimes)){

        // If the file is uploaded
        if(is_uploaded_file($_FILES['file']['tmp_name'])){
            // Open uploaded CSV file with read-only mode
            $csvFile = fopen($_FILES['file']['tmp_name'], 'r');

            // Skip the first line
            fgetcsv($csvFile);

            // Parse data from CSV file line by line
            while(($line = fgetcsv($csvFile)) !== FALSE){
                // Get row data
                $eanCode   = $line[0];
                $gruppe  = $line[1];
                $produktname  = $line[2];
                $produktcode = $line[3];
                $produktbeschreibungFR = $line[4];
                $produktbeschreibungDE = $line[5];
                $verkaufspreis = $line[6];
                $inklMWST = $line[7];

                // Check whether member already exists in the database with the same email
                $prevQuery = "SELECT EAN_Code FROM productTable WHERE EAN_Code = '".$line[1]."'";
                $prevResult = $db->query($prevQuery);

                if($prevResult->num_rows > 0){
                    // Update member data in the database
                    $db->query("UPDATE productTable SET EAN_Code = '".$eanCode."', Gruppe = '".$gruppe."', Produktname = '".$produktname."', Produktcode = '".$produktcode."', ProduktbeschreibungFR = '".$produktbeschreibungFR."', ProduktbeschreibungDE = '".$produktbeschreibungDE."', Verkaufspreis = '".$verkaufspreis."', VerkaufspreisINKLMWST = '".$inklMWST."'");
                }else{
                    // Insert member data in the database
                    $db->query("INSERT INTO productTable (EAN_Code, Gruppe, Produktname, Produktcode, ProduktbeschreibungFR, ProduktbeschreibungDE,  Verkaufspreis,  VerkaufspreisINKLMWST) VALUES ('".$eanCode."', '".$gruppe."', '".$produktname."', '".$produktcode."', '".$produktbeschreibungFR."', '".$produktbeschreibungDE."', '".$verkaufspreis."', '".$inklMWST."')");
                }
            }

            // Close opened CSV file
            fclose($csvFile);

            $qstring = '?status=succ';
        }else{
            $qstring = '?status=err';
        }
    }else{
        $qstring = '?status=invalid_file';
    }
}

// Redirect to the listing page
header("Location: import.php".$qstring);
