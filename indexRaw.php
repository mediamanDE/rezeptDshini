<?php
header('Content-Type: text/html; charset=ASCII');

$emotionalParam = $_GET['emo'];
$rationalParam = $_GET['ratio'];

// Connecting, selecting database
$link = mysql_connect('10.15.20.110', 'dshini', 'S:zVbBhbOn*]hF*0=.BCCESD1')
    or die('Could not connect: ' . mysql_error());
#echo 'Connected successfully';
mysql_select_db('rezeptDshini') or die('Could not select database');
mysql_set_charset('utf8'); 

// Performing SQL query
$query = 'SELECT * FROM recipe LEFT JOIN recipe_emotional ON recipe.id=recipe_emotional.recipe_id LEFT JOIN recipe_rational ON recipe.id=recipe_rational.recipe_id';
if(!empty($emotionalParam) || !empty($rationalParam)){
    $query .= ' WHERE ';
    if(!empty($emotionalParam)){
        $query .= 'emotional_id=' . $emotionalParam;
    }
    if(!empty($emotionalParam) && !empty($rationalParam)){
        $query .= ' AND ';
    }
    if(!empty($rationalParam)){
        $query .= 'rational_id=' . $emotionalParam;
    }
}
$query .= ' ORDER BY RAND() LIMIT 1';
#echo "<br>$query<br>";

$result = mysql_query($query) or die('Query failed: ' . mysql_error());

// Printing results in HTML
$text = "::BEGIN<br>\n";
if ($line = mysql_fetch_assoc($result)) {
    $text .= "::L\n";
    $text .= $line['title'] . "\n";
    $text .= "::S\n";
    $text .= "::BOLD\n";
    $text .= "\n" . $line['ingredients'] . "\n\n";
    $text .= "::NORMAL\n";
    $text .= "::BOLD\n";
    $text .= "Zubereitungszeit:\n";
    $text .= "::NORMAL\n";
    $text .= $line['preparation_time'] . " Minuten\n\n";
    $text .= "::BOLD\n";
    $text .= "Zubereitung:\n";
    $text .= "::NORMAL\n";
    $text .= $line['preparation'] . "\n";
}

echo $text;

// Free resultset
mysql_free_result($result);

// Closing connection
mysql_close($link);
?>
