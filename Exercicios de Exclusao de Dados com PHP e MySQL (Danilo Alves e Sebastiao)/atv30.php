<?php

// Danilo Alves e Sebastiao

$servername = "seu_servidor";
$username = "seu_usuario";
$password = "sua_senha";
$dbname = "seu_banco_de_dados";

// Conectar ao banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}

// SQL para criar tabela projetos
$sqlCriarTabelaProjetos = "CREATE TABLE IF NOT EXISTS projetos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL
)";

if ($conn->query($sqlCriarTabelaProjetos) === TRUE) {
    echo "Tabela 'projetos' criada com sucesso ou já existe.<br>";
} else {
    echo "Erro ao criar tabela 'projetos': " . $conn->error . "<br>";
}

// SQL para criar tabela atribuicoes
$sqlCriarTabelaAtribuicoes = "CREATE TABLE IF NOT EXISTS atribuicoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_projeto INT NOT NULL,
    nome_funcionario VARCHAR(50) NOT NULL,
    FOREIGN KEY (id_projeto) REFERENCES projetos(id) ON DELETE CASCADE
)";

if ($conn->query($sqlCriarTabelaAtribuicoes) === TRUE) {
    echo "Tabela 'atribuicoes' criada com sucesso ou já existe.<br>";
} else {
    echo "Erro ao criar tabela 'atribuicoes': " . $conn->error . "<br>";
}

// ID do projeto a ser excluído
$idProjeto = 1; // Substitua pelo ID do projeto que deseja excluir

// Iniciar transação
$conn->begin_transaction();

try {
    // Excluir todas as atribuições associadas ao projeto na tabela atribuicoes
    $sqlExcluirAtribuicoes = "DELETE FROM atribuicoes WHERE id_projeto = ?";
    $stmtExcluirAtribuicoes = $conn->prepare($sqlExcluirAtribuicoes);
    $stmtExcluirAtribuicoes->bind_param("i", $idProjeto);
    $stmtExcluirAtribuicoes->execute();

    // Excluir o projeto na tabela projetos
    $sqlExcluirProjeto = "DELETE FROM projetos WHERE id = ?";
    $stmtExcluirProjeto = $conn->prepare($sqlExcluirProjeto);
    $stmtExcluirProjeto->bind_param("i", $idProjeto);
    $stmtExcluirProjeto->execute();

    // Commit da transação
    $conn->commit();

    echo "Projeto e atribuições associadas removidos com sucesso!";
} catch (Exception $e) {
    // Rollback em caso de erro
    $conn->rollback();
    echo "Erro ao excluir projeto e atribuições associadas: " . $e->getMessage();
}

// Fechar a conexão
$conn->close();
?>
