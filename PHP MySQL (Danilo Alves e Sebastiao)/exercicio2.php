<?php
// Conexão com o banco de dados (substitua pelos seus próprios dados)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "exerciciosbd";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Query para criar a tabela
$sql = "CREATE TABLE IF NOT EXISTS pessoas (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    idade INT(3) NOT NULL,
    sexo VARCHAR(1)
 )";

// Executar a query
if ($conn->query($sql) === TRUE) {
    echo "Tabela 'pessoas' criada com sucesso";
} else {
    echo "Erro ao criar tabela: " . $conn->error;
}

// Query para inserir dados
$sql = "INSERT INTO pessoas (nome, idade, sexo) VALUES
('João', 25, 'M'),
('Maria', 20, 'F')";

// Executar a query
if ($conn->query($sql) === TRUE) {
    echo "Dados inseridos com sucesso";
} else {
    echo "Erro ao inserir dados: " . $conn->error;
}

// Função para retornar todos os registros da tabela
function getAllPessoas($conn) {
    $sql = "SELECT * FROM pessoas";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        return "Nenhum resultado encontrado";
    }
}

// Exercício 4: Contando registros
function getTotalPessoas($conn) {
    $sql = "SELECT COUNT(*) as total FROM pessoas";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['total'];
    } else {
        return 0;
    }
}

// Exercício 5: Obtendo registro por ID
function getPessoaById($conn, $id) {
    $sql = "SELECT * FROM pessoas WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return "Nenhum resultado encontrado";
    }
}

// Exercício 6: Atualizando registros por ID
function updatePessoaById($conn, $id, $nome, $idade, $sexo) {
    $sql = "UPDATE pessoas SET nome = '$nome', idade = $idade, sexo = '$sexo' WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        return "Registro atualizado com sucesso";
    } else {
        return "Erro ao atualizar registro: " . $conn->error;
    }
}

// Uso da função para obter todos os registros
$data = getAllPessoas($conn);
echo "<pre>";
print_r($data);
echo "</pre>";

// Exemplo de uso das novas funções
echo "Total de Pessoas: " . getTotalPessoas($conn) . "<br>";

$idBusca = 1; // ID a ser buscado
$pessoa = getPessoaById($conn, $idBusca);
echo "Pessoa com ID $idBusca: " . print_r($pessoa, true) . "<br>";

$idUpdate = 1; // ID do registro a ser atualizado
$updateResult = updatePessoaById($conn, $idUpdate, "NovoNome", 30, "F");
echo "$updateResult <br>";

// Fechar a conexão
$conn->close();
?>
