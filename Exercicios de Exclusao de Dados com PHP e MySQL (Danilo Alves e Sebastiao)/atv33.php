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

// SQL para criar tabela livros
$sqlCriarTabelaLivros = "CREATE TABLE IF NOT EXISTS livros (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(100) NOT NULL
)";

if ($conn->query($sqlCriarTabelaLivros) === TRUE) {
    echo "Tabela 'livros' criada com sucesso ou já existe.<br>";
} else {
    echo "Erro ao criar tabela 'livros': " . $conn->error . "<br>";
}

// SQL para criar tabela autores
$sqlCriarTabelaAutores = "CREATE TABLE IF NOT EXISTS autores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL
)";

if ($conn->query($sqlCriarTabelaAutores) === TRUE) {
    echo "Tabela 'autores' criada com sucesso ou já existe.<br>";
} else {
    echo "Erro ao criar tabela 'autores': " . $conn->error . "<br>";
}

// Tabela de associação entre livros e autores
$sqlCriarTabelaAssociacao = "CREATE TABLE IF NOT EXISTS livros_autores (
    id_livro INT NOT NULL,
    id_autor INT NOT NULL,
    PRIMARY KEY (id_livro, id_autor),
    FOREIGN KEY (id_livro) REFERENCES livros(id) ON DELETE CASCADE,
    FOREIGN KEY (id_autor) REFERENCES autores(id) ON DELETE CASCADE
)";

if ($conn->query($sqlCriarTabelaAssociacao) === TRUE) {
    echo "Tabela 'livros_autores' criada com sucesso ou já existe.<br>";
} else {
    echo "Erro ao criar tabela 'livros_autores': " . $conn->error . "<br>";
}

// ID do livro a ser removido
$idLivro = 1; // Substitua pelo ID do livro que deseja excluir

// Iniciar transação
$conn->begin_transaction();

try {
    // Remover todas as associações do livro com autores na tabela livros_autores
    $sqlRemoverAssociacoes = "DELETE FROM livros_autores WHERE id_livro = ?";
    $stmtRemoverAssociacoes = $conn->prepare($sqlRemoverAssociacoes);
    $stmtRemoverAssociacoes->bind_param("i", $idLivro);
    $stmtRemoverAssociacoes->execute();

    // Remover o livro na tabela livros
    $sqlRemoverLivro = "DELETE FROM livros WHERE id = ?";
    $stmtRemoverLivro = $conn->prepare($sqlRemoverLivro);
    $stmtRemoverLivro->bind_param("i", $idLivro);
    $stmtRemoverLivro->execute();

    // Commit da transação
    $conn->commit();

    echo "Livro e associações com autores removidos com sucesso!";
} catch (Exception $e) {
    // Rollback em caso de erro
    $conn->rollback();
    echo "Erro ao remover livro e associações com autores: " . $e->getMessage();
}

// Fechar a conexão
$conn->close();
?>
