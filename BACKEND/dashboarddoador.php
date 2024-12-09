<?php
session_start();

// Verifique se o usuário está logado e tem o perfil correto
if (!isset($_SESSION['perfil']) || $_SESSION['perfil'] != 'doador') {
    // Redirecionar para a página de login se não estiver logado ou não for doador
    header('Location: login.php');
    exit;
}

// Configurações do banco de dados
$host = 'localhost';
$dbname = 'cadastro_usuario';
$username = 'root'; // Substitua pelo seu usuário MySQL
$password = ''; // Substitua pela sua senha MySQL

// Conexão com o banco de dados
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}

// Processamento do formulário de atualização das informações
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['nome'], $_POST['telefone'], $_POST['id_doador'], $_POST['endereco'], $_POST['rua'], $_POST['complemento'], $_POST['cep'], $_POST['tipo_convenio'])) {
        $nome = $_POST['nome'];
        $telefone = $_POST['telefone'];
        $id_doador = $_POST['id_doador'];
        $endereco = $_POST['endereco'];
        $rua = $_POST['rua'];
        $complemento = $_POST['complemento'];
        $cep = $_POST['cep'];
        $tipo_convenio = $_POST['tipo_convenio'];

        // Atualização dos dados no banco
        $sql = "UPDATE doador_info SET 
                    nome = :nome,
                    telefone = :telefone,
                    id_doador = :id_doador,
                    endereco = :endereco,
                    rua = :rua,
                    complemento = :complemento,
                    cep = :cep,
                    tipo_convenio = :tipo_convenio
                WHERE user_id = :user_id"; // Garantindo que apenas o doador logado possa atualizar seus dados

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':nome' => $nome,
            ':telefone' => $telefone,
            ':id_doador' => $id_doador,
            ':endereco' => $endereco,
            ':rua' => $rua,
            ':complemento' => $complemento,
            ':cep' => $cep,
            ':tipo_convenio' => $tipo_convenio,
            ':user_id' => $_SESSION['user_id']
        ]);

        // Mensagem de sucesso ou erro
        $message = "Informações atualizadas com sucesso!";
    }

    // Processamento do formulário de atualização da lista de órgãos
    if (isset($_POST['orgao'])) {
        $orgao = $_POST['orgao'];

        // Atualização da lista de órgãos no banco
        $sql = "UPDATE orgaos_doados SET orgao = :orgao WHERE user_id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':orgao' => $orgao,
            ':user_id' => $_SESSION['user_id']
        ]);

        // Mensagem de sucesso ou erro
        $message = "Lista de órgãos atualizada com sucesso!";
    }
}
?>