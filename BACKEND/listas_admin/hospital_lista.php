<?php
// Inicia a sessão e verifica se o usuário tem o perfil adequado
session_start();
if (!isset($_SESSION['perfil']) || $_SESSION['perfil'] != 'admin') {
    // Redireciona para login caso o usuário não tenha o perfil adequado
    header('Location: login.php');
    exit;
}

// Configurações de banco de dados
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

// Buscar a lista de hospitais
$sql = "SELECT * FROM hospitais"; // Consulta para obter todos os hospitais
$stmt = $pdo->query($sql);
$hospitais = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Verifica se há hospitais e gera o conteúdo da tabela
if ($stmt->rowCount() > 0) {
    $hospitaisHtml = '';
    foreach ($hospitais as $hospital) {
        $hospitaisHtml .= "<tr>
            <td>" . htmlspecialchars($hospital['id']) . "</td>
            <td>" . htmlspecialchars($hospital['nome']) . "</td>
            <td>" . htmlspecialchars($hospital['localizacao']) . "</td>
            <td>" . htmlspecialchars($hospital['contato']) . "</td>
        </tr>";
    }
} else {
    $hospitaisHtml = "<tr><td colspan='4'>Nenhum hospital encontrado.</td></tr>";
}

// Passa as variáveis para o HTML
include('hospitaisListaTemplate.php');
?>