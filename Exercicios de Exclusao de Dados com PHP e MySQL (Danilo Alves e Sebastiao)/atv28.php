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

// SQL para criar tabela clientes
$sqlCriarTabelaClientes = "CREATE TABLE IF NOT EXISTS clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL
)";

if ($conn->query($sqlCriarTabelaClientes) === TRUE) {
    echo "Tabela 'clientes' criada com sucesso ou já existe.<br>";
} else {
    echo "Erro ao criar tabela 'clientes': " . $conn->error . "<br>";
}

// SQL para criar tabela vendas
$sqlCriarTabelaVendas = "CREATE TABLE IF NOT EXISTS vendas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_cliente INT NOT NULL,
    produto VARCHAR(50) NOT NULL,
    quantidade INT NOT NULL,
    FOREIGN KEY (id_cliente) REFERENCES clientes(id) ON DELETE CASCADE
)";

if ($conn->query($sqlCriarTabelaVendas) === TRUE) {
    echo "Tabela 'vendas' criada com sucesso ou já existe.<br>";
} else {
    echo "Erro ao criar tabela 'vendas': " . $conn->error . "<br>";
}

// ID do cliente a ser excluído
$idCliente = 1; // Substitua pelo ID do cliente que deseja excluir

// Iniciar transação
$conn->begin_transaction();

try {
    // Excluir todas as vendas associadas ao cliente na tabela vendas
    $sqlExcluirVendas = "DELETE FROM vendas WHERE id_cliente = ?";
    $stmtExcluirVendas = $conn->prepare($sqlExcluirVendas);
    $stmtExcluirVendas->bind_param("i", $idCliente);
    $stmtExcluirVendas->execute();

    // Excluir o cliente na tabela clientes
    $sqlExcluirCliente = "DELETE FROM clientes WHERE id = ?";
    $stmtExcluirCliente = $conn->prepare($sqlExcluirCliente);
    $stmtExcluirCliente->bind_param("i", $idCliente);
    $stmtExcluirCliente->execute();

    // Commit da transação
    $conn->commit();

    echo "Cliente e vendas associadas removidos com sucesso!";
} catch (Exception $e) {
    // Rollback em caso de erro
    $conn->rollback();
    echo "Erro ao excluir cliente e vendas associadas: " . $e->getMessage();
}

// Fechar a conexão
$conn->close();
?>
