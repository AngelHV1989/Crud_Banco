
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
				<legend>Tabla Cuentas</legend>
				<?php require_once("template/cuentas/menuCuentas.php");?>
			</div>
			<div class="card-body">
				<table class="table table-hover">
				<thead>
					<tr>
						<th>Id</th>
						<th>Cuenta</th>
						<th>Apellidos</th>
						<th>Nombre</th>
						<th># Movtos</th>
						<th>Saldo</th>
						<th>Accciones</th>
					</tr>
				</thead>
				<tbody>

				<?php foreach ($this->cuentas as $cuenta): ?>
					<tr>
						<td><?= $cuenta->id ?></td>
						<td><?= $cuenta->num_cuenta ?></td>
						<td><?= $cuenta->apellidos ?></td>
						<td><?= $cuenta->nombre ?></td>
						<td><?= $cuenta->num_movtos ?></td>
						<td><?= $cuenta->saldo ?></td>
						<td>
						<a href="<?= URL ?>cuentas/eliminar/<?= $cuenta->id?>" onclick="if(!confirm('¿Estas seguro de que desea eliminar este usuario?')) return false;" title="Eliminar"
						<?= (!in_array($_SESSION['id_rol'], $GLOBALS['eliminar'])) ? 'class = "btn disabled"': null?>><i class="material-icons">delete</i></a>
						<a href="<?= URL ?>cuentas/editar/<?= $cuenta->id?>" title="Editar"
						<?= (!in_array($_SESSION['id_rol'], $GLOBALS['editar'])) ? 'class = "btn disabled"': null?>><i class="material-icons">edit</i></a>
						<a href="<?= URL ?>cuentas/mostrar/<?= $cuenta->id?>" title="Mostrar"
						<?= (!in_array($_SESSION['id_rol'], $GLOBALS['consultar'])) ? 'class = "btn disabled"': null?>><i class="material-icons">visibility</i></a>
						<a href="<?= URL ?>movimientos/render/<?= $cuenta->id?>" title="Movimientos"
						<?= (!in_array($_SESSION['id_rol'], $GLOBALS['consultar'])) ? 'class = "btn disabled"': null?>><i class="material-icons">format_list_bulleted</i></a>
						</td>
						
					</tr>
					<?php endforeach; ?>
				</tbody>

				</table>
			</div>
			<div class="catd-footer text-muted">
				Nº Registro: <?= $this->cuentas->rowCount();?>
			</div>
		</div>


    </div>
	<br><br><br>

    <!-- /.container -->
    
    <?php require_once("template/partials/footer.php") ?>
	<?php require_once("template/partials/javascript.php") ?>
	
</body>

</html>