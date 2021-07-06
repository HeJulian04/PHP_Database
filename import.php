
 
<!-- Import form (start) -->
<div class="popup_import">
 <form method="post" action="" enctype="multipart/form-data" id="import_form">
  <table width="100%">

   <tr>
    <td colspan="2">
     <input type='file' name="importfile" id="importfile">
    </td>
   </tr>
   <tr>
    <td colspan="2" ><input type="submit" id="but_import" name="but_import" value="Import"></td>
   </tr>
   <tr>
    <td colspan="2" align="center"><span class="format">Username, First name, Last name,Email</span> </td>
   </tr>
   <tr>
    <td colspan="2" align="center"><a href="import_example.csv" target="_blank">Download Sample</a></td>
   </tr>

   <tr>
    <td colspan="2"><b>Instruction : </b><br/>
     <ul>
      <li>Enclose text field in quotes (' , " ) if text contains comma (,) is used.</li>
      <li>Enclose text field in single quotes (') if text contains double quotes (")</li>
      <li>Enclose text field in double quotes (") if text contains single quotes (')</li>
     </ul>
    </td>
   </tr>
  </table>
 </form>
</div>
<!-- Import form (end) -->

<!-- Displaying imported users -->
<table border="1" id="userTable">
  <tr>
   <th scope="col">EAN_Code</th>
    <th scope="col">Gruppe</th>
    <th scope="col">Produktname</th>
    <th scope="col">Productcode</th>
    <th scope="col">Produktbeschreibung FR</th>
    <th scope="col">Produktbeschreibung DE</th>
    <th scope="col">Verkaufspreis</th>
    <th scope="col">VP inkl. MWST</th>
  </tr>
  <?php
include "dbConfig.php";

if(isset($_POST['but_import'])){
   $target_dir = "uploads/";
   $target_file = $target_dir . basename($_FILES["importfile"]["name"]);

   $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

   $uploadOk = 1;
   if($imageFileType != "csv" ) {
     $uploadOk = 0;
   }

   if ($uploadOk != 0) {
      if (move_uploaded_file($_FILES["importfile"]["tmp_name"], $target_dir.'importfile.csv')) {

        // Checking file exists or not
        $target_file = $target_dir . 'importfile.csv';
        $fileexists = 0;
        if (file_exists($target_file)) {
           $fileexists = 1;
        }
        if ($fileexists == 1 ) {

           // Reading file
           $file = fopen($target_file,"r");
           $i = 0;

           $importData_arr = array();
                       
           while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
             $num = count($data);

             for ($c=0; $c < $num; $c++) {
                $importData_arr[$i][] = mysqli_real_escape_string($con, $data[$c]);
             }
             $i++;
           }
           fclose($file);

           $skip = 0;
           // insert import data
           foreach($importData_arr as $data){
              if($skip != 0){
                 $EAN_Code = $data[0];
                 $Gruppe = $data[1];
                 $Produktname = $data[2];
                 $Produktcode = $data[3];
                 $ProduktbeschreibungFR = $data[4];
                 $ProduktbeschreibungDE = $data[5];
                 $Verkaufspreis = $data[6];
                 $VerkaufspreisINKLMWST = $data[7];

                 // Checking duplicate entry
                 $sql = "select count(*) as allcount from productTable where EAN_Code='" . $EAN_Code "' ";

                 $retrieve_data = mysqli_query($con,$sql);
                 $row = mysqli_fetch_array($retrieve_data);
                 $count = $row['allcount'];

                 if($count == 0){
                    // Insert record
                    $insert_query = "insert into productTable(EAN_Code,Gruppe,Produktname,Produktcode,ProduktbeschreibungFR,ProduktbeschreibungDE,Verkaufspreis,VerkaufspreisINKLMWST) values('".$EAN_Code."','".$Gruppe."','".$Produktname."','".$Produktcode."','".$ProduktbeschreibungFR."','".$ProduktbeschreibungDE."','".$Verkaufspreis."','".$VerkaufspreisINKLMWST."')";
                    mysqli_query($con,$insert_query);
                 }
              }
              $skip ++;
           }
           $newtargetfile = $target_file;
           if (file_exists($newtargetfile)) {
              unlink($newtargetfile);
           }
         }

      }
   }
}
    $sql = "select * from productTable limit 10";
    $sno = 1;
    $retrieve_data = mysqli_query($con,$sql);
    while($row = mysqli_fetch_array($retrieve_data)){
        $EAN_Code = $row['EAN_Code'];
        $Gruppe = $row['Gruppe'];
        $Produktname = $row['Produktname'];
        $Productcode = $row['Productcode'];
        $ProduktbeschreibungFR = $row['ProduktbeschreibungFR'];
        $ProduktbeschreibungDE = $row['ProduktbeschreibungDE'];
        $Verkaufspreis = $row['Verkaufspreis'];
        $VerkaufspreisINKLMWST = $row['VerkaufspreisINKLMWST'];

        echo "<tr>
            <td>".$EAN_Code."</td>
            <td>".$Gruppe."</td>
            <td>".$Produktname."</td>
            <td>".$Productcode."</td>
            <td>".$ProduktbeschreibungFR."</td>
            <td>".$ProduktbeschreibungDE."</td>
            <td>".$Verkaufspreis."</td>
            <td>".$VerkaufspreisINKLMWST."</td>
        </tr>";
        $sno++;
    }
   ?>
</table>

