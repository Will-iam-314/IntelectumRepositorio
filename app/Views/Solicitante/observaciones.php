<?= $this->extend('layouts/SolicitanteTemplate.php'); ?>

<?= $this->section('content');?>


<div class="d-flex flex-wrap align-items-center gap-2">       
    <button class="btn btn-link p-0 border-0" onclick='Regresar()'>
        <img class="me-1" width="30" height="30" src="<?=base_url('assets/icons/flecha-atras.png')?>" alt="Regresar"> 
    </button>
 
    <span class="title-modules">Levantar Observaciones</span> 
    
</div>



<form action="<?= base_url('solicitante/levantarObservaciones') ?>" method="post" enctype="multipart/form-data" onsubmit= "mostrarLoadingConArchivos()">
    <?= csrf_field() ?>

    <input type="hidden" name="idTramite" value="<?= esc($idTramite) ?>">
    <input type="hidden" name="idMaterial" value="<?= esc($idMaterial) ?>">
    <input type="hidden" name="codigoTramite" value="<?= esc($codigoTramite) ?>">
    <input type="hidden" name="idTesis" value="<?= esc($idTesis) ?>">
    
    <div class="container-default mt-4 shadow-sm">

        <div class="container-title-observaciones">
            <span class="title-levObservaciones">Tramite </span> <span class="codigo-title-LevObservaciones"><?= esc($codigoTramite) ?></span>
        </div>
        
    
        <div class="container-observaciones mt-3">
                <span class="title-observaciones">Observaciones</span>
                <p class="observaciones-lista"><?=$observaciones?></p>
                
        </div>

        <div class="container-form-actualizacion-observaciones">

            <div class="mb-3">
                <label for="tituloMaterial" class="label-form">Título</label>
                <input type="text" class="input-form" id="tituloMaterial" name="tituloMaterial" value="<?= esc($tituloMaterial) ?>" >
            </div>
        
            <div class="mb-3">
                <label for="autores" class="label-form">Autores</label>
                <?php foreach($autores as $i => $autor):  ?>
                    <input type="text" class="input-form mb-2" id="autor[<?= $i ?>]" name="autor[<?= $i ?>][nombre]" value="<?=esc($autor['nombre']) ?>" >
                    <input type="text" name="autor[<?= $i ?>][dni]" value="<?=esc($autor['dni'])?>" hidden>
                <?php endforeach; ?>
                    
            </div>
            
            <div class="mb-4">
                <label for="fileTesis" class="label-form">Archivo de Tesis</label>
                <div class="form-text">Actualiza el archivo de Tesis (PDF).</div>
                <div class="d-flex">
                    <input class="form-control mt-2 me-3" type="file" name="fileTesis" id="fileTesis" accept=".pdf">
                    <?php if(!empty($fileTesis)): ?>
                        <a href="<?= base_url('solicitante/documentos/verTesis/'.$fileTesis) ?>" target="_blank" class="btn-ver-archiv-actual">Ver Actual</a>
                    <?php endif; ?>
                </div>

            </div>

            

            <div class="mb-4">
                <label for="declaracionJurada" class="label-form">Declaración Jurada</label>
                <div class="form-text">Actualiza el archivo de la Declaracion Jurada (PDF).</div>
                <div class="d-flex">
                    <input class="form-control mt-2  me-3" type="file" name="declaracionJurada" id="declaracionJurada" accept=".pdf">
                    <?php if(!empty($fileDeclaracionJuradaTramite)): ?>
                        <a href="<?= base_url('solicitante/documentos/verDeclaracionJurada/'.$fileDeclaracionJuradaTramite) ?>" target="_blank" class="btn-ver-archiv-actual">Ver Actual</a>
                    <?php endif; ?>
                </div>
                
                
            </div>
            
            <div class="mb-4">
                <label for="autorizacionPublicacion" class="label-form">Autorización de Publicación</label>
                <div class="form-text">Actualiza el archivo de la Autorización de Publicación (PDF).</div>
                <div class="d-flex">
                    <input class="form-control mt-2  me-3" type="file" name="autorizacionPublicacion" id="autorizacionPublicacion" accept=".pdf">
                    <?php if(!empty($fileAutorizacionPublicacionTramite)): ?>
                        <a href="<?= base_url('solicitante/documentos/verAutorizacionPublicacion/'.$fileAutorizacionPublicacionTramite) ?>" target="_blank" class="btn-ver-archiv-actual">Ver Actual</a>
                    <?php endif; ?>
                </div>
                
                
            </div>

        </div>

        <div class="d-flex justify-content-center mt-4 mb-3">
            <div style="width:200px;">
                <button type="submit" class="btn-style1">Guardar Cambios</button>
            </div>
            
        </div>

   
    
    </div>

 

    
</form>

<?= $this->endSection();?>

