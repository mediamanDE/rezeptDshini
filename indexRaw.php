<?php
$emotionalParam = $_GET['emo'];
$rationalParam = $_GET['ratio'];

// Connecting, selecting database
$link = mysql_connect('10.15.20.110', 'dshini', 'S:zVbBhbOn*]hF*0=.BCCESD1')
    or die('Could not connect: ' . mysql_error());
echo 'Connected successfully';
mysql_select_db('rezeptDshini') or die('Could not select database');

// Performing SQL query
$query = 'SELECT * FROM recipe LEFT JOIN recipe_emotional ON recipe.id=recipe_emotional.recipe_id LEFT JOIN recipe_rational ON recipe.id=recipe_rational.recipe_id';
if(!empty($emotionalParam) || !empty($rationalParam)){
    $query += ' WHERE ';
    if(!empty($emotionalParam)){
        $query += 'emotional_id=' + $emotionalParam;
    }
    if(!empty($emotionalParam) && !empty($rationalParam)){
        $query += ' AND ';
    }
    if(!empty($rationalParam)){
        $query += 'rational_id=' + $emotionalParam;
    }
}
echo $query;
$result = mysql_query($query) or die('Query failed: ' . mysql_error());

// Printing results in HTML
while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
    foreach ($line as $col_value) {
        echo "$col_value, ";
    }
    echo "<br>\n";
}

// Free resultset
mysql_free_result($result);

// Closing connection
mysql_close($link);
?>
