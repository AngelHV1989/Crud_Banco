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
				<form method="POST" action="<?= URL ?>movimientos/create/<?=$this->id?>">
				
				<div class="mb-3">
						<label class="form-label">Id Cuenta</label>
						<input type="text" class="form-control" name="id_cuenta" value="<?=$this->id?>" readonly>
					</div>
					<div class="mb3" form-check>
                <label class="form-label">Gasto o Ingreso</label>
                <div  class="form-control">
                
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="tipo" value="I" <?= ($this->movimiento->tipo == 'I')?'checked':null?>>
                            <label class="form-check-label" for="inlineCheckbox1" name="tipo">Ingreso</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="tipo" value="R" <?= ($this->movimiento->tipo == 'R')?'checked':null?>>
                            <label class="form-check-label" for="inlineCheckbox1" name="tipo">Gasto</label>
                        </div>
                        
                </div>
				<span class="form-text text-danger" role="alert">
							<?= $this->erroresVal['tipo'] ??= null ?>
						</span>
            </div>
					<div class="mb-3">
						<label class="form-label">Concepto</label>
						<input type="text" class="form-control" name="concepto" value="<?= $this->movimiento->concepto ?>">
						<span class="form-text text-danger" role="alert">
							<?= $this->erroresVal['concepto'] ??= null ?>
						</span>
					</div>
					<div class="mb-3">
						<label class="form-label">Cantidad</label>
						<input type="text" class="form-control" name="cantidad" value="<?= $this->movimiento->cantidad ?>">
						<span class="form-text text-danger" role="alert">
							<?= $this->erroresVal['cantidad'] ??= null ?>
						</span>
					</div>
					
					
					<br>

					

				

			</div>
			<div class="catd-footer text-muted">
			<a class="btn btn-secondary" role="button" href="<?= URL ?>movimientos/render/<?= $this->id?>">Cancelar</a>
			<button type="reset" class="btn btn-danger">Borrar</button>
			<button type="submit" class="btn btn-primary">Enviar</button>
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