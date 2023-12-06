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

// SQL para criar tabela usuarios
$sqlCriarTabelaUsuarios = "CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL
)";

if ($conn->query($sqlCriarTabelaUsuarios) === TRUE) {
    echo "Tabela 'usuarios' criada com sucesso ou já existe.<br>";
} else {
    echo "Erro ao criar tabela 'usuarios': " . $conn->error . "<br>";
}

// SQL para criar tabela pedidos
$sqlCriarTabelaPedidos = "CREATE TABLE IF NOT EXISTS pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    produto VARCHAR(50) NOT NULL,
    quantidade INT NOT NULL,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id) ON DELETE CASCADE
)";

if ($conn->query($sqlCriarTabelaPedidos) === TRUE) {
    echo "Tabela 'pedidos' criada com sucesso ou já existe.<br>";
} else {
    echo "Erro ao criar tabela 'pedidos': " . $conn->error . "<br>";
}

// ID do usuário a ser excluído
$idUsuario = 1; // Substitua pelo ID do usuário que deseja excluir

// Iniciar transação
$conn->begin_transaction();

try {
    // Excluir pedidos associados ao usuário
    $sqlExcluirPedidos = "DELETE FROM pedidos WHERE id_usuario = ?";
    $stmtExcluirPedidos = $conn->prepare($sqlExcluirPedidos);
    $stmtExcluirPedidos->bind_param("i", $idUsuario);
    $stmtExcluirPedidos->execute();
    
    // Excluir o usuário
    $sqlExcluirUsuario = "DELETE FROM usuarios WHERE id = ?";
    $stmtExcluirUsuario = $conn->prepare($sqlExcluirUsuario);
    $stmtExcluirUsuario->bind_param("i", $idUsuario);
    $stmtExcluirUsuario->execute();

    // Commit da transação
    $conn->commit();

    echo "Usuário e pedidos excluídos com sucesso!";
} catch (Exception $e) {
    // Rollback em caso de erro
    $conn->rollback();
    echo "Erro ao excluir usuário e pedidos: " . $e->getMessage();
}

// Fechar a conexão
$conn->close();
?>

