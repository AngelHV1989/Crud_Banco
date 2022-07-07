<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="<?= URL ?>index">Gesbank</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <!-- <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="<?= URL ?>index">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="<?= URL ?>gesbank">Gesbank</a>
        </li> -->
        <li class="nav-item">
          <a class="nav-link active" href="<?= URL ?>clientes">Clientes</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="<?= URL ?>cuentas">Cuentas</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="<?= URL ?>contactar">Contactar</a>
        </li>
      </ul>
      <div class="d-flex">
        <ul class="nav navbar-nav flex-row justify-content-between ml-auto">
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <?= $_SESSION['name_user'] ?>
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="<?= URL ?>auth/logout">Logout</a>
                <a class="dropdown-item" href="<?= URL ?>auth/edit">Modificar Perfil</a>
                <a class="dropdown-item" href="<?= URL ?>auth/chpassword">Cambiar Password</a>
                <a class="dropdown-item" href="<?= URL ?>auth/delete">Eliminar Perfil</a>
                
                <div class="dropdown-divider"></div>
                <a class="dropdown-item disabled" href="#"><?= $_SESSION['name_rol'] ?></a>
              </div>
            </li>
        </ul>
        </div>
    </div>
  </div>
</nav>