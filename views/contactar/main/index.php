<!doctype html>
<html lang="es">

<?php require_once("template/partials/head.php") ?>

<body>
<?php require_once("template/partials/menu.php") ?>

	<!-- Page Content -->
	<div class="container">
		<br>

		<?php require_once("template/partials/error.php") ?>
		<?php require_once("template/partials/mensaje.php") ?>

		<!-- Estilo card de bootstrap -->
		
		<div class="card">
		
			<div class="card-header">
				<legend>Vista nuevo formulario</legend>
			</div>
			<div class="card-body">
				<form method="POST" action="<?= URL ?>contactar/validar">
					
					<div class="mb-3">
						<label class="form-label">Nombre</label>
						<input type="text" class="form-control" name="nombre" value="<?= $this->contactar->nombre?>">
						<span class="form-text text-danger" role="alert">
							<?= $this->erroresVal['nombre'] ??= null ?>
						</span>
					</div>
					<div class="mb-3">
						<label class="form-label">Email</label>
						<input type="email" class="form-control" name="email" value="<?= $this->contactar->email?>">
						<span class="form-text text-danger" role="alert">
							<?= $this->erroresVal['email'] ??= null ?>
						</span>
					</div>
					<div class="mb-3">
						<label class="form-label">Asunto</label>
						<input type="text" class="form-control" name="asunto" value="<?= $this->contactar->asunto?>">
						<span class="form-text text-danger" role="alert">
							<?= $this->erroresVal['asunto'] ??= null ?>
						</span>
					</div>
					<div class="mb-3">
						<label class="form-label">Mensaje</label>
						<input type="text" class="form-control" name="mensaje" value="<?= $this->contactar->mensaje?>">
						<span class="form-text text-danger" role="alert">
							<?= $this->erroresVal['mensaje'] ??= null ?>
						</span>
					</div>
					<br>
			</div>
			<div class="catd-footer text-muted">
			<a class="btn btn-secondary" role="button" href="<?= URL ?>">Cancelar</a>
			<button type="reset" class="btn btn-danger">Borrar</button>
			<button type="submit" href="<?= URL ?>contactar" class="btn btn-primary">Enviar</button>
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