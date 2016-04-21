<?php

$dbopts = parse_url(getenv('DATABASE_URL'));
echo var_dump($dbopts);
$zica = array('pdo.dsn' => 'pgsql:dbname='.ltrim($dbopts["path"],'/').';host='.$dbopts["host"] . ';port=' . $dbopts["port"], 'pdo.username' => $dbopts["user"], 'pdo.password' => $dbopts["pass"]);
echo 'aqui<br><br>';
echo var_dump($zica);
echo 'aqui<br><br>';

$dsn = "pgsql:"
    . "host=ec2-79-125-126-192.eu-west-1.compute.amazonaws.com;"
    . "dbname=dlvqngd1fqchp;"
    . "user=vhghkfpdfmtiro;"
    . "port=5432;"
    . "sslmode=require;"
    . "password=1xYS19qztYiYuSdUBhuKDBQ6K1";

$db = new PDO($dsn);

$query = "CREATE TABLE employees ("
    . "employee_id SERIAL,"
    . "last_name VARCHAR(30),"
    . "first_name VARCHAR(30),"
    . "title VARCHAR(50)"
    . ");";
$result = $db->query($query);
echo var_dump($result);
echo 'aqui<br><br>';

$query = "INSERT INTO employees (last_name, first_name, title) VALUES"
    . "('Abreu', 'Mark', 'Project Coordinator'),"
    . "('Nyman', 'Larry', 'Security Engineer'),"
    . "('Simmons', 'Iris', 'Software Architect'),"
    . "('Miller', 'Anthony', 'Marketing Manager'),"
    . "('Leigh', 'Stephen', 'UI Developer'),"
    . "('Lee', 'Sonia', 'Business Analyst');";
$result = $db->query($query);
echo var_dump($result);
echo 'aqui<br><br>';

$query = "SELECT employee_id, last_name, first_name, title "
    . "FROM employees ORDER BY last_name ASC, first_name ASC";
$result = $db->query($query);
echo var_dump($result);
echo 'aqui<br><br>';

while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr>";
    echo "<td>" . $row["employee_id"] . "</td>";
    echo "<td>" . htmlspecialchars($row["last_name"]) . "</td>";
    echo "<td>" . htmlspecialchars($row["first_name"]) . "</td>";
    echo "<td>" . htmlspecialchars($row["title"]) . "</td>";
    echo "</tr>";
}
$result->closeCursor();

//$app->register(new Herrera\Pdo\PdoServiceProvider(), $zica);
echo 'aqui<br><br>';

?>
