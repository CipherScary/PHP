<?php

// Danilo Alves e Sebastiao

// Configurações do banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "atvphp";

// Conectar ao banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Criar tabela livros
$sqlCreateLivros = "CREATE TABLE livros (
    id_livro INT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    ano_publicacao INT
)";

// Criar tabela autores
$sqlCreateAutores = "CREATE TABLE autores (
    id_autor INT PRIMARY KEY,
    nome_autor VARCHAR(255) NOT NULL
)";

if ($conn->query($sqlCreateLivros) === TRUE && $conn->query($sqlCreateAutores) === TRUE) {
    echo "Tabelas 'livros' e 'autores' criadas com sucesso.\n";

    // Inserir dados nas tabelas
    $sqlInsertLivros = "INSERT INTO livros (id_livro, titulo, ano_publicacao) VALUES
        (1, 'Aprendendo Python', 2020),
        (2, 'Introdução à Inteligência Artificial', 2019)";

    $sqlInsertAutores = "INSERT INTO autores (id_autor, nome_autor) VALUES
        (1, 'Carlos Silva'),
        (2, 'Ana Souza')";

    if ($conn->query($sqlInsertLivros) === TRUE && $conn->query($sqlInsertAutores) === TRUE) {
        echo "Dados inseridos com sucesso.\n";

        // Atualizar informações do livro
        $sqlUpdateLivro1 = "UPDATE livros SET titulo = 'Aprendendo Python Avançado', ano_publicacao = 2022 WHERE id_livro = 1";
        $sqlUpdateLivro2 = "UPDATE livros SET titulo = 'Introdução à IA', ano_publicacao = 2021 WHERE id_livro = 2";

        // Atualizar informações do autor associado ao livro 1
        $sqlUpdateAutor1 = "UPDATE autores SET nome_autor = 'Carlos Silva Júnior' WHERE id_autor = 1";

        // Adicionar novo autor associado ao livro 2
        $sqlInsertNovoAutor = "INSERT INTO autores (id_autor, nome_autor) VALUES
            (3, 'Pedro Rocha')";

        // Executar as consultas SQL de atualização
        if ($conn->query($sqlUpdateLivro1) === TRUE && $conn->query($sqlUpdateLivro2) === TRUE &&
            $conn->query($sqlUpdateAutor1) === TRUE && $conn->query($sqlInsertNovoAutor) === TRUE) {
            echo "Informações atualizadas com sucesso.\n";
        } else {
            echo "Erro na atualização: " . $conn->error . "\n";
        }
    } else {
        echo "Erro ao inserir dados: " . $conn->error . "\n";
    }
} else {
    echo "Erro ao criar tabelas: " . $conn->error . "\n";
}

// Fechar a conexão
$conn->close();

?>
