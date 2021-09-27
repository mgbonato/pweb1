<?php 

    include('config/bd_conexao.php');

    // Verificando se o parametro id foi enviado pelo get
    if(isset($_GET['id'])){
        //Limpa a query sql
        $id = mysqli_real_escape_string($conn, $_GET['id']);

        //Monta a query
        $sql = "SELECT * FROM tb_show WHERE id = $id";

        //Pega o resultado da query
        $result = mysqli_query($conn, $sql);

        //Busca um unico resultado em formato de vetor
        $show = mysqli_fetch_assoc($result);

        mysqli_free_result($result);
        mysqli_close($conn);
    }

    //Remove a pizza do banco de dados
    if(isset($_POST['delete'])) {
        //Limpando a query
        $id_show = mysqli_real_escape_string($conn, $_POST['id_show']);
        //Montando a query
        $sql = "DELETE FROM tb_show WHERE id = $id_show";
        //Removendo do banco
        if(mysqli_query($conn, $sql)){
            //Sucesso
            header('Location: index.php');
        } else {
            echo 'query error: '.mysqli_error($conn);
        }
    }
?>

<html lang="pt-br">
    <?php include('templates/header.php');?>
        <div class="container center">
            <?php if($show): ?>
                <h4><?php echo $show['nome_banda']; ?></h4>
                <h5>Descricao: </h5>
                <p><?php echo $show['descricao']; ?></p>

                <!-- Formulario de Remoção -->
                <form action="detalhes.php" method="POST">
                    <input type="hidden" name="id_show" value="<?php echo $show['id']; ?>">
                    <input type="submit" name="delete" value="Remover" class="btn brand z-depth-0">
                </form>
                <form action="alterar.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo $show['id']; ?>">
                    <input type="submit" name="alterar" value="Alterar" class="btn brand z-depth-0">
                </form>
            <?php else: ?>
                <h5>Show Não encontrado.</h5>
            <?php endif ?>    
        </div>
    <?php include('templates/footer.php');?>
</html>