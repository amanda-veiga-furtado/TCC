<?php
    session_start();
    ob_start();

    include_once '../../conexao.php';
    include '../../css/functions.php';
    include_once '../../menu.php'; 
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Atualizar Senha</title>
    </head>
    <body>
    <div class="container_background_type_1">
            <div class="whitecard_form_type_1">
                <div class="container_form">
        <h1>Atualizar Senha</h1>
        <?php
            $chave = filter_input(INPUT_GET, 'chave', FILTER_DEFAULT);
            if (!empty($chave)) {
                //var_dump($chave);

                $query_usuario = "SELECT id_usuario
                                    FROM usuario
                                    WHERE recuperar_senha =:recuperar_senha  
                                    LIMIT 1";
                $result_usuario = $conn->prepare($query_usuario);
                $result_usuario->bindParam(':recuperar_senha', $chave, PDO::PARAM_STR);
                $result_usuario->execute();

                if (($result_usuario) and ($result_usuario->rowCount() != 0)) {
                    $row_usuario = $result_usuario->fetch(PDO::FETCH_ASSOC);
                    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
                    //var_dump($dados);
                    if (!empty($dados['SendNovaSenha'])) {
                        $senha_usuario = password_hash($dados['senha_usuario'], PASSWORD_DEFAULT);
                        $recuperar_senha = 'NULL';

                        $query_up_usuario = "UPDATE usuario
                                             SET senha_usuario =:senha_usuario,
                                             recuperar_senha =:recuperar_senha
                                             WHERE id_usuario =:id_usuario
                                             LIMIT 1";
                        $result_up_usuario = $conn->prepare($query_up_usuario);
                        $result_up_usuario->bindParam(':senha_usuario', $senha_usuario, PDO::PARAM_STR);
                        $result_up_usuario->bindParam(':recuperar_senha', $recuperar_senha);
                        $result_up_usuario->bindParam(':id_usuario', $row_usuario['id_usuario'], PDO::PARAM_INT);

                        if ($result_up_usuario->execute()) {
                            $_SESSION['msg'] = "<p style='color: green'>Senha atualizada com sucesso!</p>";
                            header("Location: ../login.php");
                        } else {
                            echo "<p style='color: #ff0000'>Erro: Tente novamente!</p>";
                        }
                    }
                } else {
                    $_SESSION['msg_rec'] = "<p style='color: #ff0000'>Erro: Link inválido, solicite novo link para atualizar a senha!</p>";
                    header("Location: recuperar_senha.php");
                }
            } else {
                $_SESSION['msg_rec'] = "<p style='color: #ff0000'>Erro: Link inválido, solicite novo link para atualizar a senha!</p>";
                header("Location: recuperar_senha.php");
            }
        ?>

        <form method="POST" action="">
            <?php
                $usuario = "";
                if (isset($dados['senha_usuario'])) {
                    $usuario = $dados['senha_usuario'];
                }
            ?>
            <!-- <label>Senha</label> -->
            <input type="password" name="senha_usuario" placeholder="Digite a nova senha" value="<?php echo $usuario; ?>"><br><br>

            <input type="submit" value="Atualizar" name="SendNovaSenha">
        </form>

        <br>
        Lembrou? <a href="../login.php">Clique Aqui</a> para Logar
        </div>
            </div>
        </div>
    </body>
</html>