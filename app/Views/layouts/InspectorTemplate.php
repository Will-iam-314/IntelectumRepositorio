<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    
    <title><?=  name_system(); ?></title>
    <link rel="icon" type="image/png" href="<?= base_url('assets/icons/IntelectumLogoFondoBlanco.png')?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">    
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css?v=1.3') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/Inspector.css?v=1.0') ?>">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"> 

</head> 
<body class="body-templates">

    <nav class="navbar navbar-expand-xl bg-body-tertiary py-2 px-1">
        <div class="container-xl">
            <a class="redirect-cont-logo-menu" href="<?=base_url()?>">
                <div class="d-flex">
                    <div id="cont-logo-menu">
                        <img id="" height="45" width="45" src="<?= base_url('assets/icons/IntelectumLogoFondoBlanco.png')?>" alt="">
                    </div>
                    
                    <div class="d-flex flex-column justify-content-center " >
                        <span id="title-menu">Intelectum</span>
                        <span id="subtitle-menu">Repositorio</span>
                    </div>
                </div>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="<?= base_url('inspector/home') ?>">Home</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="<?= base_url('inspector/solicitudes') ?>">Solicitudes</a>
                    </li>
                
                
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Perfil
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li style="padding:0px 15px;" class="fw-bold"><?php echo(session('nombres').' '.session('apellidos')) ?></li>
                            <li style="padding:0px 15px;"><?= session('correo') ?></li>
                            <li><hr class="dropdown-divider"></li>
                            <li  ><a style="color:red;" class="dropdown-item fw-bold" href="<?= base_url('logout') ; ?>">Cerrar sesion</a></li>
                        </ul>
                    </li>
                    
                </ul>
            
            </div>
        </div>
    </nav>
 
    <div id="contenedor" class="container">
        <?= $this->renderSection('content') ?>        
    </div>

  
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

        
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>

    
    
    
    <?= $this->renderSection('scripts') ?>

    

    <script>
        function mostrarLoading() {
            let modal = new bootstrap.Modal(document.getElementById('loadingModal'), {
            backdrop: 'static',   // evita que lo cierren
            keyboard: false       // evita que cierren con ESC
            });
            modal.show();
        }

        function confirmarRegreso() {
            if (confirm("⚠️ Si regresas, los datos que estabas llenando no se guardarán. ¿Deseas continuar?")) {
                history.back();
            }
            return false; // evita que el link navegue por defecto
        }

        function Regresar(){
            history.back();
        }
    </script>
</body>
</html>

