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
				<form method="POST" action="<?= URL ?>cuentas/update/<?= $this->id?>">
				<!-- <div class="mb-3">
						<label class="form-label">Id</label>
						<input type="text" class="form-control" name="id" value="<?= $this->cuenta->id?>" readonly>
					</div> -->
					<div class="mb-3">
						<label class="form-label">Cuenta</label>
						<input type="text" class="form-control" name="num_cuenta" value="<?= $this->cuenta->num_cuenta?>">
						<span class="form-text text-danger" role="alert">
							<?= $this->erroresVal['num_cuenta'] ??= null ?>
						</span>
					</div>


					<div class="mb-3">
						<label for="id_cliente" class="form-label">Nombre Y Apellidos</label>

						<select class="form-select" name="id_cliente">
							<?php foreach ($this->clientes as $cliente) : ?>
								<option value=<?= $cliente->id ?>
								<?= ($this->cuenta->id_cliente == $cliente->id)?'selected' : null?>><?= $cliente->nombre . " " . $cliente->apellidos ?></option>
							<?php endforeach; ?>
						</select>
						<div class="form-text">Introduzca Nombre Y Apellidos</div>
						<span class="form-text text-danger" role="alert">
							<?= $this->erroresVal['id_cliente'] ??= null ?>
						</span>
					</div>


					<!-- <div class="mb-3">
						<label class="form-label">Fecha</label>
						<input type="text" class="form-control" name="fecha_alta" value="<?= $this->cuenta->fecha_alta?>" readonly>
					</div>
					<div class="mb-3">
						<label class="form-label">UI Mov</label>
						<input type="text" class="form-control" name="fecha_ul_mov" value="<?= $this->cuenta->fecha_ul_mov?>" readonly>
					</div>
					<div class="mb-3">
						<label class="form-label"># Movtos</label>
						<input type="text" class="form-control" name="num_movtos" value="<?= $this->cuenta->num_movtos?>" readonly>
					</div>
					<div class="mb-3">
						<label class="form-label">Saldo</label>
						<input type="number" class="form-control" name="saldo" value="<?= $this->cuenta->saldo?>" readonly>
					</div> -->
					<br>


			</div>
			<div class="catd-footer text-muted">
			<a class="btn btn-secondary" role="button" href="<?= URL ?>cuentas">Cancelar</a>
			<button type="reset" class="btn btn-danger">Borrar</button>
			<button type="submit" href="<?= URL ?>cuentas" class="btn btn-primary">Actualizar</button>
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