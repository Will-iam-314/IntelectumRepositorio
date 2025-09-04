<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    
    <title><?=  name_system(); ?></title>
    <link rel="icon" type="image/png" href="<?= base_url('assets/icons/IntelectumLogoFondoBlanco.png')?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">    
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css?v=1.2') ?>">

</head>
<body>

    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Intelectum</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Mis Solicitudes</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Constancias</a>
                </li>


            

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Perfil
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Action</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="<?= base_url('logout') ; ?>">Cerrar sesion</a></li>
                    </ul>
                </li>
                
            </ul>
            <form class="d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search"/>
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
            </div>
        </div>
    </nav>
 
    <div id="contenedor" class=" border">
        <?= $this->renderSection('content') ?>        
    </div>

  
        
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>

    <?= $this->renderSection('scripts') ?>

    <div class="modal fade" id="loadingModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div  class="modal-content contenedor-modal-load">
            <div  class=" cont-modal-load-spinner">
                <div class="spinner-border spinner-custom" role="status" style=""></div>
            </div>
            <p class=" text-cont-modal-load">Cargando</p>
            </div>
        </div>
    </div>

    <script>
        function mostrarLoading() {
            let modal = new bootstrap.Modal(document.getElementById('loadingModal'), {
            backdrop: 'static',   // evita que lo cierren
            keyboard: false       // evita que cierren con ESC
            });
            modal.show();
        }
    </script>

</html>

