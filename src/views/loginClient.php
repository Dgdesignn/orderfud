<?php
    require "../controllers/clientController.php";

    // Iniciar a sessão
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $cliente = new ClientController();
    
    // Se já estiver logado, redirecionar
    if($cliente->isLoggedIn()){
        header("Location: website.php?rota=produtos");
        exit();
    }

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $telefone = $_POST['telefone'];
        $senha = $_POST['senha'];

        if (empty($telefone) || empty($senha)) {
            $erro = "Todos os campos são obrigatórios!";
        } else {
            $resultado = $cliente->login($telefone, $senha);
             
            if ($resultado){
                // Verificar se veio de uma tentativa de checkout
                $redirect = isset($_SESSION['redirect_after_login']) ? $_SESSION['redirect_after_login'] : 'shopping.php';
                unset($_SESSION['redirect_after_login']); // Limpar a variável de redirecionamento
                
                echo "
                <script>
                    const cartProducts = JSON.parse(localStorage.getItem('cartProducts')) || [];
                    if (cartProducts.length > 0) {
                        window.location.href = 'checkout.php';
                    } else {
                        window.location.href = 'website.php?rota=produtos';
                    }
                </script>";
                exit();
            } else {
                $erro = "Senha ou número de telefone inválidos.";
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - OrderFüd</title>
    <link rel="stylesheet" href="loginClient.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="login">
            <form action="#" method="POST">
                <h1>Login</h1>
                <hr>
                <p>Entre para finalizar seu pedido!</p>
                
                <?php if(isset($erro)): ?>
                    <div class="alert alert-error">
                        <?php echo $erro; ?>
                    </div>
                <?php endif; ?>

                <label>TELEFONE</label>
                <div class="input-group">
                    <i class="fas fa-phone"></i>
                    <input type="text" name="telefone" placeholder="Digite o seu número" 
                           pattern="[0-9]+" title="Digite apenas números">
                </div>

                <label>SENHA</label>
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="senha" placeholder="Digite a sua senha!">
                </div>

                <button type="submit">
                    <i class="fas fa-sign-in-alt"></i>
                    Entrar
                </button>

                <p class="register-link">
                    <a href="cadastro1.php">
                        <i class="fas fa-user-plus"></i>
                        Ainda não tem conta? Cadastre-se!
                    </a>
                </p>
            </form>
        </div>
        <div class="pic">
            <img src="food.jpg" alt="Comida">
            <div class="letra">
                Bem-vindo(a) de volta!
            </div>
        </div>
    </div>

    <style>
        /* Atualizações no CSS existente */
        .input-group {
            position: relative;
            margin-bottom: 20px;
        }

        .input-group i {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #FF6B35;
        }

        .input-group input {
            padding-left: 35px;
            width: 100%;
            height: 40px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        .input-group input:focus {
            outline: none;
            border-color: #FF6B35;
            box-shadow: 0 0 0 2px rgba(255, 107, 53, 0.1);
        }

        button {
            background: #FF6B35;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 5px;
            width: 100%;
            font-size: 16px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: background-color 0.3s;
        }

        button:hover {
            background: #ff8659;
        }

        .register-link {
            text-align: center;
            margin-top: 20px;
        }

        .register-link a {
            color: #FF6B35;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        /* Mantenha os outros estilos existentes */
        
        .alert {
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .alert-error {
            background-color: #ffe6e6;
            color: #ff3333;
            border: 1px solid #ffcccc;
        }
    </style>

    <script>
        // Validação do número de telefone
        document.querySelector('input[name="telefone"]').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    </script>
</body>
</html>