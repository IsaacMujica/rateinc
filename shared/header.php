<!-- NAVBAR --><nav class="navbar navbar-expand-lg navbar-light text-white">    <!-- <a class="navbar-brand" href="#">Navbar</a> -->    <a href="dashboard.php" class="navbar-brand"><img src="<?= HOST ?>/public/images/logo-rateinc.png" alt="CETI" class="img-responsive logo" width="182"></a>    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">        <span class="navbar-toggler-icon"></span>    </button>    <div class="collapse navbar-collapse" id="navbarSupportedContent">        <ul class="navbar-nav mr-auto"></ul>        <ul class="navbar-nav mr-auto my-2 my-md-0 mr-md-3">            <li class="nav-item dropdown">                <a class="nav-link text-white dropdown-toggle" href="#" id="navbarMainMenuTop" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">                    <!-- <img src="http://www.tp3developers.cl/cetialumnos/public/vendor/theme/assets/img/user.png" class="img-circle" alt="Avatar"> -->                    <i class="fas fa-user-cog"></i>                    <?= $_SESSION['USUARIO_NOMBRE'] ?> <?= $_SESSION['USUARIO_APELLIDO'] ?>                </a>                <div class="dropdown-menu" aria-labelledby="navbarMainMenuTop">                    <!--                    <a class="dropdown-item" href="#">Perfil</a>                    -->                    <!-- <a href="javascript:void(0)" class="dropdown-item" data-toggle="modal" data-target="#modalCambioClave">Cambiar Contraseña</a>                    <a href="javascript:void(0)" class="dropdown-item" data-toggle="modal" data-target="#modalEditarPerfil">Editar Perfil</a>                    <div class="dropdown-divider"></div> -->                    <a class="dropdown-item" href="#" id="btnCerrarSesion">Cerrar Sesión</a>                </div>            </li>        </ul>    </div></nav><hr class="line-grey no-margin"><!-- END NAVBAR --><!-- MODAL ACTIONS --><div class="modal fade" id="modalCambioClave" tabindex="-1" role="dialog" aria-labelledby="modalCambioClaveLabel" aria-hidden="true">    <div class="modal-dialog" role="document">        <div class="modal-content">            <div class="modal-header">                <h6 class="modal-title" id="modalCambioClaveLabel">Cambio de Contraseña</h6>                <button type="button" class="close" data-dismiss="modal" aria-label="Close">                    <span aria-hidden="true">&times;</span>                </button>            </div>            <div class="modal-body">                <form id="formCambioClave" autocomplete="off" novalidate="novalidate">                    <div class="row">                        <div class="col-md-12">                            <label for="txtPasswordActual">Contraseña Actual</label>                            <input type="password" id="txtPasswordActual" name="txtPasswordActual" class="form-control">                        </div>                    </div>                    <br>                    <div class="row">                        <div class="col-md-12">                            <label for="txtPasswordNuevo">Nueva Contraseña</label>                            <input type="password" id="txtPasswordNuevo" name="txtPasswordNuevo" class="form-control">                            <small id="passwordHelpBlock" class="form-text text-muted">                                La nueva contraseña debe contener minimo 6 caracteres para que sea segura.                            </small>                        </div>                    </div>                    <br>                    <div class="row">                        <div class="col-md-12">                            <label for="txtPasswordConfirm">Confirmar Contraseña</label>                            <input type="password" id="txtPasswordConfirm" name="txtPasswordConfirm" class="form-control">                        </div>                    </div>                    <br>                    <hr>                    <div class="row">                        <div class="col-md-12">                            <div class="form-group text-right">                                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>                                <button type="submit" class="btn btn-info btn-sm" id="btnGuardarCambiarClave">Guardar</button>                            </div>                        </div>                    </div>                </form>            </div>        </div>    </div></div><div class="modal fade" id="modalEditarPerfil" tabindex="-1" role="dialog" aria-labelledby="modalEditarPerfilLabel" aria-hidden="true">    <div class="modal-dialog" role="document">        <div class="modal-content">            <div class="modal-header">                <h6 class="modal-title" id="modalEditarPerfilLabel">Editar Perfil</h6>                <button type="button" class="close" data-dismiss="modal" aria-label="Close">                    <span aria-hidden="true">&times;</span>                </button>            </div>            <div class="modal-body">                <form id="formEditarPerfil" autocomplete="off" novalidate="novalidate">                    <div class="row">                        <div class="col-md-12">                            <label for="txtNombre">Nombre</label>                            <input type="text" id="txtNombre" name="txtNombre" class="form-control" value="">                        </div>                    </div>                    <br>                    <div class="row">                        <div class="col-md-6">                            <label for="txtPaterno">Apellido Paterno</label>                            <input type="text" id="txtPaterno" name="txtPaterno" class="form-control" value="">                        </div>                        <div class="col-md-6">                            <label for="txtMaterno">Apellido Materno</label>                            <input type="text" id="txtMaterno" name="txtMaterno" class="form-control" value="">                        </div>                    </div>                    <br>                    <div class="row">                        <div class="col-md-12">                            <label for="txtEmail">Email</label>                            <input type="email" id="txtEmail" name="txtEmail" class="form-control" value="">                        </div>                    </div>                    <br>                    <div class="row">                        <div class="col-md-6">                            <label for="txtCelular">Celular</label>                            <input type="number" id="txtCelular" name="txtCelular" class="form-control" value="">                        </div>                        <div class="col-md-6">                            <label for="txtTelefono">Teléfono</label>                            <input type="number" id="txtTelefono" name="txtTelefono" class="form-control" value="">                        </div>                    </div>                    <br>                    <hr>                    <div class="row">                        <div class="col-md-12">                            <div class="form-group text-right">                                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>                                <button type="submit" class="btn btn-info btn-sm" id="btnGuardarInfo">Guardar</button>                            </div>                        </div>                    </div>                </form>            </div>        </div>    </div></div>