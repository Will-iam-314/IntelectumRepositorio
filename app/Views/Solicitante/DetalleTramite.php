
<?= $this->extend('layouts/SolicitanteTemplate.php'); ?>








<?= $this->section('content');?>
<button onclick='Regresar()'>Atras</button>

<h1>DETALLE TRAMITE</h1>




    <!-- Sección: Datos del Trámite -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-primary text-white">
            <strong>📑 Datos del Trámite</strong>
        </div>
        <div class="card-body">
            <p><strong>Código:</strong> <?= esc($codigoTramite) ?></p>
            <p><strong>Fecha de presentación:</strong> <?= date('d/m/Y', strtotime($fechapresentacionTramite)) ?></p>
            <p><strong>Estado:</strong> <?= esc($estadoTramite) ?></p>
            <p><strong>Declaración jurada:</strong> 
                <?php if(!empty($fileDeclaracionJuradaTramite)): ?>
                    <a href="<?= base_url('uploads/'.$fileDeclaracionJuradaTramite) ?>" target="_blank">Ver archivo</a>
                <?php else: ?>
                    <span class="text-muted">No disponible</span>
                <?php endif; ?>
            </p>
            <p><strong>Autorización de publicación:</strong> 
                <?php if(!empty($fileAutorizacionPublicacionTramite)): ?>
                    <a href="<?= base_url('uploads/'.$fileAutorizacionPublicacionTramite) ?>" target="_blank">Ver archivo</a>
                <?php else: ?>
                    <span class="text-muted">No disponible</span>
                <?php endif; ?>
            </p>
        </div>
    </div>

    <!-- Sección: Datos de la Tesis -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-success text-white">
            <strong>📘 Datos de la Tesis</strong>
        </div>
        <div class="card-body">
            <p><strong>Título:</strong> <?= esc($tituloMaterial) ?></p>
            <p><strong>Tipo de materia:</strong> <?= esc($tipomateriaMaterial) ?></p>
            <p><strong>Resumen:</strong> <?= esc($resumenTesis) ?></p>
            <p><strong>Palabras clave:</strong> <?= esc($palabrasclaveTesis) ?></p>
            <p><strong>Archivo de Tesis:</strong> 
                <?php if(!empty($fileTesis)): ?>
                    <a href="<?= base_url('uploads/'.$fileTesis) ?>" target="_blank">Ver archivo</a>
                <?php else: ?>
                    <span class="text-muted">No disponible</span>
                <?php endif; ?>
            </p>
        </div>
    </div>

    <!-- Sección: Docentes -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-info text-white">
            <strong>👨‍🏫 Docentes</strong>
        </div>
        <div class="card-body">
            <p><strong>Asesor:</strong> <?= esc($nombresAsesor . ' ' . $apellidosAsesor) ?></p>

            
        </div>
    </div>

 
<?= $this->endSection();?>











<?= $this->section('scripts');?>



<?= $this->endSection();?>