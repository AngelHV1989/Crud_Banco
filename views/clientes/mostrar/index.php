<!doctype html>
<html lang="es">

<?php require_once("template/partials/head.php") ?>

<body>
<?php require_once("template/partials/menu.php") ?>

	<!-- Page Content -->
	<div class="container">
		<br><br><br><br>

		<?php require_once("template/partials/mensaje.php") ?>


		<!-- Estilo card de bootstrap -->
		<div class="card">

			<div class="card-header">
				<legend>Vista nuevo formulario</legend>
			</div>
			<div class="card-body">
				<form method="POST">
					<div class="mb-3">
						<label class="form-label">Id</label>
						<input type="text" class="form-control" name="id" value="<?= $this->cliente->id?>" readonly>
					</div>
					<div class="mb-3">
						<label class="form-label">Apellidos</label>
						<input type="text" class="form-control" name="apellidos" value="<?= $this->cliente->apellidos?>" readonly>
					</div>
					<div class="mb-3">
						<label class="form-label">Nombre</label>
						<input type="text" class="form-control" name="nombre" value="<?= $this->cliente->nombre?>" readonly>
					</div>
					<div class="mb-3">
						<label class="form-label">Telefono</label>
						<input type="date" class="form-control" name="telefono" value="<?= $this->cliente->telefono?>" readonly>
					</div>
					<div class="mb-3">
						<label class="form-label">Población</label>
						<input type="text" class="form-control" name="ciudad" value="<?= $this->cliente->ciudad?>" readonly>
					</div>
					<div class="mb-3">
						<label class="form-label">Dni</label>
						<input type="text" class="form-control" name="dni" pattern="[0-9]{8}[A-Za-z]{1}" value="<?= $this->cliente->dni?>" readonly>
					</div>
					<div class="mb-3">
						<label class="form-label">Email</label>
						<input type="email" class="form-control" name="email" value="<?= $this->cliente->email?>" readonly>
					</div>
			</div>
			<div class="catd-footer text-muted">
			<a class="btn btn-secondary" role="button" href="<?= URL ?>clientes">Volver</a>
			</form>
			</div>
		</div>

		
	</div>
	<br><br><br>

	<!-- /.container -->

	<?php require_once("template/partials/footer.php") ?>
	<?php require_once("template/partials/javascript.php") ?>

</body>

</html>