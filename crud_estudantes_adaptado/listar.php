<?php
require "conexao.php";
require "funcoes.php";

$sql = "SELECT aluno.Nome, aluno.Idade, aluno.Numero_Telefone, aluno.CPF,
               professores.Nome AS NomeProfessor
        FROM aluno
        INNER JOIN professores ON aluno.CPF = professores.CPF
        ORDER BY aluno.Nome";
$alunos = $pdo->query($sql)->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alunos</title>
</head>
<body>
    <h1>Alunos cadastrados</h1>
    <?php if (isset($_GET["sucesso"])) { ?><p><?= escapar($_GET["sucesso"]) ?></p><?php } ?>
    <p><a href="cadastrar.php">Cadastrar aluno</a></p>

    <?php if (count($alunos) > 0) { ?>
        <?php foreach ($alunos as $aluno) { ?>
            <section>
                <p>
                    <strong>Nome:</strong> <?= escapar($aluno["Nome"]) ?><br>
                    <strong>Idade:</strong> <?= escapar($aluno["Idade"]) ?><br>
                    <strong>Telefone:</strong> <?= escapar($aluno["Numero_Telefone"]) ?><br>
                    <strong>CPF:</strong> <?= escapar($aluno["CPF"]) ?><br>
                    <strong>Professor correspondente:</strong> <?= escapar($aluno["NomeProfessor"]) ?>
                </p>
                <a href="editar.php?cpf=<?= urlencode($aluno["CPF"]) ?>">Editar</a>
                <form action="excluir.php" method="POST">
                    <input type="hidden" name="cpf" value="<?= escapar($aluno["CPF"]) ?>">
                    <input type="hidden" name="token" value="<?= escapar($_SESSION["token"]) ?>">
                    <button type="submit" onclick="return confirm('Tem certeza que deseja excluir este aluno?')">Excluir</button>
                </form>
                <hr>
            </section>
        <?php } ?>
    <?php } else { ?>
        <p>Nenhum aluno cadastrado.</p>
    <?php } ?>
</body>
</html>
