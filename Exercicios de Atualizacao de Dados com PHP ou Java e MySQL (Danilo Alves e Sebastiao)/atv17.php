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

// Criar tabela 'fornecedores'
$sqlCreateFornecedores = "CREATE TABLE fornecedores (
    id_fornecedor INT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    contato VARCHAR(255) NOT NULL
)";

// Criar tabela 'compras'
$sqlCreateCompras = "CREATE TABLE compras (
    id_compra INT PRIMARY KEY,
    id_fornecedor INT,
    produto_comprado VARCHAR(255) NOT NULL,
    quantidade INT,
    FOREIGN KEY (id_fornecedor) REFERENCES fornecedores(id_fornecedor)
)";

if ($conn->query($sqlCreateFornecedores) === TRUE && $conn->query($sqlCreateCompras) === TRUE) {
    echo "Tabelas 'fornecedores' e 'compras' criadas com sucesso.\n";

    // Inserir dados nas tabelas
    $sqlInsertFornecedores = "INSERT INTO fornecedores (id_fornecedor, nome, contato) VALUES
        (1, 'Empresa A', 'contato@empresaA.com'),
        (2, 'Empresa B', 'contato@empresaB.com')";

    $sqlInsertCompras = "INSERT INTO compras (id_compra, id_fornecedor, produto_comprado, quantidade) VALUES
        (1, 1, 'Peças de computador', 100),
        (2, 2, 'Material de escritório', 500)";

    if ($conn->query($sqlInsertFornecedores) === TRUE && $conn->query($sqlInsertCompras) === TRUE) {
        echo "Dados inseridos com sucesso.\n";

        // Atualizar informações do fornecedor
        $sqlUpdateFornecedor1 = "UPDATE fornecedores SET nome = 'Empresa A Atualizada', contato = 'novocontato@empresaA.com' WHERE id_fornecedor = 1";
        $sqlUpdateFornecedor2 = "UPDATE fornecedores SET nome = 'Empresa B Atualizada', contato = 'novocontato@empresaB.com' WHERE id_fornecedor = 2";

        // Atualizar informações da compra associada ao fornecedor 1
        $sqlUpdateCompra1 = "UPDATE compras SET produto_comprado = 'Peças de computador atualizadas', quantidade = 150 WHERE id_compra = 1";

        // Atualizar informações da compra associada ao fornecedor 2
        $sqlUpdateCompra2 = "UPDATE compras SET produto_comprado = 'Material de escritório atualizado', quantidade = 600 WHERE id_compra = 2";

        // Executar as consultas SQL de atualização
        if ($conn->query($sqlUpdateFornecedor1) === TRUE && $conn->query($sqlUpdateFornecedor2) === TRUE &&
            $conn->query($sqlUpdateCompra1) === TRUE && $conn->query($sqlUpdateCompra2) === TRUE) {
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
