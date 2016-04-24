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
    . "('brasilreal', 'xxx', 'xxx', 'xxx'),"
    . "('theball', 'xxxx', 'xxx', 'xxxx'),"
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
