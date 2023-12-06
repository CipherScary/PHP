<?php

// Danilo Alves e Sebastiao

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "atvphp";

// Conectar ao banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}

// SQL para criar tabela funcionarios
$sqlCriarTabelaFuncionarios = "CREATE TABLE IF NOT EXISTS funcionarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    cargo VARCHAR(50) NOT NULL
)";

if ($conn->query($sqlCriarTabelaFuncionarios) === TRUE) {
    echo "Tabela 'funcionarios' criada com sucesso ou já existe.<br>";
} else {
    echo "Erro ao criar tabela 'funcionarios': " . $conn->error . "<br>";
}

// SQL para criar tabela departamentos
$sqlCriarTabelaDepartamentos = "CREATE TABLE IF NOT EXISTS departamentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL
)";

if ($conn->query($sqlCriarTabelaDepartamentos) === TRUE) {
    echo "Tabela 'departamentos' criada com sucesso ou já existe.<br>";
} else {
    echo "Erro ao criar tabela 'departamentos': " . $conn->error . "<br>";
}

// ID do funcionário a ser removido
$idFuncionario = 1; // Substitua pelo ID do funcionário que deseja excluir

// Iniciar transação
$conn->begin_transaction();

try {
    // Remover todas as associações do funcionário com departamentos na tabela departamentos
    $sqlRemoverAssociacoes = "DELETE FROM departamentos WHERE id_funcionario = ?";
    $stmtRemoverAssociacoes = $conn->prepare($sqlRemoverAssociacoes);
    $stmtRemoverAssociacoes->bind_param("i", $idFuncionario);
    $stmtRemoverAssociacoes->execute();

    // Remover o funcionário na tabela funcionarios
    $sqlRemoverFuncionario = "DELETE FROM funcionarios WHERE id = ?";
    $stmtRemoverFuncionario = $conn->prepare($sqlRemoverFuncionario);
    $stmtRemoverFuncionario->bind_param("i", $idFuncionario);
    $stmtRemoverFuncionario->execute();

    // Commit da transação
    $conn->commit();

    echo "Funcionário e associações com departamentos removidos com sucesso!";
} catch (Exception $e) {
    // Rollback em caso de erro
    $conn->rollback();
    echo "Erro ao remover funcionário e associações com departamentos: " . $e->getMessage();
}

// Fechar a conexão
$conn->close();
?>
