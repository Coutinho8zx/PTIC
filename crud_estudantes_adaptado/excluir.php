<?php
require "conexao.php";
require "funcoes.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    die("Método não permitido.");
}
verificarToken();

$cpf = trim($_POST["cpf"] ?? "");
if ($cpf !== "") {
    $consulta = $pdo->prepare("DELETE FROM aluno WHERE CPF = :cpf");
    $consulta->execute([":cpf" => $cpf]);
}
header("Location: listar.php?sucesso=" . urlencode("Operação de exclusão concluída."));
exit;
?>
