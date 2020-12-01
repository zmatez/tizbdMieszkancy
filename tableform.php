<?php
$tableName = $_POST['table'];
$query = $_POST['query'];
$buttonAction = $_POST['submit'];
if(isset($tableName) && isset($query) && isset($buttonAction)){
    $json = json_decode(file_get_contents("data/database.json"));

    //mysql setup
    $mysqlConnection = mysqli_connect($json->host, $json->user, $json->password);
    mysqli_query($mysqlConnection, "set charset utf8");
    mysqli_query($mysqlConnection, "set names 'utf8' collate 'utf8_polish_ci'");
    mysqli_select_db($mysqlConnection, $json->database);

    $queryResult = "";
    $mf = 0;
    $successMsg = "";
    if($tableName === "osoby"){
        $mf = 1;
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $phone = str_replace("-","",$_POST['phone']);

        $queryResult = "insert into osoby (imie, nazwisko, telefon) values ('$name', '$surname', '$phone');";
    }else if($tableName === "mieszkania"){
        $mf = 2;
        $street = $_POST['street'];
        $houseNumber = $_POST['house-number'];
        $flatNumber = $_POST['flat-number'];
        $postalCode = $_POST['postal-code'];
        $town = $_POST['town'];

        $queryResult = "insert into mieszkania (ulica, nr_domu, nr_mieszkania, kod, miejscowosc) values ('$street', '$houseNumber', '$flatNumber', '$postalCode', '$town')";
    }else if($tableName === "osoby_mieszkania"){
        $mf = 3;
        $personID = $_POST['person-id'];
        $flatID = $_POST['flat-id'];

        $queryResult = "insert into osoby_mieszkania (id_mieszkania, id_osoby) values ('$flatID','$personID')";
    }

    $time = date("h:i:sa");

    if(mysqli_query($mysqlConnection, $queryResult)){
        $successMsg = "[$time] Dodano rekord";
    }else{
        $successMsg = "[$time] Nie można dodać rekordu";
    }

    $successMsg = base64_encode($successMsg);

    if($buttonAction === "show"){
        header("Location: index.php?query=" . (base64_encode($query)) . "&prev=" . (base64_encode($tableName)) . "&success=$successMsg");
    }else{
        header("Location: managing.php?success=$successMsg#mf$mf");
    }
}else{
    header("Location: managing.php");
}