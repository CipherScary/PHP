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
    turma VARCHAR(10) NOT NULL
)";

if ($conn->query($sqlCreateAlunos) === TRUE) {
    echo "Tabela 'alunos' criada com sucesso.\n";
} else {
    echo "Erro ao criar tabela 'alunos': " . $conn->error . "\n";
}

// Criar tabela disciplinas
$sqlCreateDisciplinas = "CREATE TABLE disciplinas (
    id_disciplina INT PRIMARY KEY,
    nome_disciplina VARCHAR(255) NOT NULL,
    professor VARCHAR(255) NOT NULL
)";

if ($conn->query($sqlCreateDisciplinas) === TRUE) {
    echo "Tabela 'disciplinas' criada com sucesso.\n";
} else {
    echo "Erro ao criar tabela 'disciplinas': " . $conn->error . "\n";
}

// Inserir dados nas tabelas
$sqlInsertAlunos = "INSERT INTO alunos (id_aluno, nome, turma) VALUES
    (3, 'Paulo', 'C'),
    (4, 'Lúcia', 'B')";

$sqlInsertDisciplinas = "INSERT INTO disciplinas (id_disciplina, nome_disciplina, professor) VALUES
    (3, 'História', 'Professor Martins'),
    (4, 'Geografia', 'Professora Silva')";

if ($conn->query($sqlInsertAlunos) === TRUE && $conn->query($sqlInsertDisciplinas) === TRUE) {
    echo "Dados inseridos com sucesso.\n";

    // Atualizar informações do aluno
    $sqlUpdateAluno3 = "UPDATE alunos SET nome = 'Paulo Silva', turma = 'D' WHERE id_aluno = 3";
    $sqlUpdateAluno4 = "UPDATE alunos SET turma = 'C' WHERE id_aluno = 4";

    // Atualizar informações da disciplina associada ao aluno 3
    $sqlUpdateDisciplina3 = "UPDATE disciplinas SET nome_disciplina = 'Filosofia' WHERE id_disciplina = 3";

    // Adicionar nova disciplina associada ao aluno 4
    $sqlInsertNovaDisciplina = "INSERT INTO disciplinas (id_disciplina, nome_disciplina, professor) VALUES
        (5, 'Matemática', 'Professor Souza')";

    // Executar as consultas SQL de atualização
    if ($conn->query($sqlUpdateAluno3) === TRUE && $conn->query($sqlUpdateAluno4) === TRUE &&
        $conn->query($sqlUpdateDisciplina3) === TRUE && $conn->query($sqlInsertNovaDisciplina) === TRUE) {
        echo "Informações atualizadas com sucesso.\n";
    } else {
        echo "Erro na atualização: " . $conn->error . "\n";
    }
} else {
    echo "Erro ao inserir dados: " . $conn->error . "\n";
}

// Fechar a conexão
$conn->close();

?>
