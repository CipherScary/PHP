<?php

// Danilo ALves e Sebastiao

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

// SQL para criar tabela categorias
$sqlCriarTabelaCategorias = "CREATE TABLE IF NOT EXISTS categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL
)";

if ($conn->query($sqlCriarTabelaCategorias) === TRUE) {
    echo "Tabela 'categorias' criada com sucesso ou já existe.<br>";
} else {
    echo "Erro ao criar tabela 'categorias': " . $conn->error . "<br>";
}

// SQL para criar tabela produtos
$sqlCriarTabelaProdutos = "CREATE TABLE IF NOT EXISTS produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    descricao TEXT,
    preco DECIMAL(10, 2) NOT NULL,
    id_categoria INT,
    FOREIGN KEY (id_categoria) REFERENCES categorias(id) ON DELETE CASCADE
)";

if ($conn->query($sqlCriarTabelaProdutos) === TRUE) {
    echo "Tabela 'produtos' criada com sucesso ou já existe.<br>";
} else {
    echo "Erro ao criar tabela 'produtos': " . $conn->error . "<br>";
}

// ID do produto a ser excluído
$idProduto = 1; // Substitua pelo ID do produto que deseja excluir

// Iniciar transação
$conn->begin_transaction();

try {
    // Excluir as associações do produto com categorias na tabela categorias
    $sqlExcluirAssociacoes = "DELETE FROM produtos WHERE id = ?";
    $stmtExcluirAssociacoes = $conn->prepare($sqlExcluirAssociacoes);
    $stmtExcluirAssociacoes->bind_param("i", $idProduto);
    $stmtExcluirAssociacoes->execute();

    // Commit da transação
    $conn->commit();

    echo "Produto e associações removidos com sucesso!";
} catch (Exception $e) {
    // Rollback em caso de erro
    $conn->rollback();
    echo "Erro ao excluir produto e associações: " . $e->getMessage();
}

// Fechar a conexão
$conn->close();
?>
