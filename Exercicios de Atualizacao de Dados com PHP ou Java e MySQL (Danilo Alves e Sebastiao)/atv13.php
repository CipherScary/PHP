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

// Criar tabela 'clientes'
$sqlCreateClientes = "CREATE TABLE clientes (
    id_cliente INT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL
)";

if ($conn->query($sqlCreateClientes) === TRUE) {
    echo "Tabela 'clientes' criada com sucesso.\n";
} else {
    echo "Erro ao criar tabela 'clientes': " . $conn->error . "\n";
}

// Criar tabela 'vendas'
$sqlCreateVendas = "CREATE TABLE vendas (
    id_venda INT PRIMARY KEY,
    id_cliente INT,
    produto_vendido VARCHAR(255) NOT NULL,
    valor DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (id_cliente) REFERENCES clientes(id_cliente)
)";

if ($conn->query($sqlCreateVendas) === TRUE) {
    echo "Tabela 'vendas' criada com sucesso.\n";
} else {
    echo "Erro ao criar tabela 'vendas': " . $conn->error . "\n";
}

// Inserir dados nas tabelas
$sqlInsertClientes = "INSERT INTO clientes (id_cliente, nome, email) VALUES
    (1, 'Ana', 'ana@example.com'),
    (2, 'Pedro', 'pedro@example.com')";

$sqlInsertVendas = "INSERT INTO vendas (id_venda, id_cliente, produto_vendido, valor) VALUES
    (1, 1, 'Celular', 1200.00),
    (2, 2, 'Fones', 150.00)";

if ($conn->query($sqlInsertClientes) === TRUE && $conn->query($sqlInsertVendas) === TRUE) {
    echo "Dados inseridos com sucesso.\n";
} else {
    echo "Erro ao inserir dados: " . $conn->error . "\n";
}

// Atualizar informações do cliente
$sqlUpdateCliente1 = "UPDATE clientes SET nome = 'Ana Silva', email = 'ana.silva@example.com' WHERE id_cliente = 1";
$sqlUpdateCliente2 = "UPDATE clientes SET nome = 'Pedro Oliveira', email = 'pedro.oliveira@example.com' WHERE id_cliente = 2";

// Atualizar informações da venda associada ao cliente 1
$sqlUpdateVenda1 = "UPDATE vendas SET produto_vendido = 'Novo Celular', valor = 1300.00 WHERE id_cliente = 1";

// Atualizar informações da venda associada ao cliente 2
$sqlUpdateVenda2 = "UPDATE vendas SET produto_vendido = 'Fones Pro', valor = 180.00 WHERE id_cliente = 2";

// Executar as consultas SQL de atualização
if ($conn->query($sqlUpdateCliente1) === TRUE && $conn->query($sqlUpdateCliente2) === TRUE &&
    $conn->query($sqlUpdateVenda1) === TRUE && $conn->query($sqlUpdateVenda2) === TRUE) {
    echo "Informações atualizadas com sucesso.\n";
} else {
    echo "Erro na atualização: " . $conn->error . "\n";
}

// Fechar a conexão
$conn->close();

?>
