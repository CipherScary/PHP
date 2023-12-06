<?php

// Danilo Alves e Sebastiao

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "atvphp";

// Conectar ao banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}

// SQL para criar tabela resultados_exames
$sqlCriarTabelaResultadosExames = "CREATE TABLE IF NOT EXISTS resultados_exames (
    id INT AUTO_INCREMENT PRIMARY KEY,
    descricao VARCHAR(100) NOT NULL,
    id_paciente INT NOT NULL,
    FOREIGN KEY (id_paciente) REFERENCES pacientes(id) ON DELETE CASCADE
)";

if ($conn->query($sqlCriarTabelaResultadosExames) === TRUE) {
    echo "Tabela 'resultados_exames' criada com sucesso ou já existe.<br>";
} else {
    echo "Erro ao criar tabela 'resultados_exames': " . $conn->error . "<br>";
}

// SQL para criar tabela pacientes
$sqlCriarTabelaPacientes = "CREATE TABLE IF NOT EXISTS pacientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    idade INT NOT NULL
)";

if ($conn->query($sqlCriarTabelaPacientes) === TRUE) {
    echo "Tabela 'pacientes' criada com sucesso ou já existe.<br>";
} else {
    echo "Erro ao criar tabela 'pacientes': " . $conn->error . "<br>";
}

// ID do resultado de exame a ser removido
$idResultadoExame = 1; // Substitua pelo ID do resultado de exame que deseja excluir

// Iniciar transação
$conn->begin_transaction();

try {
    // Remover o resultado de exame na tabela resultados_exames
    $sqlRemoverResultadoExame = "DELETE FROM resultados_exames WHERE id = ?";
    $stmtRemoverResultadoExame = $conn->prepare($sqlRemoverResultadoExame);
    $stmtRemoverResultadoExame->bind_param("i", $idResultadoExame);
    $stmtRemoverResultadoExame->execute();

    // Obter o ID do paciente associado ao resultado de exame
    $sqlObterIdPaciente = "SELECT id_paciente FROM resultados_exames WHERE id = ?";
    $stmtObterIdPaciente = $conn->prepare($sqlObterIdPaciente);
    $stmtObterIdPaciente->bind_param("i", $idResultadoExame);
    $stmtObterIdPaciente->execute();
    $stmtObterIdPaciente->bind_result($idPaciente);
    $stmtObterIdPaciente->fetch();
    $stmtObterIdPaciente->close();

    // Remover o paciente na tabela pacientes
    $sqlRemoverPaciente = "DELETE FROM pacientes WHERE id = ?";
    $stmtRemoverPaciente = $conn->prepare($sqlRemoverPaciente);
    $stmtRemoverPaciente->bind_param("i", $idPaciente);
    $stmtRemoverPaciente->execute();

    // Commit da transação
    $conn->commit();

    echo "Resultado de exame e dados do paciente removidos com sucesso!";
} catch (Exception $e) {
    // Rollback em caso de erro
    $conn->rollback();
    echo "Erro ao remover resultado de exame e dados do paciente: " . $e->getMessage();
}

// Fechar a conexão
$conn->close();
?>
