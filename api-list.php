<?php
header("Acess-Control-Allow-Origin: *");
header("Content-type: application/json; charset=UTF-8");

require_once 'db.php';

try {

    $stmt = $pdo->query(
        "SELECT id,
        nome,
        preco,
        data_criacao
        FROM frutas WHERE data_remocao IS NULL ORDER BY id");
    $frutas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($fruta);

} catch (PDOException $e) {

    http_response_code(500);
    echo json_encode(array("message" => "Erro ao buscar frutas: " . $e->getMessage()));

}
?>