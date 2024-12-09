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
$dbname = 'cadastro_usuario'; // Nome do banco de dados
$username = 'root'; // Seu usuário do MySQL
$password = ''; // Sua senha do MySQL

// Conexão com o banco de dados
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}

// Buscar a lista de receptores
$sql = "SELECT * FROM receptores"; // Consulta para obter todos os receptores
$stmt = $pdo->query($sql);
$receptores = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Variáveis para mensagens
$message = '';

// Verifica se houve algum erro ou sucesso na execução
if ($stmt->rowCount() > 0) {
    $message = "Lista de receptores carregada com sucesso.";
} else {
    $message = "Nenhum receptor encontrado.";
}
?>