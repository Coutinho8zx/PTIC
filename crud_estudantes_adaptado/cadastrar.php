<?php
require "conexao.php";
require "funcoes.php";

$erro = "";
$nome = "";
$idade = "";
$telefone = "";
$cpf = "";
$professores = buscarCPFsProfessores($pdo);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    verificarToken();
    $nome = trim($_POST["nome"] ?? "");
    $idade = trim($_POST["idade"] ?? "");
    $telefone = trim($_POST["telefone"] ?? "");
    $cpf = trim($_POST["cpf"] ?? "");

    if ($nome === "" || strlen($nome) > 67) {
        $erro = "Informe um nome com até 67 caracteres.";
    } elseif ($idade === "" || strlen($idade) > 67) {
        $erro = "Informe uma idade válida.";
    } elseif ($telefone === "" || strlen($telefone) > 67) {
        $erro = "Informe um telefone com até 67 caracteres.";
    } elseif ($cpf === "" || strlen($cpf) > 90 || !professorExiste($pdo, $cpf)) {
        $erro = "Selecione um CPF que exista na tabela professores.";
    } else {
        try {
            $sql = "INSERT INTO aluno (Nome, Idade, Numero_Telefone, CPF)
                    VALUES (:nome, :idade, :telefone, :cpf)";
            $consulta = $pdo->prepare($sql);
            $consulta->execute([
                ":nome" => $nome,
                ":idade" => $idade,
                ":telefone" => $telefone,
                ":cpf" => $cpf
            ]);
            header("Location: listar.php?sucesso=" . urlencode("Aluno cadastrado com sucesso!"));
            exit;
        } catch (PDOException $e) {
            $erro = "Não foi possível cadastrar. Verifique se esse CPF já está cadastrado como aluno.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar aluno</title>
</head>
<body>
    <h1>Cadastrar aluno</h1>
    <?php if ($erro !== "") { ?><p><?= escapar($erro) ?></p><?php } ?>

    <?php if (count($professores) === 0) { ?>
        <p>Não há CPFs cadastrados na tabela professores. Por causa da relação atual do banco, é necessário cadastrar um professor primeiro.</p>
    <?php } else { ?>
    <form method="POST">
        <input type="hidden" name="token" value="<?= escapar($_SESSION["token"]) ?>">
        <p><label for="nome">Nome:</label><br>
        <input type="text" id="nome" name="nome" maxlength="67" value="<?= escapar($nome) ?>" required></p>

        <p><label for="idade">Idade:</label><br>
        <input type="text" id="idade" name="idade" maxlength="67" value="<?= escapar($idade) ?>" required></p>

        <p><label for="telefone">Número de telefone:</label><br>
        <input type="text" id="telefone" name="telefone" maxlength="67" value="<?= escapar($telefone) ?>" required></p>

        <p><label for="cpf">CPF (deve existir na tabela professores):</label><br>
        <select id="cpf" name="cpf" required>
            <option value="">Selecione um CPF</option>
            <?php foreach ($professores as $professor) { ?>
                <option value="<?= escapar($professor["CPF"]) ?>" <?= $cpf === $professor["CPF"] ? "selected" : "" ?>>
                    <?= escapar($professor["CPF"]) ?> — <?= escapar($professor["Nome"]) ?>
                </option>
            <?php } ?>
        </select></p>
        <button type="submit">Cadastrar</button>
    </form>
    <?php } ?>
    <p><a href="listar.php">Voltar para a lista</a></p>
</body>
</html>
