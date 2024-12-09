<?php
session_start();

// Verifique se o usuário está logado e tem o perfil correto de administrador
if (!isset($_SESSION['perfil']) || $_SESSION['perfil'] != 'admin') {
    // Redireciona para a página de login se não estiver logado ou não for admin
    header('Location: login.php');
    exit;
}

// Configuração de conexão com o banco de dados
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

// Variáveis para controle dos botões
$message = ''; // Mensagem de sucesso ou erro

// Processamento dos botões de ação
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Se o botão "Doador" for pressionado
    if (isset($_POST['doador'])) {
        // Exemplo de lógica para exibir lista de doadores
        $sql = "SELECT * FROM doadores"; // Consulta para obter doadores
        $stmt = $pdo->query($sql);
        $doadores = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $message = "Exibindo lista de doadores.";
    }

    // Se o botão "Receptor" for pressionado
    if (isset($_POST['receptor'])) {
        // Exemplo de lógica para exibir lista de receptores
        $sql = "SELECT * FROM receptores"; // Consulta para obter receptores
        $stmt = $pdo->query($sql);
        $receptores = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $message = "Exibindo lista de receptores.";
    }

    // Se o botão "Hospitais" for pressionado
    if (isset($_POST['hospitais'])) {
        // Exemplo de lógica para exibir lista de hospitais
        $sql = "SELECT * FROM hospitais"; // Consulta para obter hospitais
        $stmt = $pdo->query($sql);
        $hospitais = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $message = "Exibindo lista de hospitais.";
    }
}
?>