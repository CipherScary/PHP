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

// Criar tabela funcionarios
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

// Criar tabela departamentos
$sqlCreateDepartamentos = "CREATE TABLE departamentos (
    id_departamento INT PRIMARY KEY,
    nome_departamento VARCHAR(255) NOT NULL
)";

if ($conn->query($sqlCreateDepartamentos) === TRUE) {
    echo "Tabela 'departamentos' criada com sucesso.\n";
} else {
    echo "Erro ao criar tabela 'departamentos': " . $conn->error . "\n";
}

// Inserir dados nas tabelas
$sqlInsertFuncionarios = "INSERT INTO funcionarios (id_funcionario, nome, cargo) VALUES
    (1, 'Luiz', 'Analista'),
    (2, 'Carla', 'Gerente')";

$sqlInsertDepartamentos = "INSERT INTO departamentos (id_departamento, nome_departamento) VALUES
    (1, 'TI'),
    (2, 'Recursos Humanos')";

if ($conn->query($sqlInsertFuncionarios) === TRUE && $conn->query($sqlInsertDepartamentos) === TRUE) {
    echo "Dados inseridos com sucesso.\n";
} else {
    echo "Erro ao inserir dados: " . $conn->error . "\n";
}

// Atualizar informações do funcionário
$sqlUpdateFuncionario1 = "UPDATE funcionarios SET nome = 'Luiz Silva', cargo = 'Analista Sênior' WHERE id_funcionario = 1";
$sqlUpdateFuncionario2 = "UPDATE funcionarios SET nome = 'Carla Oliveira', cargo = 'Gerente de RH' WHERE id_funcionario = 2";

// Atualizar informações do departamento associado ao funcionário 1
$sqlUpdateDepartamento1 = "UPDATE departamentos SET nome_departamento = 'TI Avançado' WHERE id_departamento = 1";

// Atualizar informações do departamento associado ao funcionário 2
$sqlUpdateDepartamento2 = "UPDATE departamentos SET nome_departamento = 'Recursos Humanos Estratégico' WHERE id_departamento = 2";

// Executar as consultas SQL de atualização
if ($conn->query($sqlUpdateFuncionario1) === TRUE && $conn->query($sqlUpdateFuncionario2) === TRUE &&
    $conn->query($sqlUpdateDepartamento1) === TRUE && $conn->query($sqlUpdateDepartamento2) === TRUE) {
    echo "Informações atualizadas com sucesso.\n";
} else {
    echo "Erro na atualização: " . $conn->error . "\n";
}

// Fechar a conexão
$conn->close();

?>
