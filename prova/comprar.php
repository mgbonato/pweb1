<?php 
	include('config/bd_conexao.php');
    $erros = array('nome_banda' => '', 'descricao' => '', 'nome_cadastrante_show' => '', 'tipo_entrada' => '', 'token' => '', 'imagem' => '');
    $erros2 = array('data' => '', 'horario' => '', 'preco' => '', 'estoque' => '', 'local' => '');
	$nome_banda = $descricao = $nome_cadastrante_show = $tipo_entrada = $token = $imagem = '';
    $data = $horario = $preco = $estoque = $local = '';

	if (isset($_POST['enviar'])){
		
		// Verificar e-mail
		/*if (empty($_POST['email'])){
			$erros['email'] = 'O e-mail é obrigatório.';
		} else{
			$email = $_POST['email'];
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
				$erros['email'] = 'Insira um e-mail válido';
                $email = '';
            }
		}*/
		//Verificar nome da pizza
		if (empty($_POST['nomePizza'])){
			$erros['nomePizza'] = 'O nome da pizza é obrigatório.';
		} else{
            $nomePizza = $_POST['nomePizza'];
			if (!preg_match('/^([a-zA-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÊÍÏÓÔÕÖÚÇÑ\s]+)(,\s*[a-zA-ZzáàâãéèêíïóôõöúçñÁÀÂÃÉÈÊÍÏÓÔÕÖÚÇÑ\s]*)*$/',
			$nomePizza)){
				$erros['nomePizza'] = 'O nome deve conter somente letras';
                $nomePizza = '';
            }
		}
		//Verificar ingredientes
		if (empty($_POST['ingredientes'])){
			$erros['ingredientes'] = 'Deve conter ao menos um ingrediente';
		} else{
			$ingredientes = $_POST['ingredientes'];
			if (!preg_match('/^([a-zA-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÊÍÏÓÔÕÖÚÇÑ\s]+)(,\s*[a-zA-ZzáàâãéèêíïóôõöúçñÁÀÂÃÉÈÊÍÏÓÔÕÖÚÇÑ\s]*)*$/',
			$ingredientes)){
				$erros['ingredientes'] = 'Os ingredientes devem conter somente letras e separados por vírgula';
                $ingredientes = '';
            }
		}
        
        if(array_filter($erros)){
            echo 'Erro no formulario';
        }else {
			// Limpador de codigos
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $nomePizza = mysqli_real_escape_string($conn, $_POST['nomePizza']);
            $ingredientes = mysqli_real_escape_string($conn, $_POST['ingredientes']);

			// Criando a query
			$sql = "INSERT INTO pizza(nomePizza, email, ingredientes) VALUES('$nomePizza', '$email', '$ingredientes')";

			// Salva no banco de dados
			if(mysqli_query($conn, $sql)){
				//Sucesso
				header('Location: index.php');
			}else{
				echo 'query error: '.mysqli_error($conn);
			}
        }
	}
?>

<!DOCTYPE html>
<html>
	<?php include('templates/header.php') ?>
    <div class="container">
		<div class="col s2 m2">
			<div class="card">
				<div class="card-image">
					<img src="images/img.jpg" style="height: 200px;">
					<span class="card-title">Restart</span>
				</div>
				<div class="card-content">
					<p>Uma banda muito famosa de heavy metal</p>
				</div>
				<div class="card-action">
					<a href="#">Saiba Mais</a>
				</div>
			</div>
		</div>
	</div>
	<section class="container grey-text">
		<h4 class="center">Adicionar Novo Show</h4>
		<form class="white" action="adicionar.php" method="POST" >
            <label>Nome</label>
			<input type="text" name="nome_banda">			
			<div class="red-text">Mensagem de Erro</div>
            <label>Email</label>
			<input type="text" name="descricao">			
			<div class="red-text">Mensagem de Erro</div>
            <label>Tipo do Ingresso</label>
			<input type="text" name="nome_cadastrante_show">			
			<div class="red-text">Mensagem de Erro</div>
            <label>Quantidade</label>
			<input type="text" name="tipo_entrada">			
			<div class="red-text">Mensagem de Erro</div>
            <div class="center" style="margin-top: 10px;">
				<input type="submit" name="enviar" value="Enviar" class="btn brand z-depth-0">
			</div>
		</form>
	</section>
	<?php include('templates/footer.php') ?>
</html>
