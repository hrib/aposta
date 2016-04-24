<?php

$dbopts = parse_url(getenv('DATABASE_URL'));

$dsn = "pgsql:"
    . "host=" . $dbopts["host"] . ";"
    . "dbname=". ltrim($dbopts["path"],'/') . ";"
    . "user=" . $dbopts["user"] . ";"
    . "port=" . $dbopts["port"] . ";"
    . "sslmode=require;"
    . "password=" . $dbopts["pass"];
    

$db = new PDO($dsn);

$query = "DROP TABLE dados";
$result = $db->query($query);
echo var_dump($result);
echo 'aqui<br><br>';

$query = "CREATE TABLE dados ("
    . "id1 VARCHAR(30),"
    . "id2 VARCHAR(30),"
    . "id3 VARCHAR(50),"
    . "id4 VARCHAR(250)"
    . ");";
$result = $db->query($query);
echo var_dump($result);
echo 'aqui<br><br>';

$query = "INSERT INTO dados (id1, id2, id3, id4) VALUES"
    . "('brasilreal', '121011974285544429', '129b28ee403af9889f18c3fd6f3b9135c8', 'CAAX12OYYpZCPyZB0BADOeUcJtI94u9wZAvBPZAzz7be9DqZBBUxM1857DZCAi4WSX4VOhViZAJ5WMs7GoEp9fZC9k4NZBxH7ZBwIAW8JkFqNzbgN7ZB0a0cieHuIBwXfPAQlXFfuYoUZAEdLGqVQ6E3MGwmcpXJt8ycQUPcZCvPznY5RXSQAxhsKsCwZA50IN4ZByoEHZAiCLBHKEVprRZA5lwZDZD'),"
    . "('theball', '121011974285544429', '129b28ee403af9889f18c3fd6f3b9135c8', 'CAAX12OYYpZCPyZB0BANxJjtAtka6YZBaxB04IRK9pNYZC0VRLZCREZClhw3gXE0MZBaqZA6e7XAc8ZBZAL5exukNJVThSWVLtx1ZA7In8zc6idDIIlmcHhHnGzm3cbRDsApZBqmyNz7aDTAmlCSGCdzLZBanxZAvLRSiLTfK7jZBRPIYA9uyRNQ5H2mjetwgv0PcBDnZCnn4kHPwjbo7lvfXwZDZD'),"
    . "('xxx', 'xxxx', 'xxx', 'xx');";
$result = $db->query($query);
echo var_dump($result);
echo 'aqui<br><br>';

$query = "SELECT id1, id2, id3, id4 FROM dados";
$result = $db->query($query);
echo var_dump($result);
echo 'aqui<br><br>';

echo "<table>";
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr>";
    echo "<td>" . $row["id1"] . "</td>";
    echo "<td>" . htmlspecialchars($row["id2"]) . "</td>";
    echo "<td>" . htmlspecialchars($row["id3"]) . "</td>";
    echo "<td>" . htmlspecialchars($row["id4"]) . "</td>";
    echo "</tr>";
}
echo "</table>";
$result->closeCursor();

//$app->register(new Herrera\Pdo\PdoServiceProvider(), $zica);
echo 'aqui<br><br>';

?>
