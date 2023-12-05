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

// Criar tabela projetos
$sqlCreateProjetos = "CREATE TABLE projetos (
    id_projeto INT PRIMARY KEY,
    nome_projeto VARCHAR(255) NOT NULL,
    descricao VARCHAR(255) NOT NULL
)";

// Criar tabela atribuicoes
$sqlCreateAtribuicoes = "CREATE TABLE atribuicoes (
    id_atribuicao INT PRIMARY KEY,
    id_projeto INT,
    id_funcionario INT,
    FOREIGN KEY (id_projeto) REFERENCES projetos(id_projeto),
    FOREIGN KEY (id_funcionario) REFERENCES funcionarios(id_funcionario)
)";

if ($conn->query($sqlCreateProjetos) === TRUE && $conn->query($sqlCreateAtribuicoes) === TRUE) {
    echo "Tabelas 'projetos' e 'atribuicoes' criadas com sucesso.\n";

    // Inserir dados nas tabelas
    $sqlInsertProjetos = "INSERT INTO projetos (id_projeto, nome_projeto, descricao) VALUES
        (1, 'Sistema de Controle', 'Desenvolvimento de um sistema interno'),
        (2, 'Portal Corporativo', 'Desenvolvimento de um portal para clientes')";

    $sqlInsertAtribuicoes = "INSERT INTO atribuicoes (id_atribuicao, id_projeto, id_funcionario) VALUES
        (1, 1, 1),
        (2, 2, 2)";

    if ($conn->query($sqlInsertProjetos) === TRUE && $conn->query($sqlInsertAtribuicoes) === TRUE) {
        echo "Dados inseridos com sucesso.\n";

        // Atualizar informações do projeto
        $sqlUpdateProjeto1 = "UPDATE projetos SET nome_projeto = 'Sistema de Controle Atualizado', descricao = 'Desenvolvimento de um sistema interno aprimorado' WHERE id_projeto = 1";

        $sqlUpdateProjeto2 = "UPDATE projetos SET nome_projeto = 'Portal Corporativo Atualizado', descricao = 'Desenvolvimento de um portal para clientes melhorado' WHERE id_projeto = 2";

        // Atualizar informações da atribuição associada ao projeto 1
        $sqlUpdateAtribuicao1 = "UPDATE atribuicoes SET id_funcionario = 3 WHERE id_projeto = 1";

        // Atualizar informações da atribuição associada ao projeto 2
        $sqlUpdateAtribuicao2 = "UPDATE atribuicoes SET id_funcionario = 4 WHERE id_projeto = 2";

        // Executar as consultas SQL de atualização
        if ($conn->query($sqlUpdateProjeto1) === TRUE && $conn->query($sqlUpdateProjeto2) === TRUE &&
            $conn->query($sqlUpdateAtribuicao1) === TRUE && $conn->query($sqlUpdateAtribuicao2) === TRUE) {
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
