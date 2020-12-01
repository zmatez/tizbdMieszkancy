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

$query = $_GET['query'];
$table = $_GET['name'];

if (isset($query) && isset($table)) {
    $queryDecoded = base64_decode($query);
    $tableDecoded = base64_decode($table);

    echo("<div class='content-header'>
    <h2>$tableDecoded</h2>
</div>
<p>
<code>$queryDecoded</code>
</p>

<div class='button-container'>
    <button type='submit' class='button' style='font-size: 15px; height: 35px; width: 110px; padding: 3px 10px; margin-top: 8px' onclick='clickScript(this);'><span>Przejdź</span></button>
    <script>
    function clickScript(button){
        loseButtonFocus(button);
        let win = window.open('index.php?query=$query','_blank');
        win.focus();
    }
</script>
</div>");
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
        return $output;
    }

    $queryResult = mysqli_query($mysqlConnection,$queryDecoded);

    echo("<div id='table-holder' style=''>");
    if (!$queryResult){
        echo("Nie można wyświetlić tabeli");
    }else if (mysqli_num_rows($queryResult) >= 1){
        echo(displayQueryResults($queryResult));
    }else{
        echo("Nie można wyświetlić tabeli (" . mysqli_num_rows($queryResult) . ")");
    }

    echo("</div><br>");
}
?>
</body>
</html>
