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

// Processamento do formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Coleta e validação dos dados
    $nome = $_POST['nome'] ?? null;
    $senha = isset($_POST['senha']) ? password_hash($_POST['senha'], PASSWORD_DEFAULT) : null; // Hash da senha
    $cpf = $_POST['cpf'] ?? null;
    $endereco_rua = $_POST['endereco_rua'] ?? null;
    $endereco_bairro = $_POST['endereco_bairro'] ?? null;
    $endereco_numero = $_POST['endereco_numero'] ?? null;
    $perfil = $_POST['perfil'] ?? null;
    $plano_saude = $_POST['plano_saude'] ?? null;
    $orgao = $_POST['orgao'] ?? null;

    // Validação simples
    if (empty($nome) || empty($senha) || empty($cpf) || empty($endereco_rua) || empty($endereco_bairro) || 
        empty($endereco_numero) || empty($perfil) || empty($plano_saude)) {
        echo "Erro: Todos os campos são obrigatórios!\n";
        exit;
    }

    // Prepara e executa a inserção no banco de dados
    $sql = "INSERT INTO usuarios (nome, senha, cpf, endereco_rua, endereco_bairro, endereco_numero, perfil, plano_saude, orgao)
            VALUES (:nome, :senha, :cpf, :endereco_rua, :endereco_bairro, :endereco_numero, :perfil, :plano_saude, :orgao)";
    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute([
            ':nome' => $nome,
            ':senha' => $senha,
            ':cpf' => $cpf,
            ':endereco_rua' => $endereco_rua,
            ':endereco_bairro' => $endereco_bairro,
            ':endereco_numero' => $endereco_numero,
            ':perfil' => $perfil,
            ':plano_saude' => $plano_saude,
            ':orgao' => $orgao
        ]);
        echo "Usuário cadastrado com sucesso!\n";
    } catch (PDOException $e) {
        echo "Erro ao cadastrar o usuário: " . $e->getMessage() . "\n";
    }
} else {
    echo "Este script só aceita requisições POST.\n";
}
?>