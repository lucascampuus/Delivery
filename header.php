<!-- Topbar -->
<?php
include "data/connect/conexaomysql.php";
$consultalogin = mysqli_query( $link, "SELECT * FROM user WHERE status = '1'");
if(mysqli_num_rows($consultalogin)>0)
{
while($luser=mysqli_fetch_array($consultalogin))
{
$user=$luser['user'];
}
}
else
{
$user='No User';
}
?>
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow"> 
  
  <!-- Sidebar Toggle (Topbar) -->
  <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3"> <i class="fa fa-bars"></i> </button>
  
  <!-- Topbar Navbar -->
  <ul class="navbar-nav ml-auto">
    
    <!-- Nav Item - Search Dropdown (Visible Only XS) -->
    <li class="nav-item dropdown no-arrow d-sm-none"> <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fas fa-search fa-fw"></i> </a> 
      <!-- Dropdown - Messages -->
      <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
        <form class="form-inline mr-auto w-100 navbar-search">
          <div class="input-group">
            <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
            <div class="input-group-append">
              <button class="btn btn-primary" type="button"> <i class="fas fa-search fa-sm"></i> </button>
            </div>
          </div>
        </form>
      </div>
    </li>
    
    <!-- Nav Item - Alerts -->
    <li class="nav-item dropdown no-arrow mx-1"> <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fas fa-bell fa-fw"></i> 
      <!-- Counter - Alerts --> 
      <span class="badge badge-danger badge-counter">+1</span> </a> 
      <!-- Dropdown - Alerts -->
      <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
        <h6 class="dropdown-header"> Alerts Center </h6>
        <a class="dropdown-item d-flex align-items-center" href="#">
        <div class="mr-3">
          <div class="icon-circle bg-primary"> <i class="fas fa-file-alt text-white"></i> </div>
        </div>
        <div>
          <div class="small text-gray-500">16/04/2021</div>
          <span class="font-weight-bold">Em andamento</span> </div>
        </a> <a class="dropdown-item d-flex align-items-center" href="#"> <a class="dropdown-item text-center small text-gray-500" href="#">Mostrar Todos</a> </div>
    </li>
    <div class="topbar-divider d-none d-sm-block"></div>
    
    <!-- Nav Item - User Information -->
    <li class="nav-item dropdown no-arrow"> <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <span class="mr-2 d-none d-lg-inline text-gray-600 small" id="userlogged"><?=$user?></span> <img class="img-profile rounded-circle"
                                    src="img/undraw_profile.svg"> </a> 
      <!-- Dropdown - User Information -->
      <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown"> <a class="dropdown-item" href="#" onClick="mostrarvalores()"> <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i> Ativar </a> <a class="dropdown-item" href="#" onClick="escondevalores()"> <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i> Desativar</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="#" data-toggle="modal" onClick="logout()"> <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Sair </a> </div>
    </li>
  </ul>
</nav>
<!-- End of Topbar --> 

<script src="vendor/jquery-easing/jquery.easing.min.js"></script>
<div class="modal fade" id="login" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="false" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="idcliente"></h5>
      </div>
      <div class="modal-body" id="login">
        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0"> 
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Batattos 2.0</h1>
                  </div>
                  <BR>
                  <BR>
                  <BR>
                  <BR>
                  <BR>
                  <BR>
                  <form class="user">
                    <div class="form-group">
                     <input type="password" class="form-control form-control-user" id="pswd" placeholder="Senha de Acesso" onKeyUp="lengthpswd()" autofocus="true"/>
                     <BR>
                     <label id="pswdmsg" hidden="true">Senha Incorreta</label>
                    </div>
                    <button type="button" class="btn btn-success" id="loginuser" disabled>Entrar No Sistema</button>
                    <hr>
                  </form>
                  <hr>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>