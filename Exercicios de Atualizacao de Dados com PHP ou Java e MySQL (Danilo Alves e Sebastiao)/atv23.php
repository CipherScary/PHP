<?php

// Danilo Alves e Sebastiao

// Configurações do banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "atvjava";

// Conectar ao banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Criar tabela 'funcionarios'
$sqlCreateFuncionarios = "CREATE TABLE funcionarios (
    id_funcionario INT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    cargo VARCHAR(255) NOT NULL
)";

if ($conn->query($sqlCreateFuncionarios) === TRUE) {
    echo "Tabela 'funcionarios' criada com sucesso.\n";
} else {
    echo "Erro ao criar tabela 'funcionarios': " . $conn->error . "\n";
}

// Criar tabela 'projetos'
$sqlCreateProjetos = "CREATE TABLE projetos (
    id_projeto INT PRIMARY KEY,
    nome_projeto VARCHAR(255) NOT NULL,
    descricao TEXT
)";

if ($conn->query($sqlCreateProjetos) === TRUE) {
    echo "Tabela 'projetos' criada com sucesso.\n";
} else {
    echo "Erro ao criar tabela 'projetos': " . $conn->error . "\n";
}

// Inserir dados nas tabelas
$sqlInsertFuncionarios = "INSERT INTO funcionarios (id_funcionario, nome, cargo) VALUES
    (3, 'Pedro', 'Desenvolvedor'),
    (4, 'Mariana', 'Analista de Dados')";

$sqlInsertProjetos = "INSERT INTO projetos (id_projeto, nome_projeto, descricao) VALUES
    (3, 'Nova Plataforma Online', 'Desenvolvimento de uma nova plataforma web'),
    (4, 'Análise de Dados', 'Estudo e análise de grandes conjuntos de dados')";

if ($conn->query($sqlInsertFuncionarios) === TRUE && $conn->query($sqlInsertProjetos) === TRUE) {
    echo "Dados inseridos com sucesso.\n";

    // Atualizar informações do funcionário
    $sqlUpdateFuncionario3 = "UPDATE funcionarios SET nome = 'Pedro Silva', cargo = 'Desenvolvedor Sênior' WHERE id_funcionario = 3";
    $sqlUpdateFuncionario4 = "UPDATE funcionarios SET nome = 'Mariana Oliveira', cargo = 'Analista de Dados Sênior' WHERE id_funcionario = 4";

    // Atualizar informações do projeto associado ao funcionário 3
    $sqlUpdateProjeto3 = "UPDATE projetos SET nome_projeto = 'Plataforma Online Avançada' WHERE id_projeto = 3";

    // Adicionar novo projeto associado ao funcionário 4
    $sqlInsertNovoProjeto = "INSERT INTO projetos (id_projeto, nome_projeto, descricao) VALUES
        (5, 'Análise de Dados Avançada', 'Estudo aprofundado e análise de grandes conjuntos de dados')";

    // Executar as consultas SQL de atualização
    if ($conn->query($sqlUpdateFuncionario3) === TRUE && $conn->query($sqlUpdateFuncionario4) === TRUE &&
        $conn->query($sqlUpdateProjeto3) === TRUE && $conn->query($sqlInsertNovoProjeto) === TRUE) {
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
