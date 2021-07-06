<section>
    <div class="searchContainer">
        <h2>Produkte LogoPrint</h2>
        <form method="post">
            <div class="searchOption">
                <select class="form-select" aria-label="Default select example" name="taskOption">
                    <option selected>Suchoption auswählen</option>
                    <option value="EAN_Code">EAN_Code</option>
                    <option value="Gruppe">Gruppe</option>
                    <option value="Produktname">Produktname</option>
                    <option value="Produktcode">Produktcode</option>
                </select>
                <input class="searchField" type="text" name="searchObject">
                <input class="submitButton" type="submit" value="Suchen" name="Submit1">
            </div>
        </form>

        <?php
        if(isset($_POST["Submit1"])){
        $db = mysqli_connect("localhost","root","","logoPrint");

        if(!$db)
        {
            die("Connection failed: " . mysqli_connect_error());
        }

        $object = $_POST["searchObject"];
        $taskOption = $_POST["taskOption"];

        $sql = "SELECT * FROM productTabel where $taskOption = '$object'";
        $result = mysqli_query($db, $sql);
        ?>
        <hr class="new4">
    </div>
    <h4>Suchergebnisse:</h4>
    <div class="scrollBar">
        <?php
        if (mysqli_num_rows($result) == 0) {// output data of each row
            echo "0 Suchergebnisse";
        }else{
        ?>
        <table class="table table-success table-striped">
            <thead class="searchContainer">
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
            </thead>
            <tbody>
            <?php
            while($row = mysqli_fetch_assoc($result)) {
                ?>

                <tr>
                    <th scope="row"><?php echo $row['EAN_Code']; ?></th>
                    <td><?php echo $row['Gruppe']; ?></td>
                    <td><?php echo $row['Produktname']; ?></td>
                    <td><?php echo $row['Produktcode']; ?></td>
                    <td><?php echo $row['ProduktbeschreibungFR']; ?></td>
                    <td><?php echo $row['ProduktbeschreibungDE']; ?></td>
                    <td><?php echo $row['Verkaufspreis']; ?></td>
                    <td><?php echo $row['VerkaufspreisINKLMWST']; ?></td>
                </tr>

                <?php
            }
            }
            mysqli_close($db);
            }
            ?>
            </tbody>
        </table>
    </div>

    <hr class="new4">
</section>


