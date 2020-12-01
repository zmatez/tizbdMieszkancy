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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
<div id="dialogWindow">
    <div id="dialogWindow-content">

    </div>
</div>
<script>
    let dialog = document.getElementById("dialogWindow");
    window.onclick = function (event) {
        if (event.target === dialog) {
            hideDialog();
        }
    };
    dialog.style.opacity = "0";
    dialog.style.display = "none";

</script>
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
            <a class="header-a" href="index.php" style="color: #a86d19;">Zapytania</a>
        </div>
        <div class="logo-text">
            <a class="header-a" href="#" style="color: #a86d19;"><b>Zarządzanie</b></a>
        </div>
    </div>
</div>
<div id="menubar">
    <div class="menuEntry" style="background-color:white; border-bottom: #e5e5e5 1px solid; cursor: default;">
        <p class="menuParagraph" style="text-align: center; padding-left:0;"><strong>- Panel Zarządzania
                -</strong></p>
    </div>
    <div id="mf1" class="menuEntry" onclick="entryClick(this, 'osoby')">
        <p class="menuParagraph"><strong>Osoby</strong></p>
    </div>
    <div id="mf2" class="menuEntry" onclick="entryClick(this, 'mieszkania')">
        <p class="menuParagraph"><strong>Mieszkania</strong></p>
    </div>
    <div id="mf3" class="menuEntry" onclick="entryClick(this, 'osoby_mieszkania')">
        <p class="menuParagraph"><strong>Osoby Mieszkania</strong></p>
    </div>

</div>
<div id="content">
    <div class="content-holder" style="width: 50%;">
        <div id="form-content" style="min-width: 300px">
            <div class='info_box'>
                <div class='info_box_img'>
                    <img src='images/table.png' alt='not choosen'>
                </div>
                <div class='info_box_text' style="font-size: 20px">
                    <b>Nie wybrano tabeli</b>
                </div>
            </div>
            <br><br>
            Wybierz tabele z panelu po lewej, a ona pojawi się tutaj.

        </div>
    </div>
</div>

<script>
    var selectedButton = null;
    var selectedTable = null;

    function entryClick(button, name) {
        if(selectedButton === button){
            return;
        }
        if (selectedButton != null) {
            selectedButton.classList.remove("menuSelectedParagraph");
        }
        selectedButton = button;
        selectedButton.classList.add("menuSelectedParagraph");
        selectedTable = name;
        let id = parseInt(button.id.replace("mf", ""))

        window.location.hash = '#' + button.id;

        let path = "";
        switch (id) {
            case 1: {
                path = 'forms/form_osoby.php'
                break
            }
            case 2: {
                path = 'forms/form_mieszkania.php'
                break
            }
            case 3: {
                path = 'forms/form_osoby_mieszkania.php'
                break
            }
        }
        if (path !== "") {
            $('#form-content').fadeOut(500);
            document.getElementById("form-content").style.maxHeight = "0";


            function load() {
                $('#form-content').load(path, function () {
                    <?php
                    //http://localhost:63342/tizbdMieszkancy/managing.php?success=WzA4OjM3OjA3cG1dIERvZGFubyByZWtvcmQ=#mf2
                    if (isset($_GET['success'])) {
                        $success = base64_decode($_GET['success']);
                        echo("
                            label = document.getElementById('error-label');
                            label.style.color = '#55BE3A';
                            label.innerText = '$success';
                        ");
                    }
                    ?>
                    clearUri();

                }).fadeIn(500);
                document.getElementById("form-content").style.maxHeight = "100vh";

            }

            setTimeout(load, 500)

        }
    }

    function clearUri(){
        let uri = window.location.toString();
        if (uri.indexOf("?") > 0) {
            let clean_uri = uri.substring(0, uri.indexOf("?"));
            window.history.replaceState({}, document.title, clean_uri);
        }
    }

    if (window.location.hash) {
        let hash = window.location.hash.substring(1);
        let button = document.getElementById(hash);
        if (button != null) {
            button.click();
        }
    }
</script>


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
