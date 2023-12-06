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

// SQL para criar tabela fornecedores
$sqlCriarTabelaFornecedores = "CREATE TABLE IF NOT EXISTS fornecedores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    endereco VARCHAR(100) NOT NULL
)";

if ($conn->query($sqlCriarTabelaFornecedores) === TRUE) {
    echo "Tabela 'fornecedores' criada com sucesso ou já existe.<br>";
} else {
    echo "Erro ao criar tabela 'fornecedores': " . $conn->error . "<br>";
}

// SQL para criar tabela compras
$sqlCriarTabelaCompras = "CREATE TABLE IF NOT EXISTS compras (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_fornecedor INT NOT NULL,
    produto VARCHAR(50) NOT NULL,
    quantidade INT NOT NULL,
    FOREIGN KEY (id_fornecedor) REFERENCES fornecedores(id) ON DELETE CASCADE
)";

if ($conn->query($sqlCriarTabelaCompras) === TRUE) {
    echo "Tabela 'compras' criada com sucesso ou já existe.<br>";
} else {
    echo "Erro ao criar tabela 'compras': " . $conn->error . "<br>";
}

// ID do fornecedor a ser excluído
$idFornecedor = 1; // Substitua pelo ID do fornecedor que deseja excluir

// Iniciar transação
$conn->begin_transaction();

try {
    // Excluir todas as compras associadas ao fornecedor na tabela compras
    $sqlExcluirCompras = "DELETE FROM compras WHERE id_fornecedor = ?";
    $stmtExcluirCompras = $conn->prepare($sqlExcluirCompras);
    $stmtExcluirCompras->bind_param("i", $idFornecedor);
    $stmtExcluirCompras->execute();

    // Excluir o fornecedor na tabela fornecedores
    $sqlExcluirFornecedor = "DELETE FROM fornecedores WHERE id = ?";
    $stmtExcluirFornecedor = $conn->prepare($sqlExcluirFornecedor);
    $stmtExcluirFornecedor->bind_param("i", $idFornecedor);
    $stmtExcluirFornecedor->execute();

    // Commit da transação
    $conn->commit();

    echo "Fornecedor e compras associadas removidos com sucesso!";
} catch (Exception $e) {
    // Rollback em caso de erro
    $conn->rollback();
    echo "Erro ao excluir fornecedor e compras associadas: " . $e->getMessage();
}

// Fechar a conexão
$conn->close();
?>
