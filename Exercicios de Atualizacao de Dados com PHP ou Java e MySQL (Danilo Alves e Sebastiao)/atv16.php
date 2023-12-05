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

// Criar tabela alunos
$sqlCreateAlunos = "CREATE TABLE alunos (
    id_aluno INT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    turma VARCHAR(255) NOT NULL
)";

// Criar tabela 'cursos'
$sqlCreateCursos = "CREATE TABLE cursos (
    id_curso INT PRIMARY KEY,
    nome_curso VARCHAR(255) NOT NULL,
    instrutor VARCHAR(255) NOT NULL
)";

if ($conn->query($sqlCreateAlunos) === TRUE && $conn->query($sqlCreateCursos) === TRUE) {
    echo "Tabelas 'alunos' e 'cursos' criadas com sucesso.\n";

    // Inserir dados nas tabelas
    $sqlInsertAlunos = "INSERT INTO alunos (id_aluno, nome, turma) VALUES
        (1, 'Lucas', 'A'),
        (2, 'Julia', 'B')";

    $sqlInsertCursos = "INSERT INTO cursos (id_curso, nome_curso, instrutor) VALUES
        (1, 'Matemática', 'Professor Carlos'),
        (2, 'Ciências', 'Professora Ana')";

    if ($conn->query($sqlInsertAlunos) === TRUE && $conn->query($sqlInsertCursos) === TRUE) {
        echo "Dados inseridos com sucesso.\n";

        // Atualizar informações do aluno
        $sqlUpdateAluno1 = "UPDATE alunos SET nome = 'Lucas Silva', turma = 'A+' WHERE id_aluno = 1";
        $sqlUpdateAluno2 = "UPDATE alunos SET nome = 'Julia Oliveira', turma = 'B+' WHERE id_aluno = 2";

        // Atualizar informações do curso associado ao aluno 1
        $sqlUpdateCurso1 = "UPDATE cursos SET nome_curso = 'Matemática Avançada', instrutor = 'Professor Carlos Silva' WHERE id_curso = 1";

        // Adicionar novo curso associado ao aluno 2
        $sqlInsertNovoCurso = "INSERT INTO cursos (id_curso, nome_curso, instrutor) VALUES
            (3, 'História', 'Professora Marcos')";

        // Executar as consultas SQL de atualização
        if ($conn->query($sqlUpdateAluno1) === TRUE && $conn->query($sqlUpdateAluno2) === TRUE &&
            $conn->query($sqlUpdateCurso1) === TRUE && $conn->query($sqlInsertNovoCurso) === TRUE) {
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
