<?php
	include('config/bd_conexao.php');

	//query para buscar
	$sql = "SELECT b.nm_banda, l.data, l.id FROM tb_banda b, tb_local l WHERE b.id = l.id_banda ORDER BY data ASC";
	$result = mysqli_query($conn, $sql);
	$shows = mysqli_fetch_all($result, MYSQLI_ASSOC);

	$sql2 = "SELECT nm_banda, descricao FROM tb_banda ORDER BY nm_banda ASC";
	$result2 = mysqli_query($conn, $sql2);
	$bandas = mysqli_fetch_all($result2, MYSQLI_ASSOC);

	//limpa a memória de $result
	mysqli_free_result($result);
	mysqli_free_result($result2);

	//fecha a conexão
	mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<?php include('templates/header.php') ?>
	<div class="shows" id="sh">
		<h4>Próximos shows</h4>
		<div class="row">
			<?php foreach($shows as $show) { ?>
				<div class="col s6 md3">
					<div class="card z-depth-0" style="font-size: 17px; border-radius: 10px; background: #010f1f; color: #fff;">
						<div class="card-content">
							<p><?php echo htmlspecialchars($show['data']); ?></p>
							<h6 class="center" style="font-family: 'New Rocker', cursive; font-size: 32px; border-radius: 10px; background: #FFF; padding: 30px 10px; color: #010f1f;"><?php echo htmlspecialchars($show['nm_banda']); ?></h6>
						</div>
						<div class="card-action right-align" style="border-radius: 10px">
							<a class="brand-text" href="detalhes.php?id=<?php echo $show['id'] ?>">Comprar Ingresso</a>
						</div>
					</div>
				</div>
			<?php } ?>						
		</div>
	</div>
	<div class="bandas" id="bd">
		<h4>Bandas</h4>
		<div class="row">
			<?php foreach($bandas as $banda) { ?>
				<div class="col s4 md3">
					<div class="card z-depth-0" style="font-size: 17px; border-radius: 10px; background: #010f1f; color: #fff;">
						<div class="card-content">
							<h6 class="center" style="font-family: 'New Rocker', cursive; font-size: 32px; border-radius: 10px; background: #FFF; padding: 30px 10px; color: #010f1f;"><?php echo htmlspecialchars($banda['nm_banda']); ?></h6>
							<h6 class="center" style="font-family: 'New Rocker', cursive; font-size: 16px; border-radius: 10px; background: #FFF; padding: 30px 10px; color: #010f1f;"><?php echo htmlspecialchars($banda['descricao']); ?></h6>
						</div>
						<div class="card-action right-align" style="border-radius: 10px">
							<a class="brand-text">Informações</a>
						</div>
					</div>
				</div>
			<?php } ?>			
		</div>
	</div>	
	<div class="contatos" id="ct">
		<h4 style="font-family: 'New Rocker', cursive; font-size: 20px; margin-left: 10px; color: #fff; padding: 5px; margin-top: 10px; padding: 10px;">Contatos</h4>
		<div class="center contatos">
			<p>dsdadasdasd asdasdasd asd asd asd a sdasdasdasda asdasdasdasdas asdasdasdasd sadasdasdasdas dasdasdas</p>
		</div>
	</div>
	<?php include('templates/footer.php') ?>
</html>