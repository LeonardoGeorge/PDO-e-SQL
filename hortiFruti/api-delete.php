<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once 'db.php';

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->id)) {
    try {
        $stmt = $pdo->prepare("UPDATE frutas SET data_remocao = CURRENT_TIMESTAMP WHERE id = :id");
        $stmt->bindParam(':id', $data->id);

        if ($stmt->execute()) {
            http_response_code(200);
            echo json_encode(array("message" => "Fruta removida com sucesso."));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Não foi possível remover a fruta."));
        }
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(array("message" => "Erro ao remover fruta: " . $e->getMessage()));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Dados incompletos. Forneça o ID da fruta."));
}
?>