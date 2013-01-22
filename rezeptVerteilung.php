<!DOCTYPE HTML>
<html>
    <header>
        <meta charset="UTF-8">
        <style>
            .critical { background-color:#ff0000; }
            .bad      { background-color:#aa0000; }
            .ok       { background-color:#aa0000; }
            .good     { background-color:#00aa00; }
            .excelent { background-color:#00ff00; }
            td { padding:3px 10px; }
            td:last-child { text-align:right; }
        </style>
    </header>
<body>
<?php
// Connecting, selecting database
$link = mysql_connect('10.15.20.110', 'dshini', 'S:zVbBhbOn*]hF*0=.BCCESD1')
    or die('Could not connect: ' . mysql_error());
#echo 'Connected successfully';
mysql_select_db('rezeptDshini') or die('Could not select database');
mysql_set_charset('utf8'); 

function getNumber($emotionalParam, $rationalParam){
    $query = 'SELECT COUNT(id) FROM recipe LEFT JOIN recipe_emotional ON recipe.id=recipe_emotional.recipe_id LEFT JOIN recipe_rational ON recipe.id=recipe_rational.recipe_id';
    if(!empty($emotionalParam) || !empty($rationalParam)){
        $query .= ' WHERE ';
        if(!empty($emotionalParam)){
            $query .= 'emotional_id=' . $emotionalParam;
        }
        if(!empty($emotionalParam) && !empty($rationalParam)){
            $query .= ' AND ';
        }
        if(!empty($rationalParam)){
            $query .= 'rational_id=' . $rationalParam;
        }
    }
    #echo "<br>$query<br>";
    
    $result = mysql_query($query) or die('Query failed: ' . mysql_error());
    
    $retVal = '0';
    // Printing results in HTML
    if ($line = mysql_fetch_row($result)) {
        $retVal = $line[0];
    }
    // Free resultset
    mysql_free_result($result);
    
    return $retVal;
}

$emotional = array(
      '1'=>'Überraschung',
      '2'=>'exotisch',
      '3'=>'deftig',
      '4'=>'leicht',
      '5'=>'mediterran',
      '6'=>'Basics'
      );
$rational = array(      
      '1'=>'mit Fleisch',
      '2'=>'mit Fisch',
      '3'=>'vegan',
      '4'=>'vegetarisch'      
);      

echo '<table>';
foreach($emotional as $emoKey => $emoValue) {
    foreach($rational as $ratioKey => $ratioValue) {
        $number = getNumber($emoKey, $ratioKey);
        echo '<tr class="';
        if($number > 30) {
            echo "excelent";
        }elseif($number > 15) {
            echo "good";
        }elseif($number > 10) {
            echo "ok";
        }elseif($number > 0) {
            echo "bad";
        }elseif($number == 0) {
            echo "critical";
        }
        echo '"><td>';
        echo "$emoValue und $ratioValue:";
        echo '</td><td>';
        echo $number;
        echo '</td></tr>';
    }
}      
echo '</table>';


// Closing connection
mysql_close($link);
?>
</body>
</html>
