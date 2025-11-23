<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    
    <title><?=  name_system(); ?></title>
    <link rel="icon" type="image/png" href="<?= base_url('assets/icons/IntelectumLogoFondoBlanco.png')?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">    
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css?v=2.2') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/Solicitante.css?v=2.0') ?>">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

</head>

   
<body class="body-templates">
    <nav class="navbar navbar-expand-xl bg-body-tertiary py-2 px-1">      
        <div  class="container-xl ">
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
                        <a class="nav-link active" aria-current="page" href="<?= base_url('solicitante/home') ?>">Inicio</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="<?= base_url('solicitante/mistramites') ?>">Mis Tramites</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="<?= base_url('solicitante/constancias') ?>">Constancias</a> 
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
 
    <div  class="container mt-4 cont-layouts">

        <?= $this->renderSection('content') ?>      

    </div>

    <footer style="background-color: #2c3e50; color: #ecf0f1; padding: 40px 0 20px 0; margin-top: 60px; font-family: Arial, sans-serif;">
        <div style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
            
            <!-- Contenido principal del footer -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 30px; margin-bottom: 40px;">
                
                <!-- Sección INTELECTUM -->
                <div>
                    <div style="display: flex; align-items: center; margin-bottom: 15px;">
                        <img src="https://via.placeholder.com/50" alt="Logo" style="width: 50px; height: auto; margin-right: 12px;">
                        <div>
                            <h3 style="margin: 0; font-size: 20px; font-weight: bold;">INTELECTUM</h3>
                            <p style="margin: 0; font-size: 13px; color: #bdc3c7;">Repositorio</p>
                        </div>
                    </div>
                    <p style="font-size: 14px; line-height: 1.6; color: #bdc3c7; margin: 0;">
                        Sistema de gestión del repositorio institucional de la Universidad Nacional de Ucayali.
                    </p>
                </div>
                
                <!-- Enlaces Rápidos -->
                <div>
                    <h4 style="margin: 0 0 15px 0; font-size: 16px; font-weight: bold; color: #fff;">Enlaces Rápidos</h4>
                    <ul style="list-style: none; padding: 0; margin: 0;">
                        <li style="margin-bottom: 10px;">
                            <a href="#" style="color: #bdc3c7; text-decoration: none; font-size: 14px; transition: color 0.3s;">Inicio</a>
                        </li>
                        <li style="margin-bottom: 10px;">
                            <a href="#" style="color: #bdc3c7; text-decoration: none; font-size: 14px; transition: color 0.3s;">Repositorio</a>
                        </li>
                        <li style="margin-bottom: 10px;">
                            <a href="#" style="color: #bdc3c7; text-decoration: none; font-size: 14px; transition: color 0.3s;">Nueva Solicitud</a>
                        </li>
                        <li style="margin-bottom: 10px;">
                            <a href="#" style="color: #bdc3c7; text-decoration: none; font-size: 14px; transition: color 0.3s;">Ayuda</a>
                        </li>
                    </ul>
                </div>
                
                <!-- Contacto -->
                <div>
                    <h4 style="margin: 0 0 15px 0; font-size: 16px; font-weight: bold; color: #fff;">Contacto</h4>
                    <div style="font-size: 14px; line-height: 1.8; color: #bdc3c7;">
                        <p style="margin: 0 0 10px 0;">
                            <strong style="color: #fff;">Universidad Nacional de Ucayali</strong>
                        </p>
                        <p style="margin: 0 0 10px 0;">
                            Vicerrectorado de Investigación
                        </p>
                        <p style="margin: 0 0 10px 0;">
                            📧 repositorio@unu.edu.pe
                        </p>
                        <p style="margin: 0 0 10px 0;">
                            📞 (061) 575060
                        </p>
                        <p style="margin: 0;">
                            📍 Pucallpa, Ucayali - Perú
                        </p>
                    </div>
                </div>
                
            </div>
            
            <!-- Separador -->
            <div style="border-top: 1px solid #34495e; margin: 20px 0;"></div>
            
            <!-- Copyright -->
            <div style="text-align: center; font-size: 13px; color: #95a5a6;">
                <p style="margin: 0;">
                    © <?php echo date('Y'); ?> Universidad Nacional de Ucayali. Todos los derechos reservados.
                </p>
                <p style="margin: 5px 0 0 0;">
                    Vicerrectorado de Investigación
                </p>
            </div>
            
        </div>
    </footer>




  
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

