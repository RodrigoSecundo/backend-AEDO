<?php
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

// Processamento do formulário de login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cpf = $_POST['CPF'] ?? null;
    $senha = $_POST['password'] ?? null;
    $perfil = $_POST['perfil'] ?? null;

    // Validação simples
    if (empty($cpf) || empty($senha) || empty($perfil)) {
        $error = "Todos os campos são obrigatórios!";
    } else {
        // Verifica se o usuário existe no banco
        $sql = "SELECT * FROM usuarios WHERE cpf = :cpf AND perfil = :perfil";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':cpf' => $cpf, ':perfil' => $perfil]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($senha, $user['senha'])) {
            // Senha correta, login bem-sucedido
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_nome'] = $user['nome'];
            $_SESSION['perfil'] = $user['perfil'];

            // Redireciona para a página principal ou dashboard
            header("Location: dashboard.php"); 
            exit;
        } else {
            $error = "CPF, senha ou perfil inválido!";
        }
    }
}
?>