<?php
session_start();

// Função para conectar ao banco de dados
function conectarBanco() {
    $host = 'localhost';
    $dbname = 'cadastro_usuario';
    $username = 'root';
    $password = '';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("Erro ao conectar ao banco de dados: " . $e->getMessage());
    }
}

// Rota inicial
if ($_SERVER['REQUEST_URI'] == '/') {
    // Verifica se o usuário está logado
    if (!isset($_SESSION['perfil']) || $_SESSION['perfil'] != 'admin') {
        header('Location: /login');
        exit;
    }

    // Conectar ao banco e buscar hospitais
    $pdo = conectarBanco();
    $sql = "SELECT * FROM hospitais";
    $stmt = $pdo->query($sql);
    $hospitais = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Gerar HTML da lista de hospitais
    $hospitaisHtml = '';
    if ($stmt->rowCount() > 0) {
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

    // Exibir página de lista de hospitais
    echo '
    <!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE-edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Adm Lista Hospitais</title>
        <link rel="stylesheet" href="Admin-HospitaisLista.css">
    </head>
    <body>
        <header>
            <div class="header-admhospital">
                <div class="logo-admhospital"><img src="C:/Users/ueg/Projeto DG/FrontEnd/Src/Assets/LogoFinal.png"></div>
                <div class="menu-admhospital">
                    <nav>
                        <a href="#">Doadores</a>
                        <a href="#">Receptores</a>
                    </nav>
                </div>
            </div>
        </header>
        <div class="container-admhospital">
            <h1>Lista de Hospitais</h1>
            <div class="hospitais-lista">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Localização</th>
                            <th>Contato</th>
                        </tr>
                    </thead>
                    <tbody>
                        ' . $hospitaisHtml . '
                    </tbody>
                </table>
            </div>
        </div>
        <main>
            <div>
                <img src="C:/Users/ueg/Projeto DG/FrontEnd/Src/Assets/backgroundhospital.jpg" class="background-admhospital">
            </div>
        </main>
    </body>
    </html>';
} 

// Rota de login
elseif ($_SERVER['REQUEST_URI'] == '/login') {
    // Se o formulário for enviado
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $usuario = $_POST['usuario'];
        $senha = $_POST['senha'];

        // Verificação de login (substitua por uma verificação real)
        if ($usuario == 'admin' && $senha == 'senha123') {
            $_SESSION['perfil'] = 'admin';
            header('Location: /');
            exit;
        } else {
            $erro = "Usuário ou senha inválidos!";
        }
    }

    // Exibir página de login
    echo '
    <!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
    </head>
    <body>
        <h1>Login</h1>
        <form method="POST">
            <label for="usuario">Usuário</label>
            <input type="text" id="usuario" name="usuario" required>
            <br>
            <label for="senha">Senha</label>
            <input type="password" id="senha" name="senha" required>
            <br>
            <button type="submit">Entrar</button>
        </form>';
        if (isset($erro)) {
            echo "<p>$erro</p>";
        }
    echo '</body>
    </html>';
}
else {
    // Rota não encontrada, exibe erro 404
    header("HTTP/1.0 404 Not Found");
    echo "<h1>404 - Página não encontrada</h1>";
}
?>