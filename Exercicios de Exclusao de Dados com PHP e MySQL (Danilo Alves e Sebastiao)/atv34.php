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

// SQL para criar tabela eventos
$sqlCriarTabelaEventos = "CREATE TABLE IF NOT EXISTS eventos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    data_evento DATE NOT NULL
)";

if ($conn->query($sqlCriarTabelaEventos) === TRUE) {
    echo "Tabela 'eventos' criada com sucesso ou já existe.<br>";
} else {
    echo "Erro ao criar tabela 'eventos': " . $conn->error . "<br>";
}

// SQL para criar tabela participantes
$sqlCriarTabelaParticipantes = "CREATE TABLE IF NOT EXISTS participantes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    id_evento INT NOT NULL,
    FOREIGN KEY (id_evento) REFERENCES eventos(id) ON DELETE CASCADE
)";

if ($conn->query($sqlCriarTabelaParticipantes) === TRUE) {
    echo "Tabela 'participantes' criada com sucesso ou já existe.<br>";
} else {
    echo "Erro ao criar tabela 'participantes': " . $conn->error . "<br>";
}

// ID do evento a ser excluído
$idEvento = 1; // Substitua pelo ID do evento que deseja excluir

// Iniciar transação
$conn->begin_transaction();

try {
    // Excluir todos os participantes associados ao evento na tabela participantes
    $sqlExcluirParticipantes = "DELETE FROM participantes WHERE id_evento = ?";
    $stmtExcluirParticipantes = $conn->prepare($sqlExcluirParticipantes);
    $stmtExcluirParticipantes->bind_param("i", $idEvento);
    $stmtExcluirParticipantes->execute();

    // Excluir o evento na tabela eventos
    $sqlExcluirEvento = "DELETE FROM eventos WHERE id = ?";
    $stmtExcluirEvento = $conn->prepare($sqlExcluirEvento);
    $stmtExcluirEvento->bind_param("i", $idEvento);
    $stmtExcluirEvento->execute();

    // Commit da transação
    $conn->commit();

    echo "Evento e participantes associados removidos com sucesso!";
} catch (Exception $e) {
    // Rollback em caso de erro
    $conn->rollback();
    echo "Erro ao excluir evento e participantes associados: " . $e->getMessage();
}

// Fechar a conexão
$conn->close();
?>
