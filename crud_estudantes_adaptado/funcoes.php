<?php
function escapar($valor) {
    return htmlspecialchars((string)$valor, ENT_QUOTES, "UTF-8");
}

function verificarToken() {
    $token = $_POST["token"] ?? "";
    if (!isset($_SESSION["token"]) || !hash_equals($_SESSION["token"], $token)) {
        http_response_code(403);
        die("Requisição inválida. Volte à página e tente novamente.");
    }
}

function buscarCPFsProfessores(PDO $pdo) {
    return $pdo->query("SELECT CPF, Nome FROM professores ORDER BY Nome")->fetchAll();
}

function professorExiste(PDO $pdo, $cpf) {
    $consulta = $pdo->prepare("SELECT CPF FROM professores WHERE CPF = :cpf");
    $consulta->execute([":cpf" => $cpf]);
    return (bool)$consulta->fetch();
}
?>
