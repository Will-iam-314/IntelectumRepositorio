<?= $this->extend('layouts/SolicitanteTemplate.php'); ?>

<?= $this->section('content');?>


<h1>Levantar Observaciones</h1>

<div class="alert alert-warning" role="alert">
    <strong>¡Atención!</strong> Tu trámite ha sido observado. Por favor, edita los datos y sube las nuevas versiones de los archivos corregidos.
</div>

<form action="<?= base_url('solicitante/levantarObservaciones') ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <input type="hidden" name="idTramite" value="<?= esc($idTramite) ?>">
    <input type="hidden" name="idMaterial" value="<?= esc($idMaterial) ?>">
    <input type="hidden" name="codigoTramite" value="<?= esc($codigoTramite) ?>">
    <input type="hidden" name="idTesis" value="<?= esc($idTesis) ?>">

    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-primary text-white">
            <strong>📑 Datos del Trámite</strong>
        </div>
        <div class="card-body">
            <p><strong>Código:</strong> <?= esc($codigoTramite) ?></p>
            <p><strong>Estado:</strong> <?= esc($estadoTramite) ?></p>
            <p><strong>Observaciones:</strong></p>
            <div class="alert alert-info">
                <p><?= esc($observaciones) ?></p>
            </div>
        </div>
    </div>

    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-success text-white">
            <strong>📘 Editar Datos de la Tesis</strong>
        </div>
        <div class="card-body">
            <div class="mb-3 d-flex align-items-center">
                <div class="flex-grow-1 me-2">
                    <label for="tituloMaterial" class="form-label">Título:</label>
                    <input type="text" class="form-control" id="tituloMaterial" name="tituloMaterial" value="<?= esc($tituloMaterial) ?>" >
                </div>
          
            </div>
           
         

            <div class="mb-3 d-flex align-items-center">
                <div class="flex-grow-1 me-2">
                    <label for="autores" class="form-label">Autores:</label>
                    <?php foreach($autores as $i => $autor):  ?>
                        <input type="text" class="form-control" id="autor[<?= $i ?>]" name="autor[<?= $i ?>][nombre]" value="<?=esc($autor['nombre']) ?>" >
                        <input type="text" name="autor[<?= $i ?>][dni]" value="<?=esc($autor['dni'])?>">
                    <?php endforeach; ?>
                    
                </div>
                
            </div>
            
           
            <div class="mb-3">
                <label for="fileTesis" class="form-label">Archivo de Tesis:</label>
                <?php if(!empty($fileTesis)): ?>
                    <a href="<?= base_url('solicitante/documentos/verTesis/'.$fileTesis) ?>" target="_blank" class="btn btn-sm btn-secondary ms-2">Ver Actual</a>
                <?php endif; ?>
                <input class="form-control mt-2" type="file" name="fileTesis" id="fileTesis">
                <div class="form-text">Sube el nuevo archivo de Tesis (PDF).</div>
            </div>

        </div>
    </div>
    
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-warning text-white">
            <strong>📂 Actualizar Documentos del Trámite</strong>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <label for="declaracionJurada" class="form-label">Declaración Jurada:</label>
                <?php if(!empty($fileDeclaracionJuradaTramite)): ?>
                    <a href="<?= base_url('solicitante/documentos/verDeclaracionJurada/'.$fileDeclaracionJuradaTramite) ?>" target="_blank" class="btn btn-sm btn-secondary ms-2">Ver Actual</a>
                <?php endif; ?>
                <input class="form-control mt-2" type="file" name="declaracionJurada" id="declaracionJurada">
                <div class="form-text">Sube el nuevo archivo (PDF).</div>
            </div>
            <hr>
            <div class="mb-3">
                <label for="autorizacionPublicacion" class="form-label">Autorización de Publicación:</label>
                <?php if(!empty($fileAutorizacionPublicacionTramite)): ?>
                    <a href="<?= base_url('solicitante/documentos/verAutorizacionPublicacion/'.$fileAutorizacionPublicacionTramite) ?>" target="_blank" class="btn btn-sm btn-secondary ms-2">Ver Actual</a>
                <?php endif; ?>
                <input class="form-control mt-2" type="file" name="autorizacionPublicacion" id="autorizacionPublicacion">
                <div class="form-text">Sube el nuevo archivo (PDF).</div>
            </div>
        </div>
    </div>

    <div class="d-grid gap-2">
        <button type="submit" class="btn btn-primary btn-lg">Guardar Cambios y Levantar Observaciones</button>
    </div>
</form>

<?= $this->endSection();?>

