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

// Criar tabela clientes
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

// Criar tabela pedidos
$sqlCreatePedidos = "CREATE TABLE pedidos (
    id_pedido INT PRIMARY KEY,
    id_cliente INT,
    produto VARCHAR(255) NOT NULL,
    quantidade INT
)";

if ($conn->query($sqlCreatePedidos) === TRUE) {
    echo "Tabela 'pedidos' criada com sucesso.\n";
} else {
    echo "Erro ao criar tabela 'pedidos': " . $conn->error . "\n";
}

// Inserir dados nas tabelas
$sqlInsertClientes = "INSERT INTO clientes (id_cliente, nome, email) VALUES
    (3, 'Rita', 'rita@example.com'),
    (4, 'Gabriel', 'gabriel@example.com')";

$sqlInsertPedidos = "INSERT INTO pedidos (id_pedido, id_cliente, produto, quantidade) VALUES
    (3, 3, 'Cadeira de Escritório', 2),
    (4, 4, 'Mochila', 1)";

if ($conn->query($sqlInsertClientes) === TRUE && $conn->query($sqlInsertPedidos) === TRUE) {
    echo "Dados inseridos com sucesso.\n";

    // Atualizar informações do cliente
    $sqlUpdateCliente3 = "UPDATE clientes SET nome = 'Rita Silva', email = 'rita.silva@example.com' WHERE id_cliente = 3";
    $sqlUpdateCliente4 = "UPDATE clientes SET nome = 'Gabriel Oliveira', email = 'gabriel.oliveira@example.com' WHERE id_cliente = 4";

    // Atualizar informações do pedido associado ao cliente 3
    $sqlUpdatePedido3 = "UPDATE pedidos SET produto = 'Mesa de Escritório', quantidade = 1 WHERE id_pedido = 3";

    // Adicionar novo pedido associado ao cliente 4
    $sqlInsertNovoPedido = "INSERT INTO pedidos (id_pedido, id_cliente, produto, quantidade) VALUES
        (5, 4, 'Teclado sem Fio', 2)";

    // Executar as consultas SQL de atualização
    if ($conn->query($sqlUpdateCliente3) === TRUE && $conn->query($sqlUpdateCliente4) === TRUE &&
        $conn->query($sqlUpdatePedido3) === TRUE && $conn->query($sqlInsertNovoPedido) === TRUE) {
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
