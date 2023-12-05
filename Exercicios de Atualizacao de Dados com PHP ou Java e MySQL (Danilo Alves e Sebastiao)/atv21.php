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

// Criar tabela 'usuarios'
$sqlCreateUsuarios = "CREATE TABLE usuarios (
    id_usuario INT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL
)";

if ($conn->query($sqlCreateUsuarios) === TRUE) {
    echo "Tabela 'usuarios' criada com sucesso.\n";
} else {
    echo "Erro ao criar tabela 'usuarios': " . $conn->error . "\n";
}

// Criar tabela 'compras'
$sqlCreateCompras = "CREATE TABLE compras (
    id_compra INT PRIMARY KEY,
    id_usuario INT,
    produto_comprado VARCHAR(255) NOT NULL,
    quantidade INT
)";

if ($conn->query($sqlCreateCompras) === TRUE) {
    echo "Tabela 'compras' criada com sucesso.\n";
} else {
    echo "Erro ao criar tabela 'compras': " . $conn->error . "\n";
}

// Inserir dados nas tabelas
$sqlInsertUsuarios = "INSERT INTO usuarios (id_usuario, nome, email) VALUES
    (3, 'Eduardo', 'eduardo@example.com'),
    (4, 'Laura', 'laura@example.com')";

$sqlInsertCompras = "INSERT INTO compras (id_compra, id_usuario, produto_comprado, quantidade) VALUES
    (3, 3, 'Livro de Ficção', 3),
    (4, 4, 'Fones de Ouvido', 1)";

if ($conn->query($sqlInsertUsuarios) === TRUE && $conn->query($sqlInsertCompras) === TRUE) {
    echo "Dados inseridos com sucesso.\n";

    // Atualizar informações do usuário
    $sqlUpdateUsuario3 = "UPDATE usuarios SET nome = 'Eduardo Silva', email = 'eduardo.silva@example.com' WHERE id_usuario = 3";
    $sqlUpdateUsuario4 = "UPDATE usuarios SET nome = 'Laura Oliveira', email = 'laura.oliveira@example.com' WHERE id_usuario = 4";

    // Atualizar informações da compra associada ao usuário 3
    $sqlUpdateCompra3 = "UPDATE compras SET produto_comprado = 'Livro de Aventura', quantidade = 2 WHERE id_compra = 3";

    // Adicionar nova compra associada ao usuário 4
    $sqlInsertNovaCompra = "INSERT INTO compras (id_compra, id_usuario, produto_comprado, quantidade) VALUES
        (5, 4, 'Caneta Esferográfica', 5)";

    // Executar as consultas SQL de atualização
    if ($conn->query($sqlUpdateUsuario3) === TRUE && $conn->query($sqlUpdateUsuario4) === TRUE &&
        $conn->query($sqlUpdateCompra3) === TRUE && $conn->query($sqlInsertNovaCompra) === TRUE) {
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
