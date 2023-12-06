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

// SQL para criar tabela alunos
$sqlCriarTabelaAlunos = "CREATE TABLE IF NOT EXISTS alunos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    matricula VARCHAR(20) NOT NULL
)";

if ($conn->query($sqlCriarTabelaAlunos) === TRUE) {
    echo "Tabela 'alunos' criada com sucesso ou já existe.<br>";
} else {
    echo "Erro ao criar tabela 'alunos': " . $conn->error . "<br>";
}

// SQL para criar tabela cursos
$sqlCriarTabelaCursos = "CREATE TABLE IF NOT EXISTS cursos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL
)";

if ($conn->query($sqlCriarTabelaCursos) === TRUE) {
    echo "Tabela 'cursos' criada com sucesso ou já existe.<br>";
} else {
    echo "Erro ao criar tabela 'cursos': " . $conn->error . "<br>";
}

// Tabela de associação entre alunos e cursos
$sqlCriarTabelaAssociacao = "CREATE TABLE IF NOT EXISTS alunos_cursos (
    id_aluno INT NOT NULL,
    id_curso INT NOT NULL,
    PRIMARY KEY (id_aluno, id_curso),
    FOREIGN KEY (id_aluno) REFERENCES alunos(id) ON DELETE CASCADE,
    FOREIGN KEY (id_curso) REFERENCES cursos(id) ON DELETE CASCADE
)";

if ($conn->query($sqlCriarTabelaAssociacao) === TRUE) {
    echo "Tabela 'alunos_cursos' criada com sucesso ou já existe.<br>";
} else {
    echo "Erro ao criar tabela 'alunos_cursos': " . $conn->error . "<br>";
}

// ID do aluno a ser removido
$idAluno = 1; // Substitua pelo ID do aluno que deseja excluir

// Iniciar transação
$conn->begin_transaction();

try {
    // Remover todas as associações do aluno com cursos na tabela alunos_cursos
    $sqlRemoverAssociacoes = "DELETE FROM alunos_cursos WHERE id_aluno = ?";
    $stmtRemoverAssociacoes = $conn->prepare($sqlRemoverAssociacoes);
    $stmtRemoverAssociacoes->bind_param("i", $idAluno);
    $stmtRemoverAssociacoes->execute();

    // Remover o aluno na tabela alunos
    $sqlRemoverAluno = "DELETE FROM alunos WHERE id = ?";
    $stmtRemoverAluno = $conn->prepare($sqlRemoverAluno);
    $stmtRemoverAluno->bind_param("i", $idAluno);
    $stmtRemoverAluno->execute();

    // Commit da transação
    $conn->commit();

    echo "Aluno e associações com cursos removidos com sucesso!";
} catch (Exception $e) {
    // Rollback em caso de erro
    $conn->rollback();
    echo "Erro ao remover aluno e associações com cursos: " . $e->getMessage();
}

// Fechar a conexão
$conn->close();
?>
