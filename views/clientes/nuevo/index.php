<!doctype html>
<html lang="es">

<?php require_once("template/partials/head.php") ?>

<body>
<?php require_once("template/partials/menu.php") ?>

	<!-- Page Content -->
	<div class="container">
		<br><br><br><br>

		<?php require_once("template/partials/error.php") ?>


		<!-- Estilo card de bootstrap -->
		
		<div class="card">
		
			<div class="card-header">
				<legend>Vista nuevo formulario</legend>
			</div>
			<div class="card-body">
				<form method="POST" action="<?= URL ?>clientes/create">
					
					<div class="mb-3">
						<label class="form-label">Apellidos</label>
						<input type="text" class="form-control" name="apellidos" value="<?= $this->cliente->apellidos ?>">
						<span class="form-text text-danger" role="alert">
							<?= $this->erroresVal['apellidos'] ??= null ?>
						</span>
					</div>
					<div class="mb-3">
						<label class="form-label">Nombre</label>
						<input type="text" class="form-control" name="nombre" value="<?= $this->cliente->nombre ?>">
						<span class="form-text text-danger" role="alert">
							<?= $this->erroresVal['nombre'] ??= null ?>
						</span>
					</div>
					<div class="mb-3">
						<label class="form-label">Telefono</label>
						<input type="tel" class="form-control" name="telefono" value="<?= $this->cliente->telefono ?>">
						<span class="form-text text-danger" role="alert">
							<?= $this->erroresVal['telefono'] ??= null ?>
						</span>
					</div>
					<div class="mb-3">
						<label class="form-label">Población</label>
						<input type="text" class="form-control" name="ciudad" value="<?= $this->cliente->ciudad ?>">
						<span class="form-text text-danger" role="alert">
							<?= $this->erroresVal['ciudad'] ??= null ?>
						</span>
					</div>
					<div class="mb-3">
						<label class="form-label">Dni</label>
						<input type="text" class="form-control" name="dni" pattern="[0-9]{8}[A-Za-z]{1}" value="<?= $this->cliente->dni ?>">
						<span class="form-text text-danger" role="alert">
							<?= $this->erroresVal['dni'] ??= null ?>
						</span>
					</div>
					<div class="mb-3">
						<label class="form-label">Email</label>
						<input type="email" class="form-control" name="email" value="<?= $this->cliente->email ?>">
						<span class="form-text text-danger" role="alert">
							<?= $this->erroresVal['email'] ??= null ?>
						</span>
					</div>
					

					
					<br>

					

				

			</div>
			<div class="catd-footer text-muted">
			<a class="btn btn-secondary" role="button" href="<?= URL ?>clientes">Cancelar</a>
			<button type="reset" class="btn btn-danger">Borrar</button>
			<button type="submit" href="<?= URL ?>clientes" class="btn btn-primary">Enviar</button>
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