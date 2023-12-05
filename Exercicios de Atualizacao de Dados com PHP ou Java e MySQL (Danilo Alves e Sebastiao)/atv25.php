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

// Criar tabela vendedores
$sqlCreateVendedores = "CREATE TABLE vendedores (
    id_vendedor INT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    area_atuacao VARCHAR(255) NOT NULL
)";

if ($conn->query($sqlCreateVendedores) === TRUE) {
    echo "Tabela 'vendedores' criada com sucesso.\n";
} else {
    echo "Erro ao criar tabela 'vendedores': " . $conn->error . "\n";
}

// Criar tabela vendas
$sqlCreateVendas = "CREATE TABLE vendas (
    id_venda INT PRIMARY KEY,
    id_vendedor INT,
    produto_vendido VARCHAR(255) NOT NULL,
    valor DECIMAL(10, 2) NOT NULL
)";

if ($conn->query($sqlCreateVendas) === TRUE) {
    echo "Tabela 'vendas' criada com sucesso.\n";
} else {
    echo "Erro ao criar tabela 'vendas': " . $conn->error . "\n";
}

// Inserir dados nas tabelas
$sqlInsertVendedores = "INSERT INTO vendedores (id_vendedor, nome, area_atuacao) VALUES
    (3, 'Carlos', 'Eletrônicos'),
    (4, 'Sofia', 'Moda')";

$sqlInsertVendas = "INSERT INTO vendas (id_venda, id_vendedor, produto_vendido, valor) VALUES
    (3, 3, 'Smartphone', 1500.00),
    (4, 4, 'Vestido', 120.00)";

if ($conn->query($sqlInsertVendedores) === TRUE && $conn->query($sqlInsertVendas) === TRUE) {
    echo "Dados inseridos com sucesso.\n";

    // Atualizar informações do vendedor
    $sqlUpdateVendedor3 = "UPDATE vendedores SET nome = 'Carlos Silva', area_atuacao = 'Eletrônicos e Tecnologia' WHERE id_vendedor = 3";
    $sqlUpdateVendedor4 = "UPDATE vendedores SET area_atuacao = 'Moda Feminina' WHERE id_vendedor = 4";

    // Atualizar informações da venda associada ao vendedor 3
    $sqlUpdateVenda3 = "UPDATE vendas SET produto_vendido = 'Notebook', valor = 2000.00 WHERE id_venda = 3";

    // Adicionar nova venda associada ao vendedor 4
    $sqlInsertNovaVenda = "INSERT INTO vendas (id_venda, id_vendedor, produto_vendido, valor) VALUES
        (5, 4, 'Sapato', 80.00)";

    // Executar as consultas SQL de atualização
    if ($conn->query($sqlUpdateVendedor3) === TRUE && $conn->query($sqlUpdateVendedor4) === TRUE &&
        $conn->query($sqlUpdateVenda3) === TRUE && $conn->query($sqlInsertNovaVenda) === TRUE) {
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
