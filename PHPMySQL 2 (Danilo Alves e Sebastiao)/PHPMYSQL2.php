<?php
// Conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lala";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Query para criar a tabela Pessoas
$sqlPessoas = "CREATE TABLE Pessoas (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    idade INT NOT NULL,
    sexo VARCHAR(1) NOT NULL,
    telefone VARCHAR(15),
    endereco VARCHAR(255),
    email VARCHAR(100)
)";

// Executar a query
if ($conn->query($sqlPessoas) === TRUE) {
    echo "Tabela 'Pessoas' criada com sucesso";
} else {
    echo "Erro ao criar tabela: " . $conn->error;
}

// Inserção de Dados Complexos
$sqlInsert = "INSERT INTO Pessoas (nome, idade, sexo, telefone, endereco, email) VALUES
('João', 25, 'M', '(123) 456-7890', 'Rua ABC, 123', 'joao@email.com'),
('Maria', 20, 'F', '(987) 654-3210', 'Rua XYZ, 456', 'maria@email.com')";

// Executar a query
if ($conn->query($sqlInsert) === TRUE) {
    echo "Dados inseridos com sucesso";
} else {
    echo "Erro ao inserir dados: " . $conn->error;
}

// Função para obter detalhes de uma pessoa
function getDetalhesPessoa($conn, $idPessoa)
{
    $sql = "SELECT Pessoas.id, Pessoas.nome, Pessoas.idade, Pessoas.sexo, 
            Pessoas.telefone, Pessoas.endereco, Pessoas.email
            FROM Pessoas
            WHERE Pessoas.id = $idPessoa";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return "Nenhum resultado encontrado";
    }
}

// Função para retornar todos os registros da tabela
function getAllPessoas($conn)
{
    $sql = "SELECT * FROM Pessoas";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        return "Nenhum resultado encontrado";
    }
}

// Contando registros
function getTotalPessoas($conn)
{
    $sql = "SELECT COUNT(*) as total FROM Pessoas";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['total'];
    } else {
        return 0;
    }
}

// Obtendo registro por ID
function getPessoaById($conn, $id)
{
    $sql = "SELECT * FROM Pessoas WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return "Nenhum resultado encontrado";
    }
}

// Atualizando registros por ID
function updatePessoaById($conn, $id, $nome, $idade, $sexo)
{
    $sql = "UPDATE Pessoas SET nome = '$nome', idade = $idade, sexo = '$sexo' WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        return "Registro atualizado com sucesso";
    } else {
        return "Erro ao atualizar registro: " . $conn->error;
    }
}

// Atualizando telefone, endereco e email por ID
function updateDetalhesPessoa($conn, $id, $telefone, $endereco, $email)
{
    $sql = "UPDATE Pessoas SET telefone = '$telefone', endereco = '$endereco', email = '$email' WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        return "Detalhes da pessoa atualizados com sucesso";
    } else {
        return "Erro ao atualizar detalhes da pessoa: " . $conn->error;
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

// Atualizando telefone, endereco e email por ID
$detalhesUpdateResult = updateDetalhesPessoa($conn, $idUpdate, '(555) 123-4567', 'Nova Rua, 789', 'novo@email.com');
echo "$detalhesUpdateResult <br>";

// Fechar a conexão
$conn->close();
?>
