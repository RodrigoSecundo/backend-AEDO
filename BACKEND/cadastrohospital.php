<?php
// Configuração da conexão com o banco de dados
$host = "localhost"; // Substitua pelo endereço do servidor
$user = "root";      // Substitua pelo usuário do banco de dados
$pass = "";          // Substitua pela senha do banco de dados
$dbname = "projeto_dg"; // Substitua pelo nome do banco de dados

// Conexão com o banco de dados
$conn = new mysqli($host, $user, $pass, $dbname);

// Verifica se a conexão foi estabelecida
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Captura os dados do formulário
    $licenca = $_POST['licenca'] ?? '';
    $numero_principal = $_POST['numero'] ?? '';
    $endereco_rua = $_POST['endereco_rua'] ?? '';
    $endereco_bairro = $_POST['endereco_bairro'] ?? '';
    $endereco_numero = $_POST['endereco_numero'] ?? '';
    $plano_saude = $_POST['plano'] ?? '';

    // Validação dos campos obrigatórios
    if (empty($licenca) || empty($numero_principal) || empty($endereco_rua) || empty($endereco_bairro) || empty($endereco_numero) || empty($plano_saude)) {
        echo "Todos os campos são obrigatórios. Por favor, preencha todos os dados.";
    } else {
        // Insere os dados no banco de dados
        $sql = "INSERT INTO hospitais (licenca, numero_principal, endereco_rua, endereco_bairro, endereco_numero, plano_saude)
                VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssss", $licenca, $numero_principal, $endereco_rua, $endereco_bairro, $endereco_numero, $plano_saude);

        if ($stmt->execute()) {
            echo "Cadastro realizado com sucesso!";
        } else {
            echo "Erro ao cadastrar: " . $stmt->error;
        }

        $stmt->close();
    }
}

// Fecha a conexão com o banco de dados
$conn->close();
?>