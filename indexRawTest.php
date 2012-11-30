<?php
header('Content-Type: text/html; charset=ASCII');

// Connecting, selecting database
$link = mysql_connect('10.15.20.110', 'dshini', 'S:zVbBhbOn*]hF*0=.BCCESD1')
    or die('Could not connect: ' . mysql_error());
#echo 'Connected successfully';
mysql_select_db('rezeptDshini') or die('Could not select database');
mysql_set_charset('utf8'); 

// Performing SQL query
$query = 'SELECT * FROM test ORDER BY RAND() LIMIT 1';
#echo "<br>$query<br>";

$result = mysql_query($query) or die('Query failed: ' . mysql_error());

// Printing results in HTML
$text = "::BEGIN<br>\n";
if ($line = mysql_fetch_assoc($result)) {
    $text .= $line['test'] . "<br>\n";
    $text .= "üöäßÜÖÄ<br>\n";
    $text .= "°¼½¾<br>\n";
}

echo $text;

// Free resultset
mysql_free_result($result);

// Closing connection
mysql_close($link);
?>
