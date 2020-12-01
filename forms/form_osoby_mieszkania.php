<!DOCTYPE HTML>
<html lang="pl">
<body>
<?php
$json = json_decode(file_get_contents("../data/database.json"));

//mysql setup
$mysqlConnection = mysqli_connect($json->host, $json->user, $json->password);
mysqli_query($mysqlConnection, "set charset utf8");
mysqli_query($mysqlConnection, "set names 'utf8' collate 'utf8_polish_ci'");
mysqli_select_db($mysqlConnection, $json->database);
?>
<form action="tableform.php" method="post">
    <div class="content-header">
        <h2>Osoby_Mieszkania</h2>
    </div>
    <input type="hidden" name="table" value="osoby_mieszkania" />
    <input type="hidden" name="query" value="select * from osoby_mieszkania;" />
    <div class="form-group" style="margin: 5px">
        <select id="form-person" required="required" title="Osoba" name="person-id">
            <?php
            $people = mysqli_query($mysqlConnection, "select concat('(',id,') ',imie, ' ', nazwisko, ' | tel: ', telefon) from osoby;");
            $peopleQuery = mysqli_query($mysqlConnection, "select id from osoby;");

            foreach($people as $key => $var) {
                $output = '<option';
                foreach ($var as $k => $v) {
                    $q = mysqli_fetch_array($peopleQuery)[0];

                    $output .= " value='$q'>".$v;
                }
                $output .= '</option>';
                echo($output);
            }
            ?>
        </select>
        <label class="control-label">Osoba</label><i class="bar"></i>
    </div>
    <div style="float: right;">
        <p style="cursor:pointer;" onclick="showQueryDialog('Osoby','select * from osoby;')">Zobacz tabelę</p>
    </div>
    <br>&nbsp;
    <div class="form-group" style="margin: 5px">
        <select id="form-flat" required="required" title="Osoba" name="flat-id">
            <?php
            $flats = mysqli_query($mysqlConnection, "select concat('(',id,') ',ulica, ' ', nr_domu, '/', nr_mieszkania, ', ', kod, ' ', miejscowosc) from mieszkania;");
            $flatsQuery = mysqli_query($mysqlConnection, "select id from mieszkania;");

            foreach($flats as $key => $var) {
                $output = '<option';
                foreach ($var as $k => $v) {
                    $q = mysqli_fetch_array($flatsQuery)[0];

                    $output .= " value='$q'>".$v;
                }
                $output .= '</option>';
                echo($output);
            }
            ?>
        </select>
        <label class="control-label">Mieszkanie</label><i class="bar"></i>
    </div>
    <div style="float: right;">
        <p style="cursor:pointer;" onclick="showQueryDialog('Mieszkania','select * from mieszkania;')">Zobacz tabelę</p>
    </div>
    <br>&nbsp;
    <div class="button-container">
        <button type="submit" class="button" name="submit" value="add" onclick="loseButtonFocus(this); validateFormsAndPrintError('form',this, 'error-label','form-person','form-float')"><span>Dodaj</span></button>
        <button type="submit" class="button" name="submit" value="show" onclick="loseButtonFocus(this); validateFormsAndPrintError('form',this,  'error-label','form-person','form-float')"><span>Dodaj i zobacz tabelę</span></button>
        <button type="button" class="button" style="background-color: #d07787; border-color: #d07787" onclick="loseButtonFocus(this); showQueryDialog('Osoby_Mieszkania','select * from osoby_mieszkania;')"><span>Zobacz tabelę</span></button>

    </div>
    <div class="error-container">
        <p id="error-label"></p>
    </div>
</form>
</body>
</html>