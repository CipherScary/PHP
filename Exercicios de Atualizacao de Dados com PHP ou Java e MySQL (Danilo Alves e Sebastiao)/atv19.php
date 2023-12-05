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

// Criar tabela eventos
$sqlCreateEventos = "CREATE TABLE eventos (
    id_evento INT PRIMARY KEY,
    nome_evento VARCHAR(255) NOT NULL,
    data DATE
)";

// Criar tabela participantes
$sqlCreateParticipantes = "CREATE TABLE participantes (
    id_participante INT PRIMARY KEY,
    id_evento INT,
    nome_participante VARCHAR(255) NOT NULL,
    FOREIGN KEY (id_evento) REFERENCES eventos(id_evento)
)";

if ($conn->query($sqlCreateEventos) === TRUE && $conn->query($sqlCreateParticipantes) === TRUE) {
    echo "Tabelas 'eventos' e 'participantes' criadas com sucesso.\n";

    // Inserir dados nas tabelas
    $sqlInsertEventos = "INSERT INTO eventos (id_evento, nome_evento, data) VALUES
        (1, 'Conferência de Tecnologia', '2023-12-15'),
        (2, 'Workshop de Marketing Digital', '2023-11-20')";

    $sqlInsertParticipantes = "INSERT INTO participantes (id_participante, id_evento, nome_participante) VALUES
        (1, 1, 'Gabriel'),
        (2, 2, 'Sofia')";

    if ($conn->query($sqlInsertEventos) === TRUE && $conn->query($sqlInsertParticipantes) === TRUE) {
        echo "Dados inseridos com sucesso.\n";

        // Atualizar informações do evento
        $sqlUpdateEvento1 = "UPDATE eventos SET nome_evento = 'Conferência de Tecnologia Avançada', data = '2024-01-10' WHERE id_evento = 1";
        $sqlUpdateEvento2 = "UPDATE eventos SET nome_evento = 'Workshop de Marketing Digital Atualizado', data = '2023-12-01' WHERE id_evento = 2";

        // Atualizar informações do participante associado ao evento 1
        $sqlUpdateParticipante1 = "UPDATE participantes SET nome_participante = 'Gabriel Silva' WHERE id_participante = 1";

        // Adicionar novo participante associado ao evento 2
        $sqlInsertNovoParticipante = "INSERT INTO participantes (id_participante, id_evento, nome_participante) VALUES
            (3, 2, 'Mateus')";

        // Executar as consultas SQL de atualização
        if ($conn->query($sqlUpdateEvento1) === TRUE && $conn->query($sqlUpdateEvento2) === TRUE &&
            $conn->query($sqlUpdateParticipante1) === TRUE && $conn->query($sqlInsertNovoParticipante) === TRUE) {
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
