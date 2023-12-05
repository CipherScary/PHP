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

// Criar tabela 'resultados_exames'
$sqlCreateResultadosExames = "CREATE TABLE resultados_exames (
    id_resultado INT PRIMARY KEY,
    tipo_exame VARCHAR(255) NOT NULL,
    resultado VARCHAR(255) NOT NULL
)";

if ($conn->query($sqlCreateResultadosExames) === TRUE) {
    echo "Tabela 'resultados_exames' criada com sucesso.\n";
} else {
    echo "Erro ao criar tabela 'resultados_exames': " . $conn->error . "\n";
}

// Criar tabela 'pacientes'
$sqlCreatePacientes = "CREATE TABLE pacientes (
    id_paciente INT PRIMARY KEY,
    nome_paciente VARCHAR(255) NOT NULL,
    data_nascimento DATE NOT NULL
)";

if ($conn->query($sqlCreatePacientes) === TRUE) {
    echo "Tabela 'pacientes' criada com sucesso.\n";
} else {
    echo "Erro ao criar tabela 'pacientes': " . $conn->error . "\n";
}

// Inserir dados nas tabelas
$sqlInsertResultadosExames = "INSERT INTO resultados_exames (id_resultado, tipo_exame, resultado) VALUES
    (1, 'Exame de Sangue', 'Normal'),
    (2, 'Raio-X', 'Fratura identificada')";

$sqlInsertPacientes = "INSERT INTO pacientes (id_paciente, nome_paciente, data_nascimento) VALUES
    (1, 'Mariana', '1995-06-10'),
    (2, 'Rafael', '1987-09-25')";

if ($conn->query($sqlInsertResultadosExames) === TRUE && $conn->query($sqlInsertPacientes) === TRUE) {
    echo "Dados inseridos com sucesso.\n";

    // Atualizar informações do resultado do exame
    $sqlUpdateExame1 = "UPDATE resultados_exames SET tipo_exame = 'Hemograma' WHERE id_resultado = 1";
    $sqlUpdateExame2 = "UPDATE resultados_exames SET resultado = 'Fratura grave identificada' WHERE id_resultado = 2";

    // Atualizar informações do paciente
    $sqlUpdatePaciente1 = "UPDATE pacientes SET nome_paciente = 'Mariana Silva' WHERE id_paciente = 1";
    $sqlUpdatePaciente2 = "UPDATE pacientes SET data_nascimento = '1987-09-24' WHERE id_paciente = 2";

    // Executar as consultas SQL de atualização
    if ($conn->query($sqlUpdateExame1) === TRUE && $conn->query($sqlUpdateExame2) === TRUE &&
        $conn->query($sqlUpdatePaciente1) === TRUE && $conn->query($sqlUpdatePaciente2) === TRUE) {
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
