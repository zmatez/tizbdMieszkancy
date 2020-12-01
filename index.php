<!DOCTYPE HTML>
<html lang="pl">
<head>
    <title>Baza Danych Mieszkancy</title>
    <meta charset="utf-8"/>
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link rel="stylesheet" href="styles/stylesheet.css">
    <link rel="stylesheet" href="styles/forms.css">
    <link rel="shortcut icon" type="image/png" href="images/logo.png"/>

    <script src="js/global.js"></script>
</head>
<body>
<div id="header">
    <div id="header-content">
        <div class="logo-image">
            <a href="#"> <img src="images/logo.png" style="height: 68px; text-align: center;"
                              alt="logo"></a>
        </div>
        <div class="logo-header">
            <h1>MIESZKAŃCY</h1>
        </div>
        <div class="logo-text">
            <a class="header-a" href="#" style="color: #a86d19;"><b>Zapytania</b></a>
        </div>
        <div class="logo-text">
            <a class="header-a" href="managing.php" style="color: #a86d19;">Zarządzanie</a>
        </div>
    </div>
</div>
<div id="menubar">
    <div class="menuEntry" style="background-color:white; border-bottom: #e5e5e5 1px solid; cursor: default;">
        <p class="menuParagraph" style="text-align: center; padding-left:0;"><strong>- Skróty Zapytań
                -</strong></p>
    </div>
    <div id="mf1" class="menuEntry" onclick="entryClick(this)">
        <p class="menuParagraph"><strong>Domyślne</strong></p>
    </div>
    <div id="mf2" class="menuEntry" onclick="entryClick(this)">
        <p class="menuParagraph"><strong>Wszystkie osoby</strong></p>
    </div>
    <div id="mf3" class="menuEntry" onclick="entryClick(this)">
        <p class="menuParagraph"><strong>Wszystkie mieszkania</strong></p>
    </div>
    <div id="mf4" class="menuEntry" onclick="entryClick(this)">
        <p class="menuParagraph"><strong>Wszystkie osoby_mieszkania</strong></p>
    </div>
    <div id="mf5" class="menuEntry" onclick="entryClick(this)">
        <p class="menuParagraph"><strong>Mieszkania osób</strong></p>
    </div>

    <script>
        const queries = [
            "<?php
                echo(file_get_contents("queries/query.sql"))
                ?>",
            "select * from osoby;",
            "select * from mieszkania;",
            "select * from osoby_mieszkania;",
            "select osoby.*,mieszkania.* from osoby_mieszkania join osoby on osoby_mieszkania.id_osoby = osoby.id join mieszkania on osoby_mieszkania.id_mieszkania = mieszkania.id;"
        ];

        function entryClick(button) {
            let index = parseInt(button.id.replace("mf", ""));
            let currentURL = location.protocol + '//' + location.host + location.pathname;
            if (index === 1) {
                window.location.href = currentURL;

            } else {
                window.location.href = currentURL + "?query=" + btoa(queries[index - 1]);
            }
        }

        const query = getParameterByName("query");
        if (query != null) {
            let queryDecoded = atob(query).replace(";", "");
            for (let i = 0; i < queries.length; i++) {
                if (queries[i].replace(";", "") === queryDecoded) {
                    let button = document.getElementById("mf" + (i + 1));
                    if (button != null) {
                        button.classList.add("menuSelectedParagraph");
                    }
                }
            }
        }else{
            let button = document.getElementById("mf1");
            if (button != null) {
                button.classList.add("menuSelectedParagraph");
            }
        }
    </script>
</div>
<div id="content">
    <br>
    <div class="content-holder" style="width: 50%">
        <div id="form-content">
            <form action="queryform.php" method="get">
                <div class="content-header">
                    <h2>Zapytanie SQL</h2>
                </div>
                <div class="form-group">
                    <textarea id="form-query" required="required" maxlength="2000" placeholder=" "
                              oninvalid="this.setCustomValidity('Wpisz zapytanie SQL')"
                              oninput="this.setCustomValidity('')" title="Wpisz zapytanie SQL"
                              name="form-query"></textarea>
                    <label class="control-label">Własne zapytanie SQL</label><i class="bar"></i>
                </div>

                <div class="button-container">
                    <button type="submit" class="button"
                            onclick="loseButtonFocus(this); validateFormsAndPrintError('form',this, 'error-label','form-query')">
                        <span>Załaduj</span></button>
                </div>
                <div class="error-container">
                    <p id="error-label"></p>
                </div>
            </form>
            <?php
            if (isset($_GET['prev'])) {
                $prev = $_GET['prev'];
                $prev = base64_decode($prev);
                $prevPage = "";
                if ($prev === "mieszkania") {
                    $prevPage = "managing.php#mf2";
                } else if ($prev === "osoby_mieszkania") {
                    $prevPage = "managing.php#mf3";
                } else if ($prev === "osoby") {
                    $prevPage = "managing.php#mf1";
                }
                echo("
                    <div class='info_box'>
                    <div class='info_box_img'>
                    <img src='images/back.png' alt='go back' style='cursor: pointer' onclick='back()'>
                    </div>
                    <div class='info_box_text' style='cursor: pointer' onclick='back()'>
                        Wróć do: $prev
                    </div>
                    </div><br>&nbsp;
                    <script>
                        function back(){
                            window.location.href = '$prevPage'
                        }
                    </script>
                    ");
            }
            ?>
        </div>
    </div>
    <br>
    <div class="content-holder" style="width: 50%">
        <div id="table-holder">
            <?php
            $json = json_decode(file_get_contents("data/database.json"));

            //mysql setup
            $mysqlConnection = mysqli_connect($json->host, $json->user, $json->password);
            mysqli_query($mysqlConnection, "set charset utf8");
            mysqli_query($mysqlConnection, "set names 'utf8' collate 'utf8_polish_ci'");
            mysqli_select_db($mysqlConnection, $json->database);

            //query setup
            $query = "";
            if(!isset($_GET["query"])){
                $query = file_get_contents("queries/query.sql");
            }else{
                $query = base64_decode($_GET["query"]);
            }

            echo("<script>document.getElementById('form-query').value = '$query';</script>");

            //results
            $queryResult = mysqli_query($mysqlConnection, $query);
            if (!$queryResult) {
                echo("<div class='info_box'>
                    <div class='info_box_img'>
                    <img src='images/error.png' alt='error'>
                    </div>
                    <div class='info_box_text'>
                    Błąd w zapytaniu.
                    </div>
                </div>");
            } else if (mysqli_num_rows($queryResult) < 1) {
                echo("<div class='info_box'>
                    <div class='info_box_img'>
                    <img src='images/empty.png' alt='error'>
                    </div>
                    <div class='info_box_text'>
                    Zwrócono 0 wierszy.
                    </div>
                </div>");
            } else {
                displayQueryResults($queryResult);

                $resultCount = mysqli_num_rows($queryResult);
                echo("<div class='info_box' style='margin-top: 50px'>
                    <div class='info_box_img'>
                    <img src='images/success.png' alt='error'>
                    </div>
                    <div class='info_box_text'>
                    Wyświetlono $resultCount wierszy.
                    </div>
                </div>");

            }

            function displayQueryResults($result){
                $output = '<table>';
                foreach($result as $key => $var) {
                    if($key === 0){
                        $output .= '<tr>';
                        foreach ($var as $k => $v) {
                            $output .= '<th>' . $k . '</th>';
                        }
                        $output .= '</tr>';
                    }
                    $output .= '<tr>';
                    foreach ($var as $k => $v) {
                        $output .= '<td>' . $v . '</td>';
                    }
                    $output .= '</tr>';
                }
                $output .= '</table>';
                echo $output;
            }

            ?>
        </div>
    </div>
</div>
<div id="footer">
    <div id="copyrightFooter">
        Copyright Vortex Smoking Inc. 2020
        <br>
        Powered by <br><img src="images/matez-logo.svg" alt="matezdev" style=" height: 100px">
        <br>
        <a href="https://matez.net" style="color:#fd5d1c">matez.net</a>
        <br>
        Made by Mateusz Zamojski 2e ~matez
    </div>
</div>
</body>
</html>
