<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    
    <title><?=  name_system(); ?></title>
    <link rel="icon" type="image/png" href="<?= base_url('assets/icons/IntelectumLogoFondoBlanco.png')?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">    
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css?v=1.7') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/AuthStyle.css?v=1.7')?>">
</head>
<body>
 
    <div id="contenedor-Auth" >
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

        window.addEventListener('unload', function () {
            // handler vacío; su mera existencia evita que algunos navegadores guarden la página en bfcache
        });

        window.addEventListener("pageshow", function (event) {
            if (event.persisted) {
                window.location.reload();
            }
        });

        function mostrarLoading() {
            let modal = new bootstrap.Modal(document.getElementById('loadingModal'), {
            backdrop: 'static',   // evita que lo cierren
            keyboard: false       // evita que cierren con ESC
            });
            modal.show();
        }
    </script>
</body>
</html>

