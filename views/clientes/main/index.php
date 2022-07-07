
<!doctype html>
<html lang="es"> 

<?php require_once("template/partials/head.php") ?>

<body>
    <?php require_once("template/partials/menuAut.php") ?>
    
    <!-- Page Content -->
    <div class="container">
	<br>
		<?php require_once("template/partials/mensaje.php") ?>

		<!-- Estilo card de bootstrap -->
		<div class="card">
			<div class="card-header">
				<legend>Tabla Clientes</legend>
				<?php require_once("template/clientes/menuClientes.php");?>
			</div>
			<div class="card-body">
				
                

				<table class="table table-hover">
				<thead>
					<tr>
						<th>Id</th>
						<th>Apellidos</th>
						<th>Nombre</th>
						<th>Telefono</th>
						<th>Ciudad</th>
						<th>Email</th>
						<th>Accciones</th>
					</tr>
				</thead>
				<tbody>

				<?php foreach ($this->clientes as $cliente): ?>
					<tr>
						<td><?= $cliente->id ?></td>
						<td><?= $cliente->apellidos ?></td>
						<td><?= $cliente->nombre ?></td>
						<td><?= $cliente->telefono ?></td>
						<td><?= $cliente->ciudad ?></td>
						<td><?= $cliente->email ?></td>
						<td>
						<a href="<?= URL ?>clientes/eliminar/<?= $cliente->id?>" onclick="if(!confirm('¿Estas seguro de que desea eliminar este usuario?')) return false;" title="Eliminar"
						<?= (!in_array($_SESSION['id_rol'], $GLOBALS['eliminar'])) ? 'class = "btn disabled"': null?>><i class="material-icons">delete</i></a>
						<a href="<?= URL ?>clientes/editar/<?= $cliente->id?>" title="Editar"
						<?= (!in_array($_SESSION['id_rol'], $GLOBALS['editar'])) ? 'class = "btn disabled"': null?>><i class="material-icons">edit</i></a>
						<a href="<?= URL ?>clientes/mostrar/<?= $cliente->id?>" title="Mostrar"
						<?= (!in_array($_SESSION['id_rol'], $GLOBALS['consultar'])) ? 'class = "btn disabled"': null?>><i class="material-icons">visibility</i></a>
						</td>
						
					</tr>
					<?php endforeach; ?>
				</tbody>

				</table>
			</div>
			<div class="catd-footer text-muted">
				Nº Registro: <?= $this->clientes->rowCount();?>
			</div>
		</div>


    </div>
	<br><br><br>

    <!-- /.container -->
    
    <?php require_once("template/partials/footer.php") ?>
	<?php require_once("template/partials/javascript.php") ?>
	
</body>

</html>