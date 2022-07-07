<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <!-- <a class="navbar-brand" href="#">Navbar</a> -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="<?= URL ?>movimientos/render/<?= $this->id?>">Movimientos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= URL ?>movimientos/nuevo/<?= $this->id?>">Nuevo</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Ordenar
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="<?= URL ?>movimientos/ordenar/1/<?= $this->id?>">Id Mov</a></li>
            <li><a class="dropdown-item" href="<?= URL ?>movimientos/ordenar/2/<?= $this->id?>">Num_Cuenta</a></li>
            <li><a class="dropdown-item" href="<?= URL ?>movimientos/ordenar/3/<?= $this->id?>">Fecha</a></li>
            <li><a class="dropdown-item" href="<?= URL ?>movimientos/ordenar/4/<?= $this->id?>">Concepto</a></li>
            <li><a class="dropdown-item" href="<?= URL ?>movimientos/ordenar/5/<?= $this->id?>">Tipo</a></li>
            <li><a class="dropdown-item" href="<?= URL ?>movimientos/ordenar/6/<?= $this->id?>">Cantidad</a></li>
            <li><a class="dropdown-item" href="<?= URL ?>movimientos/ordenar/7/<?= $this->id?>">Saldo</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= URL ?>movimientos/movimientosPdf/<?= $this->id?>">Descargar Pdf</a>
        </li>
      </ul>
      <form class="d-flex" method="GET" action="<?= URL ?>movimientos/buscar/<?= $this->id?>">
        <input class="form-control me-2" type="buscar" placeholder="Expresion" aria-label="Expresion" name="Expresion">
        <button class="btn btn-outline-secondary" type="submit" >Buscar</button>
      </form>
    </div>
  </div>
</nav>