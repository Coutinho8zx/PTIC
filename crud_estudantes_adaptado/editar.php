<?php
require "conexao.php";
require "funcoes.php";

$cpf = trim($_GET["cpf"] ?? "");
if ($cpf === "") {
    http_response_code(400);
    die("CPF inválido.");
}

$consulta = $pdo->prepare("SELECT Nome, Idade, Numero_Telefone, CPF FROM aluno WHERE CPF = :cpf");
$consulta->execute([":cpf" => $cpf]);
$aluno = $consulta->fetch();
if (!$aluno) {
    http_response_code(404);
    die("Aluno não encontrado.");
}

$erro = "";
$nome = $aluno["Nome"];
$idade = $aluno["Idade"];
$telefone = $aluno["Numero_Telefone"];
$professores = buscarCPFsProfessores($pdo);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    verificarToken();
    $nome = trim($_POST["nome"] ?? "");
    $idade = trim($_POST["idade"] ?? "");
    $telefone = trim($_POST["telefone"] ?? "");
    $novoCpf = trim($_POST["cpf"] ?? "");

    if ($nome === "" || strlen($nome) > 67) {
        $erro = "Informe um nome com até 67 caracteres.";
    } elseif ($idade === "" || strlen($idade) > 67) {
        $erro = "Informe uma idade válida.";
    } elseif ($telefone === "" || strlen($telefone) > 67) {
        $erro = "Informe um telefone válido.";
    } elseif ($novoCpf === "" || strlen($novoCpf) > 90 || !professorExiste($pdo, $novoCpf)) {
        $erro = "Selecione um CPF que exista na tabela professores.";
    } else {
        $sql = "UPDATE aluno SET Nome = :nome, Idade = :idade,
                Numero_Telefone = :telefone, CPF = :novoCpf WHERE CPF = :cpfAntigo";
        $consulta = $pdo->prepare($sql);
        try {
            $consulta->execute([
                ":nome" => $nome,
                ":idade" => $idade,
                ":telefone" => $telefone,
                ":novoCpf" => $novoCpf,
                ":cpfAntigo" => $cpf
            ]);
            header("Location: listar.php?sucesso=" . urlencode("Aluno atualizado com sucesso!"));
            exit;
        } catch (PDOException $e) {
            $erro = "Não foi possível atualizar. Verifique se o CPF selecionado já está sendo usado por outro aluno.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar aluno</title>
</head>
<body>
    <h1>Editar aluno</h1>
    <?php if ($erro !== "") { ?><p><?= escapar($erro) ?></p><?php } ?>
    <form method="POST">
        <input type="hidden" name="token" value="<?= escapar($_SESSION["token"]) ?>">
        <p><label for="nome">Nome:</label><br>
        <input type="text" id="nome" name="nome" maxlength="67" value="<?= escapar($nome) ?>" required></p>

        <p><label for="idade">Idade:</label><br>
        <input type="text" id="idade" name="idade" maxlength="67" value="<?= escapar($idade) ?>" required></p>

        <p><label for="telefone">Telefone:</label><br>
        <input type="text" id="telefone" name="telefone" maxlength="67" value="<?= escapar($telefone) ?>" required></p>

        <p><label for="cpf">CPF (deve existir na tabela professores):</label><br>
        <select id="cpf" name="cpf" required>
            <?php foreach ($professores as $professor) { ?>
                <option value="<?= escapar($professor["CPF"]) ?>" <?= $cpf === $professor["CPF"] ? "selected" : "" ?>>
                    <?= escapar($professor["CPF"]) ?> — <?= escapar($professor["Nome"]) ?>
                </option>
            <?php } ?>
        </select></p>
        <button type="submit">Salvar alterações</button>
    </form>
    <p><a href="listar.php">Voltar para a lista</a></p>
</body>
</html>
