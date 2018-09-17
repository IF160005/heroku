<?php

echo "Start<br/>";
$pass=getenv("DB_PASSWORD");
$user=getenv("DB_USER");
$host=getenv("DB_PASSWORD");
echo "Settings: $host $user $pass<br/>";


use PDO;
echo "Using PDO<br/>";

$dbConnection = new PDO($host, $user, $pass);
$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

echo "Connected<br/>";


try {
    $stmt = $this->dbConnection->prepare('select count(id) from orders');
    $stmt->execute();
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    echo $stmt->fetchColumn(); //grazina array sudaryta visa is eiluciu
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}