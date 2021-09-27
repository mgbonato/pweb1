<?php 
	include('config/bd_conexao.php');
	
    $erros = array('nome_banda' => '', 'descricao' => '', 'nome_cadastrante_show' => '', 'tipo_entrada' => '', 'token' => '', 'imagem' => '');
    $erros2 = array('data' => '', 'horario' => '', 'preco' => '', 'estoque' => '', 'local' => '');
    $nome_banda = $descricao = $nome_cadastrante_show = $tipo_entrada = $token = $imagem = '';
    $data = $horario = $preco = $estoque = $local = '';
   
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
	
	if(isset($_POST['alterar'])){
		//Limpa os dados de sql injection
		$id = mysqli_real_escape_string($conn,$_POST['id']);
		
		//Monta a query
		$sql = "SELECT * FROM tb_show WHERE id = $id;";
		
		//Executa a query e guarda em $result
		$result = mysqli_query($conn,$sql);
		
		//Busca o resultado em forma de vetor
		$show = mysqli_fetch_assoc($result);
		
		$nome_banda = $show['nome_banda'];
		$descricao = $show['descricao'];
		$nome_cadastrante_show = $show['nome_cadastrante_show'];
		$tipo_entrada = $show['tipo_entrada'];
		$token = $show['token'];
		$imagem = $show['imagem'];		
		
		mysqli_free_result($result);
		
		mysqli_close($conn);	
	}		
	
	if (isset($_POST['enviar'])){
		
		if (empty($_POST['nome_banda'])){
			$erros['nome_banda'] = 'Campo obrigatorio';
		} else{
            $nome_banda = $_POST['nome_banda'];
			if (!preg_match('/^[a-zA-Z0-9]+$/', $nome_banda)){
				$erros['nome_banda'] = 'O nome deve conter somente letras e numeros';
                $nome_banda = '';
            }
		}
		
		if (empty($_POST['descricao'])){
			$erros['descricao'] = 'Campo obrigatorio';
		} else{
			$descricao = $_POST['descricao'];
			if (!preg_match('/^([a-zA-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÊÍÏÓÔÕÖÚÇÑ\s]+)(,\s*[a-zA-ZzáàâãéèêíïóôõöúçñÁÀÂÃÉÈÊÍÏÓÔÕÖÚÇÑ\s]*)*$/',
			$descricao)){
				$erros['descricao'] = 'A descricao devem conter somente letras';
                $descricao = '';
            }
		}

		if (empty($_POST['nome_cadastrante_show'])){
			$erros['nome_cadastrante_show'] = 'Campo obrigatorio';
		} else{
			$nome_cadastrante_show = $_POST['nome_cadastrante_show'];
			if (!preg_match('/^([a-zA-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÊÍÏÓÔÕÖÚÇÑ\s]+)(,\s*[a-zA-ZzáàâãéèêíïóôõöúçñÁÀÂÃÉÈÊÍÏÓÔÕÖÚÇÑ\s]*)*$/',
			$nome_cadastrante_show)){
				$erros['nome_cadastrante_show'] = 'O nome_cadastrante_show devem conter somente letras';
                $nome_cadastrante_show = '';
            }
		}

		if (empty($_POST['tipo_entrada'])){
			$erros['tipo_entrada'] = 'Campo obrigatorio';
		} else{
			$tipo_entrada = $_POST['tipo_entrada'];
			if (!preg_match('/^([a-zA-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÊÍÏÓÔÕÖÚÇÑ\s]+)(,\s*[a-zA-ZzáàâãéèêíïóôõöúçñÁÀÂÃÉÈÊÍÏÓÔÕÖÚÇÑ\s]*)*$/',
			$tipo_entrada)){
				$erros['tipo_entrada'] = 'O tipo_entrada devem conter somente letras';
                $tipo_entrada = '';
            }
		}

		if (empty($_POST['imagem'])){
			$erros['imagem'] = 'Campo obrigatorio';
		}

		if (empty($_POST['token'])){
			$erros['token'] = 'Campo obrigatorio';
		} else{
			$token = $_POST['token'];
			if (!preg_match('/^[a-zA-Z0-9]+$/', $token)){
				$erros['token'] = 'Insira somente letras e numeros';
                $token = '';
            }
		}
        
        if(array_filter($erros)){
            echo 'Erro no formulario';
        }else {
			// Limpador de codigos
            $nome_banda = mysqli_real_escape_string($conn, $_POST['nome_banda']);
            $descricao = mysqli_real_escape_string($conn, $_POST['descricao']);
            $nome_cadastrante_show = mysqli_real_escape_string($conn, $_POST['nome_cadastrante_show']);
            $tipo_entrada = mysqli_real_escape_string($conn, $_POST['tipo_entrada']);
            $token = mysqli_real_escape_string($conn, $_POST['token']);
            $imagem = mysqli_real_escape_string($conn, $_POST['imagem']);

			// Criando a query
			$sql = "INSERT INTO tb_show(nome_banda, descricao, nome_cadastrante_show, tipo_entrada, token, imagem) VALUES('$nome_banda', '$descricao', '$nome_cadastrante_show', '$tipo_entrada', '$token', '$imagem')";

			// Salva no banco de dados
			if(mysqli_query($conn, $sql)){
				//Sucesso
				header('Location: index.php');
			}else{
				echo 'query error: '.mysqli_error($conn);
			}
        }
	}

	if (isset($_POST['data'])){
		
		if (empty($_POST['data'])){
			$erros2['data'] = 'Campo obrigatorio';
		}

		if (empty($_POST['horario'])){
			$erros2['horario'] = 'Campo obrigatorio';
		}

		if (empty($_POST['preco'])){
			$erros2['preco'] = 'Campo obrigatorio';
		} else{
            $preco = $_POST['preco'];
			if (!preg_match('/^[0-9.0-9]+$/', $preco)){
				$erros2['preco'] = 'Insira uma preco valida';
                $preco = '';
            }
		}

		if (empty($_POST['estoque'])){
			$erros2['estoque'] = 'Campo obrigatorio';
		} else{
            $estoque = $_POST['estoque'];
			if (!preg_match('/^[0-9]+$/', $estoque)){
				$erros2['estoque'] = 'Insira uma estoque valida';
                $estoque = '';
            }
		}

		if (empty($_POST['local'])){
			$erros2['local'] = 'Campo obrigatorio';
		} else{
			$local = $_POST['local'];
			if (!preg_match('/^([a-z0-9A-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÊÍÏÓÔÕÖÚÇÑ\s]+)(,\s*[a-z0-9A-ZzáàâãéèêíïóôõöúçñÁÀÂÃÉÈÊÍÏÓÔÕÖÚÇÑ\s]*)*$/',
			$local)){
				$erros2['local'] = 'Local invalido';
                $local = '';
            }
		}
        
        if(array_filter($erros2)){
            echo 'Erro no formulario';
        }else {
			// Limpador de codigos
            $data = mysqli_real_escape_string($conn, $_POST['data']);
            $horario = mysqli_real_escape_string($conn, $_POST['horario']);
            $preco = mysqli_real_escape_string($conn, $_POST['preco']);
            $estoque = mysqli_real_escape_string($conn, $_POST['estoque']);
            $local = mysqli_real_escape_string($conn, $_POST['local']);

			// Criando a query
			$sql = "INSERT INTO tb_horario(id_show, data, horario, preco, estoque, local) VALUES('$id', '$data', '$horario', '$preco', '$estoque', '$local')";

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
	
	<?php include('templates/header.php'); ?>
			<div class="col s6 md3" style="display: flex;">
				<section class="container grey-text">
					<h4 class="center">Alterar Show</h4>
					<form class="white" action="alterar.php" method="POST" >
						<label>Nome da Banda</label>
						<input type="text" name="nome_banda" value="<?php echo $nome_banda ?>">			
						<div class="red-text"><?php echo $erros['nome_banda']; ?></div>
						<label>Descrição</label>
						<input type="text" name="descricao" value="<?php echo $descricao ?>">			
						<div class="red-text"><?php echo $erros['descricao']; ?></div>
						<label>Nome do Cadastrante do Show</label>
						<input type="text" name="nome_cadastrante_show" value="<?php echo $nome_cadastrante_show ?>">			
						<div class="red-text"><?php echo $erros['nome_cadastrante_show']; ?></div>
						<label>Tipo de Entrada</label>
						<input type="text" name="tipo_entrada" value="<?php echo $tipo_entrada ?>">			
						<div class="red-text"><?php echo $erros['tipo_entrada']; ?></div>
						<label>Token</label>
						<input type="text" name="token" value="<?php echo $token ?>">			
						<div class="red-text"><?php echo $erros['token']; ?></div>
						<label>Banner do Show</label><br>
						<input type="file" name="imagem" value="<?php echo $imagem ?>">			
						<div class="red-text"><?php echo $erros['imagem']; ?></div>
						<div class="center" style="margin-top: 10px;">
							<input type="submit" name="enviar" value="Enviar" class="btn brand z-depth-0">
						</div>
					</form>
				</section>
				<section class="container c6 grey-text">
					<h4 class="center">Adicionar Data e Local</h4>
					<form class="white" action="alterar.php" method="POST" >
						<label>Data</label>
						<input type="date" name="data" value="<?php echo $data ?>">			
						<div class="red-text"><?php echo $erros2['data']; ?></div>
						<label>Horario</label>
						<input type="time" name="horario" value="<?php echo $horario ?>">			
						<div class="red-text"><?php echo $erros2['horario']; ?></div>
						<label>Preco</label>
						<input type="text" name="preco" value="<?php echo $preco ?>">			
						<div class="red-text"><?php echo $erros2['preco']; ?></div>
						<label>Estoque</label>
						<input type="text" name="estoque" value="<?php echo $estoque ?>">			
						<div class="red-text"><?php echo $erros2['estoque']; ?></div>
						<label>Local</label>
						<input type="text" name="local" value="<?php echo $local ?>">			
						<div class="red-text"><?php echo $erros2['local']; ?></div>
						<div class="center" style="margin-top: 10px;">
							<input type="submit" name="data" value="Enviar" class="btn brand z-depth-0">
						</div>
					</form>
				</section>
			</div>

	<?php include('templates/footer.php'); ?>

</html>
