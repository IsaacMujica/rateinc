<a id="show-sidebar" class="btn btn-sm btn-dark" href="#">
    <i class="fas fa-bars"></i>
</a>
<nav id="sidebar" class="sidebar-wrapper">
    <div class="sidebar-content">
        <div class="sidebar-brand">
            <!--<a href="#">pro sidebar</a>-->
            <a href="https://tp3developers.cl/cetialumnos/dashboard.php"><img
                    src="<?= HOST ?>/public/images/logo-ceti-blanco.png" alt="CETI"
                    class="img-responsive logo" width="182"></a>

            <div id="close-sidebar">
                <i class="fas fa-times"></i>
            </div>
        </div>
        <div class="sidebar-header">
            <div class="user-pic">
                <img class="img-responsive img-rounded"
                     src="https://raw.githubusercontent.com/azouaoui-med/pro-sidebar-template/gh-pages/src/img/user.jpg"
                     alt="User picture">
            </div>
            <div class="user-info">
          <span class="user-name"><?= $_SESSION['USUARIO_NOMBRE'] ?>
            <strong><?= $_SESSION['USUARIO_APELLIDO'] ?></strong>
          </span>
                <span class="user-role"><?= $_SESSION['USUARIO_TIPO'] ?></span>
                <span class="user-sede"><?= $_SESSION['USUARIO_SEDE'] ?></span>
            </div>
        </div>
        <!-- sidebar-header  -->

        <div class="sidebar-menu">
            <ul>
                <li class="header-menu">
                    <span>Menú Usuario</span>
                </li>
                <li class="sidebar-dropdown mAdmUsu">
                    <a href="#">
                        <i class="fas fa-building"></i>
                        <span class="mAdmUsu">Usuarios</span>
                    </a>
                </li>
                <li class="header-menu">
                    <hr class="hr">
                </li>

                <li class="">
                    <a href="../../dashboard.php">
                        <i class="fas fa-arrow-left"></i>
                        <span class="mDash">Volver a Menu Principal</span>
                    </a>
                </li>
            </ul>

            <?php require_once APP_PUBLIC . "/shared/footer.php"; ?>
        </div>
    </div>

</nav>

<!-- END LEFT SIDEBAR -->



