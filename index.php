<?php

$dbopts = parse_url(getenv('DATABASE_URL'));
echo var_dump($dbopts);
$zica = array('pdo.dsn' => 'pgsql:dbname='.ltrim($dbopts["path"],'/').';host='.$dbopts["host"] . ';port=' . $dbopts["port"], 'pdo.username' => $dbopts["user"], 'pdo.password' => $dbopts["pass"]);

echo var_dump($zica);
echo 'aqui';
$app->register(new Herrera\Pdo\PdoServiceProvider(), $zica);


$app->get('/db/', function() use($app) {
  $st = $app['pdo']->prepare('SELECT name FROM test_table');
  $st->execute();

  $names = array();
  while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
    $app['monolog']->addDebug('Row ' . $row['name']);
    $names[] = $row;
  }

  return $app['twig']->render('database.twig', array(
    'names' => $names
  ));
});




?>
