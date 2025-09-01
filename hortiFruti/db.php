<?php 
// bd.php
$host = "localhost";
$port = "5432";
$dbname = "loja";
$user = "postgres";
$password = "2501";

try {
    $pdo = new PDO("pgsql:host=$host;$port=$port;dbname=$dbname", $user, $password);
} catch (PDOException $e) {
    die ("Erro na conexão " . $e->getMessage());
}
?>
