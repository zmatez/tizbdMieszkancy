<?php
if (isset($_GET['form-query'])) {
    $prev = $_GET['prev'];
    $loc = $_GET['lov'];
    if(!isset($loc)){
        $loc = "index.php";
    }
    if(file_get_contents("queries/query.sql") === $_GET['form-query']){
        if(isset($prev)){
            header("Location: $loc?prev=$prev");
        }else {
            header("Location: $loc");
        }
    }else {
        if(isset($prev)){
            header("Location: $loc?query=" . (base64_encode($_GET['form-query'])) . "&prev=$prev");
        }else {
            header("Location: $loc?query=" . (base64_encode($_GET['form-query'])));
        }
    }
}else{
    header("Location: index.php");
}